# Academic Rating System Update - Summary

## 🎯 Changes Made

### Core Update: From Simplified Bands to Academic Framework

The rating system has been transformed from simple categorical bands (Poor, Average, Good, etc.) to a **rigorous academic assessment framework** with detailed scholarly guidance and role-specific evaluation dimensions.

## ✅ What Changed

### 1. Rating Scale Service
**File:** `app/Services/RatingScale.php`

**Before:**
- 10 categorical bands (1-10, 11-20, ... 91-100)
- Simple labels ("Poor", "Excellent", etc.)
- Generic characteristics

**After:**
- **Academic scoring guidance** for each role's rating ranges (1-15, 16-30, 31-45, etc.)
- **Detailed scholarly descriptions** focusing on methodological rigor, contribution, etc.
- **Evaluation dimensions** specific to each role
- Methods:
  - `getCriteriaForReviewer()` - Peer review assessment framework
  - `getCriteriaForEditor()` - Editorial decision framework
  - `getCriteriaForRevisionReviewer()` - Revision quality assessment
  - `getCriteriaForLayoutEditor()` - Production quality assessment

### 2. User Interface
**Files:** 
- `resources/views/reviews/create.blade.php`
- `resources/views/reviews/revision-review-create.blade.php`

**Before:**
- HTML5 range slider (1-100)
- Visual color-coded bands
- Band category display

**After:**
- **Simple number input field** (users type 1-100)
- **Real-time interpretation display** (shows scholarly assessment meaning)
- Clean, academic appearance
- No slider distractions

**Example:**
```
Rating: [    75   ] / 100  Good to excellent work
```

### 3. Rating Display
**Files:**
- `resources/views/reviews/peer-reviews.blade.php`
- `resources/views/reviews/editor-show.blade.php`
- `resources/views/submissions/show.blade.php`

**Before:**
- Progress bars showing visual representation
- Band information overlay

**After:**
- **Numeric score with interpretation** (e.g., "75/100 - Good to excellent work")
- Clean academic presentation
- Interpretation text from `getRatingInterpretation()` method

### 4. Model Methods
**Files:**
- `app/Models/Review.php`
- `app/Models/RevisionReview.php`

**New Methods:**
- `getRatingInterpretation()` - Returns scholarly interpretation (e.g., "Good to excellent work")
- `getRatingGuidance()` - Returns detailed academic guidance for the rating

**Removed Methods:**
- `getRatingBand()` - Band concept removed
- `getRatingLabel()` - No longer used (not in database)
- `getRatingDescription()` - Not needed in new system
- `getRatingCharacteristics()` - Stored but not used in views

### 5. Data Migration
**File:** `database/migrations/2026_03_03_000001_migrate_ratings_to_100_scale.php`

**Updated Conversion Mapping:**
- `1` → `20` (Critically deficient)
- `2` → `40` (Below publication standard)
- `3` → `60` (Competent work)
- `4` → `75` (Good work)
- `5` → `90` (Outstanding work)

## 📊 Academic Rating Framework

### Rating Interpretation Scale

```
1-20     → Critically deficient
21-40    → Below publication standard
41-55    → Acceptable but limited quality
56-70    → Competent work meeting standards
71-85    → Good to excellent work
86-100   → Outstanding scholarly contribution
```

### Reviewer Assessment Framework
Detailed guidance for each rating range considering:
- **Methodological Rigor:** Soundness of research design and analysis
- **Theoretical Framework:** Coherence and originality of theoretical positioning
- **Analytical Depth:** Sophistication of analysis and argumentation
- **Scholarly Contribution:** Significance and potential impact
- **Clarity & Presentation:** Professional quality and accessibility

### Editor Assessment Framework
Evaluates:
- **Journal Scope Alignment:** Thematic fit with journal mission
- **Manuscript Quality:** Overall scholarly merit and presentation
- **Scholarly Significance:** Contribution to disciplinary knowledge
- **Strategic Fit:** Alignment with journal strategy
- **Practical Viability:** Feasibility of publication

### Revision Reviewer Assessment Framework
Measures:
- **Feedback Completeness:** How systematically issues are addressed
- **Response Quality:** Substantive engagement with critique
- **Manuscript Improvement:** Extent and significance of improvements
- **Scholarly Engagement:** Sophistication of intellectual response
- **Documentation:** Clarity of revision tracking

### Layout Editor Assessment Framework
Assesses:
- **File Format Integrity:** Technical soundness
- **Formatting Consistency:** Uniform application of standards
- **Standards Compliance:** Adherence to specifications
- **Content Presentation:** Quality of figures, tables, references
- **Publication Readiness:** Overall compatibility with production workflow

## 💻 Technical Implementation

