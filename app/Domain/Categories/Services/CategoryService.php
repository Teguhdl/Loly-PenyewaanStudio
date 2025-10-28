<?php
namespace App\Domain\Categories\Services;

use App\Domain\Categories\Repositories\CategoryRepositoryInterface;

class CategoryService
{
    protected CategoryRepositoryInterface $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all() { return $this->repository->all(); }
    public function find(int $id) { return $this->repository->find($id); }
    public function create(array $data) { return $this->repository->create($data); }
    public function update(int $id, array $data) { return $this->repository->update($id, $data); }
    public function delete(int $id) { return $this->repository->delete($id); }
}
