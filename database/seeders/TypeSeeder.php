<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => ['en' => 'Stock', 'ar' => 'مخزون'],
                'slug' => 'stock',
            ],
            [
                'name' => ['en' => 'Delivered', 'ar' => 'تم التوصيل'],
                'slug' => 'delivered',
            ],
        ];

        foreach ($types as $type) {
            Type::updateOrCreate(
                ['slug' => $type['slug']],
                [
                    'name' => $type['name'],
                ]
            );
        }
    }
}
