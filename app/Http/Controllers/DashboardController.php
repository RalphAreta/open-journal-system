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
            if ($activeRole === 'editor-in-chief') {
                return redirect()->route('chief-editor.dashboard');
            } elseif ($activeRole === 'layout-editor') {
                return redirect()->route('layout-editor.dashboard');
            } elseif ($activeRole === 'managing-editor') {
                return redirect()->route('managing-editor.dashboard');
            }
            return redirect()->route("dashboard.{$activeRole}");
        }

        // FALLBACK: If no active_role, try preferred_dashboard from previous visit
        $preferred = $request->session()->get('preferred_dashboard');
        if ($preferred && $user->hasRole($preferred)) {
            if ($preferred === 'editor-in-chief') {
                return redirect()->route('chief-editor.dashboard');
            } elseif ($preferred === 'layout-editor') {
                return redirect()->route('layout-editor.dashboard');
            } elseif ($preferred === 'managing-editor') {
                return redirect()->route('managing-editor.dashboard');
            }
            return redirect()->route("dashboard.{$preferred}");
        }

        // LAST RESORT: Use primary role if nothing else is available
        $role = $user->primaryRole();
        if ($role) {
            if ($role->name === 'editor-in-chief') {
                return redirect()->route('chief-editor.dashboard');
            } elseif ($role->name === 'layout-editor') {
                return redirect()->route('layout-editor.dashboard');
            } elseif ($role->name === 'managing-editor') {
                return redirect()->route('managing-editor.dashboard');
            }
            return redirect()->route("dashboard.{$role->name}");
        }

        return redirect()->route('login');
    }

    public function author(Request $request): View
    {
        $request->session()->put('preferred_dashboard', 'author');
        $request->session()->put('active_role', 'author'); // Ensure active role is set

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
            'published'             => $user->submissionsAsAuthor()->where('status', Submission::STATUS_PUBLISHED)->count(),
        ];

        $notifications = Notification::where('user_id', $user->id)
            ->where(function($q) {
                $q->where('role', 'author')
                  ->orWhereNull('role');
            })
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.author', compact('submissions', 'stats', 'notifications'));
    }

    public function reviewer(Request $request): View
    {
        $request->session()->put('preferred_dashboard', 'reviewer');
        $request->session()->put('active_role', 'reviewer'); // Ensure active role is set

        $user = $request->user();

        $pendingInvitations = $user->reviewAssignments()
            ->where('status', ReviewAssignment::STATUS_PENDING)
            ->with(['submission.author', 'submission.reviews'])
            ->latest()
            ->get();

        $assignments = $user->reviewAssignments()
            ->whereNotIn('status', [ReviewAssignment::STATUS_PENDING, ReviewAssignment::STATUS_DECLINED])
            ->with(['submission.author', 'submission.reviews'])
            ->latest()
            ->paginate(10);

        $revisionReviews = RevisionReview::where('reviewer_id', $user->id)
            ->where('status', RevisionReview::STATUS_ASSIGNED)
            ->with(['revisionRequest.submission.author'])
            ->latest()
            ->get();

        $stats = [
            'pending'             => $pendingInvitations->count() + $user->reviewAssignments()->where('status', ReviewAssignment::STATUS_ASSIGNED)->count(),
            'completed'           => $user->reviewAssignments()->where('status', ReviewAssignment::STATUS_COMPLETED)->count(),
            'pending_revisions'   => $revisionReviews->count(),
            'completed_revisions' => RevisionReview::where('reviewer_id', $user->id)->where('status', RevisionReview::STATUS_COMPLETED)->count(),
        ];

        $notifications = Notification::where('user_id', $user->id)
            ->where(function($q) {
                $q->where('role', 'reviewer')
                  ->orWhereNull('role');
            })
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.reviewer', compact('pendingInvitations', 'assignments', 'revisionReviews', 'stats', 'notifications'));
    }

    public function editor(Request $request): View
    {
        $request->session()->put('preferred_dashboard', 'editor');
        $request->session()->put('active_role', 'editor'); // Ensure active role is set

        $userId = $request->user()->id;

        $submissions = Submission::where('assigned_editor_id', $userId)
            ->with(['author', 'reviews', 'reviewAssignments'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total'                 => Submission::where('assigned_editor_id', $userId)->count(),
            'submitted'             => Submission::where('assigned_editor_id', $userId)->where('status', Submission::STATUS_SUBMITTED)->count(),
            'under_review'          => Submission::where('assigned_editor_id', $userId)->where('status', Submission::STATUS_UNDER_REVIEW)->count(),
            'revision_under_review' => Submission::where('assigned_editor_id', $userId)->where('status', Submission::STATUS_REVISION_UNDER_REVIEW)->count(),
            'decisions_pending'     => Submission::where('assigned_editor_id', $userId)->whereIn('status', [
                Submission::STATUS_UNDER_REVIEW,
                Submission::STATUS_REVISION_UNDER_REVIEW,
                Submission::STATUS_REVISIONS_REQUESTED,
            ])->count(),
        ];

        return view('dashboard.editor', compact('submissions', 'stats'));
    }

    public function admin(Request $request): View
    {
        $request->session()->put('preferred_dashboard', 'admin');
        $request->session()->put('active_role', 'admin'); // Ensure active role is set

        $userCount       = \App\Models\User::count();
        $submissionCount = Submission::count();
        $roleCount       = \App\Models\Role::count();

        return view('dashboard.admin', [
            'userCount'       => $userCount,
            'submissionCount' => $submissionCount,
            'roleCount'       => $roleCount,
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

        if (!in_array($role, ['author', 'reviewer', 'editor', 'layout-editor', 'editor-in-chief', 'admin', 'managing-editor'])) {
            abort(400, 'Invalid role.');
        }

        $request->session()->put('active_role', $role);

        if ($role === 'editor-in-chief') {
            return redirect()->route('chief-editor.dashboard');
        } elseif ($role === 'layout-editor') {
            return redirect()->route('layout-editor.dashboard');
        } elseif ($role === 'managing-editor') {
            return redirect()->route('managing-editor.dashboard');
        }

        return redirect()->route("dashboard.{$role}");
    }
}