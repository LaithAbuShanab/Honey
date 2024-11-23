<?php

namespace App\Repositories;

use App\Http\Resources\LookupResource;
use App\Models\Lookup;

class LookupRepository
{
    public function getBySlug($slug)
    {
        $lookup = Lookup::where(['slug' => $slug , 'is_active' => 1])->first();
        return new LookupResource($lookup);
    }
}
