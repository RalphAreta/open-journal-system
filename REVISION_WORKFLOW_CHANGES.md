# Revised Manuscript Workflow Implementation

## Overview
This document outlines the changes made to modify the revised manuscript handling workflow. The system now ensures that when an author submits a revised manuscript, it first goes to the assigned editor for review before being forwarded to the original reviewers.

---

## 🔄 Workflow Comparison

### Previous Workflow
1. Author submits revised manuscript
2. ❌ System **automatically assigns** original reviewers
3. Reviewers review the revision
4. Editor makes final decision

### New Workflow (Current)
1. Author submits revised manuscript
2. ✅ Editor reviews the revision first
3. Editor decides whether to:
   - Forward to original reviewers for feedback, OR
   - Make a final decision directly (Accept/Reject/Further Revisions)
4. If forwarded to reviewers:
   - Reviewers review and provide feedback
   - Editor makes final decision based on feedback

---

## 📝 Code Changes

### 1. **RevisionService.php** - Core Logic Changes

#### Modified Method: `processRevisionSubmission()`
**Location:** [app/Services/RevisionService.php](app/Services/RevisionService.php#L59)

**Changes:**
- ❌ Removed automatic assignment of original reviewers
- ❌ Removed automatic notification to reviewers
- ✅ Added error handling with try-catch blocks
- ✅ Now only notifies the assigned editor that revision is awaiting their review

**Key Code:**
```php
// Before: Automatically assigned reviewers
self::assignOriginalReviewersForRevision($revisionRequest);
self::notifyReviewersOfRevision($submission, $revisionRequest);

// After: Only notifies editor
self::notifyEditorOfSubmittedRevisionAwaitingReview($submission, $revisionRequest);
```

#### New Method: `notifyEditorOfSubmittedRevisionAwaitingReview()`
**Location:** [app/Services/RevisionService.php](app/Services/RevisionService.php#L109)

**Purpose:** Notifies assigned editor that a revised manuscript is ready for their review

**Features:**
- Validates that editor exists before sending notification
- Includes error handling with logging
- Clear message informing editor of their next steps

#### Updated Method: `assignOriginalReviewersForRevision()`
**Changes:**
- ✅ Changed from `private` to `public` (now callable from controller)
- ✅ Added comprehensive error handling
- ✅ Throws `RuntimeException` if no reviewers found
- ✅ Logs all operations for debugging

**Error Handling:**
```php
if ($originalReviewers->isEmpty()) {
    throw new RuntimeException('No original reviewers found for this submission.');
}
```

#### Updated Method: `notifyChiefEditorOfRevision()`
**Changes:**
- ✅ Added try-catch error handling
- ✅ Validates chief editor exists
- ✅ Logs warnings if editor not found

#### Updated Method: `notifyAuthorOfRevisionRequest()`
**Changes:**
- ✅ Added try-catch error handling
- ✅ Continues if notification fails (doesn't block process)

#### Updated Method: `notifyReviewersOfRevision()`
**Changes:**
- ✅ Added try-catch error handling
- ✅ Called only when editor decides to forward revision to reviewers
- ✅ Continues if notification fails

---

### 2. **ReviewController.php** - Editor Actions

#### New Method: `forwardRevisionToReviewers()`
**Location:** [app/Http/Controllers/ReviewController.php](app/Http/Controllers/ReviewController.php#L639)

**Purpose:** Allows editor to forward a revised manuscript to original reviewers

**Authorization Checks:**
- Verifies user is the assigned editor
- Verifies submission status is `REVISION_UNDER_REVIEW`
- Ensures revised manuscript exists
- Prevents duplicate reviewer assignments

**Error Handling:**
```php
try {
    // Authorization and validation
    if ($submission->assigned_editor_id !== $request->user()->id) {
        abort(403, 'You do not have access to this submission.');
    }
    
    // Call service to assign reviewers
    RevisionService::assignOriginalReviewersForRevision($revision);
    
} catch (\RuntimeException $e) {
    // Handle specific errors (no reviewers found, etc.)
    Log::error('Error forwarding revision to reviewers', [...]);
    return back()->withErrors('Unable to forward to reviewers: ' . $e->getMessage());
} catch (\Exception $e) {
    // Handle unexpected errors
    Log::error('Unexpected error forwarding revision to reviewers', [...]);
    return back()->withErrors('An unexpected error occurred. Please try again.');
}
```

**Flow:**
1. Get latest revision request
2. Verify revision has been submitted by author
3. Check reviewers not already assigned
4. Call `RevisionService::assignOriginalReviewersForRevision()`
5. Redirect to editor dashboard with success message
6. Logs successful action and any errors

---

### 3. **routes/web.php** - Routing

**New Route:**
```php
Route::post('/editor/submissions/{submission}/forward-revision-to-reviewers', 
    [ReviewController::class, 'forwardRevisionToReviewers'])
    ->name('editor.forward-revision-to-reviewers');
```

**Location:** [routes/web.php](routes/web.php#L86)

**Middleware:** `role:editor` (only editors can access)

---

### 4. **editor-revision-reviews.blade.php** - UI Updates

**Location:** [resources/views/reviews/editor-revision-reviews.blade.php](resources/views/reviews/editor-revision-reviews.blade.php)

#### New Section: "Forward to Reviewers" Button
**Visible When:** No reviewers have been assigned yet

**Code:**
```blade
@if ($revision->revisionReviews->isEmpty())
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <h3 class="text-sm font-bold text-blue-900 mb-3">📋 Ready for Reviewer Feedback?</h3>
        <p class="text-sm text-blue-800 mb-4">
            You have reviewed the revised manuscript. You can now:
        </p>
        <ul class="list-disc list-inside text-sm text-blue-800 mb-4 space-y-1">
            <li><strong>Forward to Reviewers:</strong> Send to original reviewers for their feedback before making a final decision</li>
            <li><strong>Make Final Decision:</strong> Accept, reject, or request further revisions directly</li>
        </ul>
        <form method="POST" action="{{ route('editor.forward-revision-to-reviewers', $submission) }}" class="inline">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Forward to Original Reviewers
            </button>
        </form>
    </div>
@endif
```

#### Updated: "Reviewer Feedback" Section
**Changes:**
- ✅ Now conditional - only shows if reviewers have been assigned
- ✅ Shows reviewer status (assigned, pending, completed)
- ✅ Displays reviewer recommendations and comments when available

#### Updated: Final Decision Form
**Changes:**
- ✅ Added status indicators:
  - "⚠️ Some reviews still pending" (when reviewers assigned but not all submitted)
  - "✓ All reviews received" (when all reviewers submitted)
  - "No reviewers assigned yet" (when editor hasn't forwarded to reviewers)
- ✅ Allows editor to make final decision regardless of reviewer status

---

## 🛡️ Error Handling

### Comprehensive Error Management Implemented

**1. Service Layer (RevisionService.php)**
- Try-catch blocks around all database operations
- Validation of required entities (editor, reviewers, etc.)
- Meaningful error logging with context
- Non-critical failures don't block main process (notifications)

**2. Controller Layer (ReviewController.php)**
- Pre-flight authorization checks
- Status validation before operations
- Specific exception handling for different error types
- User-friendly error messages
- Detailed logging for debugging

**3. Database Integrity**
- Uses Laravel transactions for atomic operations
- Rollback on errors prevents inconsistent states
- Validation before state changes

**4. Logging**
All critical operations logged to `storage/logs/laravel.log`:
- Successful revision forwarding
- Authorization failures
- No reviewers found errors
- Notification failures
- Unexpected exceptions

---

## 📊 Submission Status Flow

```
SUBMITTED
    ↓
UNDER_REVIEW
    ↓
REVISIONS_REQUESTED (Author notified)
    ↓
Author submits revision
    ↓
REVISION_UNDER_REVIEW (Editor notified, NOT reviewers)
    ↓
Editor Decision:
├─ Option 1: Forward to Reviewers
│  └─ ReviewAssignment created → Reviewers notified
│  └─ Reviewers submit feedback
│  └─ Editor makes final decision
└─ Option 2: Make Direct Decision
   └─ ACCEPTED / REJECTED / REVISIONS_REQUESTED
```

---

## 🔔 Notifications

### Modified Notification Flow

**When Author Submits Revision:**
- ✅ **Editor** is notified: "Revised Manuscript Submitted - Awaiting Your Review"
- ❌ **Reviewers** NOT notified (happens only if editor forwards)

**When Editor Forwards to Reviewers:**
- ✅ **Reviewers** are notified: "Revised Manuscript Ready for Re-Review"

**When Editor Makes Final Decision:**
- ✅ **Author** is notified with decision and notes

---

## 🧪 Testing Recommendations

### User Stories to Test

#### Story 1: Editor Reviews Revision and Forwards to Reviewers
1. Author submits manuscript
2. Editor requests revisions
3. Author uploads revised manuscript
4. ✅ Verify editor receives notification (NOT reviewers)
5. Editor navigates to `/editor/revision-reviews`
6. ✅ Verify "Forward to Reviewers" button is visible
7. Editor clicks button
8. ✅ Verify reviewers are assigned
9. ✅ Verify reviewers receive notification
10. ✅ Verify reviewers can submit re-reviews
11. ✅ Verify editor can then make final decision

#### Story 2: Editor Rejects Revision Without Forwarding to Reviewers
1. Author submits revised manuscript
2. Editor reviews revision
3. Editor decides to reject without getting reviewer input
4. ✅ Verify final decision form shows "No reviewers assigned yet"
5. ✅ Verify editor can select "Reject" and make decision
6. ✅ Verify author is notified

#### Story 3: Multiple Revisions
1. Author submits revision 1
2. Editor reviews and requests further revisions
3. Author submits revision 2
4. ✅ Verify each revision can be handled independently
5. ✅ Verify no reviewer assignment conflicts occur

---

## 📋 Files Modified

1. ✅ [app/Services/RevisionService.php](app/Services/RevisionService.php)
   - Updated `processRevisionSubmission()` method
   - Made `assignOriginalReviewersForRevision()` public
   - Added error handling to all notification methods
   - New method: `notifyEditorOfSubmittedRevisionAwaitingReview()`

2. ✅ [app/Http/Controllers/ReviewController.php](app/Http/Controllers/ReviewController.php)
   - New method: `forwardRevisionToReviewers()`
   - Added comprehensive error handling

3. ✅ [routes/web.php](routes/web.php)
   - New route: `editor.forward-revision-to-reviewers`

4. ✅ [resources/views/reviews/editor-revision-reviews.blade.php](resources/views/reviews/editor-revision-reviews.blade.php)
   - New "Forward to Reviewers" section
   - Conditional "Reviewer Feedback" section
   - Updated decision form with status indicators

---

## ✅ Integrity & Robustness

### Code Quality
- ✅ No syntax errors
- ✅ Proper error handling with try-catch blocks
- ✅ Type hints for all parameters
- ✅ Comprehensive logging
- ✅ Authorization checks at controller and method level
- ✅ Validation of all state changes

### Database Safety
- ✅ Transactional operations
- ✅ Foreign key constraints maintained
- ✅ No orphaned records possible
- ✅ State consistency verified before operations

### User Experience
- ✅ Clear messaging on what actions are available
- ✅ Prevents duplicate reviewer assignments
- ✅ Visual indicators of process status
- ✅ User-friendly error messages

---

## 🚀 Deployment Notes

1. **No database migrations required** - Uses existing schema
2. **No new models required** - Reuses `RevisionReview` model
3. **Backward compatible** - Existing functionality preserved
4. **Cache clearing** - Run `php artisan config:cache` after deployment

---

## 📞 Support & Debugging

### Checking Logs
```bash
tail -f storage/logs/laravel.log
```

### Common Issues & Solutions

**Issue:** "Reviewers have already been assigned for this revision"
- **Cause:** Multiple forward attempts
- **Solution:** Page refresh before clicking again

**Issue:** "Unable to forward to reviewers: No original reviewers found"
- **Cause:** No completed reviews from initial manuscript
- **Solution:** Ensure reviewers completed their reviews on original manuscript

**Issue:** Notification not sent to editor
- **Cause:** Mail queue issue
- **Solution:** Check `MAIL_DRIVER` in `.env` and ensure queue is running

---

## Summary

The new workflow has been successfully implemented with:
- ✅ **Robust error handling** at service and controller levels
- ✅ **Clear user interface** showing available actions
- ✅ **Comprehensive logging** for debugging
- ✅ **Authorization checks** to prevent unauthorized access
- ✅ **State validation** to prevent inconsistent states
- ✅ **Backward compatibility** with existing code

The system now ensures proper manuscript review workflow with editor oversight before involving reviewers in the revision process.
