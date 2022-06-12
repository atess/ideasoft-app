<?php

namespace Domain\Product\Http\Controllers;

use Base\Concretes\BaseController;
use Domain\Product\Contracts\Services\CategoryServiceInterface;
use Domain\Product\DataTransferObjects\CategoryData;
use Domain\Product\Http\Requests\StoreCategoryRequest;
use Domain\Product\Http\Requests\UpdateCategoryRequest;
use Domain\Product\Http\Resources\CategoryResource;
use Domain\Product\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CategoryController extends BaseController
{
    public function __construct(protected CategoryServiceInterface $service)
    {
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CategoryResource::collection(
            $this->service->queryPaginate()
        );
    }

    /**
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        return CategoryResource::make(
            $this->service->store(new CategoryData($request->validated()))
        )->response()->setStatusCode(201);
    }

    /**
     * @param int $categoryId
     * @return CategoryResource
     */
    public function show(int $categoryId): CategoryResource
    {
        return CategoryResource::make(
            $this->service->queryFindOrFail($categoryId)
        );
    }

    /**
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return CategoryResource
     * @throws UnknownProperties
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        return CategoryResource::make(
            $this->service->update($category, new CategoryData($request->validated()))
        );
    }

    /**
     * @param Category $category
     * @return Response
     */
    public function destroy(Category $category): Response
    {
        $this->service->destroy($category);
        return response()->noContent();
    }
}
