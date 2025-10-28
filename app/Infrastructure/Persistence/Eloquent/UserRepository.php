<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Models\User;
use App\Domain\Users\Entities\UserEntity;
use App\Domain\Users\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?UserEntity
    {
        $user = User::where('email', $email)->first();
        return $user ? new UserEntity($user->id, $user->name, $user->email, $user->role) : null;
    }

    public function create(array $data): UserEntity
    {
        $user = User::create($data);
        return new UserEntity($user->id, $user->name, $user->email, $user->role);
    }
}
