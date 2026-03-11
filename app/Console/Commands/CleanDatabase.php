<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Submission;
use App\Models\Review;
use App\Models\ReviewAssignment;
use App\Models\RevisionRequest;
use App\Models\RevisionReview;
use App\Models\Appeal;
use App\Models\SubmissionAssignment;
use App\Models\RefereeInvitation;
use App\Models\LayoutEditorAssignment;
use App\Models\Notification;
use App\Models\EditorExpertise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CleanDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean database and remove uploaded files, keeping only admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('This will delete all users except admin@ojs.com and remove all uploaded files. Continue?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        try {
            $this->info('Starting database cleanup...');

            // Get admin user
            $admin = User::where('email', 'admin@ojs.com')->first();
            
            if (!$admin) {
                $this->error('Admin user not found!');
                return 1;
            }

            $this->info("Found admin user: {$admin->email}");

            // Delete all notifications (no foreign key constraints)
            Notification::truncate();
            $this->info('✓ Deleted all notifications');

            // Delete appeals
            Appeal::truncate();
            $this->info('✓ Deleted all appeals');

            // Delete layout editor assignments
            LayoutEditorAssignment::truncate();
            $this->info('✓ Deleted all layout editor assignments');

            // Delete revision reviews
            RevisionReview::truncate();
            $this->info('✓ Deleted all revision reviews');

            // Delete revision requests
            RevisionRequest::truncate();
            $this->info('✓ Deleted all revision requests');

            // Delete referee invitations
            RefereeInvitation::truncate();
            $this->info('✓ Deleted all referee invitations');

            // Delete reviews
            Review::truncate();
            $this->info('✓ Deleted all reviews');

            // Delete review assignments
            ReviewAssignment::truncate();
            $this->info('✓ Deleted all review assignments');

            // Delete submission assignments
            SubmissionAssignment::truncate();
            $this->info('✓ Deleted all submission assignments');

            // Delete submissions
            Submission::truncate();
            $this->info('✓ Deleted all submissions');

            // Delete editor expertise
            EditorExpertise::truncate();
            $this->info('✓ Deleted all editor expertise entries');

            // Delete all users except admin
            User::where('email', '!=', 'admin@ojs.com')->delete();
            $this->info('✓ Deleted all users except admin');

            // Clean up uploaded files
            $this->cleanUploadedFiles();

            $this->info('');
            $this->info('✅ Database cleanup completed successfully!');
            $this->info('Only admin user remains: admin@ojs.com');

            return 0;
        } catch (\Exception $e) {
            $this->error("Error during cleanup: {$e->getMessage()}");
            return 1;
        }
    }

    /**
     * Clean up uploaded files from storage
     */
    private function cleanUploadedFiles()
    {
        $paths = [
            'storage/app/private',
            'storage/app/public',
            'storage/app/visitors',
        ];

        foreach ($paths as $path) {
            $fullPath = base_path($path);
            if (is_dir($fullPath)) {
                // Get all files except .gitignore
                $files = File::allFiles($fullPath);
                foreach ($files as $file) {
                    if ($file->getFilename() !== '.gitignore') {
                        File::delete($file->getRealPath());
                    }
                }

                // Remove empty subdirectories
                $this->removeEmptyDirectories($fullPath);
                
                $this->info("✓ Cleaned uploaded files from {$path}");
            }
        }
    }

    /**
     * Remove empty directories
     */
    private function removeEmptyDirectories($dir)
    {
        if (!is_dir($dir)) {
            return;
        }

        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..' || $item === '.gitignore') {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                $this->removeEmptyDirectories($path);
                if (count(array_diff(scandir($path), ['.', '..', '.gitignore'])) === 0) {
                    @rmdir($path);
                }
            }
        }
    }
}
