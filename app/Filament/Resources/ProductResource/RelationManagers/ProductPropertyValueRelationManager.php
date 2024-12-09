<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductPropertyValueRelationManager extends RelationManager
{
    protected static string $relationship = 'ProductPropertyValue';

    protected static ?string $title = 'Price Variation';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('property_value_id')
                    ->relationship(
                        name: 'propertyValue',
                        titleAttribute: 'value',
                        modifyQueryUsing: function (Builder $query) {
                            $query->whereDoesntHave('products', function ($subQuery) {
                                $subQuery->where('product_id', $this->getOwnerRecord()->id);
                            });
                        }
                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->placeholder('Please select property value'),

                Forms\Components\TextInput::make('price_variation')
                    ->required()
                    ->placeholder('Please enter price variation')
                    ->numeric()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->suffix('JOD'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('price_variation')
            ->columns([
                Tables\Columns\TextColumn::make('propertyValue.value'),
                Tables\Columns\TextColumn::make('price_variation')->sortable()->numeric(decimalPlaces: 2)->suffix(' JOD'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Add Property Value'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
