<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LookupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            $this->mergeWhen($this->children && $this->children->isNotEmpty(), [
                'children' => LookupResource::collection(
                    $this->children->sortBy('sort')
                ),
            ]),
            'media' => $this->getFirstMediaUrl(),
        ];
    }
}
