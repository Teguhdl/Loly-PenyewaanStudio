<?php

namespace App\Domain\Users\Repositories;

use App\Domain\Users\Entities\UserEntity;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?UserEntity;
    public function create(array $data): UserEntity;
}
