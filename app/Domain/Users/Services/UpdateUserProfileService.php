<?php

namespace App\Domain\Users\Services;

use App\Domain\Users\Repositories\UserRepositoryInterface;
use App\Domain\Users\Repositories\UserProfileRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UpdateUserProfileService
{
    protected $userRepository;
    protected $profileRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserProfileRepositoryInterface $profileRepository
    ) {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }

    public function update(int $userId, array $data)
    {
        // Pisahkan data untuk tabel users
        $userData = [];
        if (isset($data['name']))  $userData['name']  = $data['name'];
        if (isset($data['email'])) $userData['email'] = $data['email'];
        if (!empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        // Update user basic info (jika ada yang berubah)
        if (!empty($userData)) {
            $this->userRepository->update($userId, $userData);
        }

        // Pisahkan data untuk tabel user_profiles
        $profileData = [];
        if (isset($data['address'])) $profileData['address'] = $data['address'];
        if (isset($data['phone']))   $profileData['phone']   = $data['phone'];
        if (isset($data['avatar']))  $profileData['avatar']  = $data['avatar'];

        // Update atau buat baru jika belum ada
        $this->profileRepository->updateOrCreate($userId, $profileData);

        return true;
    }
}
