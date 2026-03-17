# RIS File Download Feature - Documentation

## Overview

The RIS (Research Information System) file download feature allows users to download bibliographic citations in RIS format, which can be easily imported into citation management software and reference databases.

**Purpose**: Enable seamless transfer of paper metadata and references between the journal system and citation management tools.

---

## What is RIS Format?

RIS is a standardized text-based format for bibliographic data used by most citation management software including:
- **Zotero** - Free, open-source reference manager
- **Mendeley** - Research collaboration platform with reference management
- **EndNote** - Popular bibliography software
- **RefWorks** - Web-based reference management system
- **Papers 3** - Academic paper management
- **Google Scholar** - Academic search with RIS export
- And many academic databases

### RIS File Structure

Each RIS record contains tagged fields representing bibliographic information:

```
TY  - JOUR                           (Type of Reference: Journal Article)
ID  - 42                             (Reference ID)
TI  - Advanced Machine Learning      (Title)
AU  - Smith, John                    (Author: Last, First format)
PY  - 2024                           (Publication Year)
AB  - Abstract text here...          (Abstract)
KW  - Machine Learning              (Keywords)
TI  - Artificial Intelligence        
JO  - IRJIEST Journal                (Journal Name)
UR  - https://example.com/papers/42  (URL)
N1  - Downloaded from IRJIEST        (Notes)
ER  - 
```

---

## Feature Components

### 1. **RIS Export Service** (`app/Services/RisExportService.php`)

Handles the generation of RIS-formatted content from submission records.

#### Key Methods:

```php
// Generate RIS for single submission
$risService->generateRis($submission): string

// Generate RIS for multiple submissions
$risService->generateRisMultiple($submissions): string
```

#### RIS Fields Included:

| Tag | Meaning | Example |
|-----|---------|---------|
| TY | Type of Reference | JOUR (Journal Article) |
| ID | Reference ID | Submission ID |
| TI | Title | Paper title |
| AU | Author | Last, First format |
| PY | Publication Year | 2024 |
| AB | Abstract | Full abstract text |
| KW | Keywords | Paper keywords & research field |
| JO | Journal Name | IRJIEST |
| UR | URL | Link to paper on system |
| N1 | Notes | "Downloaded from IRJIEST" |
| ER | End of Record | (Marks end) |

### 2. **Controller Method** (`app/Http/Controllers/HomeController.php`)

Added `downloadPublicPaperRis()` method that:
- Validates paper publish status
- Generates RIS content using service
- Returns downloadable file with proper MIME type
- Sanitizes filename

### 3. **Route** (`routes/web.php`)

```php
Route::get('/papers/{submission}/download-ris', [HomeController::class, 'downloadPublicPaperRis'])->name('papers.download-ris');
```

### 4. **UI Elements**

#### In Published Papers Listing (`resources/views/published-papers.blade.php`)
- **Export Citation button** below each paper card
- Takes users to download .ris file
- Styled with gold border and hover effects

#### In Individual Paper View (`resources/views/papers/show.blade.php`)
- **Export as RIS button** in Citation section
- Alongside "Cite This Paper" modal button
- Contains helper text: "RIS format works with Zotero, Mendeley, EndNote, and other reference managers"

---

## User Workflow

### How to Use RIS Download

#### **For Zotero Users:**
1. Click "Export Citation" on published paper
2. Save the `.ris` file to your computer
3. In Zotero: `File` → `Import` → Select the `.ris` file
4. Citation automatically added to your library

#### **For Mendeley Users:**
1. Click "Export Citation" button
2. Open Mendeley Desktop
3. Go to `File` → `Import` and select the `.ris` file
4. Paper added to your library

#### **For EndNote Users:**
1. Download the `.ris` file
2. Open EndNote
3. `File` → `Import` → Select the `.ris` file
4. Citation imported to your database

#### **For EndNote Online/RefWorks:**
1. Click download button
2. Upload `.ris` file to your online account's import function

---

## Technical Implementation Details

### File Generation Process

1. **Service Initialization**: `RisExportService` instantiated from container
2. **Data Extraction**: Required fields extracted from `Submission` model
3. **Formatting**: Author names converted to RIS format (Last, First)
4. **Sanitization**: Text fields cleaned of line breaks and special characters
5. **RIS Generation**: Tags formatted according to RIS specification
6. **Stream Response**: File streamed directly without saving to disk

### Filename Sanitization

The feature automatically sanitizes filenames to be filesystem-safe:
```php
"Machine Learning in 2024" → "Machine_Learning_in_2024.ris"
"Advanced AI & ML (Research)" → "Advanced_AI_ML_Research.ris"
```

### MIME Type Handling

The download uses proper MIME type:
```
Content-Type: application/x-research-info-systems
```

This ensures operating systems recognize the file as a RIS file.

