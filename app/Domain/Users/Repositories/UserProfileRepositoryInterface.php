<?php

namespace App\Domain\Users\Repositories;

use App\Domain\Users\Entities\UserProfileEntity;

interface UserProfileRepositoryInterface
{
    public function findByUserId(int $userId): ?UserProfileEntity;
    public function updateOrCreate(int $userId, array $data): UserProfileEntity;
    public function createEmptyProfile($userId): UserProfileEntity;
}
