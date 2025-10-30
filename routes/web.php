<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\{
    UserController,
    DashboardController,
    CategoryController,
    VirtualWorldController,
    RentalController
};
use App\Http\Controllers\User\{
    DashboardUserController,
    ProfileController,
    RentalUserController
};


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('categories', CategoryController::class)->except(['show']);

    Route::get('/categories', [CategoryController::class,'index'])->name('admin.categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class,'edit'])->name('admin.categories.edit');
    Route::post('/categories/{category}', [CategoryController::class,'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [CategoryController::class,'destroy'])->name('admin.categories.destroy');

    Route::get('/virtual-worlds', [VirtualWorldController::class,'index'])->name('admin.virtual_worlds.index');
    Route::get('/virtual-worlds/create', [VirtualWorldController::class, 'create'])->name('admin.virtual_worlds.create');
    Route::post('/virtual-worlds', [VirtualWorldController::class, 'store'])->name('admin.virtual_worlds.store');
    Route::get('/virtual-worlds/{virtualWorld}/edit', [VirtualWorldController::class,'edit'])->name('admin.virtual_worlds.edit');
    Route::post('/virtual-worlds/{virtualWorld}', [VirtualWorldController::class,'update'])->name('admin.virtual_worlds.update');
    Route::delete('/virtual-worlds/{virtualWorld}', [VirtualWorldController::class,'destroy'])->name('admin.virtual_worlds.destroy');

    Route::get('/users', [UserController::class,'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class,'edit'])->name('admin.users.edit');
    Route::post('/users/{user}', [UserController::class,'update'])->name('admin.users.update');

    Route::get('/rental', [RentalController::class,'index'])->name('admin.rental.index');

});


Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [DashboardUserController::class, 'index'])->name('user.dashboard');
    Route::get('/rent-a-world', [RentalUserController::class, 'index'])->name('user.rentals.index');
    Route::post('/rent-a-world', [RentalUserController::class, 'store'])->name('user.rentals.store');
    Route::get('/rent/history', [DashboardUserController::class, 'index'])->name('user.rentals.history');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('user.profile.update');

});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
