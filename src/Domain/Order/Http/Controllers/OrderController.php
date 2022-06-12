<?php

namespace Domain\Order\Http\Controllers;

use Base\Concretes\BaseController;
use Domain\Order\Contracts\Services\OrderServiceInterface;
use Domain\Order\DataTransferObjects\OrderData;
use Domain\Order\Exceptions\CreateOrderException;
use Domain\Order\Exceptions\OutOfStockException;
use Domain\Order\Http\Requests\StoreOrderRequest;
use Domain\Order\Http\Resources\OrderResource;
use Domain\Order\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Support\OrderHelper;

class OrderController extends BaseController
{
    public function __construct(protected OrderServiceInterface $service)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return OrderResource::collection(
            $this->service->queryPaginate()
        );
    }

    /**
     * @param StoreOrderRequest $request
     * @return JsonResponse
     * @throws CreateOrderException
     * @throws OutOfStockException
     * @throws UnknownProperties
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        return OrderResource::make(
            (new OrderHelper())
                ->setOrderData(new OrderData($request->validated()))
                ->validate()
                ->create()
        )->response()->setStatusCode(201);
    }

    public function show(int $orderId): OrderResource
    {
        return OrderResource::make(
            $this->service->queryFindOrFail($orderId)
        );
    }

    public function destroy(Order $order): Response
    {
        $this->service->destroy($order);
        return response()->noContent();
    }
}
