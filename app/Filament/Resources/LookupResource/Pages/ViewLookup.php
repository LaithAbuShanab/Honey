<?php

namespace App\Filament\Resources\LookupResource\Pages;

use App\Filament\Resources\LookupResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLookup extends ViewRecord
{
    protected static string $resource = LookupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
