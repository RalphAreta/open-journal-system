<?php

namespace App\Services;

/**
 * Academic Rating Scale Service
 * Manages 1-100 rating scale with academically rigorous evaluations
 */
class RatingScale
{
    /**
     * Get academic assessment criteria for reviewers (peer review)
     * Provides detailed evaluative framework for manuscript assessment
     */
    public static function getCriteriaForReviewer(): array
    {
        return [
            'label' => 'Peer Review Assessment',
            'description' => 'Comprehensive scholarly evaluation framework for manuscript quality and publication fitness',
            'scale_description' => '1-100: Single quantitative metric representing overall manuscript quality',
            'scoring_guidance' => [
                '1-15' => 'Critically flawed fundamental methodology; severe conceptual errors; unsuitable for peer revision; recommendation: desk reject',
                '16-30' => 'Significant methodological deficiencies; major conceptual limitations; requires foundational restructuring; recommendation: major revisions likely insufficient',
                '31-45' => 'Substantial methodological concerns; incomplete literature integration; argumentation requires significant strengthening; recommendation: major revisions needed',
                '46-60' => 'Acceptable methodological framework; adequate but not exceptional scholarly contribution; improvements in analytical rigor required; recommendation: minor to moderate revisions',
                '61-75' => 'Sound methodological approach; competent scholarly execution; clear contribution to disciplinary knowledge; minimal revisions necessary; recommendation: acceptance with minor modifications',
                '76-85' => 'Rigorous methodology; sophisticated analytical framework; significant advancement of scholarly discourse; near-publication readiness; recommendation: accept with editorial recommendations',
                '86-100' => 'Exemplary scholarly rigor; innovative methodological approach; transformative contribution to field; publication-grade work; recommendation: accept',
            ],
            'evaluation_dimensions' => [
                'Methodological Rigor' => 'Appropriateness and validity of research design; quality of data collection and analysis procedures',
                'Theoretical Framework' => 'Coherence of theoretical positioning; integration with existing scholarly literature; originality of theoretical contribution',
                'Analytical Depth' => 'Sophistication of analysis; completeness of argumentation; consideration of alternative interpretations',
                'Scholarly Contribution' => 'Significance of findings; advancement of disciplinary knowledge; potential impact on field',
                'Clarity and Presentation' => 'Lucidity of writing; logical organization; accessibility to target audience; professional presentation standards',
            ]
        ];
    }

    /**
     * Get academic assessment criteria for editors (editorial screening)
     * Evaluates manuscript alignment with journal standards and strategic importance
     */
    public static function getCriteriaForEditor(): array
    {
        return [
            'label' => 'Editorial Assessment',
            'description' => 'Evaluative framework for editorial decision-making regarding journal fit, scholarly merit, and strategic alignment',
            'scale_description' => '1-100: Composite assessment of journal compatibility and publication viability',
            'scoring_guidance' => [
                '1-15' => 'Fundamental misalignment with journal scope; fails to meet publication standards; unsuitable for peer review; recommendation: desk reject',
                '16-30' => 'Significant scope misalignment; substantial quality deficiencies; insufficient scholarly merit; recommendation: reject without review',
                '31-45' => 'Marginal scope fit; moderate quality concerns; uncertain publication viability; recommendation: provisional hold pending author clarification',
                '46-60' => 'Acceptable scope compatibility; meets baseline publication standards; merits peer review consideration; recommendation: proceed to review',
                '61-75' => 'Good scope alignment; solid scholarly quality; demonstrated contribution to journal readership; recommendation: prioritize for peer review',
                '76-85' => 'Excellent scope fit; high scholarly quality; significant potential impact for journal audience; recommendation: fast-track review process',
                '86-100' => 'Exceptional scope alignment; outstanding scholarly merit; strategic priority for journal; recommendation: flagship submission candidate',
            ],
            'evaluation_dimensions' => [
                'Journal Scope Alignment' => 'Thematic fit; relevance to journal mission; compatibility with editorial strategy',
                'Manuscript Quality' => 'Overall scholarly merit; presentation professionalism; adherence to publication standards',
                'Scholarly Significance' => 'Potential contribution to disciplinary knowledge; relevance to journal readership',
                'Strategic Fit' => 'Alignment with journal\'s publication strategy; audience interest; potential citation impact',
                'Practical Viability' => 'Feasibility of peer review process; likelihood of successful publication trajectory',
            ]
        ];
    }

