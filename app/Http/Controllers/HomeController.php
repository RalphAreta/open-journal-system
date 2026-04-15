<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Models\Review;
use App\Models\User;
use App\Models\ExpertiseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\EditorialBoardMember;

class HomeController extends Controller
{
    public function index()
    {
        // METRICS DASHBOARD DATA
        $publishedPapersCount = Submission::where('status', Submission::STATUS_PUBLISHED)->count();
        $activeReviewersCount = User::whereHas('roles', function ($query) {
            $query->where('name', 'reviewer');
        })->count();

        // Calculate average review days
        $completedReviews = Review::where('status', Review::STATUS_SUBMITTED)
            ->whereHas('submission', function ($query) {
                $query->where('status', Submission::STATUS_PUBLISHED);
            })
            ->with('submission')
            ->get();

        $avgReviewDays = 0;
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
            : 0;

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
        $recentlyAccepted = Submission::where('status', Submission::STATUS_PUBLISHED)
            ->latest('published_at')
            ->limit(2)
            ->get()
            ->map(function ($submission) {
                return [
                    'type' => 'published',
                    'icon' => '🎉',
                    'title' => 'Paper Published',
                    'description' => $submission->title,
                    'category' => $submission->research_field ?? 'Research',
                    'timestamp' => $submission->published_at,
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

      // EDITORIAL BOARD - From database
$editorialBoard = EditorialBoardMember::where('is_active', true)
    ->orderBy('sort_order')
    ->get()
    ->map(fn($m) => [
        'name'      => trim($m->title . ' ' . $m->name),
        'role'      => $m->role,        // ← kailangan ito para sa grouping
        'expertise' => $m->affiliation,
    ]);

        // Editorial board - only show real database records

        // FEATURED RESEARCH - Recently accepted papers with highest impact
        $featuredResearch = Submission::where('status', Submission::STATUS_PUBLISHED)
            ->with('author')
            ->latest('published_at')
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
                    'citations' => $reviewCount,
                    'downloads' => $submission->download_count ?? 0,
                    'author' => $submission->author->name ?? 'Anonymous',
                    'publishedAt' => $submission->published_at,
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

            $daysSinceSubmit = $trackedManuscript->submitted_at ? $trackedManuscript->submitted_at->diffInDays(now()) : 0;

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

        // Research fields - only show real database records

        return view('welcome', [
            'publishedPapersCount' => $publishedPapersCount,
            'activeReviewersCount' => $activeReviewersCount,
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
        // Public pages can show published and archived papers
        if (!in_array($submission->status, [Submission::STATUS_PUBLISHED, Submission::STATUS_ARCHIVED], true)) {
            abort(403, 'This paper is not publicly available.');
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
                'publishedAt' => $submission->published_at,
                'citations' => $reviewCount,
                'downloads' => $submission->download_count ?? 0,
                'reviews' => $reviewCount,
                'filePath' => $submission->file_path,
                'fileName' => $submission->file_name,
            ]
        ]);
    }

    public function downloadPublicPaper(Submission $submission)
    {
        // Allow downloads for published and archived papers
        if (!in_array($submission->status, [Submission::STATUS_PUBLISHED, Submission::STATUS_ARCHIVED], true)) {
            abort(403, 'This paper is not available for download.');
        }

        if (!$submission->file_path || !Storage::disk('local')->exists($submission->file_path)) {
            abort(404, 'File not found.');
        }

        // Increment download count
        $submission->increment('download_count');

        return response()->download(
            Storage::disk('local')->path($submission->file_path),
            $submission->file_name
        );
    }

  public function viewOnline(Submission $submission)
{
        if (!in_array($submission->status, [Submission::STATUS_PUBLISHED, Submission::STATUS_ARCHIVED], true)) {
        abort(403);
    }

    $extension = strtolower(pathinfo($submission->file_path, PATHINFO_EXTENSION));

    if ($extension === 'pdf') {
        $disk = Storage::disk('local');

        if (!$disk->exists($submission->file_path)) {
            abort(404, 'File not found.');
        }

        $path = $disk->path($submission->file_path); // ← tama ang slashes

        return response()->file($path, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="paper.pdf"',
        ]);
    }

    $fileUrl = url(Storage::url($submission->file_path));
    $googleViewerUrl = 'https://docs.google.com/viewer?url=' . urlencode($fileUrl) . '&embedded=true';
    return redirect($googleViewerUrl);
}
    /**
     * Download paper citation in RIS format
     *
     * Generates a .ris file containing bibliographic information that can be imported
     * into citation management software (Zotero, Mendeley, EndNote, etc.)
     *
     * @param Submission $submission
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadPublicPaperRis(Submission $submission)
    {
        // Allow citation export for published and archived papers
        if (!in_array($submission->status, [Submission::STATUS_PUBLISHED, Submission::STATUS_ARCHIVED], true)) {
            abort(403, 'This paper is not available for citation export.');
        }

        // Generate RIS content using the service
        $risService = app(\App\Services\RisExportService::class);
        $risContent = $risService->generateRis($submission);

        // Create filename
        $filename = $this->sanitizeFilename($submission->title ?? 'paper') . '.ris';

        // Return as downloadable file
        return response()
            ->streamDownload(function () use ($risContent) {
                echo $risContent;
            }, $filename, [
                'Content-Type' => 'application/x-research-info-systems',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
    }

    /**
     * Sanitize filename to remove special characters
     *
     * @param string $filename
     * @return string
     */
    private function sanitizeFilename(string $filename): string
    {
        // Remove special characters but keep spaces and hyphens
        $filename = preg_replace('/[^a-zA-Z0-9\s\-_]/', '', $filename);

        // Replace spaces with underscores
        $filename = str_replace(' ', '_', $filename);

        // Remove multiple underscores
        $filename = preg_replace('/_+/', '_', $filename);

        // Limit length
        return substr($filename, 0, 100);
    }

    public function publishedPapers(Request $request)
    {
        return $this->renderPaperListing(
            $request,
            Submission::STATUS_PUBLISHED,
            'Published Papers',
            'Explore peer-reviewed papers currently published in our journal.',
            'published-papers',
            'Open Archive',
            'archive'
        );
    }

    public function archivePapers(Request $request)
    {
        return $this->renderPaperListing(
            $request,
            Submission::STATUS_ARCHIVED,
            'Archive',
            'Browse retained papers kept for long-term reference and record keeping.',
            'archive',
            'Back to Published Papers',
            'published-papers'
        );
    }

    private function renderPaperListing(
        Request $request,
        string $status,
        string $heroTitle,
        string $heroDescription,
        string $formRouteName,
        string $switchLabel,
        string $switchRouteName
    )
    {
        $search = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', ''));
        $isArchivePage = $status === Submission::STATUS_ARCHIVED;

        $baseArchiveQuery = Submission::where('status', $status)
            ->with('author');

        $filteredArchiveQuery = (clone $baseArchiveQuery)
            ->when($search !== '', function ($query) use ($search) {
                $term = '%' . mb_strtolower($search) . '%';

                $query->where(function ($nestedQuery) use ($term) {
                    $nestedQuery->whereRaw('LOWER(title) LIKE ?', [$term])
                        ->orWhereRaw('LOWER(abstract) LIKE ?', [$term])
                        ->orWhereRaw('LOWER(keywords) LIKE ?', [$term])
                        ->orWhereRaw('LOWER(research_field) LIKE ?', [$term])
                        ->orWhereHas('author', function ($authorQuery) use ($term) {
                            $authorQuery->whereRaw('LOWER(name) LIKE ?', [$term]);
                        });
                });
            })
            ->when($category !== '', function ($query) use ($category) {
                $query->where('research_field', $category);
            });

        $papers = (clone $filteredArchiveQuery)
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        $availableCategories = (clone $baseArchiveQuery)
            ->whereNotNull('research_field')
            ->distinct()
            ->orderBy('research_field')
            ->pluck('research_field')
            ->filter()
            ->values();

        $categoryIssueMap = [];
        if ($isArchivePage) {
            $categoryIssueMap = $availableCategories
                ->values()
                ->mapWithKeys(fn ($categoryName, $index) => [$categoryName => $index + 1])
                ->all();
        }

        // Map the papers to include additional data
        $publishedPapers = $papers->map(function ($submission) use ($isArchivePage, $categoryIssueMap) {
            $reviewCount = Review::where('submission_id', $submission->id)
                ->where('status', Review::STATUS_SUBMITTED)
                ->count();

            $publishedAt = $submission->published_at;
            $archiveVolume = null;
            $archiveIssue = null;

            if ($isArchivePage) {
                $archiveVolume = $publishedAt ? (int) $publishedAt->format('Y') : (int) now()->format('Y');
                $archiveIssue = $categoryIssueMap[$submission->research_field] ?? 1;
            }

            return [
                'id' => $submission->id,
                'title' => $submission->title,
                'abstract' => $submission->abstract,
                'keywords' => $submission->keywords,
                'category' => $submission->research_field,
                'author' => $submission->author->name ?? 'Anonymous',
                'publishedAt' => $publishedAt,
                'downloads' => $submission->download_count ?? 0,
                'reviews' => $reviewCount,
                'archiveVolume' => $archiveVolume,
                'archiveIssue' => $archiveIssue,
            ];
        });

        return view('published-papers', [
            'papers' => $publishedPapers,
            'pagination' => $papers,
            'search' => $search,
            'category' => $category,
            'availableCategories' => $availableCategories,
            'heroTitle' => $heroTitle,
            'heroDescription' => $heroDescription,
            'formRouteName' => $formRouteName,
            'switchLabel' => $switchLabel,
            'switchRouteName' => $switchRouteName,
            'isArchivePage' => $isArchivePage,
        ]);
    }
}
