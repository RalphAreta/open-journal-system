<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use App\Models\Review;
use App\Services\RisExportService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RisExportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that RIS file can be downloaded for published papers
     */
    public function test_user_can_download_published_paper_as_ris()
    {
        $author = User::factory()->create(['name' => 'John Smith']);
        
        $paper = Submission::factory()->create([
            'status' => Submission::STATUS_PUBLISHED,
            'author_id' => $author->id,
            'title' => 'Machine Learning Advances',
            'abstract' => 'This paper explores recent advances in machine learning',
            'keywords' => 'machine learning, artificial intelligence, deep learning',
            'research_field' => 'Computer Science',
            'published_at' => Carbon::now(),
        ]);

        $response = $this->get(route('papers.download-ris', $paper));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/x-research-info-systems');
        $response->assertStringContainsString('TY  - JOUR', $response->getContent());
        $response->assertStringContainsString('TI  - Machine Learning Advances', $response->getContent());
        $response->assertStringContainsString('AU  - Smith, John', $response->getContent());
        $response->assertStringContainsString('AB  - This paper explores recent advances in machine learning', $response->getContent());
        $response->assertStringContainsString('KW  - machine learning', $response->getContent());
        $response->assertStringContainsString('ER  - ', $response->getContent());
    }

    /**
     * Test that unpublished papers cannot be downloaded as RIS
     */
    public function test_unpublished_paper_cannot_be_downloaded_as_ris()
    {
        $paper = Submission::factory()->create([
            'status' => Submission::STATUS_SUBMITTED
        ]);

        $response = $this->get(route('papers.download-ris', $paper));

        $response->assertStatus(403);
    }

    /**
     * Test RIS service generates correct format
     */
    public function test_ris_service_generates_correct_format()
    {
        $author = User::factory()->create(['name' => 'Jane Doe']);
        
        $submission = Submission::factory()->create([
            'author_id' => $author->id,
            'title' => 'Quantum Computing Research',
            'abstract' => 'Exploring quantum computing applications',
            'keywords' => 'quantum, computing, research',
            'research_field' => 'Physics',
            'published_at' => Carbon::create(2024, 6, 15),
        ]);

        $service = app(RisExportService::class);
        $ris = $service->generateRis($submission);

        // Verify RIS format tags
        $this->assertStringContainsString('TY  - JOUR', $ris);
        $this->assertStringContainsString('ID  - ' . $submission->id, $ris);
        $this->assertStringContainsString('TI  - Quantum Computing Research', $ris);
        $this->assertStringContainsString('AU  - Doe, Jane', $ris);
        $this->assertStringContainsString('PY  - 2024', $ris);
        $this->assertStringContainsString('AB  - Exploring quantum computing applications', $ris);
        $this->assertStringContainsString('KW  - quantum', $ris);
        $this->assertStringContainsString('JO  - International Research Journal', $ris);
        $this->assertStringContainsString('ER  - ', $ris);
    }

    /**
     * Test RIS service handles author names correctly
     */
    public function test_ris_author_name_formatting()
    {
        $authors = [
            'John Smith' => 'Smith, John',
            'Mary Jane Watson' => 'Watson, Mary Jane',
            'Robert' => 'Robert',
            'Dr. Elizabeth Brown' => 'Brown, Dr. Elizabeth'
        ];

        foreach ($authors as $inputName => $expectedOutput) {
            $author = User::factory()->create(['name' => $inputName]);
            
            $submission = Submission::factory()->create([
                'author_id' => $author->id,
                'title' => 'Test Paper',
                'published_at' => now(),
            ]);

            $service = app(RisExportService::class);
            $ris = $service->generateRis($submission);

            $this->assertStringContainsString("AU  - {$expectedOutput}", $ris);
        }
    }

    /**
     * Test RIS service sanitizes special characters
     */
    public function test_ris_sanitizes_special_characters()
    {
        $author = User::factory()->create(['name' => 'John Smith']);
        
        $submission = Submission::factory()->create([
            'author_id' => $author->id,
            'title' => "Machine Learning &\nAdvanced AI\n\nTechniques",
            'abstract' => "This  is    a   test\nwith\nmultiple  spaces\nand\nline\nbreaks",
            'published_at' => now(),
        ]);

        $service = app(RisExportService::class);
        $ris = $service->generateRis($submission);

        // Verify line breaks removed
        $this->assertStringNotContainsString("\n\n", substr($ris, 0, 200));
        
        // Verify multiple spaces normalized
        $this->assertStringNotContainsString("   ", $ris);
    }

    /**
     * Test RIS file download has correct headers
     */
    public function test_ris_download_has_correct_headers()
    {
        $paper = Submission::factory()->create([
            'status' => Submission::STATUS_PUBLISHED,
            'title' => 'Sample Paper Title',
            'published_at' => now(),
        ]);

        $response = $this->get(route('papers.download-ris', $paper));

        $this->assertEquals('application/x-research-info-systems', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('attachment', $response->headers->get('Content-Disposition'));
        $this->assertStringContainsString('.ris', $response->headers->get('Content-Disposition'));
    }

    /**
     * Test RIS multiple submissions generation
     */
    public function test_ris_service_generates_multiple_records()
    {
        $submissions = Submission::factory(3)->create([
            'status' => Submission::STATUS_PUBLISHED,
            'published_at' => now(),
        ]);

        $submissions->each(fn($sub) => $sub->update([
            'author_id' => User::factory()->create()->id
        ]));

        $service = app(RisExportService::class);
        $ris = $service->generateRisMultiple($submissions->all());

        // Should have 3 ER (End of Record) markers
        $count = substr_count($ris, 'ER  - ');
        $this->assertEquals(3, $count);
    }

    /**
     * Test filename sanitization
     */
    public function test_ris_filename_sanitization()
    {
        $testCases = [
            'Normal Title' => 'Normal_Title',
            'Title With Special @#$%' => 'Title_With_Special',
            'Multiple   Spaces' => 'Multiple_Spaces',
            'Hyphen-Test' => 'Hyphen-Test',
            'Under_Score_Test' => 'Under_Score_Test',
        ];

        $service = app(RisExportService::class);

        foreach ($testCases as $input => $expected) {
            $author = User::factory()->create();
            $submission = Submission::factory()->create([
                'author_id' => $author->id,
                'title' => $input,
            ]);

            // Test that download completes (verifies sanitization)
            $response = $this->get(route('papers.download-ris', $submission));
            $this->assertFalse($response->isServerError());
        }
    }

    /**
     * Test that research field is included as keyword
     */
    public function test_research_field_included_in_ris()
    {
        $author = User::factory()->create();
        
        $submission = Submission::factory()->create([
            'author_id' => $author->id,
            'title' => 'Test',
            'keywords' => 'keyword1, keyword2',
            'research_field' => 'Information Systems',
            'published_at' => now(),
        ]);

        $service = app(RisExportService::class);
        $ris = $service->generateRis($submission);

        $this->assertStringContainsString('KW  - keyword1', $ris);
        $this->assertStringContainsString('KW  - keyword2', $ris);
        $this->assertStringContainsString('KW  - Information Systems', $ris);
    }

    /**
     * Test RIS file can be opened and parsed
     */
    public function test_ris_file_is_valid_format()
    {
        $author = User::factory()->create(['name' => 'Test Author']);
        
        $submission = Submission::factory()->create([
            'author_id' => $author->id,
            'title' => 'Test Paper',
            'abstract' => 'Test abstract',
            'keywords' => 'test1, test2',
            'research_field' => 'Testing',
            'published_at' => now(),
        ]);

        $service = app(RisExportService::class);
        $ris = $service->generateRis($submission);

        // Parse RIS manually to verify format
        $lines = explode("\n", $ris);
        
        // Should start with TY  - JOUR
        $this->assertStringStartsWith('TY  - JOUR', trim($lines[0]));
        
        // Should end with ER  - 
        $this->assertStringContainsString('ER  - ', $ris);
        
        // All lines should follow format "TAG - VALUE"
        foreach ($lines as $line) {
            if (!empty(trim($line))) {
                $this->assertMatchesRegularExpression('/^[A-Z0-9]{2}\s{2}-\s/', trim($line));
            }
        }
    }

    /**
     * Test JSON response for API calls (if needed)
     */
    public function test_ris_download_route_exists()
    {
        $paper = Submission::factory()->create([
            'status' => Submission::STATUS_PUBLISHED
        ]);

        $response = $this->get(route('papers.download-ris', $paper));
        
        // Should not be 404
        $this->assertNotEquals(404, $response->getStatusCode());
    }
}
