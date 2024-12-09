<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LookupResource\Pages;
use App\Filament\Resources\LookupResource\RelationManagers;
use App\Models\Lookup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;

class LookupResource extends Resource
{
    protected static ?string $model = Lookup::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?string $navigationGroup = 'General';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->placeholder('Please enter title')
                    ->translatable()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('description')
                    ->placeholder('Please enter description')
                    ->translatable()
                    ->columnSpanFull(),
                ComponentsSection::make('')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('parent_id')
                                    ->placeholder('Please select parent')
                                    ->relationship(name: 'parent', titleAttribute: 'title', ignoreRecord: true)
                                    ->nullable()
                                    ->searchable()
                                    ->preload()
                                    ->default(null),
                                Forms\Components\TextInput::make('sort')
                                    ->placeholder('Please enter sort')
                                    ->numeric(),
                                SpatieMediaLibraryFileUpload::make('image'),
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                // ActionGroup::make([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                $query->where('parent_id', null);
            });
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ChildrenRelationManager::class,
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('General')
                    ->schema([
                        TextEntry::make('title')->label('Title'),
                        TextEntry::make('description')->label('Description'),
                        SpatieMediaLibraryImageEntry::make('image')->label('Image'),
                        TextEntry::make('created_at')->label('Created At')->since()
                    ])->columns(2),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLookups::route('/'),
            'create' => Pages\CreateLookup::route('/create'),
            'view' => Pages\ViewLookup::route('/{record}'),
            'edit' => Pages\EditLookup::route('/{record}/edit'),
        ];
    }
}
