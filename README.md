# CRM System

A full-featured, modular Customer Relationship Management (CRM) web application built with **Laravel 11**, **Livewire 3**, **Tailwind CSS**, and **Alpine.js**.

---

## Features

- **Leads** — Capture and manage sales leads with status, priority, source tracking and one-click conversion to Contact
- **Contacts** — Manage individual persons linked to Accounts
- **Accounts** — Company/organisation records with linked contacts and deals
- **Deals** — Sales pipeline with Kanban-style stage view (Prospect → Won/Lost)
- **Activities** — Log calls, meetings, tasks, and emails against any entity
- **Reports** — Charts and CSV exports for leads, deals, and activities
- **Settings** — User management, role assignment, and module toggle (Admin only)
- **Role-Based Access** — Admin / Manager / User roles with fine-grained permissions
- **Modular Architecture** — Each feature is an independent Laravel module (enable/disable via UI)

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 11 |
| Reactive UI | Livewire 3 |
| Frontend | Tailwind CSS (CDN), Alpine.js (via Livewire), Chart.js |
| Auth & Roles | Laravel Auth + Spatie Permission |
| Modules | nwidart/laravel-modules |
| Database | MySQL / MariaDB |
| Exports | CSV (built-in streams) |

---

## Requirements

- PHP **8.2** or higher (with `pdo_mysql`, `mbstring`, `openssl`, `tokenizer` extensions)
- MySQL **8.0+** or MariaDB **10.4+**
- Composer **2.x**
- Apache or Nginx (WAMP / XAMPP / Laragon on Windows, or any Linux server)

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-username/crm-test.git
cd crm-test
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Create environment file

```bash
cp .env.example .env
```

Open `.env` and update these values:

```env
APP_URL=http://localhost/crm-test/public

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm_test
DB_USERNAME=root
DB_PASSWORD=
```

> **Subdirectory installs (WAMP/XAMPP):** Set `APP_URL` to the full path including subdirectory, e.g. `http://localhost/crm-test/public`. This is required for Livewire assets to load correctly.

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Create the database

In phpMyAdmin or MySQL CLI:

```sql
CREATE DATABASE crm_test CHARACTER SET utf8 COLLATE utf8_unicode_ci;
```

### 6. Run migrations

```bash
php artisan migrate
```

### 7. Publish Spatie Permission migrations and run again

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 8. Seed demo data

```bash
php artisan db:seed
```

Creates three demo accounts (see [Default Credentials](#default-credentials)).

### 9. Clear caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 10. Open in browser

```
http://localhost/crm-test/public
```

---

## Default Credentials

| Role | Email | Password |
|---|---|---|
| Admin | admin@crm.com | password |
| Manager | manager@crm.com | password |
| User | user@crm.com | password |

> **Important:** Change all passwords before deploying to production.

---

## Module Overview

| Module | Path | Description |
|---|---|---|
| Core | `Modules/Core` | Helpers, middleware, module status table |
| Auth | `Modules/Auth` | Login / logout |
| Dashboard | `Modules/Dashboard` | Stats, charts, activity feed |
| Leads | `Modules/Leads` | Lead management + convert to contact |
| Contacts | `Modules/Contacts` | Contact person records |
| Accounts | `Modules/Accounts` | Company / organisation records |
| Deals | `Modules/Deals` | Sales pipeline and deal stages |
| Activities | `Modules/Activities` | Calls, meetings, tasks, emails |
| Reports | `Modules/Reports` | Charts + CSV export |
| Settings | `Modules/Settings` | Users, roles, module toggle |

---

## Role Permissions

| Action | Admin | Manager | User |
|---|---|---|---|
| All CRUD | ✅ | ✅ | Partial |
| View all records | ✅ | ✅ | Own only |
| Reports & exports | ✅ | ✅ | ❌ |
| Settings & user management | ✅ | ❌ | ❌ |
| Enable/disable modules | ✅ | ❌ | ❌ |

---

## Project Structure

```
crm-test/
├── Modules/                  # Feature modules
│   ├── Core/
│   ├── Auth/
│   ├── Dashboard/
│   ├── Leads/
│   ├── Contacts/
│   ├── Accounts/
│   ├── Deals/
│   ├── Activities/
│   ├── Reports/
│   └── Settings/
├── app/
│   ├── Models/User.php
│   ├── Http/Middleware/
│   └── Providers/AppServiceProvider.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/views/layouts/
│   ├── app.blade.php         # Main layout (sidebar + header)
│   └── auth.blade.php        # Login layout
├── routes/web.php
├── .env.example
└── README.md
```

---

## Common Artisan Commands

```bash
php artisan migrate              # Run pending migrations
php artisan migrate:fresh --seed # Drop all tables, re-migrate and re-seed
php artisan db:seed              # Seed demo users and data
php artisan config:clear         # Clear configuration cache
php artisan cache:clear          # Clear application cache
php artisan view:clear           # Clear compiled views
php artisan route:list           # List all registered routes
```

---

## Troubleshooting

**Livewire assets return 404**
Set `APP_URL` in `.env` to the full subdirectory path (e.g. `http://localhost/crm-test/public`). The `AppServiceProvider` calls `URL::forceRootUrl(config('app.url'))` to enforce this.

**Grey overlay / cannot click on dashboard**
The Livewire JS asset failed to load (see above). Clear config cache and hard-refresh with `Ctrl+Shift+R`.

**`Table 'cache' doesn't exist` on cache:clear**
Add `CACHE_STORE=file` to `.env` (Laravel 11 renamed `CACHE_DRIVER`).

**Key length too long on migrate**
Already handled — `AppServiceProvider` sets `Schema::defaultStringLength(160)` and `.env` uses `utf8` charset.

**`Class not found` errors after adding files**
Run `composer dump-autoload`.

**Permission errors on storage (Linux/Mac)**
```bash
chmod -R 775 storage bootstrap/cache
```

---

## License

MIT — free to use, modify, and distribute.