    /**
     * Get academic assessment criteria for revision reviewers
     * Evaluates quality and adequacy of author responses to revision requirements
     */
    public static function getCriteriaForRevisionReviewer(): array
    {
        return [
            'label' => 'Revision Quality Assessment',
            'description' => 'Analytical framework for evaluating author responsiveness and revision effectiveness',
            'scale_description' => '1-100: Assessment of revision comprehensiveness and responsiveness to reviewer feedback',
            'scoring_guidance' => [
                '1-15' => 'Critical revision failures; essential issues unaddressed; mandatory requirements ignored; substantial reworking required',
                '16-30' => 'Inadequate revision execution; significant gaps in addressing feedback; lack of substantive engagement with reviewer concerns',
                '31-45' => 'Partial revision completion; multiple issues inadequately addressed; insufficient justification for retained elements',
                '46-60' => 'Acceptable revision execution; most feedback addressed; adequate responses with minor gaps; meeting basic revision expectations',
                '61-75' => 'Competent revision; comprehensive feedback engagement; well-articulated justifications; manuscript substantially strengthened',
                '76-85' => 'Thorough revision; meticulous attention to reviewer feedback; detailed responses demonstrating scholarly engagement; significant improvements evident',
                '86-100' => 'Exemplary revision; exceptional responsiveness; extensive improvements beyond requirements; demonstrates sophisticated scholarly engagement with critique',
            ],
            'evaluation_dimensions' => [
                'Feedback Completeness' => 'Degree to which reviewer comments are systematically addressed; comprehensiveness of response coverage',
                'Response Quality' => 'Substantive engagement with critique; quality of justifications for retained versus modified elements',
                'Manuscript Improvement' => 'Extent and significance of improvements; strengthening of methodological or analytical components',
                'Scholarly Engagement' => 'Sophistication of intellectual response; demonstration of serious scholarly consideration of feedback',
                'Documentation' => 'Clarity of revision tracking; quality of response letter; transparency of changes made',
            ]
        ];
    }

    /**
     * Get academic assessment criteria for layout editors
     * Evaluates manuscript file quality and publication readiness
     */
    public static function getCriteriaForLayoutEditor(): array
    {
        return [
            'label' => 'Production Quality Assessment',
            'description' => 'Evaluative framework for manuscript file quality, formatting standards, and publication readiness',
            'scale_description' => '1-100: Assessment of manuscript compliance with production specifications and publication standards',
            'scoring_guidance' => [
                '1-15' => 'Severely compromised file integrity; extensive formatting violations; substantial reconstruction required; resubmission necessary',
                '16-30' => 'Significant format deficiencies; widespread standard violations; extensive corrective intervention required; major rework necessary',
                '31-45' => 'Substantial formatting inconsistencies; multiple standard violations; considerable corrective effort required; significant modifications needed',
                '46-60' => 'Acceptable formatting with standard corrections; adequate adherence to specifications; normal production workflow required',
                '61-75' => 'Good formatting compliance; minor adjustments needed; efficient production pathway; professional presentation quality',
                '76-85' => 'Excellent formatting adherence; minimal production intervention; near-publication readiness; professional quality throughout',
                '86-100' => 'Exemplary formatting standards; publication-ready specification compliance; minimal or no production modifications required',
            ],
            'evaluation_dimensions' => [
                'File Format Integrity' => 'Technical soundness of file; compatibility with production systems; absence of corruption or defects',
                'Formatting Consistency' => 'Uniform application of style specifications; consistency of fonts, spacing, and formatting elements',
                'Standards Compliance' => 'Adherence to journal specifications; proper implementation of required formatting standards',
                'Content Presentation' => 'Figure quality and placement; table formatting; reference formatting; visual element professionalism',
                'Publication Readiness' => 'Overall compatibility with publication workflow; degree of production-stage modifications needed',
            ]
        ];
    }

    /**
     * Get criteria by user role
     */
    public static function getCriteriaByRole(string $role, string $context = 'general'): array
    {
        return match ($role) {
            'reviewer' => self::getCriteriaForReviewer(),
            'editor', 'editor-in-chief', 'chief_editor' => self::getCriteriaForEditor(),
            'revision_reviewer' => self::getCriteriaForRevisionReviewer(),
            'layout_editor' => self::getCriteriaForLayoutEditor(),
            default => self::getCriteriaForReviewer(),
        };
    }

    /**
     * Get guidance text for a specific rating
     */
    public static function getGuidanceForRating(int $rating, string $role = 'reviewer'): ?string
    {
        if ($rating < 1 || $rating > 100) {
            return null;
        }

        $criteria = self::getCriteriaByRole($role);
        $guidance = $criteria['scoring_guidance'] ?? [];

        foreach ($guidance as $range => $text) {
            [$min, $max] = explode('-', $range);
            if ($rating >= (int)$min && $rating <= (int)$max) {
                return $text;
            }
        }

        return null;
    }

    /**
     * Get evaluation dimensions for a role
     */
    public static function getEvaluationDimensions(string $role = 'reviewer'): array
    {
        $criteria = self::getCriteriaByRole($role);
        return $criteria['evaluation_dimensions'] ?? [];
    }

    /**
     * Interpret numerical rating
     */
    public static function interpretRating(int $rating): string
    {
        if ($rating >= 1 && $rating <= 20) {
            return 'Critically deficient';
        } elseif ($rating >= 21 && $rating <= 40) {
            return 'Below publication standard';
        } elseif ($rating >= 41 && $rating <= 55) {
            return 'Acceptable but limited quality';
        } elseif ($rating >= 56 && $rating <= 70) {
            return 'Competent work meeting standards';
        } elseif ($rating >= 71 && $rating <= 85) {
            return 'Good to excellent work';
        } else {
            return 'Outstanding scholarly contribution';
        }
    }

    /**
     * Convert old 1-5 rating to new 1-100 rating
     */
    public static function convertFromLegacy(int $oldRating): int
    {
        if ($oldRating < 1 || $oldRating > 5) {
            throw new \InvalidArgumentException('Old rating must be between 1 and 5');
        }

        $mapping = [
            1 => 20,
            2 => 40,
            3 => 60,
            4 => 75,
            5 => 90,
        ];

        return $mapping[$oldRating];
    }
}

