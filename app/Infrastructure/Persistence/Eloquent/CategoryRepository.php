<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\Categories\Repositories\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::all();
    }

    public function find(int $id): ?Category
    {
        return Category::find($id);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $category = $this->find($id);
        if (!$category) return false;
        return $category->update($data);
    }

    public function delete(int $id): bool
    {
        $category = $this->find($id);
        if (!$category) return false;
        return $category->delete();
    }
}
