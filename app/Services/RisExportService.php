<?php

namespace App\Services;

use App\Models\Submission;

/**
 * RIS Format Export Service
 * 
 * Generates bibliographic records in RIS (Research Information System) format
 * for integration with citation management software (Zotero, Mendeley, EndNote, etc.)
 * 
 * RIS Format Tags:
 * - TY: Type of Reference (JOUR = Journal Article, CONF = Conference, etc.)
 * - ID: Reference ID
 * - TI: Title
 * - AU: Author (last name, first name format)
 * - PY: Publication Year
 * - AB: Abstract
 * - KW: Keywords
 * - JO: Journal Name
 * - VL: Volume
 * - IS: Issue
 * - SP: Start Page
 * - EP: End Page
 * - DO: DOI
 * - UR: URL
 * - N1: Notes
 * - ER: End of Reference
 */
class RisExportService
{
    /**
     * Generate RIS format content for a single submission
     *
     * @param Submission $submission
     * @return string RIS formatted content
     */
    public function generateRis(Submission $submission): string
    {
        $ris = '';
        
        // Reference type (Journal Article)
        $ris .= "TY  - JOUR\n";
        
        // Reference ID
        $ris .= "ID  - {$submission->id}\n";
        
        // Title
        if ($submission->title) {
            $ris .= "TI  - " . $this->sanitizeRisField($submission->title) . "\n";
        }
        
        // Author(s)
        if ($submission->author) {
            $authorName = $this->formatAuthorName($submission->author->name);
            $ris .= "AU  - {$authorName}\n";
        }
        
        // Publication Year
        if ($submission->published_at) {
            $year = $submission->published_at->year;
            $ris .= "PY  - {$year}\n";
        }
        
        // Abstract
        if ($submission->abstract) {
            $ris .= "AB  - " . $this->sanitizeRisField($submission->abstract) . "\n";
        }
        
        // Keywords
        if ($submission->keywords) {
            $keywords = $this->formatKeywords($submission->keywords);
            foreach ($keywords as $keyword) {
                $ris .= "KW  - {$keyword}\n";
            }
        }
        
        // Journal Name (or placeholder)
        $ris .= "JO  - International Research Journal of Information Systems & Engineering Technology (IRJIEST)\n";
        
        // Research Field (as subject/category)
        if ($submission->research_field) {
            $ris .= "KW  - " . $this->sanitizeRisField($submission->research_field) . "\n";
        }
        
        // URL to paper
        $paperUrl = route('papers.show', ['submission' => $submission->id], false);
        $ris .= "UR  - " . url($paperUrl) . "\n";
        
        // Notes
        $notes = "Downloaded from IRJIEST Journal System";
        $ris .= "N1  - {$notes}\n";
        
        // End of reference
        $ris .= "ER  - \n";
        
        return $ris;
    }
    
    /**
     * Generate RIS format content for multiple submissions
     *
     * @param array $submissions
     * @return string RIS formatted content
     */
    public function generateRisMultiple(array $submissions): string
    {
        $ris = '';
        
        foreach ($submissions as $submission) {
            $ris .= $this->generateRis($submission);
            $ris .= "\n"; // Add spacing between records
        }
        
        return $ris;
    }
    
    /**
     * Format author name from "First Last" to "Last, First" format
     *
     * @param string $name
     * @return string Formatted name
     */
    private function formatAuthorName(string $name): string
    {
        $parts = explode(' ', trim($name));
        
        if (count($parts) === 1) {
            return $parts[0];
        }
        
        // Last part is surname
        $surname = array_pop($parts);
        $firstName = implode(' ', $parts);
        
        return "{$surname}, {$firstName}";
    }
    
    /**
     * Format keywords from comma-separated string to array
     *
     * @param string $keywords Comma-separated keywords
     * @return array Array of keywords
     */
    private function formatKeywords(string $keywords): array
    {
        return array_map(
            fn($keyword) => trim($keyword),
            explode(',', $keywords)
        );
    }
    
    /**
     * Sanitize field values for RIS format
     * Remove line breaks and special characters
     *
     * @param string $field
     * @return string Sanitized field
     */
    private function sanitizeRisField(string $field): string
    {
        // Remove line breaks
        $field = str_replace(["\r\n", "\r", "\n"], ' ', $field);
        
        // Replace multiple spaces with single space
        $field = preg_replace('/\s+/', ' ', $field);
        
        // Trim whitespace
        $field = trim($field);
        
        return $field;
    }
}
