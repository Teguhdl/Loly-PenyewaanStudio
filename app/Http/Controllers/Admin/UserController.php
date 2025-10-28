<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Domain\Users\Services\AuthService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
        $this->authService = $authService;
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,user',
        ]);

        $this->authService->register($request->only('name','email','password','role'));

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }
}
