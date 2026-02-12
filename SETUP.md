# OJS Setup & Configuration

## Development environment

### PHP

- PHP 8.2 or higher
- Extensions: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`
- For **PostgreSQL**: enable `pdo_pgsql` and `pgsql` in `php.ini`

### PostgreSQL (production / recommended)

1. Create database and user:

```sql
CREATE USER ojs WITH PASSWORD 'your_password';
CREATE DATABASE ojs OWNER ojs;
```

2. In `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ojs
DB_USERNAME=ojs
DB_PASSWORD=your_password
```

### SQLite (quick local setup)

1. Create the database file:

```bash
touch database/database.sqlite
```

2. In `.env`:

```env
DB_CONNECTION=sqlite
# DB_DATABASE is path relative to project; default database/database.sqlite
```

No PostgreSQL PHP extensions required.

## Running migrations and seeders

```bash
php artisan migrate
php artisan db:seed
```

Seeders create:

- Roles: Admin, Editor, Reviewer, Author
- Default admin user: `admin@ojs.local` / `password`
- Sample system settings (journal name, submissions open, etc.)

## Security notes

- Change the default admin password after first login
- Use strong passwords and `APP_DEBUG=false` in production
- Keep `.env` out of version control
- HTTPS in production; set `SESSION_SECURE_COOKIE=true` if using HTTPS

## Scalability

- Database: Use connection pooling (e.g. PgBouncer) and indexes (already on `submissions.status`, `submissions.author_id`)
- Files: Store submission files on a separate disk (e.g. S3) by configuring `config/filesystems.php` and using a disk other than `local` for uploads
- Sessions/cache: Use Redis in production for `CACHE_STORE` and `SESSION_DRIVER` for better performance
