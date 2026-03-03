# Rating System Documentation (1-100 Scale)

## Overview

The Open Journal System has been updated to use a comprehensive 1-100 rating scale with role-based and context-specific criteria. This replaces the previous 1-5 star system and provides more granular assessment capabilities.

## Rating Scale Structure

The 1-100 rating scale is divided into 10 bands, each with specific criteria and interpretations:

### Rating Bands

| Band | Range | Label | Description |
|------|-------|-------|-------------|
| 1 | 1-10 | Poor/Inadequate | Fundamentally flawed or seriously problematic |
| 2 | 11-20 | Very Weak/Poor | Serious problems requiring major revision |
| 3 | 21-30 | Weak/Unsatisfactory | Substantial issues requiring major work |
| 4 | 31-40 | Below Average | Moderate issues requiring significant improvement |
| 5 | 41-50 | Average/Acceptable | Fair to acceptable quality with improvements needed |
| 6 | 51-60 | Above Average/Good | Good quality with minor revisions needed |
| 7 | 61-70 | Good/Very Good | Well-executed with minimal revisions |
| 8 | 71-80 | Very Good/Excellent | High quality, nearly publication-ready |
| 9 | 81-90 | Excellent/Outstanding | Exceptional quality, minimal changes needed |
| 10 | 91-100 | Outstanding/Perfect | Exceptional/flawless, ready for publication |

## Role-Based Rating Criteria

### 1. Peer Reviewers (reviewer)

**Purpose:** Evaluate manuscript quality for peer review

**Criteria by Band:**
- **1-10 (Poor):** Fundamentally flawed, major scientific issues, not suitable for publication
- **11-20 (Very Weak):** Serious problems that need major revision, unlikely to meet publication standards
- **21-30 (Weak):** Substantial issues requiring major revision before consideration
- **31-40 (Below Average):** Moderate issues, major revision needed, questionable contribution
- **41-50 (Average):** Fair quality but needs substantial revision, moderate contribution
- **51-60 (Above Average):** Good quality with minor revisions needed, solid contribution
- **61-70 (Good):** Well-executed work with minor revisions, good scientific contribution
- **71-80 (Very Good):** High quality work, publishable with minimal changes, significant contribution
- **81-90 (Excellent):** Excellent quality, near publication-ready, highly significant contribution
- **91-100 (Outstanding):** Exceptional work, ready for publication, transformative contribution

**Key Characteristics:**
- Focus on scientific rigor and novelty
- Evaluation of methodology and conclusions
- Assessment of manuscript clarity and presentation
- Contribution to the field

---

### 2. Editors (editor, editor-in-chief, chief_editor)

**Purpose:** Initial editorial screening and assessment

**Criteria by Band:**
- **1-10 (Reject):** Completely unsuitable, fundamental mismatch with journal scope
- **11-20 (Strong Reject):** Unsuitable for publication, major editorial concerns
- **21-30 (Desk Reject):** Not suitable for external review, significant issues
- **31-40 (Unlikely Suitable):** Unlikely to proceed after review, editorial concerns
- **41-50 (Marginal):** Marginal decision, requires careful review
- **51-60 (Suitable):** Suitable for external review, meets editorial standards
- **61-70 (Good Fit):** Good fit for journal, strong editorial endorsement
- **71-80 (Very Good Fit):** Excellent fit for journal, high priority for review
- **81-90 (Excellent):** Exceptional manuscript, prioritized for expert review
- **91-100 (Outstanding):** Exceptionally promising, flagship potential

**Key Characteristics:**
- Journal scope alignment
- Manuscript presentation quality
- Strategic importance
- Reader interest potential

---

### 3. Revision Reviewers (revision_reviewer)

**Purpose:** Evaluate author's response to revision requests

