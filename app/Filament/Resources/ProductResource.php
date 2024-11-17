<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\DiscountsRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\ProductPropertyValueRelationManager;
use App\Filament\Resources\ProductResource\RelationManagers\QuestionsRelationManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Support\RawJs;
use Mokhosh\FilamentRating\Components\Rating;
use Mokhosh\FilamentRating\RatingTheme;
use Mokhosh\FilamentRating\Columns\RatingColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->placeholder('Please enter name')
                                    ->translatable(),
                                Forms\Components\Textarea::make('description')
                                    ->placeholder('Please enter description')
                                    ->required()
                                    ->translatable(),
                            ]),
                    ]),
                Section::make('')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->relationship(name: 'category', titleAttribute: 'name')
                                    ->nullable()
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->placeholder('Please select category'),
                                Forms\Components\TextInput::make('sort')
                                    ->placeholder('Please enter sort')
                                    ->numeric(),
                                Forms\Components\TextInput::make('quantity')
                                    ->required()
                                    ->placeholder('Please enter quantity')
                                    ->numeric(),
                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->placeholder('Please enter price')
                                    ->numeric()
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->suffix('JOD'),
                                Forms\Components\TextInput::make('cost_price')
                                    ->numeric()
                                    ->placeholder('Please enter cost price')
                                    ->mask(RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->suffix('JOD')
                                    ->default(0.00),
                                Rating::make('rate')->theme(RatingTheme::Simple)->allowZero(),
                                Forms\Components\TextInput::make('rate_counter')
                                    ->numeric()
                                    ->placeholder('Please enter rate counter')
                                    ->default(0)
                                    ->minValue(0),
                                Forms\Components\Toggle::make('is_active')
                                    ->inline(false),
                                SpatieMediaLibraryFileUpload::make('image')->collection('products')->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')->collection('products')->label('Image')->circular(),
                Tables\Columns\TextColumn::make('name')->searchable()->label('Name')->sortable(),
                Tables\Columns\TextColumn::make('category.name')->searchable()->label('Category')->sortable(),
                Tables\Columns\TextColumn::make('quantity')->numeric()->sortable()->suffix(' PCS'),
                Tables\Columns\TextColumn::make('price')->numeric(decimalPlaces: 2)->suffix(' JOD'),
                RatingColumn::make('rate')->theme(RatingTheme::Simple)->label('Rate')->sortable(),
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
            ProductPropertyValueRelationManager::class,
            QuestionsRelationManager::class,
            DiscountsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            // 'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
