<?php

namespace App\Http\Resources;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $discountedPrice = null;
        $discountRate = null;

        $activeDiscounts = $this->discounts()
            ->whereHas('discount', function ($query) {
                $query->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
            })
            ->get();

        if ($activeDiscounts->isNotEmpty()) {
            foreach ($activeDiscounts as $discountable) {
                $discount = $discountable->discount;

                if ($discount->type === 'percentage') {
                    $discountedPrice = $this->price - ($this->price * ($discount->amount / 100));
                    $discountRate = intval($discount->amount) . '%';
                } elseif ($discount->type === 'amount') {
                    $discountedPrice = $this->price - $discount->amount;
                    $discountRate = intval($discount->amount) . ' JOD';
                }
            }
        }

        $properties = [];
        foreach ($this->ProductPropertyValue as $productPropertyValue) {
            $propertySlug = $productPropertyValue->propertyValue->property->slug;
            $propertyValue = $productPropertyValue->propertyValue->value;

            if (!isset($properties[$propertySlug])) {
                $properties[$propertySlug] = [];
            }
            $properties[$propertySlug][] = [
                'slug' => $productPropertyValue->propertyValue->slug,
                'name' => $propertyValue
            ];
        }

        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'rate' => number_format($this->rate, 2),
            'price' => number_format($discountedPrice ?? $this->price, 2),
            'price_before_discount' => $discountedPrice ? number_format($this->price, 2) : null,
            'discount_rate' => $discountRate,
            'properties' => $properties,
            'media' => $this->getFirstMediaUrl('products'),
        ];
    }
}
