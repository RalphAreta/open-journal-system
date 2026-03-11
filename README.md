# Open Journal System (OJS) - IRJIEST

A comprehensive **Laravel-based Open Journal System** with advanced submission management, peer review workflow, and role-based access control. Built with PHP 8.2+, Laravel 12, Tailwind CSS 4.0, and PostgreSQL.

## 🎯 Key Features

### **Role-Based System**
- **Author** - Submit manuscripts, track revisions, view reviews
- **Reviewer** - Review assigned submissions, provide recommendations
- **Editor** - Manage submissions, assign reviewers, make editorial decisions
- **Editor-in-Chief** - Assign submissions to editors based on expertise
- **Admin** - Manage users, roles, system settings, editor expertise fields

### **Submission Management**
- Authors select research field matching editor expertise
- **Initial Screening**: Editor-in-Chief performs initial screening (Pass/Fail) before peer review
- Editor-in-Chief reviews and assigns submissions to multiple editors
- Editors assign reviewers and manage review process
- Submissions can be: Accepted, Rejected, or Revisions Requested
- **Appeals System**: Authors can appeal rejected manuscripts during initial screening

### **Revision Workflow**
- Editors request minor or major revisions with detailed feedback
- Authors receive notifications about revision requests
- Authors upload revised manuscripts with notes
- Editors can re-review revised submissions

### **Appeals System**
- Authors can submit appeals for rejected manuscripts during initial screening
- Appeals require detailed reasoning (minimum 50 characters)
- Editor-in-Chief reviews appeals and makes final decisions (Approve/Reject)
- Authors see editor's response in dashboard and submission details
- Approved appeals move manuscripts to peer review stage

### **Expertise-Based Assignment**
- Admin defines editor expertise in 12+ research fields
- Chief Editor assigns submissions based on expertise match
- Can assign one submission to multiple editors

### **Security & Permissions**
- Role-based access control (RBAC) with middleware protection
- Auth gates prevent unauthorized access to submissions
- Hashed passwords and CSRF protection
- File upload restrictions (PDF, DOC, DOCX only)

---

## 📋 Requirements

- **PHP 8.2+**
- **Composer** (dependency manager)
- **Node.js 16+** & **npm** (for frontend assets)
- **PostgreSQL 12+** or **SQLite** (for local development)
- **Git** (optional, for version control)

---

## 🚀 Installation & Setup

### **Step 1: Clone the Repository**

```bash
git clone <repository-url>
cd open-journal-system
```

### **Step 2: Install PHP Dependencies**

```bash
composer install
```

### **Step 3: Install Node Dependencies**

```bash
npm install
npm audit
npm audit fix
```

### **Step 4: Configure Environment**

Copy the example environment file:

```bash
cp .env.example .env
```

Edit `.env` and configure your database:

**For PostgreSQL:**
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ojt_db
DB_USERNAME=postgres
DB_PASSWORD=yourpassword
```

**For SQLite (Local Development):**
```
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Then create the SQLite database file:
```bash
touch database/database.sqlite
```

### **Step 5: Generate Application Key**

```bash
php artisan key:generate
```

### **Step 6: Run Database Migrations**

This creates all necessary tables:

```bash
php artisan migrate
```

**Tables Created:**
- users
- roles, role_user
- submissions
- revision_requests
- submission_assignments
- review_assignments
- reviews
- editor_expertise
- system_settings
- And more...

### **Step 7: Seed the Database**

This populates initial data (roles, admin user, system settings):

```bash
php artisan db:seed
```

**Default Admin Credentials:**
- Email: `admin@irjiest.local`
- Password: `password`

### **Step 8: Start Development Servers**

**Terminal 1 - Vite Development Server (CSS/JS):**
```bash
npm run dev
```

**Terminal 2 - Laravel Development Server:**
```bash
php artisan serve
```

### **Step 9: Access the Application**

Open your browser and visit:
```
http://localhost:8000
```

---

## 📝 Creating Test Accounts

After seeding, you can:

1. **Log in as Admin**
   - Email: `admin@irjiest.local`
   - Password: `password`

2. **Register New Users**
   - Click "Register" on login page
   - New users automatically get the "Author" role
   - Admin can assign additional roles

### **Creating Test Editors with Expertise**

1. Register a new user (becomes Author by default)
2. Log in as Admin
3. Go to Admin Dashboard → Users Management
4. Edit the user and assign "Editor" role
5. Go to Admin Dashboard → Editor Expertise
6. Select the editor and add expertise fields (e.g., "Engineering", "Science & Technology")

