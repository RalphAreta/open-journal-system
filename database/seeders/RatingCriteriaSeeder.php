<?php

namespace Database\Seeders;

use App\Models\RatingCriteria;
use App\Services\RatingScale;
use Illuminate\Database\Seeder;

class RatingCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['reviewer', 'editor', 'revision_reviewer', 'layout_editor'];
        $contexts = ['general'];

        foreach ($roles as $role) {
            $criteria = match ($role) {
                'reviewer' => RatingScale::getCriteriaForReviewer(),
                'editor' => RatingScale::getCriteriaForEditor(),
                'revision_reviewer' => RatingScale::getCriteriaForRevisionReviewer(),
                'layout_editor' => RatingScale::getCriteriaForLayoutEditor(),
            };

            foreach ($contexts as $context) {
                // Extract scoring guidance from criteria
                $guidance = $criteria['scoring_guidance'] ?? [];
                $dimensions = $criteria['evaluation_dimensions'] ?? [];

                foreach ($guidance as $band => $description) {
                    // Extract score range from band (e.g., "1-15" -> 1, 15)
                    [$scoreMin, $scoreMax] = explode('-', $band);

                    RatingCriteria::updateOrCreate(
                        [
                            'role' => $role,
                            'context' => $context,
                            'band' => $band,
                        ],
                        [
                            'label' => 'Academic Assessment',
                            'description' => $description,
                            'characteristics' => array_values($dimensions),
                            'score_min' => (int) $scoreMin,
                            'score_max' => (int) $scoreMax,
                        ]
                    );
                }
            }
        }

        $this->command->info('Academic rating criteria seeded successfully!');
    }
}

