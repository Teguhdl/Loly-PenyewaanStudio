<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Domain\Users\Services\UpdateUserProfileService;
use App\Domain\Users\Repositories\UserProfileRepositoryInterface;

class ProfileController extends Controller
{
    private $updateService;
    private $profileRepo;

    public function __construct(
        UpdateUserProfileService $updateService,
        UserProfileRepositoryInterface $profileRepo
    ) {
        $this->updateService = $updateService;
        $this->profileRepo = $profileRepo;
    }

    public function edit()
    {
        $user   = Auth::user();
        $userId = $user->id;
        $profile = $this->profileRepo->findByUserId($userId) ?? $this->profileRepo->createEmptyProfile($userId);
        return view('user.profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('avatars', $filename, 'public');
        }

        $this->updateService->update($user->id, $validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
