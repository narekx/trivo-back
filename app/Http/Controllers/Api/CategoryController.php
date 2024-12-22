<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\CategoryService;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryController extends BaseController
{
    public function __construct(protected CategoryService $categoryService){}

    /**
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $name = $request->input("name");
        $perPage = $request->input("per_page") ?? 15;
        $categories = $this->categoryService->paginateWithName($perPage, $name);
        return CategoryResource::collection($categories);
    }

    /**
     * @param CategoryCreateRequest $request
     * @return JsonResource
     */
    public function store(CategoryCreateRequest $request): JsonResource
    {
        $category = $this->categoryService->create($request->validated());
        return (new CategoryResource($category))->additional(
            ["message" => "Category successfully created"],
        );
    }

    /**
     * @param int $id
     * @return JsonResponse|JsonResource
     */
    public function show(int $id): JsonResponse|JsonResource
    {
        $category = $this->categoryService->find($id);
        if (!$category) {
            return $this->sendError("Category not found");
        }

        return new CategoryResource($category);
    }

    /**
     * @param CategoryUpdateRequest $request
     * @param int $id
     * @return JsonResource
     */
    public function update(CategoryUpdateRequest $request, int $id): JsonResource
    {
        $category = $this->categoryService->updateWithFail($request->validated(), $id);
        return (new CategoryResource($category))->additional(
            ["message" => "Category successfully updated"],
        );
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $data = $this->categoryService->destroy($id);
        if (!$data) {
            return $this->sendError("Category doesnt deleted");
        }

        return $this->sendResponse([], "Category successfully deleted");
    }

    public function getAll(): JsonResource
    {
        $data = $this->categoryService->getAll(["id", "name"]);
        return CategoryResource::collection($data);
    }
}
