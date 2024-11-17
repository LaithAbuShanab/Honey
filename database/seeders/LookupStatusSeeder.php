<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LookupStatus;

class LookupStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            // Order Statuses
            [
                'name' => ['en' => 'Pending', 'ar' => 'قيد الانتظار'],
                'slug' => 'pending',
                'sort' => 1,
                'is_active' => true,
                'bg_color' => '#FFC107',
                'font_color' => '#000000',
            ],
            [
                'name' => ['en' => 'Processing', 'ar' => 'قيد المعالجة'],
                'slug' => 'processing',
                'sort' => 2,
                'is_active' => true,
                'bg_color' => '#17A2B8',
                'font_color' => '#FFFFFF',
            ],
            [
                'name' => ['en' => 'Shipped', 'ar' => 'تم الشحن'],
                'slug' => 'shipped',
                'sort' => 3,
                'is_active' => true,
                'bg_color' => '#007BFF',
                'font_color' => '#FFFFFF',
            ],
            [
                'name' => ['en' => 'Delivered', 'ar' => 'تم التوصيل'],
                'slug' => 'delivered',
                'sort' => 4,
                'is_active' => true,
                'bg_color' => '#28A745',
                'font_color' => '#FFFFFF',
            ],
            [
                'name' => ['en' => 'Cancelled', 'ar' => 'تم الإلغاء'],
                'slug' => 'cancelled',
                'sort' => 5,
                'is_active' => true,
                'bg_color' => '#DC3545',
                'font_color' => '#FFFFFF',
            ],

            // Payment Statuses
            [
                'name' => ['en' => 'Pending Payment', 'ar' => 'في انتظار الدفع'],
                'slug' => 'pending-payment',
                'sort' => 6,
                'is_active' => true,
                'bg_color' => '#FFC107',
                'font_color' => '#000000',
            ],
            [
                'name' => ['en' => 'Paid', 'ar' => 'مدفوع'],
                'slug' => 'paid',
                'sort' => 7,
                'is_active' => true,
                'bg_color' => '#28A745',
                'font_color' => '#FFFFFF',
            ],
            [
                'name' => ['en' => 'Failed', 'ar' => 'فشل'],
                'slug' => 'failed',
                'sort' => 8,
                'is_active' => true,
                'bg_color' => '#DC3545',
                'font_color' => '#FFFFFF',
            ],
            [
                'name' => ['en' => 'Refunded', 'ar' => 'تم الاسترداد'],
                'slug' => 'refunded',
                'sort' => 9,
                'is_active' => true,
                'bg_color' => '#17A2B8',
                'font_color' => '#FFFFFF',
            ],

            // Item Statuses
            [
                'name' => ['en' => 'In Stock', 'ar' => 'متوفر'],
                'slug' => 'in-stock',
                'sort' => 10,
                'is_active' => true,
                'bg_color' => '#28A745',
                'font_color' => '#FFFFFF',
            ],
            [
                'name' => ['en' => 'Out of Stock', 'ar' => 'غير متوفر'],
                'slug' => 'out-of-stock',
                'sort' => 11,
                'is_active' => true,
                'bg_color' => '#DC3545',
                'font_color' => '#FFFFFF',
            ],
            [
                'name' => ['en' => 'Backordered', 'ar' => 'طلب مسبق'],
                'slug' => 'backordered',
                'sort' => 12,
                'is_active' => true,
                'bg_color' => '#FFC107',
                'font_color' => '#000000',
            ],
        ];

        foreach ($statuses as $status) {
            LookupStatus::updateOrCreate(
                ['slug' => $status['slug']],
                [
                    'name' => $status['name'],
                    'sort' => $status['sort'],
                    'is_active' => $status['is_active'],
                    'bg_color' => $status['bg_color'],
                    'font_color' => $status['font_color'],
                ]
            );
        }
    }
}