### **Creating Reviewers**

1. Register a new user
2. Log in as Admin
3. Go to Users Management
4. Assign "Reviewer" role to the user

---

## 🔄 Typical Workflow

### **Author Submits Manuscript**
1. Login as Author
2. Click "New Submission"
3. Fill details: Title, Abstract, Keywords, **Research Field**
4. Upload manuscript (PDF/DOC/DOCX)
5. Submit

### **Chief Editor Assigns to Editors**
1. Login as Editor-in-Chief
2. Go to Chief Editor Dashboard
3. Review pending submissions
4. Click "Review & Assign"
5. **Select one or more editors** based on their expertise
6. Submit assignment

### **Editor Manages Submission**
1. Login as Editor
2. Go to Manage Submissions
3. See reviewer recommendations (Accept/Reject/Minor/Major Revisions)
4. Click "Manage" to view full details
5. Assign reviewers for review
6. Once reviewers submit, make editorial decision:
   - **Accept** - Submission approved
   - **Reject** - Submission rejected
   - **Request Revisions** - Specify type (minor/major) and reason

### **Author Receives Revision Request**
1. Login as Author
2. Dashboard shows "Revisions Requested"
3. Click "View & Submit Revisions"
4. Review revision feedback
5. Upload revised file with revision notes
6. Editor can then reassign reviewers for revised version

### **Reviewer Reviews Submission**
1. Login as Reviewer
2. View assigned review tasks
3. Download and review manuscript
4. Submit recommendation:
   - Accept
   - Reject
   - Minor Revisions Needed
   - Major Revisions Needed
5. Add comments for author and editor

### **Author Appeals Rejected Manuscript** (NEW)
1. Login as Author
2. View submission with "Failed Initial Screening" status
3. Click "Submit Appeal" button
4. Write detailed appeal reason (minimum 50 characters)
5. Submit the appeal
6. View appeal status in Dashboard and Submission details

### **Editor-in-Chief Reviews Appeal** (NEW)
1. Login as Editor-in-Chief
2. Go to Chief Editor Dashboard
3. Click on "Appeals" tab to see pending appeals
4. Click appeal card or "View" button
5. Review original rejection reason and author's appeal
6. Make decision:
   - **Approve** - Move manuscript to peer review stage
   - **Reject** - Uphold the initial screening rejection
7. Provide detailed editor response
8. Author receives notification and can view response in dashboard

---

## 📱 Dashboard Screenshots & Features

### **Author Dashboard**
- View submission stats (Total, Submitted, Under Review, Revisions Needed, Accepted, Rejected)
- See submissions with status badges
- View appeal decisions and editor-in-chief's response for rejected manuscripts
- Quick access to revise submissions
- Monitor initial screening results

### **Editor Dashboard**
- View assigned submissions with reviewer recommendations
- See review counts (Accept/Reject/Minor/Major)
- Assign reviewers and make editorial decisions
- Request revisions with detailed feedback

### **Reviewer Dashboard**
- View pending review invitations
- See assigned review tasks
- Submit reviews with recommendations and comments
- Track revision reviews for revised submissions

### **Chief Editor Dashboard** (ENHANCED)
- View all submissions with assignment status
- **Initial Screening**: Review and decide on submitted manuscripts (Pass/Fail)
- **Appeals Management Tab**: List and review all pending appeals
  - See appeal count in tab badge
  - View appeal timeline with author details
  - Review original rejection reason and appeal reasoning
  - Provide approval/rejection decision with detailed response
- See pending assignments awaiting editor assignment
- See assigned submissions with current editor
- Assign/reassign editors based on expertise
- Track submission workflow progress

### **Admin Dashboard**
- Manage users and assign roles
- Manage editor expertise fields
- View all submissions in the system
- Configure system settings

---

## 🛠️ Useful Commands

```bash
# Clear cache
php artisan cache:clear

# Reset database and reseed
php artisan migrate:fresh --seed

# Check database migrations status
php artisan migrate:status

# Create a new user (via tinker)
php artisan tinker
# Then: User::create(['name' => 'John', 'email' => 'john@example.com', 'password' => bcrypt('password')])

# Run tests
php artisan test

# Compile assets for production
npm run build
```

---

