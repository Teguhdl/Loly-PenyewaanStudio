<?php
namespace App\Domain\VirtualWorlds\Services;

use App\Domain\VirtualWorlds\Repositories\VirtualWorldRepositoryInterface;

class VirtualWorldService
{
    protected $repo;

    public function __construct(VirtualWorldRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function all() { return $this->repo->all(); }
    public function find(int $id) { return $this->repo->find($id); }
    public function create(array $data) { return $this->repo->create($data); }
    public function update(int $id, array $data) { return $this->repo->update($id, $data); }
    public function delete(int $id) { return $this->repo->delete($id); }
}
