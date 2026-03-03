# Rating System Implementation Guide

This guide provides step-by-step instructions for implementing and deploying the new 1-100 rating scale system.

## Quick Start

### Prerequisites
- Laravel 11.x or higher
- PHP 8.1 or higher
- Database (MySQL 8.0+, PostgreSQL 13+, or SQLite)

### Installation Steps

#### 1. Run Database Migrations
```bash
php artisan migrate
```

This migration will:
- ✅ Create the `rating_criterias` table
- ✅ Update `reviews` table rating column to support 1-100
- ✅ Update `revision_reviews` table rating column
- ✅ Automatically convert all existing 1-5 ratings to 1-100 scale

#### 2. Seed Rating Criteria
```bash
php artisan db:seed --class=RatingCriteriaSeeder
```

This populates the `rating_criterias` table with role-based criteria:
- ✅ Reviewer criteria (peer review evaluation)
- ✅ Editor criteria (editorial assessment)
- ✅ Revision Reviewer criteria (revision assessment)
- ✅ Layout Editor criteria (file quality assessment)

#### 3. Verify Installation
```bash
php artisan tinker

# Test the seeded data
>>> App\Models\RatingCriteria::count()
40  # Should show 40 records (10 bands × 4 roles)

>>> App\Models\RatingCriteria::getForRole('reviewer')
# Should return reviewer criteria for all bands
```

## Features

### 1. Rating Input Interface

The rating input system provides:
- **Range slider** (1-100) for intuitive selection
- **Numeric display** showing exact value
- **Visual indicators** with color-coded bands
- **Real-time synchronization** between slider and number input

Location: All review forms
- `resources/views/reviews/create.blade.php`
- `resources/views/reviews/revision-review-create.blade.php`

### 2. Rating Display

Ratings are displayed with:
- **Progress bar** visualization
- **Numeric score** (e.g., 75/100)
- **Band information** on hover

Locations:
- `resources/views/reviews/peer-reviews.blade.php`
- `resources/views/reviews/editor-show.blade.php`
- `resources/views/submissions/show.blade.php`

### 3. Role-Based Criteria

Different user roles have different rating interpretations:

| Role | Purpose | Context |
|------|---------|---------|
| Reviewer | Peer review  | Scientific quality evaluation |
| Editor | Editorial  | Journal fit & strategic value |
| Revision Reviewer | Revision assessment | Adequacy of author revisions |
| Layout Editor | File quality | Publication-ready format |

### 4. Rating Bands

10 distinct bands provide granular rating categories:

```
1-10     Poor/Inadequate    (Red)
11-20    Very Weak/Poor     (Red-Orange)
21-30    Weak/Unsatisfactory (Orange)
31-40    Below Average      (Orange-Yellow)
41-50    Average/Acceptable (Yellow)
51-60    Above Average/Good (Yellow-Green)
61-70    Good/Very Good     (Blue)
71-80    Very Good/Excellent (Blue)
81-90    Excellent/Outstanding (Green)
91-100   Outstanding/Perfect (Dark Green)
```

## API Reference

### RatingScale Service

```php
use App\Services\RatingScale;

// Get band from rating
$band = RatingScale::getBandFromRating(75);  // "71-80"

// Get all bands
$bands = RatingScale::getBands();

// Get criteria by role
$reviewerCriteria = RatingScale::getCriteriaForReviewer();
$editorCriteria = RatingScale::getCriteriaForEditor();
$revisionCriteria = RatingScale::getCriteriaForRevisionReviewer();
$layoutCriteria = RatingScale::getCriteriaForLayoutEditor();

// Get specific criteria by band and role
$label = RatingScale::getLabelByBand('71-80', 'reviewer');
$description = RatingScale::getDescriptionByBand('71-80', 'reviewer');

// Convert legacy ratings
$newRating = RatingScale::convertFromLegacy(4);  // Returns 70
```

### RatingCriteria Model

```php
use App\Models\RatingCriteria;

// Get criteria for role and band
$criteria = RatingCriteria::getForRoleAndBand('reviewer', '71-80');
// Returns: {id, role, band, label, description, characteristics, score_min, score_max}

// Get all criteria for a role
$reviewerCriteria = RatingCriteria::getForRole('reviewer', 'general');
// Returns array of all bands for that role

// Get label for specific rating
$label = RatingCriteria::getLabelForRating(75, 'reviewer', 'general');
// Returns: "Very Good"

// Get description for specific rating
$description = RatingCriteria::getDescriptionForRating(75, 'reviewer', 'general');
// Returns: "High quality work, publishable with minimal changes..."

// Get characteristics for specific rating
$characteristics = RatingCriteria::getCharacteristicsForRating(75, 'reviewer', 'general');
// Returns: ["Rigorous methodology", "Novel findings", ...]
```

