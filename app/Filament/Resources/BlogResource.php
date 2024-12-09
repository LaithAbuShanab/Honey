<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Filament\Resources\BlogResource\RelationManagers\TagsRelationManager;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Grid::make(1)
                            ->schema([
                                Forms\Components\TextInput::make('title')->required()->columnSpanFull()->placeholder('Please enter title')->translatable(),
                            ]),
                        Grid::make(1)
                            ->schema([
                                Forms\Components\Textarea::make('description')->required()->columnSpanFull()->placeholder('Please enter description')->translatable(),
                            ]),
                        Grid::make(1)
                            ->schema([
                                Forms\Components\Textarea::make('quote')->required()->columnSpanFull()->placeholder('Please enter quote')->translatable(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('sort')->numeric()->placeholder('Please enter sort'),
                                Forms\Components\Toggle::make('is_active')->inline(false),
                            ]),
                        Grid::make(2)
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('image')->collection('blogs')->columnSpanFull(),
                                SpatieMediaLibraryFileUpload::make('gallery')->collection('blog_galleries')->columnSpanFull()->multiple(true)->panelLayout('grid'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('sort')->numeric()->sortable(),
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
            TagsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            // 'view' => Pages\ViewBlog::route('/{record}'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
