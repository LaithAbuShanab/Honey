<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiscountResource\Pages;
use App\Filament\Resources\DiscountResource\RelationManagers;
use App\Models\Discount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Support\RawJs;

class DiscountResource extends Resource
{
    protected static ?string $model = Discount::class;

    protected static ?string $navigationIcon = 'heroicon-o-percent-badge';

    protected static ?string $navigationGroup = 'Discounts';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('discount_type')
                                    ->placeholder('Please select discount type')
                                    ->options([
                                        'coupon' => 'Coupon',
                                        'general_discount' => 'General Discount',
                                        'free_shipping' => 'Free Shipping',
                                    ])->required(),
                                Forms\Components\Select::make('type')
                                    ->placeholder('Please select type')
                                    ->options([
                                        'percentage' => 'Percentage',
                                        'amount' => 'Amount',
                                    ])
                                    ->live()
                                    ->required(),
                                Forms\Components\TextInput::make('amount')
                                    ->required()
                                    ->numeric()
                                    ->placeholder('Please enter amount')
                                    ->reactive()
                                    ->suffix(fn(callable $get) => $get('type') === 'percentage' ? '%' : 'JOD')
                                    ->default(0.00),
                                Forms\Components\DateTimePicker::make('start_date'),
                                Forms\Components\DateTimePicker::make('end_date'),
                                Forms\Components\TextInput::make('code')->maxLength(20)->default(null)->placeholder('Please enter code'),
                                Forms\Components\TextInput::make('min_purchase')
                                    ->numeric()
                                    ->placeholder('Please enter min purchase')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->suffix('JOD')
                                    ->default(0.00)->numeric(),
                                Forms\Components\TextInput::make('max_discount')
                                    ->numeric()
                                    ->placeholder('Please enter min purchase')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->suffix('JOD')
                                    ->default(0.00)->numeric(),
                                Forms\Components\TextInput::make('limit_per_user')
                                    ->numeric()
                                    ->placeholder('Please enter limit per user')
                                    ->default(1)->numeric(),
                                Forms\Components\Toggle::make('is_active')
                                    ->inline(false),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('discount_type')
                    ->formatStateUsing(function ($state) {
                        return collect(explode('_', $state))
                            ->map(fn($word) => ucfirst($word))
                            ->implode(' ');
                    }),
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn($state) => $state === 'percentage' ? 'Percentage' : 'Amount'),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric(decimalPlaces: 2)
                    ->formatStateUsing(function ($state, $record) {
                        $suffix = $record->type === 'percentage' ? '%' : 'JOD';
                        return $state . ' ' . $suffix;
                    }),
                Tables\Columns\TextColumn::make('start_date')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('end_date')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('code')->searchable(),
                // Tables\Columns\TextColumn::make('min_purchase')->numeric()->sortable(),
                // Tables\Columns\TextColumn::make('max_discount')->numeric()->sortable(),
                // Tables\Columns\TextColumn::make('limit_per_user')->numeric()->sortable(),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiscounts::route('/'),
            'create' => Pages\CreateDiscount::route('/create'),
            // 'view' => Pages\ViewDiscount::route('/{record}'),
            'edit' => Pages\EditDiscount::route('/{record}/edit'),
        ];
    }
}
