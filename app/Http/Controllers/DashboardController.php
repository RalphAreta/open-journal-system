<?php

namespace App\Http\Controllers;

use App\Models\ReviewAssignment;
use App\Models\Submission;
use App\Models\RevisionReview;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Redirect to role-specific dashboard based on active_role set during login.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // PRIMARY: Use the active_role that was set during login
        $activeRole = $request->session()->get('active_role');
        if ($activeRole && $user->hasRole($activeRole)) {
            return $activeRole === 'editor-in-chief'
                ? redirect()->route('chief-editor.dashboard')
                : redirect()->route("dashboard.{$activeRole}");
        }

        // FALLBACK: If no active_role, try preferred_dashboard from previous visit
        $preferred = $request->session()->get('preferred_dashboard');
        if ($preferred && $user->hasRole($preferred)) {
            return $preferred === 'editor-in-chief'
                ? redirect()->route('chief-editor.dashboard')
                : redirect()->route("dashboard.{$preferred}");
        }

        // LAST RESORT: Use primary role if nothing else is available
        $role = $user->primaryRole();
        if ($role) {
            return $role->name === 'editor-in-chief'
                ? redirect()->route('chief-editor.dashboard')
                : redirect()->route("dashboard.{$role->name}");
        }

        return redirect()->route('login');
    }

    public function author(Request $request): View
    {
        // remember that author dashboard was visited last
        $request->session()->put('preferred_dashboard', 'author');

        $user = $request->user();

        $submissions = $user->submissionsAsAuthor()
            ->with(['reviews' => function($q) {
                $q->latest();
            }, 'appeals' => function($q) {
                $q->latest();
            }])
            ->latest()
            ->paginate(10);

        $stats = [
            'total'                 => $user->submissionsAsAuthor()->count(),
            'submitted'             => $user->submissionsAsAuthor()->where('status', Submission::STATUS_SUBMITTED)->count(),
            'under_review'          => $user->submissionsAsAuthor()->where('status', Submission::STATUS_UNDER_REVIEW)->count(),
            'revisions_requested'   => $user->submissionsAsAuthor()->where('status', Submission::STATUS_REVISIONS_REQUESTED)->count(),
            'revision_under_review' => $user->submissionsAsAuthor()->where('status', Submission::STATUS_REVISION_UNDER_REVIEW)->count(),
            'accepted'              => $user->submissionsAsAuthor()->where('status', Submission::STATUS_ACCEPTED)->count(),
            'rejected'              => $user->submissionsAsAuthor()->where('status', Submission::STATUS_REJECTED)->count(),
        ];

        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.author', compact('submissions', 'stats', 'notifications'));
    }

    public function reviewer(Request $request): View
    {
        // remember that reviewer dashboard was visited last
        $request->session()->put('preferred_dashboard', 'reviewer');

        $user = $request->user();

        // 1. Pending Invitations (status = 'pending' - awaiting reviewer's accept/decline decision)
        $pendingInvitations = $user->reviewAssignments()
            ->where('status', ReviewAssignment::STATUS_PENDING)
            ->with(['submission.author', 'submission.reviews'])
            ->latest()
            ->get();

        // 2. Standard Review Assignments (for main table - accepted/completed)
        $assignments = $user->reviewAssignments()
            ->whereNotIn('status', [ReviewAssignment::STATUS_PENDING, ReviewAssignment::STATUS_DECLINED])
            ->with(['submission.author', 'submission.reviews'])
            ->latest()
            ->paginate(10);

        // 3. Pending Revision Reviews (The new system)
        $revisionReviews = RevisionReview::where('reviewer_id', $user->id)
            ->where('status', RevisionReview::STATUS_ASSIGNED)
            ->with(['revisionRequest.submission.author'])
            ->latest()
            ->get();

        // 4. Stats Calculation
        $stats = [
            'pending'             => $pendingInvitations->count() + $user->reviewAssignments()->where('status', ReviewAssignment::STATUS_ASSIGNED)->count(),
            'completed'           => $user->reviewAssignments()->where('status', ReviewAssignment::STATUS_COMPLETED)->count(),
            'pending_revisions'   => $revisionReviews->count(),
            'completed_revisions' => RevisionReview::where('reviewer_id', $user->id)->where('status', RevisionReview::STATUS_COMPLETED)->count(),
        ];

        // 5. Notifications
        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.reviewer', compact('pendingInvitations', 'assignments', 'revisionReviews', 'stats', 'notifications'));
    }

    public function editor(Request $request): View
    {
        // remember that editor dashboard was visited last
        $request->session()->put('preferred_dashboard', 'editor');

        $userId = $request->user()->id;

        $submissions = Submission::where('assigned_editor_id', $userId)
            ->with(['author', 'reviews', 'reviewAssignments'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Submission::where('assigned_editor_id', $userId)->count(),
            'submitted' => Submission::where('assigned_editor_id', $userId)->where('status', Submission::STATUS_SUBMITTED)->count(),
            'under_review' => Submission::where('assigned_editor_id', $userId)->where('status', Submission::STATUS_UNDER_REVIEW)->count(),
            'revision_under_review' => Submission::where('assigned_editor_id', $userId)->where('status', Submission::STATUS_REVISION_UNDER_REVIEW)->count(),
            'decisions_pending' => Submission::where('assigned_editor_id', $userId)->whereIn('status', [
                Submission::STATUS_UNDER_REVIEW,
                Submission::STATUS_REVISION_UNDER_REVIEW,
                Submission::STATUS_REVISIONS_REQUESTED,
            ])->count(),
        ];

        return view('dashboard.editor', compact('submissions', 'stats'));
    }

    public function admin(Request $request): View
    {
        // remember that admin dashboard was visited last
        $request->session()->put('preferred_dashboard', 'admin');

        $userCount = \App\Models\User::count();
        $submissionCount = Submission::count();
        $roleCount = \App\Models\Role::count();

        return view('dashboard.admin', [
            'userCount' => $userCount,
            'submissionCount' => $submissionCount,
            'roleCount' => $roleCount,
        ]);
    }

    /**
     * Switch to a different role (for users with multiple roles).
     */
    public function switchRole(Request $request, string $role)
    {
        $user = $request->user();

        if (!$user || !$user->hasRole($role)) {
            abort(403, 'You do not have permission to switch to this role.');
        }

        // Validate the role name
        if (!in_array($role, ['author', 'reviewer', 'editor', 'editor-in-chief', 'admin'])) {
            abort(400, 'Invalid role.');
        }

        // Update the active role in session
        $request->session()->put('active_role', $role);

        // Redirect to the appropriate dashboard
        return $role === 'editor-in-chief'
            ? redirect()->route('chief-editor.dashboard')
            : redirect()->route("dashboard.{$role}");
    }
}

