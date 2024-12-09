<?php

namespace App\Filament\Resources\LookupResource\RelationManagers;

use App\Filament\Resources\LookupResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\lookup;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    public function form(Form $form): Form
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
            Forms\Components\TextInput::make('sort')
                ->placeholder('Please enter sort')
                ->numeric(),
            SpatieMediaLibraryFileUpload::make('image'),
            Forms\Components\Toggle::make('is_active')
                ->inline(false)
                ->required(),
        ])->columns(2);    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort')
                    ->numeric()
                    ->sortable(),
                    Tables\Columns\ToggleColumn::make('is_active'),
                SpatieMediaLibraryImageColumn::make('image'),
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
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->url(fn (lookup $record): string => LookupResource::getUrl('edit', ['record' => $record])),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('General')
                    ->schema([
                        TextEntry::make('title')->label('Title'),
                        TextEntry::make('description')->label('Description')->html(),
                        SpatieMediaLibraryImageEntry::make('image')->label('Image'),
                        TextEntry::make('created_at')->label('Created At')->since()
                    ])->columns(2),
            ]);
    }
}
