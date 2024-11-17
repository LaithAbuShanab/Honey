<?php

namespace App\Filament\Resources\LookupResource\Pages;

use App\Filament\Resources\LookupResource;
use App\Models\Lookup;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListLookups extends ListRecords
{
    protected static string $resource = LookupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // public function getTabs(): array
    // {
    //     $parentLookups = Lookup::whereNull('parent_id')->get(); // Get only parent lookups
    //     $tabs = [];
    //     foreach ($parentLookups as $parent) {
    //         $tabs[] = Tab::make($parent->title)
    //             ->modifyQueryUsing(fn(Builder $query) => $query->where('parent_id', $parent->id));
    //     }
    //     return $tabs;
    // }
}
