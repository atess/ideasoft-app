<?php

namespace Database\Seeders;

use Domain\Order\Contracts\Services\DiscountServiceInterface;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $discountService = resolve(DiscountServiceInterface::class);

        $discounts = [
            [
                'reason' => 'CATEGORY_BUY_5_GET_1',
                'rules' => [
                    'conditions' => [
                        'category_id' => 2,
                        'min_count' => 6,
                    ],
                    'first_free' => [
                        'column' => 'price',
                        'sort' => 'asc',
                    ],
                ],
            ],
            [
                'reason' => '10_PERCENT_OVER_1000',
                'rules' => [
                    'conditions' => [
                        'min_price' => 1000,
                    ],
                    'discount_rate' => 10,
                ],
            ],
            [
                'reason' => 'CATEGORY_20_PERCENT_2_COUNT',
                'rules' => [
                    'conditions' => [
                        'category_id' => 1,
                        'min_count' => 2,
                    ],
                    'first_discount_rate' => [
                        'column' => 'price',
                        'sort' => 'asc',
                        'discount_rate' => 20,
                    ],
                ],
            ],
        ];

        foreach ($discounts as $discount) {
            $discountService->updateOrCreate(['reason' => $discount['reason']], $discount);
        }
    }
}
