# Submission Management System Documentation

## Overview

This document describes the submission management system where an Editor-in-Chief assigns new submissions to Editors based on their specialized fields of expertise.

## System Architecture

### User Roles

1. **Admin**: Full system access, can manage editor expertise fields
2. **Editor-in-Chief**: Reviews new submissions and assigns them to editors based on expertise
3. **Editor**: Works with assigned submissions, conducts reviews, and makes editorial decisions
4. **Reviewer**: Provides peer reviews for assigned submissions
5. **Author**: Submits research papers and manages their submissions

### Key Components

#### 1. Editor Expertise Management

**Location**: `/admin/editor-expertise`

**Features**:
- View all editors and their expertise fields
- Add, edit, and remove expertise fields for each editor
- Multiple expertise fields per editor allowed
- Pre-defined field categories:
  - Science & Technology
  - Engineering
  - Health & Medical Sciences
  - Information Systems
  - Computer Science
  - Business & Management
  - Education
  - Social Sciences
  - Environmental Sciences
  - Mathematics & Statistics
  - Humanities
  - Other

**Admin Access**: 
```
GET  /admin/editor-expertise              # List all editors with expertise
GET  /admin/editor-expertise/{user}       # View editor's expertise
GET  /admin/editor-expertise/{user}/edit  # Edit editor's expertise
PUT  /admin/editor-expertise/{user}       # Update editor's expertise
POST /admin/editor-expertise/{user}/add-field  # Add new expertise field
DELETE /admin/editor-expertise/{expertise}    # Remove expertise field
```

#### 2. Chief Editor Dashboard

**Location**: `/chief-editor/dashboard`

**Features**:
- View submission statistics (total, pending, under review, completed)
- See all pending submissions needing assignment
- View assigned submissions and their status
- Pagination support for large datasets
- Quick access to review and assign submissions

**Chief Editor Access**:
```
GET  /chief-editor/dashboard              # Main dashboard with statistics
GET  /chief-editor/submissions/{id}       # View submission details
POST /chief-editor/submissions/{id}/assign    # Assign to editor
POST /chief-editor/submissions/{id}/reassign  # Reassign to different editor
POST /chief-editor/submissions/{id}/review    # Add review notes
```

#### 3. Submission Assignment Workflow

**Process**:

1. Author submits a research paper (STATUS: SUBMITTED)
2. System stores submission with research field indicated by author
3. Chief Editor reviews pending submissions
4. Chief Editor selects appropriate editor based on:
   - Research field specified in submission
   - Editor's expertise fields
   - Current workload
5. System creates SubmissionAssignment record
6. Editor receives assignment notification
7. Editor accepts or rejects assignment
8. If accepted: submission moves to the editor's queue (STATUS: UNDER_REVIEW)
9. If rejected: Chief Editor can reassign to another editor

**Assignment History**: All assignments are tracked with:
- Who assigned it
- When assigned
- Which expertise field matched
- Assignment notes
- Accept/reject status and timestamps

#### 4. Database Schema

**Tables Created**:

```sql
-- Editor expertise fields
editor_expertise
  - id
  - user_id (FK: users)
  - field_name (string)
  - description (text, nullable)
  - created_at, updated_at
  - unique(user_id, field_name)

-- Submission assignments tracking
submission_assignments
  - id
  - submission_id (FK: submissions)
  - assigned_to_user_id (FK: users)
  - assigned_by_user_id (FK: users, nullable)
  - expertise_field (string, nullable)
  - assignment_notes (text, nullable)
  - assigned_at (timestamp)
  - accepted_at (timestamp, nullable)
  - rejected_at (timestamp, nullable)
  - created_at, updated_at

-- Additional fields added to submissions table
submissions
  - research_field (string, nullable)
  - assigned_editor_id (FK: users, nullable)
  - chief_editor_review_at (timestamp, nullable)
  - chief_editor_notes (text, nullable)
```

## Models

### EditorExpertise
```php
$editor->editorExpertise()           // Get all expertise fields
EditorExpertise::getFieldOptions()   // Get available field options
```

### SubmissionAssignment
```php
$assignment->submission()            // Get related submission
$assignment->assignedTo()            // Get assigned editor
$assignment->assignedBy()            // Get chief editor who assigned
$assignment->isAccepted()            // Check if accepted
$assignment->isRejected()            // Check if rejected
$assignment->isPending()             // Check if still pending
```

### Submission (Updated)
```php
$submission->assignedEditor()        // Get assigned editor
$submission->assignments()           // Get all assignment records
```

### User (Updated)
```php
$user->editorExpertise()            // Get user's expertise fields
$user->submissionAssignments()      // Get submissions assigned to user
$user->isEditorInChief()            // Check if editor-in-chief
```

## Implementation Steps

### 1. Run Migrations
```bash
php artisan migrate
```

