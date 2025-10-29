<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Models\UserProfile;
use App\Domain\Users\Entities\UserProfileEntity;
use App\Domain\Users\Repositories\UserProfileRepositoryInterface;

class UserProfileRepository implements UserProfileRepositoryInterface
{
    public function findByUserId(int $userId): ?UserProfileEntity
    {
        $profile = UserProfile::where('user_id', $userId)->first();
        return $profile ? new UserProfileEntity(
            $profile->id,
            $profile->user_id,
            $profile->address,
            $profile->phone,
            $profile->avatar
        ) : null;
    }

    public function updateOrCreate(int $userId, array $data): UserProfileEntity
    {
        $profile = UserProfile::updateOrCreate(
            ['user_id' => $userId],
            $data
        );

        return new UserProfileEntity(
            $profile->id,
            $profile->user_id,
            $profile->address,
            $profile->phone,
            $profile->avatar
        );
    }

    public function createEmptyProfile($userId): UserProfileEntity
    {
        $profile = UserProfile::create([
            'user_id' => $userId,
            'phone' => null,
            'address' => null,
            'bio' => null,
        ]);

        return new UserProfileEntity(
            $profile->id,
            $profile->user_id,
            $profile->phone,
            $profile->address,
            $profile->bio
        );
    }
}
