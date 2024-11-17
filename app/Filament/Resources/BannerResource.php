<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'General';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->placeholder('Please enter title')
                            ->translatable(),
                        Forms\Components\TextInput::make('button_text')
                            ->placeholder('Please enter button text')
                            ->translatable(),
                    ]),
                Grid::make(1)
                    ->schema([
                        Forms\Components\Textarea::make('text')
                            ->placeholder('Please enter text')
                            ->translatable(),
                    ]),
                Section::make('')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('alignments')
                                    ->options([
                                        'left' => 'Left',
                                        'center' => 'Center',
                                        'right' => 'Right',
                                    ])
                                    ->default('left')
                                    ->required(),
                                Forms\Components\TextInput::make('button_link')
                                    ->placeholder('Please enter button link')
                                    ->maxLength(255)
                                    ->url()
                                    ->default(null),
                                Forms\Components\TextInput::make('sort')
                                    ->placeholder('Please enter sort')
                                    ->numeric(),
                                SpatieMediaLibraryFileUpload::make('image')->columnSpan(2)->collection('banners'),
                                Forms\Components\Toggle::make('is_active')
                                    ->inline(false)
                                    ->required(),
                            ]),
                    ]),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('slug')->searchable(),
                SpatieMediaLibraryImageColumn::make('image')->collection('banners')->label('Image')->circular(),
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('alignments'),
                // Tables\Columns\TextColumn::make('button_link')->searchable(),
                Tables\Columns\TextColumn::make('sort')->numeric()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'view' => Pages\ViewBanner::route('/{record}'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