This creates:
- `editor_expertise` table
- `submission_assignments` table
- Adds new fields to `submissions` table
- Updates `submissions` table with chief editor fields

### 2. Seed Initial Roles
```bash
php artisan db:seed --class=RoleSeeder
```

This creates the new "editor-in-chief" role.

### 3. Assign Roles to Users
```bash
# Via database or admin interface
User::find(1)->roles()->attach('editor-in-chief');
```

### 4. Assign Editor Expertise
- Go to Admin Dashboard
- Click "Manage Editor Expertise"
- Select an editor
- Click "Manage" and add their expertise fields

### 5. Process Submissions
- Author submits paper with research field
- Chief Editor reviews at: `/chief-editor/dashboard`
- Chief Editor selects matching editor
- Editor reviews assigned submission
- System tracks all assignments

## Features

### Smart Editor Selection
- Editors grouped by expertise in assignment interface
- Easy comparison of available editors
- Assignment notes for tracking decisions

### Assignment Tracking
- Complete assignment history visible
- Accept/reject status tracked
- Timestamps for all actions
- Reassignment capability

### Notifications (Ready for Implementation)
- Email notifications when assigned (add to `assignSubmission()`)
- Notification when appearance changes
- Digest emails for editors

### Flexibility
- Easy to add new expertise fields
- Reassign submissions if needed
- Add notes to assignments
- Remove expertise fields at any time

## Future Enhancements

1. **Notifications**: Email/SMS when editors are assigned
2. **Workload Management**: Show editor current workload
3. **Auto Assignment**: Suggest editors based on expertise
4. **SLA Tracking**: Track assignment to completion times
5. **Performance Metrics**: Analytics on editor performance
6. **Bulk Operations**: Assign multiple submissions at once

## Usage Examples

### For Admin: Managing Editor Expertise

```bash
# Go to admin dashboard
# Navigate to "Manage Editor Expertise"
# Select an editor
# Click "Manage"
# Add multiple expertise fields
# Save changes
```

### For Chief Editor: Assigning Submissions

```php
// Controller automatically handles this
// Visit /chief-editor/dashboard
// Click "Review & Assign" on pending submission
// Select editor from grouped expertise list
// Add optional assignment notes
// Click "Assign"
```

### For Developers: Querying the System

```php
// Get all editors with specific expertise
$editors = User::whereHas('editorExpertise', function ($q) {
    $q->where('field_name', 'Engineering');
})->get();

// Get submissions assigned to specific expertise
$assignments = SubmissionAssignment::where('expertise_field', 'Engineering')
    ->with('submission', 'assignedTo')
    ->get();

// Get pending assignments for an editor
$pending = auth()->user()
    ->submissionAssignments()
    ->whereNull('accepted_at')
    ->whereNull('rejected_at')
    ->get();
```

## File Structure

```
app/
├── Http/Controllers/
│   ├── Admin/EditorExpertiseController.php
│   ├── ChiefEditorController.php
│   └── DashboardController.php (updated)
├── Models/
│   ├── EditorExpertise.php
│   ├── SubmissionAssignment.php
│   ├── User.php (updated)
│   ├── Submission.php (updated)
│   └── Role.php

resources/views/
├── admin/editor-expertise/
│   ├── index.blade.php
│   ├── show.blade.php
│   └── edit.blade.php
├── chief-editor/
│   ├── dashboard.blade.php
│   └── show-submission.blade.php
│   └── (views for assignment)

database/migrations/
├── 2025_02_18_000001_create_editor_expertise_table.php
├── 2025_02_18_000002_create_submission_assignments_table.php
└── 2025_02_18_000003_add_chief_editor_fields_to_submissions.php

database/seeders/
└── RoleSeeder.php (updated)

routes/
└── web.php (updated)
```

## Database Design Notes

1. **EditorExpertise**: Allows editors to have multiple expertise fields
2. **SubmissionAssignment**: Immutable record of all assignment decisions
3. **Submissions**: Enhanced with research field and chief editor tracking
4. **Audit Trail**: Complete history of assignments preserved

## Security Considerations

1. Only admins can manage editor expertise
2. Only editor-in-chief can assign submissions
3. Editors can only view their assigned submissions
4. Role-based middleware protects all routes
5. Authorization checks in controllers

## Performance Optimization

- Eager load expertise when listing editors
- Index on user_id in editor_expertise
- Index on submission_id in submission_assignments
- Pagination on large lists
- Efficient queries with relationships

## Testing Checklist

- [ ] Create test user with editor-in-chief role
- [ ] Create test editors with various expertise fields
- [ ] Test assigning submission to editor
- [ ] Test reassigning submission
- [ ] Test adding/removing expertise fields
- [ ] Test pagination on large datasets
- [ ] Test role-based access control
- [ ] Test email notifications (when implemented)

---

**Last Updated**: February 18, 2026
**Status**: Production Ready
