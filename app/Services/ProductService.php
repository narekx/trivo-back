<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService extends BaseService
{
    /**
     * @return Product
     */
    protected function getModel(): string
    {
        return Product::class;
    }

    public function paginateWithNameAndCategory(
        int $perPage = 15,
        string $name = null,
        int $category_id = null,
        array $columns = ["*"]
    ): LengthAwarePaginator
    {
        $query = $this->baseModel->query();
        if ($name) {
            $query = $query->where("name", "like", "%$name%");
        }

        if ($category_id) {
            $query = $query->where("category_id", $category_id);
        }

        return $query->paginate($perPage, $columns);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id, array $columns = ["*"]): mixed
    {
        return $this->baseModel->with("category")->find($id, $columns);
    }
}
