<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\DiscountsRelationManager;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\Builder;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationGroup = 'General';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->placeholder('Please enter name')
                    ->translatable()
                    ->columnSpanFull(),
                Section::make('')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('parent_id')
                                    ->placeholder('Please select parent')
                                    ->relationship(name: 'parent', titleAttribute: 'name', ignoreRecord: true)
                                    ->nullable()
                                    ->searchable()
                                    ->preload()
                                    ->default(null),
                                Forms\Components\TextInput::make('sort')->numeric()->placeholder('Please enter sort'),
                                SpatieMediaLibraryFileUpload::make('image')->collection('categories'),
                                Forms\Components\Toggle::make('is_active')->required()->inline(false),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // SpatieMediaLibraryImageColumn::make('image')->label('Image')->circular()->collection('categories'),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                // Tables\Columns\TextColumn::make('parent.name')->sortable()->label('Main Category')->searchable(),
                Tables\Columns\TextColumn::make('sort')->numeric()->sortable(),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextColumn::make('deleted_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            ])
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query->where('parent_id', null);
            });
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ChildrenRelationManager::class,
            DiscountsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'view' => Pages\ViewCategory::route('/{record}'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
