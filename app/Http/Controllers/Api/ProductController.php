<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Requests\ProductCreateRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductController extends BaseController
{
    public function __construct(protected ProductService $productService){}

    /**
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $name = $request->input("name");
        $perPage = $request->input("per_page") ?? 15;
        $categoryId = $request->input("category_id") ?? null;
        $products = $this->productService->paginateWithNameAndCategory($perPage, $name, $categoryId);
        return ProductResource::collection($products);
    }

    /**
     * @param ProductCreateRequest $request
     * @return JsonResource
     */
    public function store(ProductCreateRequest $request): JsonResource
    {
        $product = $this->productService->create($request->validated());
        return (new ProductResource($product))->additional(
            ["message" => "Product successfully created"],
        );
    }

    /**
     * @param int $id
     * @return JsonResponse|JsonResource
     */
    public function show(int $id): JsonResponse|JsonResource
    {
        $category = $this->productService->find($id);
        if (!$category) {
            return $this->sendError("Product not found");
        }

        return new ProductResource($category);
    }

    /**
     * @param ProductUpdateRequest $request
     * @param int $id
     * @return JsonResource
     */
    public function update(ProductUpdateRequest $request, int $id): JsonResource
    {
        $category = $this->productService->updateWithFail($request->validated(), $id);
        return (new ProductResource($category))->additional(
            ["message" => "Product successfully updated"],
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $data = $this->productService->destroy($id);
        if (!$data) {
            return $this->sendError("Product doesnt deleted");
        }

        return $this->sendResponse([], "Product successfully deleted");
    }
}