### Input Format
```blade
<input type="number" name="rating" min="1" max="100" placeholder="0">
```
- Users directly enter a number from 1 to 100
- No slider interaction
- Clear, straightforward interface

### Interpretation Display
```blade
<span id="ratingInterpretation">{{ $review->getRatingInterpretation() }}</span>
```
- Shows scholarly meaning of the rating
- Updates in real-time on form
- Uses `RatingScale::interpretRating()` method

### Database Queries
```php
// Excellent work (86-100)
Review::where('rating', '>=', 86)->get();

// Quality analysis
$avg = Review::where('submission_id', $id)->avg('rating');

// Distribution
Review::whereBetween('rating', [56, 70])->count();
```

## 📚 Documentation Updates

- **RATING_SYSTEM_QUICK_REFERENCE.md** - Updated with academic framework
- **Views updated** with new input/display logic
- **Migration updated** with new conversion mapping

## 🔄 Conversion Examples

### Old vs New Ratings

| Old 1-5 | New 1-100 | Interpretation |
|---------|-----------|---|
| 1 Poor | 20 | Critically deficient |
| 2 Fair | 40 | Below publication standard |
| 3 Good | 60 | Competent work |
| 4 Very Good | 75 | Good to excellent work |
| 5 Excellent | 90 | Outstanding contribution |

## ✅ Implementation Checklist

### No Additional Migrations Needed
- All Rating criteria seeded through base migration
- Database compatible with existing schema
- RatingCriteria table still populated for archive purposes

### Files Modified
- ✅ `app/Services/RatingScale.php` - Academic framework
- ✅ `app/Models/Review.php` - Simplified model methods
- ✅ `app/Models/RevisionReview.php` - Simplified model methods
- ✅ `resources/views/reviews/create.blade.php` - Number input UI
- ✅ `resources/views/reviews/revision-review-create.blade.php` - Number input UI
- ✅ `resources/views/reviews/peer-reviews.blade.php` - Rating display
- ✅ `resources/views/reviews/editor-show.blade.php` - Rating display
- ✅ `resources/views/submissions/show.blade.php` - Rating display
- ✅ `database/seeders/RatingCriteriaSeeder.php` - Updated for academic criteria
- ✅ `database/migrations/2026_03_03_000001_migrate_ratings_to_100_scale.php` - Updated mapping

## 🎓 Benefits of Academic Framework

1. **Scholarly Rigor:** Assessment criteria aligned with academic standards
2. **Flexibility:** Users input exact score (1-100), not limited to bands
3. **Interpretability:** Each rating has clear academic meaning
4. **Extensibility:** Detailed guidance for each role's evaluation needs
5. **Simplicity:** Clean UI without complex visualizations
6. **Professionalism:** Appropriate for academic publishing context

## 🚀 No Additional Setup Required

The system is already migrated. No further database changes needed:
- Existing ratings converted using new mapping
- Rating criteria seeded with academic framework
- All views updated and functional

## 📝 Usage Notes

### For Reviewers
```php
// Create a review with academic rating
$review = Review::create([
    'submission_id' => $submission->id,
    'reviewer_id' => $user->id,
    'recommendation' => 'accept',
    'rating' => 78,  // Academic score, not category
]);

// Get guidance
echo $review->getRatingGuidance();
// "Rigorous methodology; sophisticated analytical framework; 
//  significant advancement of scholarly discourse; 
//  near-publication readiness; recommendation: accept with editorial recommendations"
```

### For Editors
```php
// Query excellent manuscripts (86-100)
$candidates = Submission::whereHas('reviews', function ($q) {
    $q->where('rating', '>=', 86);
})->get();
```

### For Analysis
```php
// Average quality score
$avgScore = Review::where('submission_id', $id)->avg('rating');

// Quality distribution
$distribution = [
    'excellent' => Review::where('rating', '>=', 86)->count(),
    'good' => Review::whereBetween('rating', [71, 85])->count(),
    'acceptable' => Review::whereBetween('rating', [41, 70])->count(),
    'below_standard' => Review::where('rating', '<', 41)->count(),
];
```

## 🔍 Backward Compatibility

✅ **Full Backward Compatibility:**
- Existing review data preserved
- All old 1-5 ratings converted to 1-100
- RatingCriteria table maintained for reference
- Database schema compatible
- Rollback support available via migration

## 📞 Support

For questions or customization:
1. Review RatingScale service class for academic criteria
2. Check getRatingInterpretation() and getRatingGuidance() methods
3. Examine blade templates for UI implementation
4. Review migration for data mapping

---

**Update Date:** March 3, 2026
**System Version:** 2.0 (Academic)
**Key Change:** Switched from simplified bands to rigorous academic framework
