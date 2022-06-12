<?php

namespace Support;

use Domain\Order\Contracts\Repositories\OrderRepositoryInterface;
use Domain\Order\DataTransferObjects\OrderData;
use Domain\Order\Exceptions\CreateOrderException;
use Domain\Order\Exceptions\OutOfStockException;
use Domain\Order\Models\Order;
use Domain\Product\Contracts\Services\ProductServiceInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderHelper
{
    protected ProductServiceInterface $productService;
    protected Collection $products;
    protected OrderData $orderData;

    public function __construct()
    {
        $this->productService = resolve(ProductServiceInterface::class);
    }

    /**
     * @param OrderData $orderData
     * @return OrderHelper
     */
    public function setOrderData(OrderData $orderData): self
    {
        $this->orderData = $orderData;
        $this->products = $this->productService->getWhereIn('id', Arr::pluck($this->orderData->products, 'product_id'));

        return $this;
    }

    /**
     * @return OrderHelper
     * @throws OutOfStockException
     */
    public function validate(): self
    {
        $orderData = $this->orderData;

        $outOfStockExists = $this->products->first(function ($product) use ($orderData) {
            $find = Arr::first($orderData->products, function ($item) use ($product) {
                return $item->product_id == $product->id;
            });
            return $find->quantity > $product->stock;
        });

        if ($outOfStockExists) {
            throw new OutOfStockException();
        }

        return $this;
    }

    /**
     * @return Order
     * @throws CreateOrderException
     */
    public function create(): Order
    {
        $orderRepository = resolve(OrderRepositoryInterface::class);
        $products = $this->products;
        $total = 0;

        try {
            DB::beginTransaction();

            $order = $orderRepository->store([
                'user_id' => Auth::id(),
                'total' => $total,
            ]);

            Arr::map($this->orderData->products, function ($orderData) use ($order, $products, &$total) {
                $currentProduct = Arr::first($products, function ($product) use ($orderData) {
                    return $product->id == $orderData->product_id;
                });

                $rowTotal = $orderData->quantity * $currentProduct->price;
                $total += $rowTotal;

                $order->items()->create([
                    'product_id' => $orderData->product_id,
                    'quantity' => $orderData->quantity,
                    'unit_price' => $currentProduct->price,
                    'total' => $rowTotal,
                ]);
            });

            $order->update([
                'total' => $total,
            ]);

            DB::commit();
        } catch (CreateOrderException $createOrderException) {
            DB::rollBack();
            throw $createOrderException;
        }

        return $order->loadMissing('items');
    }
}
