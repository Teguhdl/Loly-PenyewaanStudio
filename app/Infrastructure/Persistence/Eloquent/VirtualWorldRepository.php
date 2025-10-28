<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Domain\VirtualWorlds\Repositories\VirtualWorldRepositoryInterface;
use App\Models\VirtualWorld;

class VirtualWorldRepository implements VirtualWorldRepositoryInterface
{
    public function all()
    {
        return VirtualWorld::with('categories')->get();
    }

    public function find(int $id): ?VirtualWorld
    {
        return VirtualWorld::with('categories')->find($id);
    }

    public function create(array $data)
    {
        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $virtualWorld = VirtualWorld::create($data);
        $virtualWorld->categories()->sync($categories);

        return $virtualWorld;
    }

    public function update(int $id, array $data): bool
    {
        $virtualWorld = $this->find($id);
        if (!$virtualWorld) return false;

        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $virtualWorld->update($data);
        $virtualWorld->categories()->sync($categories);

        return true;
    }

    public function delete(int $id): bool
    {
        $virtualWorld = $this->find($id);
        if (!$virtualWorld) return false;

        $virtualWorld->categories()->detach();
        return $virtualWorld->delete();
    }
}
