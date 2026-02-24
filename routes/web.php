<?php

use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\SystemSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\EditorExpertiseController;
use App\Http\Controllers\Admin\ExpertiseCategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChiefEditorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Make sure this is at the top of the file

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : view('welcome');
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
    Route::get('/submissions/{submission}/download', [ReviewController::class, 'downloadFile'])->name('submissions.download');

    Route::middleware('role:author')->group(function (): void {
        Route::get('/dashboard/author', [DashboardController::class, 'author'])->name('dashboard.author');
        Route::resource('submissions', SubmissionController::class)->except('destroy');
        Route::get('/submissions/{submission}/revisions', [SubmissionController::class, 'revisions'])->name('submissions.revisions');
        Route::post('/submissions/{submission}/submit-revision', [SubmissionController::class, 'submitRevision'])->name('submissions.submit-revision');
    });

    Route::middleware('role:reviewer')->group(function (): void {
        Route::get('/dashboard/reviewer', [DashboardController::class, 'reviewer'])->name('dashboard.reviewer');
        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reviews/assignment/{assignment}/create', [ReviewController::class, 'create'])->name('reviews.create');
        Route::get('/reviews/revision/{revisionRequest}/create', [ReviewController::class, 'revisionCreate'])->name('reviews.revision-create');
        Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
        Route::get('/reviewer/pending-assignments', [ReviewController::class, 'pendingReviewerAssignments'])->name('reviewer.pending-assignments');
        Route::post('/reviewer/submissions/{submission}/request-revision', [ReviewController::class, 'reviewerRequestRevision'])->name('reviewer.request-revision');
        Route::post('/reviewer/invitation/{assignment}/accept',  [ReviewController::class, 'acceptInvitation'])->name('reviewer.invitation.accept');
        Route::post('/reviewer/invitation/{assignment}/decline', [ReviewController::class, 'declineInvitation'])->name('reviewer.invitation.decline');
        Route::get('/reviews/revision/{revisionReview}/create', [ReviewController::class, 'createRevisionReview'])->name('reviews.revision-review-create');
        Route::post('/reviews/revision', [ReviewController::class, 'storeRevisionReview'])->name('reviews.revision-store');
    });

    Route::middleware('role:editor')->group(function (): void {
        Route::get('/dashboard/editor', [DashboardController::class, 'editor'])->name('dashboard.editor');
        Route::get('/editor/submissions', [ReviewController::class, 'editorSubmissions'])->name('editor.submissions');
        Route::get('/editor/submissions/{submission}', [ReviewController::class, 'editorShow'])->name('editor.submission.show');
        Route::get('/editor/submissions/{submission}/initial-screening', [ReviewController::class, 'editorInitialScreening'])->name('editor.initial-screening');
        Route::post('/editor/submissions/{submission}/initial-screening', [ReviewController::class, 'storeInitialScreening'])->name('editor.store-initial-screening');
        Route::post('/editor/submissions/{submission}/assign-reviewer', [ReviewController::class, 'assignReviewer'])->name('editor.assign-reviewer');
        Route::post('/editor/submissions/{submission}/decision', [ReviewController::class, 'editorDecision'])->name('editor.decision');
        Route::post('/editor/submissions/{submission}/request-revision', [ReviewController::class, 'requestRevision'])->name('editor.request-revision');
        Route::get('/editor/revision-reviews', [ReviewController::class, 'editorRevisionReviews'])->name('editor.revision-reviews');
        Route::post('/editor/submissions/{submission}/revision-decision', [ReviewController::class, 'editorRevisionDecision'])->name('editor.revision-decision');
    });

    Route::middleware('role:editor-in-chief')->group(function (): void {
        Route::get('/chief-editor/dashboard', [ChiefEditorController::class, 'dashboard'])->name('chief-editor.dashboard');
        Route::get('/chief-editor/submissions/{submission}', [ChiefEditorController::class, 'showSubmission'])->name('chief-editor.submission.show');
        Route::get('/chief-editor/submissions/{submission}/initial-screening', [ChiefEditorController::class, 'initialScreening'])->name('chief-editor.initial-screening');
        Route::post('/chief-editor/submissions/{submission}/initial-screening', [ChiefEditorController::class, 'storeInitialScreening'])->name('chief-editor.store-initial-screening');
        Route::post('/chief-editor/submissions/{submission}/assign', [ChiefEditorController::class, 'assignSubmission'])->name('chief-editor.assign');
        Route::post('/chief-editor/submissions/{submission}/reassign', [ChiefEditorController::class, 'reassignSubmission'])->name('chief-editor.reassign');
        Route::post('/chief-editor/submissions/{submission}/review', [ChiefEditorController::class, 'reviewSubmission'])->name('chief-editor.review');
        Route::post('/chief-editor/submissions/{submission}/request-revision', [ChiefEditorController::class, 'requestRevision'])->name('chief-editor.request-revision');
    });

    Route::middleware('role:admin')->group(function (): void {
        Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
        Route::resource('admin/users', AdminUserController::class)->except('show')->names('admin.users')->parameters(['users' => 'user']);

        // Role Management
        Route::get('/admin/roles', [AdminRoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/admin/roles/{role}/edit', [AdminRoleController::class, 'edit'])->name('admin.roles.edit');
        Route::put('/admin/roles/{role}', [AdminRoleController::class, 'update'])->name('admin.roles.update');
        Route::delete('/admin/roles/{role}', [AdminRoleController::class, 'destroy'])->name('admin.roles.destroy'); // Fixed: Added destroy route

        Route::get('/admin/settings', [SystemSettingController::class, 'index'])->name('admin.settings.index');
        Route::put('/admin/settings', [SystemSettingController::class, 'update'])->name('admin.settings.update');

        // Submission Management
        Route::get('/admin/submissions', [ReviewController::class, 'adminSubmissions'])->name('admin.submissions');
        Route::get('/admin/submissions/{submission}', [ReviewController::class, 'adminShow'])->name('admin.submissions.show');
        Route::patch('/admin/submissions/{submission}/update', [ReviewController::class, 'adminUpdateSubmission'])->name('admin.submissions.update');

        // Editor Expertise Management
        Route::get('/admin/editor-expertise', [EditorExpertiseController::class, 'index'])->name('admin.editor-expertise.index');
        Route::get('/admin/editor-expertise/{user}', [EditorExpertiseController::class, 'show'])->name('admin.editor-expertise.show');
        Route::get('/admin/editor-expertise/{user}/edit', [EditorExpertiseController::class, 'edit'])->name('admin.editor-expertise.edit');
        Route::put('/admin/editor-expertise/{user}', [EditorExpertiseController::class, 'update'])->name('admin.editor-expertise.update');
        Route::post('/admin/editor-expertise/{user}/add-field', [EditorExpertiseController::class, 'addField'])->name('admin.editor-expertise.add-field');
        Route::delete('/admin/editor-expertise/{expertise}', [EditorExpertiseController::class, 'removeField'])->name('admin.editor-expertise.remove-field');

        // Expertise Categories Management
        Route::get('/admin/expertise-categories', [ExpertiseCategoryController::class, 'index'])->name('admin.expertise-categories.index');
        Route::post('/admin/expertise-categories', [ExpertiseCategoryController::class, 'store'])->name('admin.expertise-categories.store');
        Route::put('/admin/expertise-categories/{expertiseCategory}', [ExpertiseCategoryController::class, 'update'])->name('admin.expertise-categories.update');
        Route::delete('/admin/expertise-categories/{expertiseCategory}', [ExpertiseCategoryController::class, 'destroy'])->name('admin.expertise-categories.destroy');
    });

    Route::post('/notifications/{notification}/read', function (\App\Models\Notification $notification) {
        $notification->markAsRead();
        return response()->json(['ok' => true]);
    })->name('notifications.read')->middleware('auth');
});
