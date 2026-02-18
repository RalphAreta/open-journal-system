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
- Editor-in-Chief reviews and assigns submissions to multiple editors
- Editors assign reviewers and manage review process
- Submissions can be: Accepted, Rejected, or Revisions Requested

### **Revision Workflow**
- Editors request minor or major revisions with detailed feedback
- Authors receive notifications about revision requests
- Authors upload revised manuscripts with notes
- Editors can re-review revised submissions

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
cd ojt-project
```

### **Step 2: Install PHP Dependencies**

```bash
composer install
```

### **Step 3: Install Node Dependencies**

```bash
npm install
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

---

## 📱 Dashboard Screenshots

### **Author Dashboard**
- View submission stats (Total, Submitted, Under Review, Revisions Needed, Accepted, Rejected)
- See submissions with status
- Quick access to revise submissions

### **Editor Dashboard**
- View assigned submissions with reviewer recommendations
- See review counts (Accept/Reject/Minor/Major)
- Assign reviewers and make decisions

### **Chief Editor Dashboard**
- View all submissions with assignment status
- See pending assignments
- See assigned submissions with current editor
- Assign/reassign editors based on expertise

### **Admin Dashboard**
- Manage users and roles
- Manage editor expertise fields
- View all submissions
- System settings

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
│   ├── RevisionRequest.php               # NEW: Revision tracking
│   ├── SubmissionAssignment.php          # NEW: Editor assignments
│   ├── EditorExpertise.php               # NEW: Editor expertise fields
│   └── ...
└── ...

database/
├── migrations/
│   ├── *_create_users_table.php
│   ├── *_create_submissions_table.php
│   ├── *_create_editor_expertise_table.php       # NEW
│   ├── *_create_submission_assignments_table.php # NEW
│   ├── *_create_revision_requests_table.php      # NEW
│   └── ...
└── seeders/
    └── DatabaseSeeder.php

resources/
└── views/
    ├── dashboard/
    │   ├── author.blade.php
    │   ├── editor.blade.php
    │   ├── admin.blade.php
    │   └── chief-editor.blade.php         # NEW
    ├── submissions/
    │   ├── create.blade.php               # Now includes research field
    │   ├── edit.blade.php                 # Now includes research field
    │   ├── show.blade.php
    │   └── revisions.blade.php            # NEW: Revision management
    ├── reviews/
    │   ├── editor-submissions.blade.php   # Enhanced with review counts
    │   ├── editor-show.blade.php          # NEW: Revision decision UI
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

**Last Updated**: February 2026
**Version**: 1.0.0
