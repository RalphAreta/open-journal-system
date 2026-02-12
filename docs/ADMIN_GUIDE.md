# Admin Guide — Open Journal System

## Overview

As an **Admin**, you have full system access: manage **users**, **roles**, and **system settings**. You can also use all Editor and submission features.

## Logging in

Default admin account (after seeding):

- **Email:** admin@ojs.local  
- **Password:** password  

Change the password after first login.

## Dashboard

The **Admin Dashboard** shows counts and links for:

- **Users** — manage user accounts
- **Roles** — view and edit role details
- **Submissions** — view the submission queue (editor view)
- **System Settings** — configure journal and system options

## Managing users

1. Go to **Users** in the nav or dashboard.
2. **Add User**: Click **Add User**, then enter name, email, password, and assign one or more **Roles** (Author, Reviewer, Editor, Admin). Click **Create User**.
3. **Edit User**: Click **Edit** next to a user. You can change name, email, password (optional), and roles. Click **Update**.
4. **Delete User**: Click **Delete** (confirm when prompted). The last remaining admin cannot be deleted.

New users should use “Forgot password” or receive a temporary password and change it after first login (if you implement password reset).

## Managing roles

1. Go to **Roles**.
2. You’ll see: Admin, Editor, Reviewer, Author (and user count per role).
3. Click **Edit** on a role to change its **Display name** and **Description**. The internal role **name** (e.g. `admin`, `editor`) is fixed; only display text is editable.
4. The edit page lists **Users with this role** with links to edit them.

Role names and permissions:

- **Admin** — full access; users, roles, settings, and all editor/submission features
- **Editor** — manage submissions, assign reviewers, make decisions
- **Reviewer** — complete assigned reviews only
- **Author** — submit and manage own submissions only

## System settings

1. Go to **Settings** (or **System Settings** from the dashboard).
2. Settings are grouped (e.g. General, Submissions). Edit values as needed.
3. Click **Save Settings**.

Typical seeded settings:

- **Journal name** — title of the journal
- **Journal description** — short description
- **Submissions open** — whether new submissions are accepted (boolean)

Adding new settings requires creating records in the `system_settings` table (e.g. via a seeder or migration).

## Security and good practice

- Use strong passwords and change the default admin password immediately.
- Assign the Admin role only to trusted users.
- Assign Editor to users who should manage the submission queue; Reviewer only to those who will review.
- In production, use HTTPS and set `APP_DEBUG=false`.
