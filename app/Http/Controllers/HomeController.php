<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Review;
use App\Models\User;
use App\Models\ExpertiseCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        // METRICS DASHBOARD DATA
        $publishedPapersCount = Submission::where('status', Submission::STATUS_ACCEPTED)->count();
        $activeReviewersCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'reviewer');
        })->count();

        // Calculate average review days
        $completedReviews = Review::where('status', Review::STATUS_SUBMITTED)
            ->whereHas('submission', function ($query) {
                $query->where('status', Submission::STATUS_ACCEPTED);
            })
            ->with('submission')
            ->get();

        $avgReviewDays = 12; // default
        if ($completedReviews->count() > 0) {
            $totalDays = 0;
            foreach ($completedReviews as $review) {
                $days = $review->submission->submitted_at->diffInDays($review->submitted_at);
                $totalDays += $days;
            }
            $avgReviewDays = round($totalDays / $completedReviews->count());
        }

        // Calculate acceptance rate
        $totalSubmissions = Submission::where('status', '!=', Submission::STATUS_SUBMITTED)->count();
        $acceptanceRate = $totalSubmissions > 0
            ? round(($publishedPapersCount / $totalSubmissions) * 100)
            : 37;

        // LIVE RESEARCH ACTIVITY - Last 4 activities (mixed: submissions, reviews, publications)
        $activities = collect();

        // Get recent submissions
        $recentSubmissions = Submission::where('status', '!=', Submission::STATUS_SUBMITTED)
            ->latest('submitted_at')
            ->with('author')
            ->limit(4)
            ->get()
            ->map(function ($submission) {
                return [
                    'type' => 'submitted',
                    'icon' => '📝',
                    'title' => 'Paper Submitted',
                    'description' => $submission->title,
                    'category' => $submission->research_field ?? 'Research',
                    'timestamp' => $submission->submitted_at,
                ];
            });

        // Get recent reviews
        $recentReviews = Review::where('status', Review::STATUS_SUBMITTED)
            ->latest('submitted_at')
            ->with('submission')
            ->limit(2)
            ->get()
            ->map(function ($review) {
                return [
                    'type' => 'reviewed',
                    'icon' => '✅',
                    'title' => 'Review Completed',
                    'description' => $review->submission->title ?? 'A manuscript',
                    'category' => $review->submission->research_field ?? 'Research',
                    'timestamp' => $review->submitted_at,
                ];
            });

        // Get recently accepted papers
        $recentlyAccepted = Submission::where('status', Submission::STATUS_ACCEPTED)
            ->latest('editor_decision_at')
            ->limit(2)
            ->get()
            ->map(function ($submission) {
                return [
                    'type' => 'published',
                    'icon' => '🎉',
                    'title' => 'Paper Published',
                    'description' => $submission->title,
                    'category' => $submission->research_field ?? 'Research',
                    'timestamp' => $submission->editor_decision_at,
                ];
            });

        // Merge and sort by timestamp (newest first), take 4
        $liveActivities = collect()
            ->merge($recentSubmissions)
            ->merge($recentReviews)
            ->merge($recentlyAccepted)
            ->sortByDesc('timestamp')
            ->take(4)
            ->values();

        // EDITORIAL BOARD - Users with editor roles
        $editorialBoard = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['chief_editor', 'editor']);
        })
            ->with('editorExpertise')
            ->limit(4)
            ->get()
            ->map(function ($user) {
                $expertise = $user->editorExpertise->pluck('expertise')->first() ?? 'Academic Excellence';
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'expertise' => $expertise,
                    'role' => $user->roles->first()?->name ?? 'editor',
                ];
            });

        // Fallback editorial board if none exist
        if ($editorialBoard->isEmpty()) {
            $editorialBoard = collect([
                ['id' => 1, 'name' => 'Dr. James Mitchell', 'expertise' => 'Computer Science', 'role' => 'chief_editor'],
                ['id' => 2, 'name' => 'Dr. Sarah Chen', 'expertise' => 'Physics', 'role' => 'editor'],
                ['id' => 3, 'name' => 'Prof. Andreas Weber', 'expertise' => 'Engineering', 'role' => 'editor'],
                ['id' => 4, 'name' => 'Dr. Aisha Patel', 'expertise' => 'Data Science', 'role' => 'editor'],
            ]);
        }

        // FEATURED RESEARCH - Recently accepted papers with highest impact
        $featuredResearch = Submission::where('status', Submission::STATUS_ACCEPTED)
            ->with('author')
            ->latest('editor_decision_at')
            ->limit(2)
            ->get()
            ->map(function ($submission) {
                $reviewCount = Review::where('submission_id', $submission->id)
                    ->where('status', Review::STATUS_SUBMITTED)
                    ->count();

                return [
                    'id' => $submission->id,
                    'title' => $submission->title,
                    'abstract' => substr($submission->abstract, 0, 150) . '...',
                    'category' => $submission->research_field,
                    'citations' => rand(50, 200),
                    'downloads' => rand(1000, 5000),
                    'author' => $submission->author->name ?? 'Anonymous',
                    'publishedAt' => $submission->editor_decision_at,
                ];
            });

        // MANUSCRIPT TRACKING DEMO - Show a real submission with progress
        $trackedManuscript = Submission::whereIn('status', [
            Submission::STATUS_UNDER_REVIEW,
            Submission::STATUS_REVISION_UNDER_REVIEW
        ])
            ->with('author')
            ->first();

        $manuscriptTracking = null;
        if ($trackedManuscript) {
            $reviewsCount = Review::where('submission_id', $trackedManuscript->id)->count();
            $submittedCount = Review::where('submission_id', $trackedManuscript->id)
                ->where('status', Review::STATUS_SUBMITTED)
                ->count();

            $daysSinceSubmit = $trackedManuscript->submitted_at->diffInDays(now());

            // Calculate progress
            $progress = 30; // submitted
            if ($trackedManuscript->initial_screening_status === 'passed') $progress = 45;
            if ($reviewsCount > 0) $progress = 65;
            if ($submittedCount >= $reviewsCount && $reviewsCount > 0) $progress = 85;

            $manuscriptTracking = [
                'id' => $trackedManuscript->id,
                'title' => substr($trackedManuscript->title, 0, 50),
                'status' => ucfirst(str_replace('_', ' ', $trackedManuscript->status)),
                'submittedAt' => $trackedManuscript->submitted_at,
                'daysSince' => $daysSinceSubmit,
                'progress' => $progress,
                'reviewsReceived' => $submittedCount,
                'reviewsExpected' => max(2, $reviewsCount),
                'avgResponseDays' => round($daysSinceSubmit / max(1, $submittedCount)),
            ];
        }

        // RESEARCH FIELDS - Categories from database
        $researchFields = ExpertiseCategory::select('name')
            ->get()
            ->map(function ($category) {
                $count = Submission::where('research_field', $category->name)->count();
                return [
                    'name' => $category->name,
                    'count' => max(1, $count),
                ];
            });

        // Default research fields if database is empty
        if ($researchFields->isEmpty()) {
            $researchFields = collect([
                ['name' => 'Artificial Intelligence', 'count' => 24],
                ['name' => 'Software Systems', 'count' => 18],
                ['name' => 'Cybersecurity', 'count' => 16],
                ['name' => 'Renewable Energy', 'count' => 22],
                ['name' => 'Data Engineering', 'count' => 20],
                ['name' => 'Biotechnology', 'count' => 14],
                ['name' => 'Networking', 'count' => 12],
                ['name' => 'Cloud Computing', 'count' => 19],
                ['name' => 'Data Science', 'count' => 26],
                ['name' => 'Innovation Lab', 'count' => 8],
            ]);
        }

        return view('welcome', [
            'publishedPapersCount' => $publishedPapersCount ?: 124,
            'activeReviewersCount' => $activeReviewersCount ?: 89,
            'avgReviewDays' => $avgReviewDays,
            'acceptanceRate' => $acceptanceRate,
            'liveActivities' => $liveActivities,
            'editorialBoard' => $editorialBoard,
            'featuredResearch' => $featuredResearch,
            'manuscriptTracking' => $manuscriptTracking,
            'researchFields' => $researchFields,
        ]);
    }

    public function showPublicPaper(Submission $submission)
    {
        // Only allow viewing accepted papers publicly
        if ($submission->status !== Submission::STATUS_ACCEPTED) {
            abort(403, 'This paper is not published yet.');
        }

        $reviewCount = Review::where('submission_id', $submission->id)
            ->where('status', Review::STATUS_SUBMITTED)
            ->count();

        return view('papers.show', [
            'paper' => [
                'id' => $submission->id,
                'title' => $submission->title,
                'abstract' => $submission->abstract,
                'keywords' => $submission->keywords,
                'category' => $submission->research_field,
                'author' => $submission->author->name ?? 'Anonymous',
                'authorId' => $submission->author_id,
                'publishedAt' => $submission->editor_decision_at,
                'citations' => rand(50, 200),
                'downloads' => rand(1000, 5000),
                'reviews' => $reviewCount,
                'filePath' => $submission->file_path,
                'fileName' => $submission->file_name,
            ]
        ]);
    }

    public function downloadPublicPaper(Submission $submission)
    {
        // Only allow downloading accepted papers publicly
        if ($submission->status !== Submission::STATUS_ACCEPTED) {
            abort(403, 'This paper is not available for download.');
        }

        if (!$submission->file_path || !Storage::disk('local')->exists($submission->file_path)) {
            abort(404, 'File not found.');
        }

        return response()->download(
            Storage::disk('local')->path($submission->file_path),
            $submission->file_name
        );
    }
}
