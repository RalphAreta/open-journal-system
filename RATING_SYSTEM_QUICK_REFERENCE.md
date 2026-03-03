# Rating System Quick Reference

## 🎯 What Changed?
- ✅ Rating scale: **1-5** → **1-100**
- ✅ Input method: Slider → **Simple number input (1-100)**
- ✅ Framework: **Academically rigorous** (no simplified bands)
- ✅ Criteria: Role-based with detailed scholarly guidance

## 📊 Rating Scale Guide

**Numerical Assessment (1-100):**
- **1-20:** Critically deficient
- **21-40:** Below publication standard
- **41-55:** Acceptable but limited quality
- **56-70:** Competent work meeting standards
- **71-85:** Good to excellent work
- **86-100:** Outstanding scholarly contribution

## 🔧 Quick Commands

```bash
# Install
php artisan migrate
php artisan db:seed --class=RatingCriteriaSeeder

# Verify
php artisan tinker
>>> App\Models\RatingCriteria::count()
# Should show: 40
```

## 📁 Key Files

| Purpose | File |
|---------|------|
| Service Logic | `app/Services/RatingScale.php` |
| Review Model | `app/Models/Review.php` |
| Revision Model | `app/Models/RevisionReview.php` |
| Migration | `database/migrations/2026_03_03_000001_migrate_ratings_to_100_scale.php` |

## 💻 API Usage

### Create/Update Review
```php
// Simple creation
$review = Review::create([
    'submission_id' => 1,
    'reviewer_id' => 5,
    'recommendation' => 'accept',
    'rating' => 75,  // 1-100 scale
]);

// Get rating interpretation
echo $review->getRatingInterpretation();  // "Good to excellent"
echo $review->getRatingGuidance();        // Full scholarly guidance
```

### Query by Rating
```php
// Excellent work (81-100)
$excellent = Review::where('rating', '>=', 81)->get();

// Below publication standard (21-40)
$weak = Review::whereBetween('rating', [21, 40])->get();

// Average rating
$avg = Review::where('submission_id', $id)->avg('rating');
```

### Get Criteria
```php
use App\Services\RatingScale;

// Get interpretation
RatingScale::interpretRating(75);  // "Good to excellent work"

// Get guidance for specific rating
RatingScale::getGuidanceForRating(75, 'reviewer');

// Get evaluation dimensions
RatingScale::getEvaluationDimensions('reviewer');

// Convert old rating
RatingScale::convertFromLegacy(4);  // 75
```

## 📝 Validation

```php
// Form validation
'rating' => ['nullable', 'integer', 'min:1', 'max:100']

// Custom validation
Rule::when($somethingTrue, ['required', 'integer', 'min:1', 'max:100'])
```

## 🎨 Blade Examples

### Display Rating
```blade
@if ($review->rating)
    <p>Rating: {{ $review->rating }}/100</p>
    <p>Interpretation: {{ $review->getRatingInterpretation() }}</p>
@endif
```

### Input Rating
```blade
<input type="number" name="rating" min="1" max="100" 
    value="{{ old('rating', $review?->rating) }}"
    placeholder="Enter rating (1-100)">
```

## 🔄 Data Conversion

Automatic conversion on migration:
- `1` → `20` (Critical deficiency)
- `2` → `40` (Below standard)
- `3` → `60` (Competent work)
- `4` → `75` (Good work)
- `5` → `90` (Excellent work)

## 📊 Database Schema

### rating_criterias Table
```
- id: bigint
- role: string (reviewer|editor|revision_reviewer|layout_editor)
- context: string (usually 'general')
- band: string ('1-10', '11-20', ..., '91-100')
- label: string
- description: text
- characteristics: json
- score_min/score_max: integer
```

## 🛠️ Role-Based Rating Framework

### Reviewer (Peer Review)
- **1-15:** Critically flawed methodology; unsuitable for revision
- **16-30:** Significant deficiencies; likely insufficient
- **31-45:** Substantial concerns; major revisions needed
- **46-60:** Acceptable framework; improvements required
- **61-75:** Sound approach; minimal revisions necessary
- **76-85:** Rigorous methodology; near-publication ready
- **86-100:** Exemplary rigor; transformative contribution

### Editor (Editorial Assessment)
- Evaluates journal fit, strategic alignment, publication viability
- Range: Desk reject to flagship submission candidate

### Revision Reviewer
- **1-15:** Critical failures; issues unaddressed
- **46-60:** Acceptable execution; most feedback addressed
- **86-100:** Exemplary revision; extensive improvements

### Layout Editor
- **1-15:** Severely compromised; resubmission necessary
- **46-60:** Acceptable; standard corrections needed
- **86-100:** Exemplary; publication-ready

## ✅ Validation Rules Reference

| Rule | Details |
|------|---------|
| `nullable` | Optional field |
| `integer` | Must be whole number |
| `min:1` | Minimum value 1 |
| `max:100` | Maximum value 100 |

## 🛠️ Troubleshooting

| Issue | Solution |
|-------|----------|
| Can't input decimal (e.g., 7.5) | System uses integers only (1-100) |
| Old 1-5 ratings still showing | Check migration completed |
| Criteria empty | Run: `php artisan db:seed --class=RatingCriteriaSeeder` |
| Need rating guidance | Use `getRatingGuidance()` on model or `RatingScale::getGuidanceForRating()` |

## 📚 Documentation

- **Full Docs:** See `RATING_SYSTEM_DOCUMENTATION.md`
- **Implementation Guide:** See `RATING_SYSTEM_IMPLEMENTATION_GUIDE.md`

## 🔍 Evaluation Dimensions by Role

### Reviewer
- Methodological Rigor
- Theoretical Framework
- Analytical Depth
- Scholarly Contribution
- Clarity and Presentation

### Editor
- Journal Scope Alignment
- Manuscript Quality
- Scholarly Significance
- Strategic Fit
- Practical Viability

### Revision Reviewer
- Feedback Completeness
- Response Quality
- Manuscript Improvement
- Scholarly Engagement
- Documentation

### Layout Editor
- File Format Integrity
- Formatting Consistency
- Standards Compliance
- Content Presentation
- Publication Readiness

---

**Last Updated:** March 3, 2026
**System Version:** 2.0 (Academic)
**Input:** Simple number field (1-100)
**Compatibility:** Laravel 11+, PHP 8.1+

