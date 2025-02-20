<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KontraktorProfileController;
use App\Http\Controllers\Admin\KontraktorApprovalController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskInteractionController;

Route::post('/task/{task}/like', [TaskInteractionController::class, 'likeTask'])->name('task.like');
Route::post('/task/{task}/comment', [TaskInteractionController::class, 'commentTask'])->name('task.comment');
Route::post('/task/{task}/interest', [TaskInteractionController::class, 'interestTask'])->name('task.interest');
Route::get('/', [HomeController::class, 'index'])->name('homepage');
Route::middleware('auth')->group(function () {
    Route::get('/user/task', [TaskController::class, 'showTaskForm'])->name('user.task');
    Route::post('/user/task/post', [TaskController::class, 'postTask'])->name('user.task.post');
});
Route::middleware('auth')->group(function () {
    Route::get('/user/profile', [UserProfileController::class, 'showProfileForm'])->name('user.profile');
    Route::post('/user/profile/save', [UserProfileController::class, 'saveProfile'])->name('user.profile.save');
});
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/approve/{id}', [KontraktorApprovalController::class, 'showApprovalForm'])->name('admin.approve_kontraktor');
    Route::put('/approve/{id}', [KontraktorApprovalController::class, 'approve'])->name('admin.approve_kontraktor');
});



// // Route untuk tampilan
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Route untuk user
// Route::middleware('auth')->group(function () {
//     Route::get('/homepage', function () {
//         return view('homepage');
//     })->name('homepage');
// });

// Menampilkan semua data kontraktor (tidak memerlukan login)
Route::get('/kontraktor/show', [KontraktorProfileController::class, 'showAll'])
    ->name('kontraktor.show');

// Middleware untuk kontraktor yang sudah login
Route::middleware(['auth', 'kontraktor'])->group(function () {

    // Dashboard Kontraktor
    Route::get('/kontraktor/dashboard', function () {
        return view('kontraktor.dashboard');
    })->name('kontraktor.dashboard');

    // Rute terkait profil kontraktor
    Route::prefix('/kontraktor')->controller(KontraktorProfileController::class)->group(function () {
        Route::get('/profile', 'showProfileForm')->name('kontraktor.profile'); // Menampilkan form profil
        Route::post('/profile/save', 'saveProfile')->name('kontraktor.profile.save'); // Simpan perubahan profil
        Route::get('/show', 'show')->name('kontraktor.show'); // Menampilkan data kontraktor yang sedang login
    });

});

