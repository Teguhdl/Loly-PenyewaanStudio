<?php

namespace App\Domain\VirtualWorlds\Repositories;

use App\Models\VirtualWorld;

interface VirtualWorldRepositoryInterface
{
    public function all();
    public function find(int $id): ?VirtualWorld;
    public function create(array $data);
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}

