<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\Product;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiscountsRelationManager extends RelationManager
{
    protected static string $relationship = 'discounts';

    protected static ?string $badge = '%';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('discount_id')
                    ->relationship(
                        name: 'discount',
                        titleAttribute: 'code',
                        modifyQueryUsing: function (Builder $query) {
                            $query->where('is_active', true)
                                ->whereDoesntHave('discountables', function (Builder $subQuery) {
                                    $ownerRecord = $this->getOwnerRecord();
                                    $subQuery->where('discountable_id', $ownerRecord->id)
                                        ->where('discountable_type', get_class($ownerRecord));
                                });
                        }
                    )
                    ->placeholder('Select a discount')
                    ->nullable()
                    ->preload()
                    ->searchable()
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('discount.code')
            ->columns([
                Tables\Columns\TextColumn::make('discount.code')->searchable()->label('Code')->sortable(),
                Tables\Columns\TextColumn::make('discount.start_date')
                    ->formatStateUsing(function ($state, $record) {
                        $startDate = Carbon::parse($record->discount->start_date);
                        $endDate = Carbon::parse($record->discount->end_date);
                        $now = Carbon::now();
                        $isActive = $record->discount->is_active;
                        if (!$isActive) {
                            return 'Inactive';
                        }
                        if ($now->between($startDate, $endDate)) {
                            return 'Valid';
                        } elseif ($now->lt($startDate)) {
                            return 'Upcoming';
                        } else {
                            return 'Expired';
                        }
                    })
                    ->label('Validity Status')
                    ->searchable()
                    ->badge(function ($state) {
                        switch ($state) {
                            case 'Valid':
                                return ['color' => 'success', 'label' => $state];
                            case 'Upcoming':
                                return ['color' => 'warning', 'label' => $state];
                            case 'Expired':
                                return ['color' => 'danger', 'label' => $state];
                            case 'Inactive':
                                return ['color' => 'secondary', 'label' => $state];
                            default:
                                return ['color' => 'neutral', 'label' => $state];
                        }
                    }),
                Tables\Columns\TextColumn::make('discount.amount')
                    ->formatStateUsing(function ($state, $record) {
                        $discountType = $record->discount->type;
                        $discountValue = $record->discount->amount;
                        if ($discountType === 'percentage') {
                            $originalPrice = $this->getOwnerRecord()->price;
                            $discountAmount = ($originalPrice * $discountValue) / 100;
                            return number_format($discountAmount, 2) . ' JOD';
                        }
                        if ($discountType === 'amount') {
                            return number_format($discountValue, 2) . ' JOD';
                        }
                        return 'N/A';
                    })
                    ->label('Discount Amount')
                    ->searchable()
                    ->visible(fn () => get_class($this->getOwnerRecord()) === Product::class),
                Tables\Columns\TextColumn::make('discount.end_date')->dateTime()->sortable()->label('Expiry Date')->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Add Discount')
                    ->visible(function () {
                        $record = $this->getOwnerRecord();
                        $now = Carbon::now();
                        $hasActiveOrUpcomingDiscount = $record->discounts->some(function ($discountable) use ($now) {
                            $discount = $discountable->discount;
                            return ($discount->is_active && $now->between($discount->start_date, $discount->end_date)) ||
                                ($now->lt($discount->start_date));
                        });
                        return !$hasActiveOrUpcomingDiscount;
                    }),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DetachBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