## 📂 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── SubmissionController.php      # Author submissions
│   │   ├── ReviewController.php          # Review workflow
│   │   ├── ChiefEditorController.php     # Chief editor assignment
│   │   ├── DashboardController.php       # Role-specific dashboards
│   │   └── Admin/                        # Admin controllers
│   └── Middleware/
│       └── EnsureUserHasRole.php         # Role authorization
├── Models/
│   ├── User.php
│   ├── Submission.php
│   ├── Review.php
│   ├── Appeal.php                        # NEW: Appeal management system
│   ├── RevisionRequest.php               # Revision tracking
│   ├── RevisionReview.php                # Revision review tracking
│   ├── SubmissionAssignment.php          # Editor assignments
│   ├── EditorExpertise.php               # Editor expertise fields
│   ├── ReviewAssignment.php              # Reviewer assignments
│   └── ...
└── ...

database/
├── migrations/
│   ├── *_create_users_table.php
│   ├── *_create_submissions_table.php
│   ├── *_create_reviews_table.php
│   ├── *_create_appeals_table.php                # NEW: Appeals system
│   ├── *_create_editor_expertise_table.php       # Editor expertise fields
│   ├── *_create_submission_assignments_table.php # Editor assignments
│   ├── *_create_revision_requests_table.php      # Revision requests
│   ├── *_create_revision_reviews_table.php       # Revision reviews
│   ├── *_add_initial_screening_to_submissions.php# Initial screening fields
│   └── ...
└── seeders/
    └── DatabaseSeeder.php

resources/
└── views/
    ├── dashboard/
    │   ├── author.blade.php               # Shows appeal decisions in submissions
    │   ├── editor.blade.php
    │   ├── reviewer.blade.php
    │   ├── admin.blade.php
    │   └── chief-editor.blade.php         # Now includes Appeals management tab
    ├── submissions/
    │   ├── create.blade.php               # Includes research field selection
    │   ├── edit.blade.php                 # Includes research field
    │   ├── show.blade.php                 # Shows appeal decision info
    │   ├── partials/
    │   │   ├── appeal-section.blade.php   # NEW: Appeal form for authors
    │   │   └── ...\n    │   └── ...\n    ├── appeals/
    │   ├── index.blade.php                # NEW: List pending appeals (editor-in-chief)\n    │   └── show.blade.php                 # NEW: Review and respond to appeals\n    ├── reviews/
    │   ├── editor-submissions.blade.php   # Enhanced with review counts
    │   ├── editor-show.blade.php          # Revision decision UI
    │   └── ...
    └── ...

routes/
└── web.php                                # All application routes
```

---

## 🔐 Authentication & Authorization

- **Login Required**: All routes except Welcome, Login, Register
- **Role Middleware**: Routes protected by user role (`role:author`, `role:editor`, etc.)
- **Ownership Checks**: Users can only access their own submissions/reviews
- **Admin Access**: Admins can access all resources

---

## 🐛 Troubleshooting

### **Database Migration Errors**
```bash
# Reset and re-migrate
php artisan migrate:fresh --seed
```

### **Asset Compilation Issues**
```bash
# Clear npm cache and reinstall
rm -rf node_modules package-lock.json
npm install
npm run dev
```

### **Permission Errors**
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
```

### **Port 8000 Already in Use**
```bash
# Use different port
php artisan serve --port=8001
```

### **PostgreSQL Connection Issues**
- Ensure PostgreSQL is running
- Check DB credentials in `.env`
- Create database: `createdb ojt_db`

---

## 📚 Documentation

- [Setup Guide](SETUP.md) - Detailed configuration
- [Author Guide](docs/AUTHOR_GUIDE.md) - How to submit and manage submissions
- [Reviewer Guide](docs/REVIEWER_GUIDE.md) - How to review submissions
- [Editor Guide](docs/EDITOR_GUIDE.md) - Editorial workflow
- [Admin Guide](docs/ADMIN_GUIDE.md) - System administration

---

## 🎓 Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [PostgreSQL](https://www.postgresql.org/docs/)

---

## 📄 License

MIT License - See LICENSE file for details.

---

## 👥 Contributing

1. Create a feature branch (`git checkout -b feature/AmazingFeature`)
2. Commit changes (`git commit -m 'Add AmazingFeature'`)
3. Push to branch (`git push origin feature/AmazingFeature`)
4. Open a Pull Request

---

## 📞 Support

For issues or questions:
1. Check the documentation files in `/docs`
2. Review existing GitHub issues
3. Create a new issue with detailed description

---

## 📌 Recent Updates (February 26, 2026)

### **Appeals System** ✨ NEW
- Complete appeal workflow for authors contesting rejected manuscripts
- Editor-in-Chief appeal review interface with decision-making
- Appeals tab in chief editor dashboard with pending appeals list
- Author can see appeal decisions and editor's response in dashboard and submission details
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
