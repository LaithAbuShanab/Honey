<?php

namespace App\Repositories;

use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductRepository
{
    public function all()
    {
        return ProductResource::collection(Product::where('is_active', 1)->latest()->get());
    }

    public function updatePrice(array $data, string $slug)
    {
        $color = $data['color'] ?? null;
        $weight = $data['weight'] ?? null;

        $product = Product::where('slug', $slug)->first();

        $price = $product->price;
        $discountedPrice = $this->getDiscountedPrice($product);

        foreach (['color' => $color, 'weight' => $weight] as $valueSlug) {
            if ($valueSlug) {
                $priceVariation = $this->getPropertyPriceVariation($product, $valueSlug);
                $price += $priceVariation;

                if ($discountedPrice !== null) {
                    $discountedPrice += $priceVariation;
                }
            }
        }

        return [
            'price' => $discountedPrice ?? $price
        ];
    }

    private function getDiscountedPrice(Product $product): ?float
    {
        $activeDiscount = $product->discounts()
            ->whereHas('discount', function ($query) {
                $query->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now());
            })
            ->first();

        if (!$activeDiscount) {
            return null;
        }

        $discount = $activeDiscount->discount;
        if ($discount->type === 'percentage') {
            return $product->price - ($product->price * ($discount->amount / 100));
        } elseif ($discount->type === 'amount') {
            return $product->price - $discount->amount;
        }
    }

    private function getPropertyPriceVariation(Product $product, string $slug): float
    {
        $value = $product->ProductPropertyValue()->whereHas('propertyValue', function ($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();

        if (!$value) {
            throw new \Exception(__('app.somethingwentwrong'));
        }

        return $value->price_variation;
    }
}