### Model Methods

#### Review Model
```php
$review = Review::find(1);

// Get rating band
$band = $review->getRatingBand();  // "71-80"

// Get rating label
$label = $review->getRatingLabel();  // "Excellent"

// Get rating description
$description = $review->getRatingDescription();
// "Excellent quality, near publication-ready, highly significant contribution"

// Get rating characteristics
$characteristics = $review->getRatingCharacteristics();
// ["Outstanding methodology", "Groundbreaking findings", ...]
```

#### RevisionReview Model
```php
$revisionReview = RevisionReview::find(1);

// Same methods as Review model
$band = $revisionReview->getRatingBand();
$label = $revisionReview->getRatingLabel();
// etc.
```

## Database Schema

### rating_criterias table

```sql
CREATE TABLE rating_criterias (
    id BIGINT UNSIGNED PRIMARY KEY,
    role VARCHAR(50) NOT NULL,           -- reviewer, editor, revision_reviewer, layout_editor
    context VARCHAR(50) DEFAULT 'general',  -- general, submission, revision, layout
    band VARCHAR(10) NOT NULL,           -- 1-10, 11-20, ..., 91-100
    label VARCHAR(100) NOT NULL,         -- Outstanding, Excellent, etc.
    description TEXT NOT NULL,
    characteristics JSON,
    score_min INT NOT NULL,              -- 1, 11, 21, etc.
    score_max INT NOT NULL,              -- 10, 20, 30, etc.
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    UNIQUE KEY unique_role_context_band (role, context, band),
    INDEX idx_role_context (role, context)
);
```

### reviews table modifications

```sql
-- Updated column
ALTER TABLE reviews 
MODIFY COLUMN rating UNSIGNED SMALLINT NULLABLE;
-- Supports range 0-65535 (more than enough for 1-100)
```

### revision_reviews table modifications

```sql
-- Changed to supports 1-100 scale
ALTER TABLE revision_reviews 
MODIFY COLUMN rating UNSIGNED SMALLINT NULLABLE;
```

## Validation Rules

### Form Validation

```php
'rating' => ['nullable', 'integer', 'min:1', 'max:100']
```

- Optional field (users can skip rating)
- Must be whole number
- Range: 1 to 100

### Custom Validation Examples

```php
// Rate only if reviewer recommends certain decision
'rating' => Rule::when($validated['recommendation'] === 'accept', [
    'required', 'integer', 'min:1', 'max:100'
]),

// Reject low ratings when recommending acceptance
'rating' => [
    'nullable',
    'integer',
    'min:1',
    'max:100',
    function ($attribute, $value, $fail) {
        if ($value && $value < 50 && $this->recommendation === 'accept') {
            $fail('Cannot recommend acceptance with low rating.');
        }
    }
]
```

## User Interface Customization

### Rating Input Component

The rating slider uses:
- **HTML5 Range Input** for accessibility
- **Color bands** for visual feedback
- **Live synchronization** with number display
- **Responsive design** for mobile and desktop

**JavaScript Initialization:**
```javascript
// Auto-syncs slider to display
document.getElementById('rating').addEventListener('input', function() {
    document.getElementById('ratingValue').value = this.value;
});
```

### Customizing Band Colors

Edit view files to change band colors:

```blade
<!-- In create.blade.php -->
<div class="text-center p-2 rounded bg-red-50 border border-red-200">
    <!-- Customize these classes -->
</div>
```

Available Tailwind colors: red, orange, yellow, blue, green, slate, etc.

## Migration Examples

### Querying by Rating

```php
// Get reviews with excellent rating (81-100)
$excellent = Review::where('rating', '>=', 81)->get();

// Get reviews in specific band
$veryGood = Review::whereBetween('rating', [71, 80])->get();

// Get average rating for submission
$avgRating = Review::where('submission_id', $id)
    ->avg('rating');  // Returns integer average

// Get rating distribution
$distribution = Review::selectRaw('
    CASE 
        WHEN rating BETWEEN 1 AND 10 THEN "1-10"
        WHEN rating BETWEEN 11 AND 20 THEN "11-20"
        WHEN rating BETWEEN 21 AND 30 THEN "21-30"
        WHEN rating BETWEEN 31 AND 40 THEN "31-40"
        WHEN rating BETWEEN 41 AND 50 THEN "41-50"
        WHEN rating BETWEEN 51 AND 60 THEN "51-60"
        WHEN rating BETWEEN 61 AND 70 THEN "61-70"
        WHEN rating BETWEEN 71 AND 80 THEN "71-80"
        WHEN rating BETWEEN 81 AND 90 THEN "81-90"
        WHEN rating BETWEEN 91 AND 100 THEN "91-100"
    END as band,
    COUNT(*) as count
')
    ->groupBy('band')
    ->get();
```

