<?php

use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:author')->group(function (): void {
        Route::get('/dashboard/author', [DashboardController::class, 'author'])->name('dashboard.author');
        Route::resource('submissions', SubmissionController::class)->except('destroy');
    });

    Route::middleware('role:reviewer')->group(function (): void {
        Route::get('/dashboard/reviewer', [DashboardController::class, 'reviewer'])->name('dashboard.reviewer');
        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reviews/assignment/{assignment}/create', [ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    });

    Route::middleware('role:editor')->group(function (): void {
        Route::get('/dashboard/editor', [DashboardController::class, 'editor'])->name('dashboard.editor');
        Route::get('/editor/submissions', [ReviewController::class, 'editorSubmissions'])->name('editor.submissions');
        Route::get('/editor/submissions/{submission}', [ReviewController::class, 'editorShow'])->name('editor.submission.show');
        Route::post('/editor/submissions/{submission}/assign-reviewer', [ReviewController::class, 'assignReviewer'])->name('editor.assign-reviewer');
        Route::post('/editor/submissions/{submission}/decision', [ReviewController::class, 'editorDecision'])->name('editor.decision');
    });

    Route::middleware('role:admin')->group(function (): void {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
        Route::resource('admin/users', AdminUserController::class)->except('show')->names('admin.users')->parameters(['users' => 'user']);
        Route::get('/admin/roles', [AdminRoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/admin/roles/{role}/edit', [AdminRoleController::class, 'edit'])->name('admin.roles.edit');
        Route::put('/admin/roles/{role}', [AdminRoleController::class, 'update'])->name('admin.roles.update');
        Route::get('/admin/settings', [SystemSettingController::class, 'index'])->name('admin.settings.index');
        Route::put('/admin/settings', [SystemSettingController::class, 'update'])->name('admin.settings.update');
    });
});
