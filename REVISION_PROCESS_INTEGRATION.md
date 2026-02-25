# Revision Process Flow - Integration Summary

## Complete Revision Workflow

The system now implements a comprehensive peer review revision process with the following flow:

### 1. **Reviewer Recommends Revision**
   - Reviewers submit their review with recommendation (Accept, Minor Revisions, Major Revisions, Reject)
   - Location: `/reviews/assignment/{assignment}/create`
   - Model: `Review`

### 2. **Assigned Editor Decision: Requests Minor/Major Revision**
   - Editor reviews all submissions and feedback
   - Makes decision to request revisions (minor or major)
   - Location: `/editor/submissions/{submission}`
   - Creates: `RevisionRequest` record
   - Status changes to: `revisions_requested`
   - Notification sent to author

### 3. **System Notifies Author**
   - Author receives notification of revision request
   - Includes revision type and reason for revision
   - Uses notification system in `Notification` model

### 4. **Author Uploads Revised Version**
   - Author navigates to `/submissions/{submission}/revisions`
   - Uploads revised manuscript with notes
   - Submits revision via `submitRevision` method in `SubmissionController`

### 5. **System Auto-Sends Back to Original Reviewers**
   - Original reviewers who completed initial review are auto-assigned
   - `RevisionReview` records created for each original reviewer
   - Status set to `revision_under_review`
   - Reviewers notified of revised manuscript ready for re-review
   - Location for reviewers: `/reviews/revision/{revisionReview}/create`

### 6. **Assigned Editor Checks Revision Reviews**
   - Editor navigates to `/editor/revision-reviews`
   - Views all pending revision reviews for their submissions
   - Sees feedback from all reviewers on revised manuscript
   - Tracks which reviewers have completed re-review

### 7. **Final Editorial Decision**
   - Editor can now:
     - **Accept**: Manuscript accepted for publication
     - **Reject**: Manuscript rejected
     - **Request Further Revisions**: Send back for another revision cycle
   - Decision recorded in `Submission` status
   - Author notified of final decision
   - Route: `POST /editor/submissions/{submission}/revision-decision`

---

## Database Schema

### New Model: `RevisionReview`
Tracks reviewer feedback on revised manuscripts:
- `id` (Primary Key)
- `revision_request_id` (FK to RevisionRequest)
- `reviewer_id` (FK to User)
- `status` (assigned, completed, declined)
- `recommendation` (accept, minor_revisions, major_revisions, reject)
- `comments_for_author` (Visible to author)
- `comments_for_editor` (Confidential)
- `rating` (1-5 scale, optional)
- `assigned_at` (Timestamp)
- `completed_at` (Timestamp)
- `due_at` (Timestamp)

### Updated Model: `RevisionRequest`
Added relationship to `RevisionReview`:
- New method: `revisionReviews()` - One-to-many relationship

### New Submission Status
- `revision_under_review` - Indicates revised manuscript is being evaluated by reviewers

---

## Controller Methods

### SubmissionController
- `submitRevision()` - UPDATED: Auto-assigns original reviewers to RevisionReview records

### ReviewController
- `createRevisionReview()` - Show form for reviewer to review revised manuscript
- `storeRevisionReview()` - Save reviewer's revision review
- `editorRevisionReviews()` - List submissions with pending revision reviews
- `editorRevisionDecision()` - Record editor's final decision after revision review

### DashboardController
- `reviewer()` - UPDATED: Includes pending revision reviews in stats

---

## Views Created

### /resources/views/reviews/revision-review-create.blade.php
- Allows reviewers to submit reviews on revised manuscripts
- Shows original revision request context
- Author's revision notes displayed
- Recommendation, comments, and rating fields

### /resources/views/reviews/editor-revision-reviews.blade.php
- Dashboard for editors to manage revision reviews
- Lists submissions awaiting revision decisions
- Shows all reviewer feedback on revised manuscripts
- Final decision form (Accept/Reject/Further Revisions)

---

## Routes Added

### Reviewer Routes
- `GET /reviews/revision/{revisionReview}/create` → `reviews.revision-create`
- `POST /reviews/revision` → `reviews.revision-store`

### Editor Routes
- `GET /editor/revision-reviews` → `editor.revision-reviews`
- `POST /editor/submissions/{submission}/revision-decision` → `editor.revision-decision`

---

## Notification Flow

1. **Revision Request**: Author notified when editor requests revisions
2. **Revision Submitted**: Editor and reviewers notified when author submits revision
3. **Re-Review Assigned**: Reviewers notified of revised manuscript ready for re-review
4. **Review Submitted**: Editor notified when reviewer completes revision review
5. **Final Decision**: Author notified of final decision (Accepted/Rejected/Further Revisions)

---

## Key Features

✅ **Double-Blind Anonymity**: Reviewer names remain anonymous to authors  
✅ **Automatic Reviewer Assignment**: Original reviewers automatically re-assigned for revised manuscripts  
✅ **Complete Audit Trail**: All revisions, reviews, and decisions tracked  
✅ **Flexible Revision Cycles**: Multiple revision rounds supported  
✅ **Editor Control**: Editors can request further revisions even after revision review  
✅ **Real-time Notifications**: All stakeholders notified at each stage  
✅ **Comprehensive Feedback**: Separate comments for authors and editors  

---

## Usage Examples

### For Authors
1. Author submits manuscript
2. Receives revision request notification
3. Navigates to `/submissions/{id}/revisions`
4. Uploads revised file with notes
5. Receives final decision notification

### For Reviewers
1. Assigned to review manuscript
2. Submits initial review
3. Later assigned to review revised manuscript
4. Navigates to `/reviews/revision/{id}/create`
5. Submits revision review with updated recommendation

### For Editors
1. Reviews all submissions
2. Makes decision to request revisions
3. Views `/editor/revision-reviews` to check reviewer feedback on revisions
4. Makes final decision (Accept/Reject/Further Revisions)
5. System automatically notifies all parties

---

## Migration Required

Run the following to add revision reviews table:
```bash
php artisan migrate
```

This will create the `revision_reviews` table with all necessary fields and relationships.

---

## Status Flow Diagram

```
submitted
    ↓
under_review
    ↓
revisions_requested (OR accepted/rejected)
    ↓
revision_under_review
    ↓
accepted/rejected (OR back to revisions_requested for another cycle)
```
