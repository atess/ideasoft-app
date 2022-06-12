<?php

namespace Domain\Product\Http\Controllers;

use Base\Concretes\BaseController;
use Domain\Product\Contracts\Services\ProductServiceInterface;
use Domain\Product\DataTransferObjects\ProductData;
use Domain\Product\Http\Requests\StoreProductRequest;
use Domain\Product\Http\Requests\UpdateProductRequest;
use Domain\Product\Http\Resources\ProductResource;
use Domain\Product\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ProductController extends BaseController
{
    public function __construct(protected ProductServiceInterface $service)
    {
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ProductResource::collection(
            $this->service->queryPaginate()
        );
    }

    /**
     * @param StoreProductRequest $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        return ProductResource::make(
            $this->service->store(new ProductData($request->validated()))
        )->response()->setStatusCode(201);
    }

    /**
     * @param int $productId
     * @return ProductResource
     */
    public function show(int $productId): ProductResource
    {
        return ProductResource::make(
            $this->service->queryFindOrFail($productId)
        );
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return ProductResource
     * @throws UnknownProperties
     */
    public function update(UpdateProductRequest $request, Product $product): ProductResource
    {
        return ProductResource::make(
            $this->service->update($product, new ProductData($request->validated()))
        );
    }

    /**
     * @param Product $product
     * @return Response
     */
    public function destroy(Product $product): Response
    {
        $this->service->destroy($product);
        return response()->noContent();
    }
}