---

## Code Examples

### Adding RIS Download to Library Feature

If you want to add bulk RIS export for multiple papers:

```php
// In controller
$papers = Submission::where('status', 'published')
    ->where('research_field', 'Machine Learning')
    ->get();

$risService = app(RisExportService::class);
$risContent = $risService->generateRisMultiple($papers);

return response()->streamDownload(
    fn() => echo $risContent,
    'machine_learning_papers.ris'
);
```

### Programmatic RIS Generation

```php
use App\Services\RisExportService;

$submission = Submission::find(42);
$risService = app(RisExportService::class);
$ris = $risService->generateRis($submission);

// Do something with RIS content
// - Email to users
// - Save to database
// - API response, etc.
```

---

## Data Privacy & Security

### Privacy Considerations
- ✅ Only published papers available for RIS download
- ✅ No authentication required (public feature)
- ✅ Download logs available via standard Laravel logging
- ✅ No personal data stored (only paper metadata)

### Security Measures
- ✅ Status validation (`STATUS_PUBLISHED` check)
- ✅ Filename sanitization prevents directory traversal
- ✅ No file system writes during download
- ✅ Proper MIME type prevents browser interpretation attacks

---

## Extensibility & Future Enhancements

### Possible Enhancements

1. **Bulk Export**
   - Download RIS files for search results
   - Export entire research field bibliography

2. **Alternative Formats**
   - BibTeX export (.bib)
   - CSL-JSON format
   - APA/MLA text formats

3. **Author Metadata**
   - Multiple authors (currently uses first author only)
   - Author affiliations
   - ORCID identifiers

4. **Additional Fields**
   - DOI assignment and tracking
   - Volume/Issue numbers
   - Page numbers
   - Publisher information
   - Editor information

5. **Integration Enhancements**
   - Direct Zotero API integration
   - One-click import buttons
   - Browser extension support

### How to Extension

Add new export formats by creating additional service classes:

```php
// Example: BibTeX export service
namespace App\Services;

class BibtexExportService {
    public function generateBibtex(Submission $submission): string {
        // Implementation...
    }
}

// Register route
Route::get('/papers/{submission}/download-bib', 
    [HomeController::class, 'downloadPublicPaperBibtex']
    )->name('papers.download-bib');
```

---

## Testing

### Manual Testing Checklist

- [ ] Download RIS file from published papers listing
- [ ] Download RIS file from individual paper view
- [ ] RIS file opens correctly in text editor
- [ ] File contains all required fields (TY, ID, TI, AU, PY, etc.)
- [ ] Author name formatted correctly (Last, First)
- [ ] Import into Zotero works
- [ ] Import into Mendeley works
- [ ] Special characters in title handled correctly
- [ ] Long titles truncated properly
- [ ] Keywords properly separated
- [ ] URL included correctly

### Automated Testing Example

```php
// Feature test
public function test_user_can_download_published_paper_as_ris()
{
    $paper = Submission::factory()->create(['status' => 'published']);
    
    $response = $this->get(route('papers.download-ris', $paper));
    
    $response->assertStatus(200);
    $response->assertHeader('content-type', 'application/x-research-info-systems');
    $response->assertHeader('content-disposition', 'attachment; filename="' . $paper->title . '.ris"');
}

public function test_unpublished_paper_cannot_be_downloaded_as_ris()
{
    $paper = Submission::factory()->create(['status' => 'draft']);
    
    $response = $this->get(route('papers.download-ris', $paper));
    
    $response->assertStatus(403);
}
```

---

## Common Issues & Solutions

### Issue: Downloaded file won't open in reference manager

**Solutions:**
1. Ensure file has `.ris` extension
2. Check MIME type is `application/x-research-info-systems`
3. Manually rename file if necessary
4. Try importing as "Generic RIS"

### Issue: Author name format looks wrong

**Current behavior:** Only first author included, formatted as "Last, First"

**Future enhancement:** Multi-author support with proper separation

### Issue: Special characters corrupted

**Solution:** Service sanitizes line breaks and excessive spaces. If corruption persists, check system character encoding.

---

## Support & Feedback

For issues or feature requests related to RIS download:
1. Check the troubleshooting section above
2. Review RIS format specification: https://en.wikipedia.org/wiki/RIS_(file_format)
3. Test with reference manager documentation
4. Create GitHub issue with details

---

## References

- **RIS Format Specification**: https://en.wikipedia.org/wiki/RIS_(file_format)
- **Zotero Import**: https://www.zotero.org/support/kb/importing_records_from_other_sources
- **Mendeley Import**: https://www.elsevier.com/products/mendeley/mendeley-desktop
- **EndNote Import**: https://endnote.com/
- **MIME Types**: https://www.iana.org/assignments/media-types/media-types.xhtml

