# REVISION PROCESS REFACTORING ANALYSIS

## 🔍 Issues Found

### 1. **Duplicate Initial Screening Methods**
- `ChiefEditorController::storeInitialScreening()` - at initial screening stage
- `ReviewController::storeInitialScreening()` - editor's initial screening
- Both can request revisions - conflicting workflows

### 2. **Multiple Revision Request Entry Points** (5+ locations)
- Chief Editor during screening: `ChiefEditorController::storeInitialScreening()`
- Chief Editor standalone: `ChiefEditorController::requestRevision()`
- Editor during review: `ReviewController::editorDecision()`
- Editor post screening: `ReviewController::requestRevision()`
- Reviewer during review: `ReviewController::reviewerRequestRevision()`
- **Problem**: Duplicate logic spread across 5+ methods

### 3. **Inconsistent Status Management**
- `revisions_requested` status used in multiple contexts
- `revision_under_review` status added but not integrated into dashboards
- Author dashboard missing revision upload status updates
- Editor dashboard doesn't show pending revision decisions

### 4. **Incomplete Dashboard Integration**
- Author Dashboard: ❌ Doesn't show `revision_under_review` status
- Editor Dashboard: ❌ Missing "Pending Revision Decisions" section
- Chief Editor Dashboard: ❌ No revision tracking section
- Reviewer Dashboard: ✅ Partially working but needs refinement

---

## 📊 Current Workflow Issues

### Path 1: Chief Editor Initial Screening
```
Chief Editor Review
→ Pass: Goes to editor
→ Fail: Rejected
→ Revision: Creates RevisionRequest (ISSUE: Duplicates editor revision flow)
       └─ Author uploads revision
       └─ Goes back to same Chief Editor (but no single flow for this)
```

### Path 2: Editor After Assignment
```
Editor Reviews
→ Accept: Done
→ Reject: Done
→ Revision: Can create RevisionRequest
       └─ Reviewers re-review
       └─ Editor makes final decision (NEW: revision_under_review)
```

### Problem: Both Chief Editor AND Editor can request revisions differently!

---

## 🎯 Solution: Unified Revision Process

### Consolidated Workflow
```
1️⃣ Chief Editor Initial Screening
   ├─ Pass → Assign to Editor
   ├─ Fail → Reject
   └─ Revision → Create RevisionRequest (Type: initial_screening)
       └─ Status: revisions_requested
       └─ Author uploads revision
       └─ Revert back to Chief Editor

2️⃣ Editor Reviews (after passing screening)
   ├─ Accept → Done
   ├─ Reject → Done
   └─ Request Revision → Create RevisionRequest (Type: review)
       └─ Status: revision_under_review
       └─ Auto-assign original reviewers
       └─ After re-review, editor makes final decision

3️⃣ Revision Re-Review Cycle
   └─ Can repeat if further revisions needed
```

---

## 🔧 Changes Required

### Controllers to Modify
1. **Remove**: `ReviewController::reviewerRequestRevision()` - Reviewers shouldn't directly request revisions
2. **Consolidate**: `storeInitialScreening()` - Make Chief Editor the only initial screening point
3. **Simplify**: `requestRevision()` - Single unified method for revision requests
4. **Update**: `editorDecision()` - Clarify when revisions are requested
5. **Fix**: Dashboard methods - Add revision status stats

### Models to Update
1. **RevisionRequest**: Add `revision_stage` field (initial_screening/review/post_review)
2. **Submission**: Status constants already exist, ensure they're used consistently

### Views to Update
1. **Author Dashboard**: Show revision_under_review status
2. **Editor Dashboard**: Add "Pending Revision Decisions" section
3. **Chief Editor Dashboard**: Add revision tracking
4. **Reviewer Dashboard**: Clarify what revision they're reviewing

### Database
1. Add `revision_stage` column to `revision_requests` table

---

## 📋 Status Flow Reference

```
submitted
    ↓
[Chief Editor Screening]
    ├─ passed → under_review
    ├─ failed → rejected
    └─ revision_requested → revisions_requested (stage: initial_screening)
            ↓
        [Author uploads revision]
            ↓
        revision_under_review (temporary status)
            ↓
        [Back to Chief Editor review]
            ├─ passed → under_review
            ├─ failed → rejected
            └─ revision_requested → revisions_requested (restart initial screening)

under_review
    ├─ minor_revision → revisions_requested (stage: review)
    ├─ major_revision → revisions_requested (stage: review)
    ├─ rejected → rejected
    └─ accepted → accepted

revisions_requested (during initial screening)
    → Author uploads → Chief Editor review

revisions_requested (during editor review)
    → Author uploads → revision_under_review → Reviewers re-review → Editor final decision

revision_under_review
    ├─ accepted → accepted
    ├─ rejected → rejected
    └─ further_revisions → revisions_requested (restart cycle)
```

---

## ✅ Implementation Checklist

- [ ] Add `revision_stage` column to `revision_requests` table
- [ ] Remove `ReviewController::reviewerRequestRevision()`
- [ ] Consolidate `storeInitialScreening()` to ChiefEditor only
- [ ] Unify revision request logic into single method
- [ ] Update Author Dashboard with revision status
- [ ] Update Editor Dashboard with revision stats
- [ ] Update Reviewer Dashboard with clear status
- [ ] Update Chief Editor Dashboard with revision tracking
- [ ] Fix all notifications for clarity
- [ ] Test complete workflow end-to-end

---

**Created**: February 24, 2026
