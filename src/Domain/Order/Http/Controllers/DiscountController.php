<?php

namespace Domain\Order\Http\Controllers;

use Base\Concretes\BaseController;
use Domain\Order\Contracts\Services\DiscountServiceInterface;
use Domain\Order\DataTransferObjects\DiscountData;
use Domain\Order\Http\Requests\StoreDiscountRequest;
use Domain\Order\Http\Requests\UpdateDiscountRequest;
use Domain\Order\Http\Resources\DiscountResource;
use Domain\Order\Models\Discount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class DiscountController extends BaseController
{
    public function __construct(protected DiscountServiceInterface $service)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        return DiscountResource::collection(
            $this->service->queryPaginate()
        );
    }

    public function store(StoreDiscountRequest $request): JsonResponse
    {
        return DiscountResource::make(
            $this->service->store(new DiscountData($request->validated()))
        )->response()->setStatusCode(201);
    }

    public function show(int $discountId): DiscountResource
    {
        return DiscountResource::make(
            $this->service->queryFindOrFail($discountId)
        );
    }

    public function update(UpdateDiscountRequest $request, Discount $discount): DiscountResource
    {
        return DiscountResource::make(
            $this->service->update($discount, new DiscountData($request->validated()))
        );
    }

    public function destroy(Discount $discount): Response
    {
        $this->service->destroy($discount);
        return response()->noContent();
    }
}
