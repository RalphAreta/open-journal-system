<?php

namespace App\Http\Controllers;

use App\Models\ReviewAssignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Redirect to role-specific dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Special handling for editor-in-chief
        if ($user?->isEditorInChief()) {
            return redirect()->route('chief-editor.dashboard');
        }

        $role = $user?->primaryRole();
        if ($role) {
            return redirect()->route("dashboard.{$role->name}");
        }
        return redirect()->route('login');
    }

   public function author(Request $request): View
{
    $user = $request->user();

    $submissions = $user->submissionsAsAuthor()
    ->with(['reviews' => function($q) {
        $q->latest();
    }])
    ->latest()
    ->paginate(10);

    $stats = [
        'total'               => $user->submissionsAsAuthor()->count(),
        'submitted'           => $user->submissionsAsAuthor()->where('status', Submission::STATUS_SUBMITTED)->count(),
        'under_review'        => $user->submissionsAsAuthor()->where('status', Submission::STATUS_UNDER_REVIEW)->count(),
        'revisions_requested' => $user->submissionsAsAuthor()->where('status', Submission::STATUS_REVISIONS_REQUESTED)->count(),
        'accepted'            => $user->submissionsAsAuthor()->where('status', Submission::STATUS_ACCEPTED)->count(),
        'rejected'            => $user->submissionsAsAuthor()->where('status', Submission::STATUS_REJECTED)->count(),
    ];

    // ✅ DAGDAG LANG ITO
    $notifications = \App\Models\Notification::where('user_id', $user->id)
        ->latest()
        ->take(10)
        ->get();

    return view('dashboard.author', compact('submissions', 'stats', 'notifications')); // ✅ dagdag ang notifications
}

    public function reviewer(Request $request): View
{
    $user = $request->user(); // ✅ ideclare muna si $user

    $assignments = $user->reviewAssignments()
        ->with(['submission.author', 'submission.reviews'])
        ->latest()
        ->paginate(10);

    $stats = [
        'pending'   => $user->reviewAssignments()->where('status', ReviewAssignment::STATUS_ASSIGNED)->count(),
        'completed' => $user->reviewAssignments()->where('status', ReviewAssignment::STATUS_COMPLETED)->count(),
    ];

    $notifications = \App\Models\Notification::where('user_id', $user->id)
        ->latest()
        ->take(10)
        ->get();

    // Get review assignments for submissions with pending revision requests
    $revisionReviews = $user->reviewAssignments()
        ->whereHas('submission.revisionRequests', function ($query) {
            $query->whereNull('revised_at'); // Only pending revision requests
        })
        ->with(['submission.author', 'submission.revisionRequests'])
        ->latest()
        ->get();

    return view('dashboard.reviewer', compact('assignments', 'stats', 'notifications', 'revisionReviews')); // ✅ dagdag ang notifications
}

    public function editor(Request $request): View
    {
        $userId = $request->user()->id;

        $submissions = Submission::where('assigned_editor_id', $userId)
            ->with(['author', 'reviews', 'reviewAssignments'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Submission::where('assigned_editor_id', $userId)->count(),
            'submitted' => Submission::where('assigned_editor_id', $userId)->where('status', Submission::STATUS_SUBMITTED)->count(),
            'under_review' => Submission::where('assigned_editor_id', $userId)->where('status', Submission::STATUS_UNDER_REVIEW)->count(),
            'decisions_pending' => Submission::where('assigned_editor_id', $userId)->whereIn('status', [
                Submission::STATUS_UNDER_REVIEW,
                Submission::STATUS_REVISIONS_REQUESTED,
            ])->count(),
        ];

        return view('dashboard.editor', compact('submissions', 'stats'));
    }

    public function admin(Request $request): View
    {
        $userCount = \App\Models\User::count();
        $submissionCount = Submission::count();
        $roleCount = \App\Models\Role::count();

        return view('dashboard.admin', [
            'userCount' => $userCount,
            'submissionCount' => $submissionCount,
            'roleCount' => $roleCount,
        ]);
    }
}
