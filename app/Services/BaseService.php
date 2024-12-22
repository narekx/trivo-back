<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService
{
    /**
     * @var
     */
    protected $baseModel;

    /**
     *
     */
    public function __construct()
    {
        $this->baseModel = app($this->getModel());
    }

    /**
     * @return string
     */
    protected abstract function getModel(): string;

    /**
     * @param array $columns
     * @return Collection
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getAll(array $columns = ["*"]): Collection
    {
        return $this->baseModel->get($columns);
    }

    /**
     * @param int $perPage
     * @return mixed
     */
    public function paginate(int $perPage = 15, array $columns = ["*"]): LengthAwarePaginator
    {
        return $this->baseModel->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->baseModel->create($data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id, array $columns = ["*"]): mixed
    {
        return $this->baseModel->find($id, $columns);
    }

    /**
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail(int $id, array $columns = ["*"])
    {
        return $this->baseModel->findOrFail($id, $columns);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool|null
     */
    public function update(array $data, int $id): mixed
    {
        $model = $this->baseModel->find($id);
        if (!$model) {
            return null;
        }

        return $model->update($data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function updateWithFail(array $data, int $id): mixed
    {
        $model = $this->baseModel->findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * @param $id
     * @return bool|null
     */
    public function destroy($id): bool | null
    {
        $model = $this->baseModel->find($id);
        if (!$model) {
            return null;
        }

        return $model->delete();
    }

    /**
     * @param $id
     * @return boolean
     */
    public function destroyOrFail($id): bool
    {
        $model = $this->baseModel->findOrFail($id);
        return $model->delete();
    }

    /**
     * @param array $columns
     * @param int $limit
     * @param $orderByColumn
     * @return Collection
     */
    public function getLatest(array $columns = ["*"], int $limit = 3, $orderByColumn = "id"): Collection
    {
        return $this->baseModel
            ->orderBy($orderByColumn, "desc")
            ->limit($limit)
            ->get($columns);
    }
}
