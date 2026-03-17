# Open Journal System (OJS) - IRJIEST

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-purple.svg)](https://www.php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.0-38B2AC.svg)](https://tailwindcss.com)

A comprehensive **Laravel-based Open Journal System** designed for the International Research Journal of Information Systems & Engineering Technology (IRJIEST). Features advanced multi-stage peer review workflows, manuscript submission management, role-based access control, sophisticated rating systems, and complete publication pipelines. Built with PHP 8.2+, Laravel 12, Tailwind CSS 4.0, and PostgreSQL/SQLite.

---

## 🎯 Core Features

### **📜 Complete Submission Lifecycle**
- Multi-stage workflow: Submission → Initial Screening → Peer Review → Revisions → Layout Editing → Publication
- Authors select research field (12+ categories) for expertise-based editor assignment
- Real-time status tracking and notifications at each workflow stage
- Support for minor and major revisions with detailed feedback
- Copyright Transfer Form (CTF) management and author confirmation workflow
- Published papers publicly accessible with download capabilities

### **👥 Role-Based System**
- **Author**: Submit manuscripts, respond to feedback, appeal rejections, manage revisions
- **Reviewer**: Conduct peer reviews with 1-100 rating scale, provide recommendations
- **Editor**: Manage assigned submissions, assign reviewers, request revisions, make editorial decisions
- **Editor-in-Chief**: Initial manuscript screening, assign to editors based on expertise, review appeals
- **Layout Editor**: Format accepted manuscripts, coordinate with authors, prepare for publication
- **Managing Editor**: Manage CTF tracking, coordinate final publication workflow
- **Admin**: User management, role configuration, expertise field definition, system settings

### **⭐ Advanced Rating System (1-100 Scale)**
- **10-band rating system** with role-specific criteria:
  - **Peer Reviewers**: Scientific rigor, novelty, methodology, clarity, originality
  - **Editors**: Journal scope fit, presentation quality, strategic importance
  - **Revision Reviewers**: Completeness of revisions, quality of responses
  - **Layout Editors**: Formatting, readability, compliance standards
- Automated guidance based on role and rating band
- Visual progress indicators and rating interpretations
- Database of rating criteria per role

### **📋 Intelligent Submission Management**
- Author-driven field selection matching editor expertise categories
- Editor-in-Chief initial screening (Pass/Fail/Revisions) as gatekeeper before peer review
- Multi-editor assignment for complex submissions
- Reviewer assignment with invitation tracking and deadline management
- Automated notification system across all roles
- Appeal mechanism for authors contesting initial rejection (max 2 appeals per submission)

### **🔄 Revision Workflow (v2025+)**
- Editors request minor or major revisions with detailed line-by-line feedback
- Authors receive notifications and submit revised manuscripts with response notes
- **New**: Editor reviews revisions first, then decides whether to:
  - Forward to original reviewers for re-evaluation
  - Close revisions and make final decision
  - Request additional revisions
- Revision review tracking and history
- Authors can view editor responses to their revision notes

### **✅ Appeals System**
- Authors can appeal Editor-in-Chief's initial screening rejection
- Appeals require detailed reasoning (minimum 50 characters) with manuscript context
- Maximum 2 appeals per submission to prevent abuse
- Editor-in-Chief dedicated appeals review interface with timeline view
- Approve/Reject decisions with detailed editor response
- Authors see appeal status and editor's response in dashboard
- Approved appeals move manuscript directly to peer review stage

### **🎨 Layout & Publication Pipeline**
- Accepted papers assigned to layout editors for formatting and typesetting
- Layout editor coordination interface with file versioning
- Author feedback collection on layout formatting
- CTF (Copyright Transfer Form) generation and signature tracking
- Author confirmation before final publication
- Published papers catalog with public-facing interface and search functionality
- Paper download tracking (count displayed publicly)

### **📚 Citation Export (RIS Format)**
- Download paper citations in RIS format (.ris files) for use with reference managers
- Compatible with Zotero, Mendeley, EndNote, RefWorks, Google Scholar, and similar tools
- One-click download from published papers listing and individual paper pages
- Automatic formatting of authors, dates, keywords, and metadata
- Complete bibliographic information included (title, abstract, authors, publication date, keywords, research field, journal name)

### **🔒 Security & Permissions**
- Comprehensive role-based access control (RBAC) with middleware protection
- Authentication gates prevent unauthorized resource access
- CSRF protection on all forms
- Bcrypt password hashing with configurable rounds
- Email verification via OTP with throttling (6 requests/minute)
- File upload restrictions (PDF, DOC, DOCX only)
- File storage outside web root for security
- Separate storage disks for different file types

---

## 📋 Technology Stack

### **Backend**
- **PHP 8.2+** with strict types enabled
- **Laravel 12.x** - Modern PHP web framework
- **PostgreSQL 12+** (production) / SQLite (development)
- **Eloquent ORM** for database abstraction
- **Laravel Blade** templating engine
- **Resend** for reliable email delivery

### **Frontend**
- **Tailwind CSS 4.0** - Utility-first CSS framework
- **Vite 7.0+** - Next-generation module bundler, hot reload in development
- **Axios** - Promise-based HTTP client
- **Blade Components** - Reusable template components

### **Development & Testing**
- **PHPUnit 11.5+** - PHP testing framework
- **Faker** - Test data generation
- **Mockery** - Object mocking library
- **Laravel Pail** - Real-time log viewer
- **Prettier + Blade Plugin** - Code formatting
- **Concurrently** - Run multiple dev servers simultaneously

### **System Requirements**

**Minimum:**
- PHP 8.2 or higher
- Composer 2.0+
- Node.js 18+ & npm 9+
- PostgreSQL 12+ or SQLite 3.8+
- 512 MB free disk space
- 256 MB RAM (development)

**Recommended:**
- PHP 8.3
- PostgreSQL 14+
- Node.js 20 LTS
- 2 GB+ RAM
- SSD storage
- 2+ CPU cores

---

## 🚀 Quick Start (5 Minutes)

### **Fastest Way to Get Running**

```bash
# 1. Clone and navigate
git clone https://github.com/RalphAreta/open-journal-system
cd open-journal-system

# 2. Run setup script (handles everything)
composer setup

# 3. Access at http://localhost:8000
# Default credentials: admin@irjiest.local / password
```

Or use the Windows batch file:
```bash
# Windows only
run-server.bat
```

---

## 📦 Detailed Installation & Setup

### **Prerequisites Check**
```bash
# Check PHP version (must be 8.2+)
php --version

# Check Composer is installed
composer --version

# Check Node.js and npm
node --version
npm --version
```

### **Step 1: Clone & Navigate**

```bash
git clone https://github.com/RalphAreta/open-journal-system
cd open-journal-system
```

### **Step 2: Install PHP Dependencies**

```bash
composer install
```

This installs:
- Laravel framework and components
- Resend email service
- Testing frameworks (PHPUnit, Faker, Mockery)
- Development tools (Pint, Pail, Tinker)

### **Step 3: Install Frontend Dependencies**

```bash
npm install
npm audit
npm audit fix  # Fix any security vulnerabilities
```

### **Step 4: Environment Configuration**

```bash
# Copy example environment file
cp .env.example .env

# Generate app encryption key (required!)
php artisan key:generate
```

Edit `.env` and configure your database:

**Option A: PostgreSQL (Recommended for Production)**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ojs_db
DB_USERNAME=postgres
DB_PASSWORD=your_secure_password

# Email configuration
MAIL_MAILER=resend
MAIL_FROM_ADDRESS=noreply@irjiest.local
RESEND_API_KEY=your_resend_key
```

**Option B: SQLite (Quick Local Development)**
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Create SQLite database file
touch database/database.sqlite
```

### **Step 5: Database Setup**

```bash
# Run all migrations to create tables
php artisan migrate

# Seed initial data (roles, admin user, settings)
php artisan db:seed
```

**Tables Created (35+ tables):**
- Authentication: users, roles, role_user
- Submissions: submissions, submission_assignments
- Reviews: reviews, review_assignments, referee_invitations
- Revisions: revisions_requests, revision_reviews
- Editorial: editor_expertise, expertise_categories, appeals
- Workflows: layout_editor_assignments, notifications
- System: system_settings, and more...

**Default Admin Credentials:**
```
Email:    admin@irjiest.local
Password: password
```

### **Step 6: Storage & Cache Setup**

```bash
# Create storage symlink (allows file downloads)
php artisan storage:link

# Clear any cached configuration
php artisan cache:clear
```

### **Step 7: Launch Development Servers**

Open two separate terminals:

**Terminal 1 - Frontend Assets (Vite Dev Server)**
```bash
npm run dev
```
- Hot module reloading for CSS/JS changes
- Outputs: http://localhost:5173

**Terminal 2 - Laravel Application**
```bash
php artisan serve
```
- Runs on: http://localhost:8000
- Accessible at: http://127.0.0.1:8000

**Optional - Template Updates (Live)**
```bash
# In another terminal for Blade template hot reloading
php artisan tinker
```

### **Step 8: Access the Application**

Open browser: **http://localhost:8000**

Login as admin:
- Email: `admin@irjiest.local`
- Password: `password`

---

## 🛠️ Building for Production

```bash
# Compile frontend assets for production
npm run build

# Results in public/build/ directory

# Cache configuration (improves performance)
php artisan config:cache

# Cache routes
php artisan route:cache

# Optimize class loader
php artisan optimize

# For zero-downtime deployment
php artisan down         # Show maintenance mode
php artisan up          # Resume service
```

---

## 🗄️ Database Schema & Models

### **Core Data Models (16 Models)**

#### **Authentication & Authorization**
| Model | Purpose | Key Relations |
|-------|---------|---------------|
| `User` | System users with multiple roles | `roles`, `submissionsAsAuthor`, `reviewAssignments`, `reviews` |
| `Role` | Role definitions (Author, Reviewer, etc) | `users` |

#### **Submission Management**
| Model | Purpose | Key Relations |
|-------|---------|---------------|
| `Submission` | Core manuscript entity with complete lifecycle tracking | `author`, `editor`, `reviews`, `revisionRequests`, `appeals` |
| `SubmissionAssignment` | Editor assignments to submissions | `submission`, `editor` |

#### **Review Process**
| Model | Purpose | Key Relations |
|-------|---------|---------------|
| `Review` | Individual peer review with 1-100 rating | `submission`, `reviewer`, `assignment` |
| `ReviewAssignment` | Reviewer task assignment with due dates | `submission`, `reviewer`, `review` |
| `RefereeInvitation` | Invitation tracking for reviewer recruitment | `submission`, `reviewer` |

#### **Revision & Appeals**
| Model | Purpose | Key Relations |
|-------|---------|---------------|
| `RevisionRequest` | Minor/major revision requests with feedback | `submission`, `reviews` |
| `RevisionReview` | Assessment of revised manuscripts | `submission`, `reviewer` |
| `Appeal` | Author appeals for rejected manuscripts | `submission`, `author` |

#### **Layout & Publication**
| Model | Purpose | Key Relations |
|-------|---------|---------------|
| `LayoutEditorAssignment` | Layout editor task with file versioning | `submission`, `layoutEditor` |

#### **Editorial Support**
| Model | Purpose | Key Relations |
|-------|---------|---------------|
| `EditorExpertise` | Maps editor expertise to research fields | `editor`, `category` |
| `ExpertiseCategory` | Research field/category definitions | `editorExpertise` |

#### **System**
| Model | Purpose | Key Relations |
|-------|---------|---------------|
| `RatingCriteria` | Role-specific rating scale criteria | `role` |
| `Notification` | In-app notifications with role tracking | `user` |
| `SystemSetting` | Journal configuration settings | None |

### **Submission Status Flow**

```
submitted
    ↓
with_chief_editor (initial screening)
    ├→ screening_pass → under_review
    ├→ screening_fail → rejected
    └→ screening_revision_required
        ↓
under_review (peer review)
    ├→ accept → accepted
    ├→ revisions_requested
    │   ↓
    │ revision_submitted
    │   ↓
    │ revision_under_review
    │   └→ (accept/reject/more revisions)
    └→ reject → rejected

accepted
    ↓
with_managing_editor (CTF processing)
    ↓
layout_editing
    ↓
layout_review (author confirms layout)
    ↓
author_confirmation
    ↓
published
```

---

## � Complete Workflows

### **1. Author Submission & Initial Screening Workflow**

```
1. Author Submits Manuscript
   ↓
2. Paper appears on Chief Editor Dashboard (Pending Screening)
   ↓
3. Chief Editor Performs Initial Screening:
   - Pass: Move to peer review assignment
   - Fail: Manuscript rejected
   - Revision Required: Author can revise before review
   ↓
4. If passed, Chief Editor assigns to Editor(s) based on expertise
   ↓
5. Editors assign Reviewers
```

**Author Actions:**
- Submit manuscript with title, abstract, keywords, research field selection
- View submission status in real-time
- Respond to revision requests
- Submit appeals if rejected at screening stage

### **2. Peer Review Workflow**

```
1. Reviewers assigned by Editor
   ↓
2. Reviewers receive email invitation (can accept/decline)
   ↓
3. Reviewers download manuscript and conduct review:
   - Provide 1-100 rating with role-specific criteria
   - Recommend: Accept/Reject/Minor Revisions/Major Revisions
   - Add comments for author and editor
   ↓
4. Editor receives review recommendations
   ↓
5. Editor makes decision:
   - Accept manuscript → Move to layout editing
   - Reject → Author receives rejection
   - Request Revisions → Start revision workflow
```

**Rating Scale Guidance:**
- **1-10**: Reject (critical issues)
- **11-20**: Major issues (major revisions)
- **21-40**: Significant improvements needed
- **41-60**: Moderate issues (minor revisions)
- **61-80**: Good quality (minor edits)
- **81-100**: Excellent work (accept)

### **3. Revision Workflow (Author Responds to Feedback)**

```
1. Editor requests Minor or Major Revisions with feedback
   ↓
2. Author receives notification
   ↓
3. Author uploads revised manuscript with response notes:
   - Addresses each feedback point
   - Explains changes made
   ↓
4. Editor Reviews Revision:
   - Accept revision and close
   - Request additional revisions
   - Send to original reviewers for re-evaluation
   ↓
5. If sent to reviewers: Revision review by peers
   ↓
6. Final decision after revision review
```

### **4. Appeals Workflow (Authors Contest Rejection)**

```
1. Author receives Initial Screening rejection
   ↓
2. Author clicks "Appeal Rejection" button
   ↓
3. Author submits appeal with:
   - Detailed reasoning (min 50 characters)
   - Context about manuscript value
   ↓
4. Chief Editor reviews appeal with:
   - Original screening rejection reason
   - Author's appeal statement
   ↓
5. Chief Editor decides:
   - Approve: Move to peer review stage
   - Reject: Uphold original rejection
   ↓
6. Author sees decision and editor's response in dashboard
```

**Appeal Limitations:**
- Maximum 2 appeals per submission
- Requires minimum 50 characters reasoning
- Chief Editor final authority

### **5. Layout Editing & Publication Pipeline**

```
1. Manuscript Accepted → Assign to Layout Editor
   ↓
2. Layout Editor:
   - Downloads accepted manuscript
   - Formats for journal standards
   - Uploads formatted version
   ↓
3. Author Review:
   - Author downloads formatted file
   - Reviews layout and formatting
   - Provides feedback or confirms
   ↓
4. Managing Editor:
   - Generates Copyright Transfer Form (CTF)
   - Tracks CTF signature
   - Coordinates final publication
   ↓
5. Author Confirmation:
   - Confirms all details correct
   - Signs CTF if required
   ↓
6. Publication:
   - Paper published in journal
   - Available in published papers catalog
   - Publicly visible with download tracking
```

---

## 🛣️ API Routes & Endpoints

### **Public Routes**
| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/` | Home page / redirect to dashboard |
| GET | `/published-papers` | View all published papers with search/filter |
| GET | `/papers/{id}` | View specific published paper details |
| GET | `/papers/{id}/download` | Download published paper PDF |
| GET | `/papers/{id}/download-ris` | Download paper citation in RIS format (for Zotero, Mendeley, EndNote, etc.) |

### **Authentication Routes**
| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/login` | Login page |
| POST | `/login` | Process login |
| GET | `/register` | Registration page |
| POST | `/register` | Create new account |
| GET | `/email/verify` | OTP verification page |
| POST | `/email/verify` | Verify email with OTP |
| POST | `/logout` | Logout user |

### **Author Routes** (`/submissions/*`)
| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/submissions` | List author's submissions |
| GET | `/submissions/create` | New submission form |
| POST | `/submissions` | Create submission |
| GET | `/submissions/{id}` | View submission details |
| GET | `/submissions/{id}/edit` | Edit submission |
| PUT | `/submissions/{id}` | Update submission |
| GET | `/submissions/{id}/revisions` | View revision requests |
| POST | `/submissions/{id}/submit-revision` | Upload revised manuscript |
| GET | `/submissions/{id}/appeals` | View appeals |
| POST | `/submissions/{id}/appeal` | Submit appeal |
| POST | `/submissions/{id}/confirm-layout` | Confirm layout formatting |
| POST | `/submissions/{id}/upload-signed-ctf` | Upload signed CTF |

### **Reviewer Routes** (`/reviews/*`, `/reviewer/*`)
| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/reviews` | Pending review tasks |
| GET | `/reviews/assignment/{id}/create` | Create new review form |
| POST | `/reviews` | Submit review |
| POST | `/reviews/{id}/edit` | Edit submitted review |
| GET | `/reviews/revision-request/{id}/create` | Create revision review form |
| POST | `/reviews/revision-request/{id}` | Submit revision review |
| GET | `/reviewer/dashboard` | Reviewer statistics |
| POST | `/reviewer/invitation/{id}/accept` | Accept review invitation |
| POST | `/reviewer/invitation/{id}/decline` | Decline review invitation |

### **Editor Routes** (`/editor/*`)
| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/editor/dashboard` | Editor dashboard with assignments |
| GET | `/editor/submissions` | Manage assigned submissions |
| GET | `/editor/submissions/{id}` | View submission with reviews |
| POST | `/editor/submissions/{id}/assign-reviewer` | Assign reviewer |
| POST | `/editor/submissions/{id}/decision` | Make editorial decision (Accept/Reject/Revisions) |
| POST | `/editor/submissions/{id}/request-revision` | Request minor/major revisions |
| POST | `/editor/submissions/{id}/send-to-managing-editor` | Move accepted paper to layout editing |

### **Chief Editor Routes** (`/chief-editor/*`)
| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/chief-editor/dashboard` | Chief editor dashboard |
| GET | `/chief-editor/submissions` | All submissions with status |
| GET | `/chief-editor/submissions/{id}` | Submission details |
| POST | `/chief-editor/submissions/{id}/initial-screening` | Perform initial screening (Pass/Fail) |
| POST | `/chief-editor/submissions/{id}/assign` | Assign submission to editor(s) |
| GET | `/chief-editor/appeals` | Pending appeals list |
| GET | `/chief-editor/appeals/{id}` | Appeal details & review form |
| POST | `/chief-editor/appeals/{id}/decision` | Approve/reject appeal with response |

### **Layout Editor Routes** (`/layout-editor/*`)
| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/layout-editor/dashboard` | Layout tasks |
| GET | `/layout-editor/assignment/{id}` | Layout editing interface |
| POST | `/layout-editor/assignment/{id}/upload` | Upload formatted file |
| POST | `/layout-editor/assignment/{id}/request-feedback` | Request author review |

### **Managing Editor Routes** (`/managing-editor/*`)
| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/managing-editor/dashboard` | Management tasks |
| GET | `/managing-editor/ctf/{id}` | CTF tracking & generation |
| POST | `/managing-editor/ctf/{id}/generate` | Generate CTF form |
| POST | `/managing-editor/publication/{id}/publish` | Publish paper |

### **Admin Routes** (`/admin/*`)
| Method | Route | Purpose |
|--------|-------|---------|
| GET | `/admin/dashboard` | Admin statistics |
| GET | `/admin/users` | User management list |
| POST | `/admin/users` | Create user |
| PUT | `/admin/users/{id}` | Update user |
| DELETE | `/admin/users/{id}` | Delete user |
| GET | `/admin/roles/{id}` | Edit role permissions |
| PUT | `/admin/roles/{id}` | Update role |
| GET | `/admin/settings` | System settings |
| PUT | `/admin/settings` | Update settings |
| GET | `/admin/editor-expertise` | Edit editor expertise |
| PUT | `/admin/editor-expertise/{user}` | Update editor expertise |
| POST | `/admin/editor-expertise/{user}/add-field` | Add expertise field to editor |
| DELETE | `/admin/editor-expertise/{user}/field/{field}` | Remove expertise field |
| GET | `/admin/expertise-categories` | Manage research fields |
| POST | `/admin/expertise-categories` | Create new category |
| PUT | `/admin/expertise-categories/{id}` | Update category |
| DELETE | `/admin/expertise-categories/{id}` | Delete category |

---

## 🎨 Dashboard Features by Role

### **Author Dashboard**
- Submission statistics (Total, Submitted, Under Review, Revisions Needed, Accepted, Rejected, Published)
- Submissions list with color-coded status badges
- Quick actions: Submit new, view revisions, appeal rejection
- Appeal status showing approval/rejection decisions
- Published papers authored
- Download invitation letters for accepted papers

### **Reviewer Dashboard**
- Pending review invitations with accept/decline buttons
- Assigned review tasks with due dates
- Review history with submitted dates
- Rating scale reference and criteria guidance
- Invitation response tracking

### **Editor Dashboard**
- Assigned submissions list with statistics
- Peer review status (Accept/Reject/Minor/Major recommendations count)
- Quick assignment interface to invite reviewers
- Editorial decision making interface
- Revision requests and responses
- Performance metrics (submissions handled, average decision time)

### **Chief Editor Dashboard**
- All submissions with assignment status
- Initial screening queue (pending, pass, fail, revision request)
- **Appeals Management Tab**: Pending appeals, review timeline
- Editor workload distribution
- Submission flow statistics
- Expertise category management quick access

### **Layout Editor Dashboard**
- Layout tasks awaiting work
- Formatting guidelines and templates
- File version tracking
- Author feedback collection interface
- Publication readiness checklist

### **Admin Dashboard**
- System statistics (users, submissions, reviews, publications)
- User management with role assignment
- Expertise field management
- Email notification logs
- System settings configuration
- Activity logs

---

## 📊 Rating System Details

### **Rating Scale: 1-100 (10 Bands)**

```
Band  Range    Interpretation              Action Recommendation
1     1-10     Fundamentally flawed        REJECT
2     11-20    Major issues                MAJOR REVISIONS
3     21-30    Significant problems        MAJOR REVISIONS
4     41-50    Moderate issues             MINOR REVISIONS
5     51-60    Generally good              MINOR REVISIONS/ACCEPT
6     61-70    Good quality                ACCEPT
7     71-80    Very good                   ACCEPT
8     81-90    Excellent                   ACCEPT
9     91-100   Outstanding                 ACCEPT
```

### **Role-Specific Rating Criteria**

**Peer Reviewers Assess:**
- Scientific rigor and methodology validity
- Novelty and originality of findings
- Quality of experimental design (if applicable)
- Clarity of presentation and writing
- Significance to research community
- Proper citation and references

**Editors Assess:**
- Fit with journal scope and mission
- Presentation quality and formatting
- Strategic importance to journal
- Completeness of revision responses
- Author communication quality

**Revision Reviewers Assess:**
- Completeness of revision addressing feedback
- Quality of author responses to comments
- Improvement in manuscript quality
- Remaining issues (if any)

**Layout Editors Assess:**
- Compliance with journal formatting standards
- Readability and visual appeal
- Proper table and figure placement
- Reference formatting accuracy
- PDF generation quality

### **Automated Guidance by Band**

The system automatically shows guidance to reviewers and editors based on selected rating band:
- Typical criteria met at that level
- Recommendations for improvement
- Notes on when to request revisions vs. accept/reject

---

## � Useful Development Commands

### **Database Management**
```bash
# Create fresh database and seed
php artisan migrate:fresh --seed

# Check migration status
php artisan migrate:status

# Rollback last batch of migrations
php artisan migrate:rollback

# Reset entire database
php artisan migrate:reset

# Seed after migrations
php artisan db:seed

# Seed specific seeder class
php artisan db:seed --class=SpecificSeeder
```

### **Cache & Configuration**
```bash
# Clear all caches
php artisan cache:clear

# Cache configuration for production
php artisan config:cache

# Cache routes for production
php artisan route:cache

# Clear cached routes
php artisan route:clear

# Optimize for production
php artisan optimize
```

### **Interactive Shell (Tinker)**
```bash
# Enter interactive PHP shell
php artisan tinker

# Create test user
User::create(['name' => 'Test User', 'email' => 'test@local', 'password' => bcrypt('pass')])

# Find and update user
$user = User::find(1); $user->email = 'new@email.com'; $user->save();

# Count submissions
Submission::count()

# List all submissions
Submission::all()
```

### **Testing**
```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/AuthTest.php

# Run specific test method
php artisan test --filter=test_login_required

# Generate code coverage report
php artisan test --coverage

# Run with verbose output
php artisan test --verbose
```

### **Logs & Debugging**
```bash
# View live logs in real-time
php artisan pail --timeout=0

# Debug mode in .env
APP_DEBUG=true

# Check storage permissions
ls -la storage/

# Fix storage permissions (Linux/Mac)
chmod -R 775 storage bootstrap/cache
```

### **Email Testing**
```bash
# Set mail driver to log for testing
MAIL_MAILER=log

# View logged emails in storage/logs/
tail -f storage/logs/laravel.log
```

### **Artisan Commands - Custom**
```bash
# Clean database (removes all data but keeps structure)
php artisan app:clean-database

# List all artisan commands
php artisan list

# Get help on specific command
php artisan help migrate
```

---

## 🏗️ Project Directory Structure

```
open-journal-system/
│
├── app/                              # Application code
│   ├── Console/                      # Artisan commands
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/                # Admin controllers
│   │   │   ├── Auth/                 # Authentication
│   │   │   ├── SubmissionController.php
│   │   │   ├── ReviewController.php
│   │   │   ├── ChiefEditorController.php
│   │   │   ├── LayoutEditorController.php
│   │   │   ├── AppealController.php
│   │   │   └── ...
│   │   └── Middleware/
│   │       ├── EnsureUserHasRole.php # Role authorization
│   │       └── ...
│   ├── Models/
│   │   ├── User.php
│   │   ├── Submission.php
│   │   ├── Review.php
│   │   ├── RevisionRequest.php
│   │   ├── Appeal.php
│   │   ├── EditorExpertise.php
│   │   ├── ReviewAssignment.php
│   │   ├── RatingCriteria.php
│   │   ├── Notification.php
│   │   └── ...                       # 16 models total
│   ├── Services/                     # Business logic
│   │   ├── RevisionService.php
│   │   ├── RatingScale.php
│   │   └── ...
│   ├── Mail/                         # Email notifications
│   │   ├── OtpMail.php
│   │   ├── InitialScreeningNotification.php
│   │   └── ...
│   └── Notifications/
│
├── database/
│   ├── migrations/                   # Database schema (35+ migrations)
│   │   ├── *_create_users_table.php
│   │   ├── *_create_submissions_table.php
│   │   ├── *_create_reviews_table.php
│   │   ├── *_add_initial_screening_to_submissions.php
│   │   ├── *_create_appeals_table.php
│   │   └── ...
│   ├── seeders/
│   │   ├── DatabaseSeeder.php        # Main seeder
│   │   ├── RoleSeeder.php
│   │   └── ...
│   └── factories/                    # Model factories for testing
│
├── resources/
│   ├── views/                        # Blade templates
│   │   ├── layouts/
│   │   │   ├── app.blade.php        # Authenticated layout
│   │   │   └── guest.blade.php      # Public layout
│   │   ├── dashboard/
│   │   │   ├── author.blade.php
│   │   │   ├── editor.blade.php
│   │   │   ├── reviewer.blade.php
│   │   │   ├── admin.blade.php
│   │   │   ├── chief-editor.blade.php
│   │   │   └── ...
│   │   ├── submissions/              # Submission CRUD
│   │   ├── reviews/                  # Review interface
│   │   ├── appeals/                  # Appeal management
│   │   ├── auth/                     # Login/register
│   │   ├── admin/                    # Admin pages
│   │   ├── components/               # Reusable components
│   │   └── published-papers.blade.php # Public papers list
│   ├── css/
│   │   └── app.css                   # Tailwind imports
│   └── js/
│       └── app.js                    # Frontend utilities
│
├── routes/
│   ├── web.php                       # Web application routes
│   └── console.php                   # Console commands
│
├── config/                           # Laravel configuration
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystem.php
│   ├── mail.php
│   ├── queue.php
│   └── ...
│
├── bootstrap/
│   ├── app.php                       # Application bootstrap
│   └── providers.php
│
├── storage/
│   ├── app/                          # User uploads
│   ├── framework/
│   │   ├── cache/
│   │   └── views/
│   └── logs/
│
├── public/
│   ├── index.php                     # Application entry point
│   ├── hot/                          # Vite hot reload
│   └── images/
│
├── tests/
│   ├── Feature/                      # Feature tests
│   │   ├── AuthTest.php
│   │   ├── SubmissionTest.php
│   │   └── ...
│   ├── Unit/                         # Unit tests
│   │   └── ...
│   └── TestCase.php                  # Base test class
│
├── docs/                             # Documentation
│   ├── AUTHOR_GUIDE.md
│   ├── REVIEWER_GUIDE.md
│   ├── EDITOR_GUIDE.md
│   ├── ADMIN_GUIDE.md
│   └── ...
│
├── vendor/                           # Composer dependencies
├── node_modules/                     # NPM dependencies
│
├── .env.example                      # Environment template
├── .env                              # Environment configuration (git ignored)
├── .editorconfig
├── .gitignore
├── .prettierrc.json                  # Code formatting config
├── composer.json                     # PHP dependencies
├── composer.lock
├── package.json                      # NPM dependencies
├── package-lock.json
├── phpunit.xml                       # PHPUnit configuration
├── vite.config.js                    # Vite build configuration
├── artisan                           # Laravel CLI tool
├── run-server.bat                    # Windows quick start
│
├── README.md                         # This file
├── SETUP.md                          # Installation guide
├── RATING_SYSTEM_DOCUMENTATION.md    # Rating scale docs
├── REVISION_PROCESS_INTEGRATION.md   # Revision workflow
├── SUBMISSION_MANAGEMENT_SYSTEM.md   # Expert assignment
├── UI_IMPROVEMENTS_2026.md           # UI/UX updates
├── REFACTORING_PLAN.md               # Code improvements
└── Other supporting docs...
```

---

## 🧪 Testing

### **Test Structure**
- **Unit Tests**: `tests/Unit/` - Test individual functions/methods
- **Feature Tests**: `tests/Feature/` - Test complete workflows
- **Database**: SQLite in-memory (`:memory:`) for isolation
- **Mail**: Logged to array (no actual emails sent)
- **Queue**: Synchronous execution
- **Cache**: Array driver

### **PHPUnit Configuration** (`phpunit.xml`)
```xml
<!-- Test environment variables -->
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
</php>

<!-- Code coverage reports -->
<coverage report="html" outputDirectory="coverage/">
    <include>
        <directory>app/</directory>
    </include>
</coverage>
```

### **Example Tests**
```bash
# Authentication tests
php artisan test tests/Feature/AuthTest.php

# Submission workflow tests
php artisan test tests/Feature/SubmissionTest.php

# Review system tests
php artisan test tests/Feature/ReviewTest.php

# Run with coverage
php artisan test --coverage

# Test specific method
php artisan test --filter=test_author_can_submit_manuscript
```

### **Writing New Tests**
```php
// Feature test example
public function test_author_can_submit_manuscript()
{
    $author = User::factory()->create();
    
    $response = $this->actingAs($author)
        ->post('/submissions', [
            'title' => 'Test Paper',
            'abstract' => 'Abstract...',
            'keywords' => 'keyword1, keyword2',
            'research_field' => 'Science',
            'file' => UploadedFile::fake()->create('paper.pdf'),
        ]);
    
    $response->assertRedirect();
    $this->assertDatabaseHas('submissions', ['title' => 'Test Paper']);
}
```

---

## 🔐 Security Best Practices

### **Authentication**
- All protected routes require login
- Role-based middleware enforces authorization
- OTP email verification prevents unauthorized registration
- 6-request/minute throttling on OTP resend

### **Data Protection**
- Bcrypt password hashing (iterations configurable in testing)
- CSRF token protection on all POST/PUT/DELETE
- File uploads stored outside web root
- Separate storage disk configuration
- SQL injection prevention via Eloquent ORM

### **Access Control**
- Gates prevent users accessing others' submissions
- Role middleware checks user roles
- Owner verification on sensitive actions
- Admin-only routes fully protected

### **File Security**
- Only PDF, DOC, DOCX allowed uploads
- File size limits configurable
- Virus scan ready (integrate ClamAV if needed)
- Downloaded files served via controller (not directly)

### **Production Checklist**
```bash
# Enable HTTPS only
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true

# Disable debug mode
APP_DEBUG=false

# Cache for performance
php artisan config:cache
php artisan route:cache

# Set proper file permissions
chmod -R 755 public/
chmod -R 775 storage/

# Use Redis for sessions/cache
CACHE_STORE=redis
SESSION_DRIVER=redis
```

---

## 🐛 Troubleshooting

### **Installation Issues**

**Problem**: `PHP 8.1 but requires PHP 8.2`
```bash
# Check PHP version
php --version

# Update PHP or use PHP 8.2+
# macOS: brew install php@8.2
# Windows: Download from php.net or use WSL
```

**Problem**: `Composer version conflicts`
```bash
# Clear composer cache
composer clear-cache

# Reinstall dependencies
rm composer.lock
composer install
```

**Problem**: `npm install fails`
```bash
# Clear npm cache
npm cache clean --force

# Reinstall npm packages
rm -rf node_modules package-lock.json
npm install
```

### **Database Issues**

**Problem**: `SQLSTATE[HY000]: General error: 1 table users has no column named [column_name]`
```bash
# Migrations incomplete
php artisan migrate --fresh

# Verify migration status
php artisan migrate:status
```

**Problem**: `PostgreSQL connection refused`
```bash
# Check PostgreSQL running
psql --version

# Start PostgreSQL service
# macOS: brew services start postgresql
# Linux: sudo service postgresql start

# Test connection
psql -U postgres -c "SELECT version();"
```

**Problem**: `SQLite database locked`
```bash
# Stop all processes accessing database
# Check file permissions
chmod 666 database/database.sqlite

# Delete corrupted database and recreate
rm database/database.sqlite
php artisan migrate
```

### **Development Server Issues**

**Problem**: `Port 8000 already in use`
```bash
# Find process using port
lsof -i :8000

# Use different port
php artisan serve --port=8001

# Kill process (careful!)
kill -9 <PID>
```

**Problem**: `Vite hot reload not working`
```bash
# Restart Vite dev server
# Kill: Ctrl+C
npm run dev

# Check Vite is accessible
curl http://localhost:5173
```

**Problem**: `Assets not loading (404 errors)`
```bash
# Run Vite build
npm run build

# Links should be in public/build/
ls public/build/

# Clear cache
php artisan cache:clear
```

### **Permission Errors**

**Problem**: `Failed to write permissions to storage/`
```bash
# Linux/Mac: Fix permissions
sudo chmod -R 775 storage bootstrap/cache

# Change ownership if needed
sudo chown -R $(whoami) storage bootstrap/cache
```

**Problem**: `Cannot write to .env file`
```bash
# Check file permissions
ls -la .env

# Make writable
chmod 644 .env

# Or use docker/sudo to modify
```

### **Email Delivery Issues**

**Problem**: `Email not sending`
```bash
# Check mail configuration in .env
MAIL_MAILER=log      # For local testing
RESEND_API_KEY=your_key  # For production

# View logged emails
tail -f storage/logs/laravel.log

# Test email sending in Tinker
php artisan tinker
Mail::raw('Test', function ($m) { $m->to('test@local'); });
```

### **Performance Issues**

**Problem**: `Application loading slowly`
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Use Redis for cache (requires Redis server)
CACHE_STORE=redis

# Profile requests
php artisan pail --timeout=0
```

**Problem**: `Database queries too slow`
```bash
# Enable query logging
DB::enableQueryLog();
DD(DB::getQueryLog());

# Add database indexes for frequently queried columns
# Create migration for index

# Use eager loading to prevent N+1 queries
Submission::with('author', 'reviews')->get();
```

---

## 📚 Documentation & Resources

### **Project Documentation**
- [SETUP.md](SETUP.md) - Environment setup and configuration
- [SUBMISSION_MANAGEMENT_SYSTEM.md](SUBMISSION_MANAGEMENT_SYSTEM.md) - Expert assignment system
- [RATING_SYSTEM_DOCUMENTATION.md](RATING_SYSTEM_DOCUMENTATION.md) - Rating scale details
- [REVISION_PROCESS_INTEGRATION.md](REVISION_PROCESS_INTEGRATION.md) - Revision workflow
- [UI_IMPROVEMENTS_2026.md](UI_IMPROVEMENTS_2026.md) - UI/UX enhancements
- [REFACTORING_PLAN.md](REFACTORING_PLAN.md) - Code improvements roadmap
- [RIS_DOWNLOAD_FEATURE.md](RIS_DOWNLOAD_FEATURE.md) - Citation export feature documentation
- [RIS_QUICK_REFERENCE.md](RIS_QUICK_REFERENCE.md) - Quick reference for RIS download feature

### **Role-Specific Guides**
- [docs/AUTHOR_GUIDE.md](docs/AUTHOR_GUIDE.md) - How to submit and manage manuscripts
- [docs/REVIEWER_GUIDE.md](docs/REVIEWER_GUIDE.md) - How to review manuscripts
- [docs/EDITOR_GUIDE.md](docs/EDITOR_GUIDE.md) - Editorial workflow
- [docs/ADMIN_GUIDE.md](docs/ADMIN_GUIDE.md) - System administration

### **External Resources**
- [Laravel Official Documentation](https://laravel.com/docs) - PHP framework reference
- [Tailwind CSS Documentation](https://tailwindcss.com/docs) - Styling guide
- [Vite Documentation](https://vitejs.dev/) - Build tool reference
- [PostgreSQL Documentation](https://www.postgresql.org/docs/) - Database reference
- [Eloquent ORM Documentation](https://laravel.com/docs/eloquent) - Database queries

---

## 📦 Dependencies & Versions

### **Backend Dependencies** (composer.json)
```json
require: {
  "php": "^8.2",
  "laravel/framework": "^12.0",
  "laravel/tinker": "^2.10.1",
  "resend/resend-laravel": "^1.3"
},
require-dev: {
  "fakerphp/faker": "^1.23",
  "laravel/pail": "^1.2.2",
  "laravel/pint": "^1.24",
  "mockery/mockery": "^1.6",
  "phpunit/phpunit": "^11.5.3"
}
```

### **Frontend Dependencies** (package.json)
```json
devDependencies: {
  "@tailwindcss/vite": "^4.0.0",
  "axios": "^1.11.0",
  "concurrently": "^9.0.1",
  "laravel-vite-plugin": "^2.0.0",
  "tailwindcss": "^4.0.0",
  "vite": "^7.0.7"
}
```

---

## 🤝 Contributing

### **How to Contribute**
1. Fork the repository
2. Create a feature branch: `git checkout -b feature/YourFeature`
3. Make your changes and commit: `git commit -m 'Add YourFeature'`
4. Push to branch: `git push origin feature/YourFeature`
5. Open a Pull Request

### **Code Standards**
- Follow PSR-12 PHP coding standards
- Use Prettier for formatting: `npm run format`
- Write tests for new features: `php artisan test`
- Update documentation with changes
- Use descriptive commit messages

### **Reporting Bugs**
1. Check existing issues first
2. Use GitHub Issues with template
3. Include: expected behavior, actual behavior, steps to reproduce
4. Provide PHP/Laravel versions and environment details

---

## 📄 License

MIT License - See LICENSE file for details.

Copyright © 2025-2026 International Research Journal of Information Systems & Engineering Technology (IRJIEST)

---

## 👥 Support & Contact

### **Getting Help**
1. Check [SETUP.md](SETUP.md) and documentation files in `/docs`
2. Search existing [GitHub Issues](https://github.com/RalphAreta/open-journal-system/issues)
3. Create a new issue with detailed description
4. Contact: [Project Issues](https://github.com/RalphAreta/open-journal-system/issues)

### **Community**
- Report bugs and request features via GitHub Issues
- Share improvements and suggestions in Discussions
- Check project board for planned features

---

## 📌 Version History & Recent Updates

### **v2025.03 - March 2026** ✨ Current
- **Complete Revision Workflow**: Editor reviews revisions before assigning to reviewers
- **Enhanced Appeals**: Dedicated appeals management interface with timeline view
- **Published Papers Catalog**: Public-facing papers list with search, filter, and download tracking
- **Layout Editing Pipeline**: Layout editor workflow with CTF management
- **Rating System (1-100)**: Role-specific criteria with automated guidance
- **UI Improvements**: Modern Tailwind cards, gradients, hover effects across dashboards
- **Initial Screening**: Chief Editor gatekeeper process before peer review
- **📚 RIS Citation Export**: Download paper citations in RIS format for Zotero, Mendeley, EndNote (NEW)

### **v2024.12 - December 2024**
- Appeals system for manuscript rejection challenges
- Expertise-based editor assignment
- Multi-editor support for complex submissions
- Editor-in-Chief initial screening workflow

### **v2024.06 - June 2024**
- Complete peer review workflow
- Revision request and management system
- Role-based access control implementation
- Author, Editor, Reviewer, Admin dashboards

### **v2024.01 - January 2024**
- Project initialization
- Submission management system
- User authentication and authorization
- Basic submission lifecycle

---

## 🎯 Roadmap (Q2-Q4 2026)

- [ ] Advanced search and filtering for papers
- [ ] Batch import functionality for bulk uploads
- [ ] API endpoints for external systems
- [ ] Enhanced analytics and reporting
- [ ] Mobile application (React Native)
- [ ] Accessibility (WCAG 2.1 AA) improvements
- [ ] Multi-language support (i18n)
- [ ] Advanced notification preferences
- [ ] Integration with academic identity providers
- [ ] DOI and CrossRef integration
- Appeal form in submission page for rejected manuscripts
- Database migration and Appeal model implementation

### **Initial Screening Enhancement**
- Editor-in-Chief performs initial screening before peer review assignment
- Pass/Fail decision with detailed comments
- Screening results visible to authors in dashboard

### **Author Dashboard Improvements**
- Display of appeal decisions with color-coded status (Approved/Rejected/Pending)
- Show editor-in-chief's response to appeals in submission listings
- Appeal status chip alongside other submission metadata

### **Submission Details Page Enhancement**
- New Appeal Decision block showing:
  - Appeal status (Approved/Rejected/Pending)
  - Editor-in-Chief's detailed response
  - Pending review message if decision not yet made

### **UI/UX Improvements**
- Hide reviewer recommendations from authors in author-facing views
- Fixed login form to properly recognize "Editor-in-Chief" role
- Consistent styling for appeal status badges and information cards
- Tab-based interface for chief editor dashboard with appeals management

### **Backend Improvements**
- AppealController with full CRUD operations
- Appeal model with relationships and status constants
- Appeals eager loading in DashboardController and SubmissionController
- Authorization checks restricting appeal management to editor-in-chief only
- Database schema with appeals table including status, responses, and reviewer tracking

---

**Last Updated**: February 26, 2026
**Version**: 1.1.0
