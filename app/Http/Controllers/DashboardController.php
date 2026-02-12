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
        $role = $user?->primaryRole();
        if ($role) {
            return redirect()->route("dashboard.{$role->name}");
        }
        return redirect()->route('login');
    }

    public function author(Request $request): View
    {
        $submissions = $request->user()
            ->submissionsAsAuthor()
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => $request->user()->submissionsAsAuthor()->count(),
            'submitted' => $request->user()->submissionsAsAuthor()->where('status', Submission::STATUS_SUBMITTED)->count(),
            'under_review' => $request->user()->submissionsAsAuthor()->where('status', Submission::STATUS_UNDER_REVIEW)->count(),
            'accepted' => $request->user()->submissionsAsAuthor()->where('status', Submission::STATUS_ACCEPTED)->count(),
            'rejected' => $request->user()->submissionsAsAuthor()->where('status', Submission::STATUS_REJECTED)->count(),
        ];

        return view('dashboard.author', compact('submissions', 'stats'));
    }

    public function reviewer(Request $request): View
    {
        $assignments = $request->user()
            ->reviewAssignments()
            ->with(['submission.author', 'submission.reviews'])
            ->latest()
            ->paginate(10);

        $stats = [
            'pending' => $request->user()->reviewAssignments()->where('status', ReviewAssignment::STATUS_ASSIGNED)->count(),
            'completed' => $request->user()->reviewAssignments()->where('status', ReviewAssignment::STATUS_COMPLETED)->count(),
        ];

        return view('dashboard.reviewer', compact('assignments', 'stats'));
    }

    public function editor(Request $request): View
    {
        $submissions = Submission::with(['author', 'reviews', 'reviewAssignments'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Submission::count(),
            'submitted' => Submission::where('status', Submission::STATUS_SUBMITTED)->count(),
            'under_review' => Submission::where('status', Submission::STATUS_UNDER_REVIEW)->count(),
            'decisions_pending' => Submission::whereIn('status', [
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
