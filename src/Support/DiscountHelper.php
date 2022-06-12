<?php

namespace Support;

use Domain\Order\Contracts\Services\DiscountServiceInterface;
use Domain\Order\Contracts\Services\OrderServiceInterface;
use Domain\Order\Models\Discount;
use Domain\Order\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as ResponseCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DiscountHelper
{
    protected DiscountServiceInterface $discountService;
    protected OrderServiceInterface $orderService;
    protected Collection $discounts;
    protected Order $order;
    protected array $discountsExport;

    public function __construct()
    {
        $this->discountService = resolve(DiscountServiceInterface::class);
        $this->orderService = resolve(OrderServiceInterface::class);
    }

    public function setOrder(int $orderId): self
    {
        $this->order = $this->orderService->firstOrFail(['id' => $orderId], ['items.product']);

        $this->discountsExport = [
            'order_id' => $orderId,
            'discounts' => collect([]),
            'total_discount' => 0,
            'discounted_total' => $this->order->total,
        ];

        return $this;
    }

    /**
     * @return array
     */
    public function orderDiscounts(): array
    {
        $this->discounts = $this->discountService->get();

        if ($this->discounts->count() == 0) {
            return $this->discountsExport;
        }

        foreach ($this->discounts as $discount) {
            $apply = $this->setRules($discount);

            if ($apply) {
                $this->applyDiscount($discount);
            }
        }

        $this->calculateDiscount();

        return $this->discountsExport;
    }

    /**
     * Uygulanan indirimler hesaplanıyor.
     *
     * @return void
     */
    private function calculateDiscount(): void
    {
        $this->discountsExport['total_discount'] = $this->discountsExport['discounts']->sum('amount');
        $this->discountsExport['discounted_total'] = $this->discountsExport['discounted_total'] - $this->discountsExport['discounts']->sum('amount');
    }

    /**
     * İndirim kuralları karşılanıyor mu ?
     *
     * @param Discount $discount
     * @return bool
     */
    private function setRules(Discount $discount): bool
    {
        $apply = true;

        $conditions = Arr::except($discount->rules['conditions'], 'category_id');

        foreach ($conditions as $key => $value) {
            if (!$this->{Str::camel($key)}($value, Arr::get($discount->rules['conditions'], 'category_id'))) {
                $apply = false;
            }
        }

        return $apply;
    }

    /**
     * Min ürün sayısı karşılanıyor mu?
     *
     * @param int $count
     * @param int|null $categoryId
     * @return bool
     */
    private function minCount(int $count, ?int $categoryId): bool
    {
        return !is_numeric($categoryId)
            ? $this->order->items->sum('quantity') >= $count
            : $this->order->items->where('product.category_id', $categoryId)->sum('quantity') >= $count;
    }

    /**
     * Min tutar karşılanıyor mu?
     *
     * @param float $price
     * @param int|null $categoryId
     * @return bool
     */
    private function minPrice(float $price, ?int $categoryId): bool
    {
        return !is_numeric($categoryId)
            ? $this->order->items->sum('price') >= $price
            : $this->order->items->where('product.category_id', $categoryId)->sum('price') >= $price;
    }

    /**
     * İndirimi uygula
     *
     * @param Discount $discount
     * @return void
     */
    private function applyDiscount(Discount $discount): void
    {
        $discountRules = Arr::except($discount->rules, 'conditions');
        $arrayKeys = array_keys($discountRules);
        foreach ($arrayKeys as $arrayKey) {
            $this->{Str::camel($arrayKey)}($discountRules[$arrayKey], $discount->reason);
        }
    }

    /**
     * İndirimi ekle
     *
     * @param float $amount
     * @param string $reason
     * @return void
     */
    private function addDiscount(float $amount, string $reason): void
    {
        $this->discountsExport['discounts']->add([
            'reason' => $reason,
            'amount' => $amount,
        ]);
    }

    /**
     * @param string $sort
     * @return string
     */
    private function getSortMethod(string $sort): string
    {
        return Str::lower($sort) == 'asc'
            ? 'sortBy'
            : 'sortByDesc';
    }

    /**
     * Koşula göre ücretsiz olarak belirle.
     *
     * @param array $free
     * @param string $reason
     * @return void
     */
    private function firstFree(array $free, string $reason): void
    {
        $orderItem = $this->order->items->{$this->getSortMethod($free['sort'])}($free['column'])->first();
        $this->addDiscount($orderItem->unit_price, $reason);
    }

    /**
     * Koşula göre indirim uygula.
     *
     * @param array $firstDiscountRate
     * @param string $reason
     * @return void
     */
    private function firstDiscountRate(array $firstDiscountRate, string $reason): void
    {
        $orderItem = $this->order->items->{$this->getSortMethod($firstDiscountRate['sort'])}($firstDiscountRate['column'])->first();
        $this->addDiscount(($orderItem->unit_price / 100) * $firstDiscountRate['discount_rate'], $reason);
    }

    /**
     * İndirim uygula.
     *
     * @param int $discountRate
     * @param string $reason
     * @return void
     */
    private function discountRate(int $discountRate, string $reason): void
    {
        $total = $this->order->items->sum('price');
        $this->addDiscount(($total / 100) * $discountRate, $reason);
    }
}