**Criteria by Band:**
- **1-10 (Inadequate):** Author has not adequately addressed revision requirements
- **11-20 (Poor):** Most revision issues not properly addressed, significant gaps remain
- **21-30 (Unsatisfactory):** Multiple revision issues inadequately addressed
- **31-40 (Below Average):** Some revision issues addressed but gaps remain
- **41-50 (Acceptable):** Acceptable revision, most issues addressed adequately
- **51-60 (Good):** Good revision quality, issues well addressed
- **61-70 (Very Good):** Very good revision quality, comprehensive responses
- **71-80 (Excellent):** Excellent revision quality, all issues thoroughly addressed
- **81-90 (Outstanding):** Outstanding revision quality, extensive improvements throughout
- **91-100 (Exemplary):** Exemplary revision, extensively improved beyond expectations

**Key Characteristics:**
- Completeness of author responses
- Quality of revisions made
- Justifications provided
- Overall strengthening of manuscript

---

### 4. Layout Editors (layout_editor)

**Purpose:** Assess file and formatting quality

**Criteria by Band:**
- **1-10 (Unusable):** File cannot be used for layout, major issues
- **11-20 (Very Poor):** Major layout issues, extensive corrections needed
- **21-30 (Poor):** Significant layout issues, substantial corrections needed
- **31-40 (Below Average):** Moderate layout issues, needs correction
- **41-50 (Average):** Fair layout, standard corrections needed
- **51-60 (Good):** Good layout quality, minor adjustments needed
- **61-70 (Very Good):** Very good quality, minimal layout work needed
- **71-80 (Excellent):** Excellent content quality, nearly publication-ready layout
- **81-90 (Outstanding):** Outstanding file quality, minimal intervention needed
- **91-100 (Perfect):** Perfect file quality, publication-ready as-is

**Key Characteristics:**
- File format and compatibility
- Formatting consistency
- Style adherence
- Publication readiness

---

## Migration from 1-5 to 1-100 Scale

Existing 1-5 ratings have been automatically converted to the 1-100 scale using this mapping:

- **1 (Poor)** → **10 (1-10 band)**
- **2 (Fair)** → **30 (21-30 band)**
- **3 (Good)** → **50 (41-50 band)**
- **4 (Very Good)** → **70 (61-70 band)**
- **5 (Excellent)** → **90 (81-90 band)**

---

## Technical Implementation

### Database Tables

#### `reviews` table
- **rating:** `unsignedSmallInteger(1-100)` - optional

#### `revision_reviews` table
- **rating:** `unsignedSmallInteger(1-100)` - optional

#### `rating_criterias` table (new)
- **role:** User role (reviewer, editor, revision_reviewer, layout_editor)
- **context:** Rating context (general, submission, revision, layout)
- **band:** Rating band (1-10, 11-20, ..., 91-100)
- **label:** Display label
- **description:** Detailed description
- **characteristics:** JSON array of characteristics
- **score_min/max:** Score range boundaries

### Models

#### ReviewModel
```php
$review->getRatingBand()         // Returns band e.g., "71-80"
$review->getRatingLabel()        // Returns label e.g., "Excellent"
$review->getRatingDescription()  // Returns full description
$review->getRatingCharacteristics() // Returns array of characteristics
```

#### RevisionReviewModel
```php
// Same methods as Review model
```

#### RatingCriteria Model
```php
// Static methods for accessing criteria
RatingCriteria::getLabelForRating($rating, $role, $context)
RatingCriteria::getDescriptionForRating($rating, $role, $context)
RatingCriteria::getCharacteristicsForRating($rating, $role, $context)
RatingCriteria::getForRole($role, $context)
```

### Services

#### RatingScale Service
```php
use App\Services\RatingScale;

// Get band from rating
RatingScale::getBandFromRating(75); // Returns "71-80"

// Get criteria by role
RatingScale::getCriteriaForReviewer();
RatingScale::getCriteriaForEditor();
RatingScale::getCriteriaForRevisionReviewer();
RatingScale::getCriteriaForLayoutEditor();

// Convert legacy ratings
RatingScale::convertFromLegacy(5); // Returns 90

// Get info by band
RatingScale::getLabelByBand('71-80', 'reviewer');
RatingScale::getDescriptionByBand('71-80', 'reviewer');
```

---

## User Interface

### Rating Input

