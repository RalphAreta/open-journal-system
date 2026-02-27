# Revised Manuscript Workflow - Quick Test Guide

## Prerequisites
- Laravel development environment running
- User accounts for: Author, Editor, 2+ Reviewers
- Initial manuscript with completed reviews

---

## Quick Test Workflow

### Step 1: Editor Requests Revisions
1. Login as **Editor**
2. Go to `/editor/submissions`
3. Select a submission with completed reviews
4. Click "Manage" button
5. Scroll to "Editor Decision" section
6. Select "More Revisions"
7. Choose revision type (Minor/Major)
8. Add reason for revisions
9. Click "Send Revision Request"
10. ✅ Author should receive notification

### Step 2: Author Submits Revised Manuscript
1. Login as **Author**
2. Go to `/submissions`
3. Click on the submission with "Revisions Requested" status
4. Navigate to "Revisions" tab
5. Upload revised manuscript file
6. Add revision notes
7. Click "Submit Revised Manuscript"
8. ✅ Submission status changes to "REVISION_UNDER_REVIEW"
9. ✅ Editor should receive notification for review

### Step 3: Editor Reviews & Decides on Forwarding
1. Login as **Editor**
2. Go to `/editor/revision-reviews`
3. Find the submission with "⏳ Awaiting Your Decision"
4. Review the submission details and author's revision notes
5. **You have two options:**

#### Option A: Forward to Reviewers
1. Click blue button "Forward to Original Reviewers"
2. ✅ System assigns original reviewers
3. ✅ Reviewers receive notification
4. ✅ "Reviewer Feedback" section now appears below

#### Option B: Make Direct Decision
1. Scroll to "Final Decision Form"
2. Note: Shows "No reviewers assigned yet"
3. Select decision: Accept / Reject / More Revisions
4. Add optional editor notes
5. Click submit
6. ✅ Author receives final decision

### Step 4: Reviewers Review Revision (if forwarded)
1. Each **Reviewer** receives notification
2. Login as **Reviewer**
3. Go to `/reviews`
4. Find the submission in "Pending Revision Reviews"
5. Click "Review Revision"
6. Fill in recommendation, comments, rating
7. Submit review
8. ✅ Editor sees feedback on `/editor/revision-reviews`

### Step 5: Editor Makes Final Decision (if reviewers involved)
1. Editor returns to `/editor/revision-reviews`
2. Reviews are now visible with all feedback
3. Scroll to "Final Decision Form"
4. Note: Shows "✓ All reviews received" (if all reviewed)
5. Select final decision
6. Add editor notes
7. Click submit
8. ✅ Author receives final decision

---

## Verification Checklist

### Notifications
- [ ] Author notified when editor requests revisions
- [ ] Editor notified when author submits revision (**NOT reviewers**)
- [ ] Reviewers notified only if editor forwards revision
- [ ] Author notified of final decision

### UI Elements
- [ ] Author sees "Revisions Requested" status
- [ ] Editor sees revision in `/editor/revision-reviews`
- [ ] "Forward to Reviewers" button visible (when no reviewers)
- [ ] "Reviewer Feedback" section hidden (when no reviewers)
- [ ] "Reviewer Feedback" section visible (when reviewers assigned)
- [ ] Decision form shows correct status indicators

### Status Changes
- [ ] Submission status: `submitted` → `under_review` → `revisions_requested`
- [ ] Submission status: → `revision_under_review` (after author uploads revision)
- [ ] Status remains `revision_under_review` until final decision
- [ ] Final status: `accepted` | `rejected` | `revisions_requested`

### Error Handling
- [ ] Can't forward if no original reviewers found (gets error message)
- [ ] Can't forward twice (gets error on second attempt)
- [ ] Can't access as unauthorized user (403 error)
- [ ] All errors logged to `storage/logs/laravel.log`

---

## Log Verification

Check that operations are being logged:

```bash
tail -f storage/logs/laravel.log | grep -i "revision\|forward"
```

Should see entries like:
- `Revised manuscript forwarded to reviewers`
- `Error forwarding revision to reviewers` (if any)
- `notifyEditorOfSubmittedRevisionAwaitingReview called`

---

## Database Verification

Verify database state changes:

```sql
-- Check revision request
SELECT id, submission_id, revision_stage, revised_at FROM revision_requests ORDER BY id DESC LIMIT 1;

-- Check revision reviews (should be empty until editor forwards)
SELECT id, revision_request_id, reviewer_id, status FROM revision_reviews WHERE revision_request_id = <id> ORDER BY id DESC;

-- Check submission status
SELECT id, status FROM submissions WHERE id = <submission_id>;
```

---

## Troubleshooting

### "Forward to Reviewers" button not appearing
- [ ] Check that `revision->revisionReviews` is empty
- [ ] Verify submission status is `revision_under_review`
- [ ] Check browser cache (Ctrl+Shift+Delete)

### Button appears but click does nothing
- [ ] Check browser console for JavaScript errors (F12)
- [ ] Verify `route('editor.forward-revision-to-reviewers')` is correct
- [ ] Check if `artisan route:list` shows the new route

### No reviewers get assigned
- [ ] Verify original manuscript had completed reviews
- [ ] Check database: `review_assignments` with `status='completed'`
- [ ] Check logs for "No original reviewers found"

### Editor not notified of revision
- [ ] Check `MAIL_DRIVER` in `.env` (should be configured)
- [ ] Run `php artisan queue:work` if using async queue
- [ ] Check `notifications` table for record

### Reviewers not notified when forwarded
- [ ] Verify notification method was called
- [ ] Check logs for notification errors
- [ ] Manually verify in `/reviews` dashboard

---

## Testing Tips

### Speed up Testing
1. Use same test user for multiple roles (adjust authorization checks temporarily)
2. Pre-create test data: SQL script to insert submissions and reviews
3. Disable email sending during testing (set `MAIL_DRIVER=log`)

### Inspect Email (if using log driver)
```bash
grep -i "revised manuscript ready for re-review" storage/logs/laravel.log
```

### Reset Testing State
```bash
# Clear all notifications
DELETE FROM notifications;

# Reset revision reviews
DELETE FROM revision_reviews;

# Reset revision requests
DELETE FROM revision_requests;

# Update submissions to previous status
UPDATE submissions SET status = 'under_review' WHERE status = 'revision_under_review';
```

---

## Success Criteria

All tests pass when:
1. ✅ Author submits revision
2. ✅ Only editor (not reviewers) gets notified
3. ✅ Editor sees "Forward to Reviewers" button
4. ✅ Editor can forward revision to reviewers
5. ✅ Reviewers get notified only after forwarding
6. ✅ Reviewers can submit re-reviews
7. ✅ Editor can make final decision with or without reviews
8. ✅ All status changes are logged
9. ✅ No unauthorized access possible
10. ✅ Graceful error handling for edge cases

---

## Contact & Support

For issues or questions:
1. Check `storage/logs/laravel.log` for error details
2. Review the comprehensive guide: `REVISION_WORKFLOW_CHANGES.md`
3. Verify all syntax: `php -l app/Services/RevisionService.php`
4. Clear cache: `php artisan config:cache`

---
