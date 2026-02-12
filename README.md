# Open Journal System (OJS)

A Laravel-based Open Journal System with role-based dashboards for **Author**, **Reviewer**, **Editor**, and **Admin**. Built with PHP, Laravel, and PostgreSQL (SQLite supported for development).

## Features

- **User roles**: Author, Reviewer, Editor, Admin with distinct permissions
- **Dashboards**: Role-specific dashboards with relevant stats and actions
- **Submission management**: Authors submit articles; Editors manage the queue
- **Review workflow**: Reviewers submit feedback; Editors assign reviewers and make decisions (Accept / Reject / Revisions requested)
- **Admin panel**: Manage users, roles, and system settings
- **Security**: Role-based access control, hashed passwords, CSRF protection

## Requirements

- PHP 8.2+
- Composer
- PostgreSQL 12+ (or SQLite for local dev)
- Node.js & npm (for frontend assets)

## Quick Start

### 1. Install dependencies

```bash
composer install
npm install
```

### 2. Environment

Copy `.env.example` to `.env` and set your database:

- **PostgreSQL**: Set `DB_CONNECTION=pgsql`, `DB_DATABASE=ojs`, `DB_USERNAME`, `DB_PASSWORD`. Create the database: `createdb ojs`
- **SQLite**: Set `DB_CONNECTION=sqlite` and ensure `database/database.sqlite` exists (`touch database/database.sqlite` if needed)

Generate app key:

```bash
php artisan key:generate
```

### 3. Database

```bash
php artisan migrate
php artisan db:seed
```

Default admin: **admin@ojs.local** / **password**

### 4. Run the app

```bash
npm run dev
php artisan serve
```

Visit http://localhost:8000 — log in as admin or register as a new user (registered users get the Author role).

## Documentation

- [Setup & configuration](SETUP.md)
- [Author guide](docs/AUTHOR_GUIDE.md)
- [Reviewer guide](docs/REVIEWER_GUIDE.md)
- [Editor guide](docs/EDITOR_GUIDE.md)
- [Admin guide](docs/ADMIN_GUIDE.md)

## Project structure (relevant parts)

- `app/Models/` — User, Role, Submission, Review, ReviewAssignment, SystemSetting
- `app/Http/Controllers/` — Auth, Dashboard, Submission, Review, Admin (User, Role, SystemSetting)
- `app/Http/Middleware/EnsureUserHasRole.php` — Role-based access
- `database/migrations/` — roles, role_user, submissions, review_assignments, reviews, system_settings
- `resources/views/` — layouts, auth, dashboard (author, reviewer, editor, admin), submissions, reviews, admin

## License

MIT.