Users rate on a 1-100 scale with:
- **Range slider** for intuitive selection
- **Numeric input** showing exact value
- **Visual indicators** showing rating band and category
- **Color-coded bands** for quick reference:
  - Red: 1-20 (Poor)
  - Orange: 21-40 (Weak)
  - Yellow: 41-60 (Average)
  - Blue: 61-80 (Good)
  - Green: 81-100 (Excellent)

### Rating Display

Ratings are displayed with:
- **Progress bar** showing visual representation
- **Numeric score** (e.g., 75/100)
- **Tooltips** with rating band information on hover

---

## Validation

### Form Validation Rules

```php
'rating' => ['nullable', 'integer', 'min:1', 'max:100']
```

- Optional field
- Must be integer
- Range: 1-100

---

## Usage Examples

### Creating/Updating a Review with Rating

```php
$review = Review::create([
    'submission_id' => $submission->id,
    'reviewer_id' => $reviewer->id,
    'recommendation' => 'accept',
    'comments_for_author' => '...',
    'rating' => 78, // 1-100 scale
]);
```

### Displaying Rating Information

```blade
@if ($review->rating)
    <p>Rating: {{ $review->rating }}/100</p>
    <p>Band: {{ $review->getRatingBand() }}</p>
    <p>Label: {{ $review->getRatingLabel() }}</p>
    <p>Description: {{ $review->getRatingDescription() }}</p>
@endif
```

### Querying by Rating Band

```php
// Get reviews with rating above 70
$excellentReviews = Review::whereRaw('rating >= 71')->get();

// Get reviews in specific band
$goodReviews = Review::whereRaw('rating >= 61 AND rating <= 70')->get();
```

---

## Best Practices

1. **Always provide context** when displaying ratings
2. **Use tooltips** to show rating band descriptions
3. **Consider user role** when interpreting ratings
4. **Provide guidance** on what each rating band means
5. **Use visual indicators** for quick assessment
6. **Include characteristics** in detailed views
7. **Display the band** not just the number (e.g., "75 (71-80: Very Good)")

---

## Customization

To customize rating criteria for your institution:

1. Edit `app/Services/RatingScale.php` methods:
   - `getCriteriaForReviewer()`
   - `getCriteriaForEditor()`
   - `getCriteriaForRevisionReviewer()`
   - `getCriteriaForLayoutEditor()`

2. Update the corresponding seeder: `database/seeders/RatingCriteriaSeeder.php`

3. Run migrations and seeder:
   ```bash
   php artisan migrate
   php artisan db:seed --class=RatingCriteriaSeeder
   ```

---

## Migration Guide for Implementers

### Step 1: Run Migrations
```bash
php artisan migrate
```

This will:
- Create the `rating_criterias` table
- Update `reviews` and `revision_reviews` tables
- Automatically convert existing 1-5 ratings to 1-100 scale

### Step 2: Seed Rating Criteria
```bash
php artisan db:seed --class=RatingCriteriaSeeder
```

### Step 3: Update Existing Code
- Validation rules are already updated in controllers
- Views have been updated to display 1-100 ratings
- Models include new helper methods

### Step 4: Test the System
- Create a new review/revision review
- Test rating input and display
- Verify rating criteria display

---

## Support and Troubleshooting

### Common Issues

**Q: Why are my old ratings showing as 10, 30, 50, 70, 90?**
A: These are the converted values from the 1-5 scale. They map to the middle of each band for better representation.

**Q: Can I use half ratings (e.g., 75.5)?**
A: No, ratings are integers from 1-100. The system doesn't support decimal ratings.

**Q: How do I filter by rating band?**
A: Use the `getBandFromRating()` method or query directly:
```php
Review::whereRaw('rating >= 61 AND rating <= 70')->get();
```

**Q: Can I customize the rating criteria?**
A: Yes, edit the RatingScale service class and update the seeder, then re-migrate.

---

## References

- **RatingScale Service:** `/app/Services/RatingScale.php`
- **RatingCriteria Model:** `/app/Models/RatingCriteria.php`
- **Migration:** `/database/migrations/2026_03_03_000001_migrate_ratings_to_100_scale.php`
- **Seeder:** `/database/seeders/RatingCriteriaSeeder.php`