### Filtering by Label

```php
// Get reviews with "Excellent" label
$excellent = Review::whereIn('rating', range(81, 90))->get();

// Get reviews above "Good" threshold
$good = Review::where('rating', '>=', 61)->get();
```

## Common Issues & Troubleshooting

### Issue: Rating input shows 0 or empty

**Solution:** Ensure JavaScript is running and form is properly initialized.

```blade
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', initializeRating);

function initializeRating() {
    const input = document.getElementById('rating');
    const display = document.getElementById('ratingValue');
    if (input && display) {
        input.addEventListener('input', function() {
            display.value = this.value;
        });
    }
}
</script>
@endpush
```

### Issue: Old ratings still show as 1-5

**Solution:** Verify migration ran successfully:

```bash
php artisan migrate:status
# Confirm 2026_03_03_000001_migrate_ratings_to_100_scale is "Ran"

# If not, run migration:
php artisan migrate --path=database/migrations/2026_03_03_000001_migrate_ratings_to_100_scale.php
```

### Issue: RatingCriteria table is empty

**Solution:** Run the seeder:

```bash
php artisan db:seed --class=RatingCriteriaSeeder

# Or seed all:
php artisan db:seed
```

### Issue: Rating criteria not showing in API

**Solution:** Ensure relationship is loaded in controller or API:

```php
// Load with criteria
$reviews = Review::with('reviewer')->get();

// Access criteria
foreach ($reviews as $review) {
    $label = RatingCriteria::getLabelForRating(
        $review->rating, 
        'reviewer', 
        'general'
    );
}
```

## Testing

### Unit Tests

```php
// tests/Unit/RatingScaleTest.php

public function test_get_band_from_rating()
{
    $this->assertEquals('1-10', RatingScale::getBandFromRating(5));
    $this->assertEquals('71-80', RatingScale::getBandFromRating(75));
    $this->assertEquals('91-100', RatingScale::getBandFromRating(100));
}

public function test_legacy_rating_conversion()
{
    $this->assertEquals(10, RatingScale::convertFromLegacy(1));
    $this->assertEquals(30, RatingScale::convertFromLegacy(2));
    $this->assertEquals(50, RatingScale::convertFromLegacy(3));
    $this->assertEquals(70, RatingScale::convertFromLegacy(4));
    $this->assertEquals(90, RatingScale::convertFromLegacy(5));
}
```

### Feature Tests

```php
// tests/Feature/ReviewRatingTest.php

public function test_create_review_with_rating()
{
    $response = $this->post(route('reviews.store'), [
        'review_assignment_id' => $this->assignment->id,
        'recommendation' => 'accept',
        'rating' => 75,
    ]);
    
    $this->assertDatabaseHas('reviews', [
        'rating' => 75,
    ]);
}
```

## Performance Considerations

### Indexing

The `rating_criterias` table has:
- `UNIQUE` constraint on (role, context, band) for fast lookups
- `INDEX` on (role, context) for filtering

### Caching Criteria

For high-traffic systems, cache criteria:

```php
// In ServiceProvider boot()
Cache::remember('rating_criteria:reviewer', now()->addDay(), function () {
    return RatingCriteria::getForRole('reviewer', 'general');
});
```

### Query Optimization

```php
// Bad - N+1 queries
$reviews = Review::all();
foreach ($reviews as $review) {
    echo RatingCriteria::getLabelForRating($review->rating, 'reviewer');
}

// Good - Single query
$criteria = RatingCriteria::whereIn('score_min', 
    [...$reviews->pluck('rating')]
)->get()->keyBy('score_min');

foreach ($reviews as $review) {
    echo $criteria[$review->rating]?->label;
}
```

## Rollback Instructions

If you need to revert to the original 1-5 system:

```bash
php artisan migrate:rollback
```

This will:
- ✅ Revert 1-100 ratings back to 1-5
- ✅ Drop the `rating_criterias` table
- ✅ Restore original column types

**Warning:** Data mapping:
- 10 → 1, 30 → 2, 50 → 3, 70 → 4, 90 → 5
- Ratings not in this set will be lost

## Support Resources

- **Full Documentation:** [RATING_SYSTEM_DOCUMENTATION.md](RATING_SYSTEM_DOCUMENTATION.md)
- **Service Class:** [app/Services/RatingScale.php](app/Services/RatingScale.php)
- **Model:** [app/Models/RatingCriteria.php](app/Models/RatingCriteria.php)
- **Migration:** [database/migrations/2026_03_03_000001_migrate_ratings_to_100_scale.php](database/migrations/2026_03_03_000001_migrate_ratings_to_100_scale.php)

## Contact & Feedback

For questions or issues regarding the rating system implementation, please refer to the documentation files or contact the development team.
