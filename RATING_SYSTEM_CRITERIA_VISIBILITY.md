# Rating System - Criteria Visibility Enhancement

## Overview

The rating system displays a simple reference table on review submission forms showing the rating scale ranges with brief labels and descriptions, allowing users to quickly reference scoring standards while entering ratings.

## Display Format

Both peer review and revision review forms show a clean table with three columns:

| Range | Label | Description |
|-------|-------|-------------|
| 1-20 | Critically deficient | Brief explanation |
| 21-40 | Below standard | Brief explanation |
| ... | ... | ... |

Each range is color-coded with a subtle background color (red to green gradient) for visual quick reference.

## Peer Review Scale

**File**: `resources/views/reviews/create.blade.php`

```
1-20    | Critically deficient | Fundamental flaws; unsuitable for publication
21-40   | Below standard       | Major deficiencies; significant revisions needed
41-55   | Acceptable but limited | Concerns present; major revisions required
56-70   | Competent work       | Acceptable quality; minor to moderate revisions
71-85   | Good to excellent    | Sound work; minimal revisions needed
86-100  | Outstanding         | Exemplary quality; ready for publication
```

## Revision Review Scale

**File**: `resources/views/reviews/revision-review-create.blade.php`

```
1-20    | Critical failures    | Essential issues unaddressed; substantial rework needed
21-40   | Inadequate revision  | Significant gaps in addressing feedback
41-55   | Partial completion   | Multiple issues inadequately addressed
56-70   | Acceptable responses | Most feedback addressed; minor gaps
71-85   | Good revision work   | Thorough engagement; significant improvements
86-100  | Exemplary revision   | Exceptional responsiveness; extensive improvements
```

## User Experience

- **Simple Reference**: Clean table format similar to published academic standards (Saaty scale)
- **Color-Coded Rows**: Each range has a subtle background color for quick scanning
- **Concise Labels**: Brief, direct language (e.g., "85 - good-excellent")
- **Always Visible**: Displayed at page load before the rating input field
- **Accessible**: Works on all devices, no complex interactions needed

## Technical Implementation

### Display Structure
```
┌── Rating Scale Reference ──────┐
│                                 │
│  Range | Label | Description   │
│  1-20  | ...   | ...            │
│  21-40 | ...   | ...            │
│  ...   | ...   | ...            │
│                                 │
└─────────────────────────────────┘

Rating Input Field
│ [ ] / 100  [Interpretation]
```

### Styling
- **Container**: Light gray background (slate-50), minimal border
- **Table**: Clean, simple structure with adequate spacing
- **Row Colors**: Subtle alternating backgrounds (red → orange → amber → yellow → lime → green)
- **Responsive**: Horizontal scroll on mobile if needed

## Files Modified

- `resources/views/reviews/create.blade.php` - Added simple rating scale table
- `resources/views/reviews/revision-review-create.blade.php` - Added simple rating scale table

## Data Source

Scale ranges and labels are hardcoded in the Blade templates for simplicity and quick loading. These align with the academic guidance in `app/Services/RatingScale.php` but are simplified for on-form display.

## Future Enhancements

1. **Dynamic Highlighting**: Highlight current range as user types rating
2. **Tooltips**: Show full guidance on hover
3. **Additional Roles**: Add table for editor and layout editor assessments
4. **Printable Guide**: Generate PDF reference document

---

**Date Generated**: 2026-03-03  
**Version**: 2.0 (Simplified)  
**Status**: Implemented
