<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService extends BaseService
{
    /**
     * @return Category
     */
    protected function getModel(): string
    {
        return Category::class;
    }

    public function paginateWithName(int $perPage = 15, string $name = null, array $columns = ["*"]): LengthAwarePaginator
    {
        $query = $this->baseModel->query();
        if ($name) {
            $query = $query->where("name", "like", "%$name%");
        }

        return $query->paginate($perPage, $columns);
    }
}
