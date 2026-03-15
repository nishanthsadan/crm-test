================================================================================
  CRM SYSTEM - Laravel 11 Customer Relationship Management Application
================================================================================

OVERVIEW
--------
A full-featured, modular CRM web application built with Laravel 11, Livewire 3,
Tailwind CSS, and Alpine.js. The system covers the complete sales lifecycle from
lead capture through to deal closure, with activity tracking, reporting, and
multi-role user management.

--------------------------------------------------------------------------------
REQUIREMENTS
--------------------------------------------------------------------------------
  - PHP 8.2 or higher
  - MySQL 8.0+ (or MariaDB 10.6+)
  - Composer 2.x
  - Web server: Apache (WAMP/XAMPP) or Nginx
  - Node.js (optional, all assets loaded via CDN)

--------------------------------------------------------------------------------
INSTALLATION
--------------------------------------------------------------------------------

1. CLONE / PLACE FILES
   Place the project folder inside your web server root.
   Example (WAMP): C:\wamp64\www\crm-test\

2. INSTALL PHP DEPENDENCIES
   Open a terminal in the project root and run:

     composer install

3. CONFIGURE ENVIRONMENT
   Copy the example environment file and edit it:

     copy .env.example .env       (Windows)
     cp .env.example .env         (Linux/Mac)

   Open .env and set your database credentials:

     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=crm_test
     DB_USERNAME=root
     DB_PASSWORD=

   Also set your application URL:

     APP_URL=http://localhost/crm-test/public

4. GENERATE APPLICATION KEY

     php artisan key:generate

5. CREATE DATABASE
   Create a MySQL database named  crm_test  (or whatever you set in DB_DATABASE).
   Example using MySQL CLI:

     CREATE DATABASE crm_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

6. RUN MIGRATIONS
   This creates all required tables:

     php artisan migrate

7. SEED DEMO DATA (Recommended)
   Creates default admin, manager, and user accounts plus roles/permissions:

     php artisan db:seed

8. CLEAR CACHES (if needed)

     php artisan config:clear
     php artisan cache:clear
     php artisan view:clear

9. ACCESS THE APPLICATION
   Open your browser and navigate to:

     http://localhost/crm-test/public

   Or if you have a virtual host configured:

     http://crm-test.local

--------------------------------------------------------------------------------
DEFAULT LOGIN CREDENTIALS
--------------------------------------------------------------------------------

  ADMIN
    Email   : admin@crm.com
    Password: password
    Access  : Full access to all modules including Settings

  MANAGER
    Email   : manager@crm.com
    Password: password
    Access  : All CRM modules except Settings/User Management

  USER
    Email   : user@crm.com
    Password: password
    Access  : Leads (own), Contacts, Accounts (view), Deals, Activities (own)

  IMPORTANT: Change all passwords immediately in a production environment.
  Settings > My Profile > Change Password

--------------------------------------------------------------------------------
MODULES & FEATURES
--------------------------------------------------------------------------------

1. DASHBOARD
   URL: /dashboard
   - Summary statistics: total leads, contacts, revenue, conversion rate
   - Line chart: Leads vs Won Deals (last 6 months)
   - Doughnut chart: Deal pipeline by stage
   - Recent activities feed
   - Upcoming tasks list

2. LEADS
   URL: /leads
   - Create, view, edit, delete leads
   - Fields: name, email, phone, company, source, status, stage, priority,
     assigned user, expected value, description
   - Lead statuses: New, Contacted, Qualified, Lost, Converted
   - Lead sources: Website, Referral, Social Media, Email Campaign, Cold Call, Other
   - Priorities: Low, Medium, High
   - Convert a lead to a Contact with one click
   - Searchable/filterable table with pagination (Livewire)
   - Role-based visibility: Admins/Managers see all; Users see only their own

3. CONTACTS
   URL: /contacts
   - Create, view, edit, delete contact persons
   - Fields: first/last name, email, phone, mobile, title, department,
     linked account, source, description
   - Link contacts to Accounts (companies)
   - Searchable table with pagination

4. ACCOUNTS
   URL: /accounts
   - Create, view, edit, delete company/organisation records
   - Fields: company name, email, phone, website, industry, employee count,
     annual revenue, address details, description
   - Industries: Technology, Finance, Healthcare, Retail, Manufacturing, and more
   - View all contacts and deals linked to an account from the detail page

5. DEALS
   URL: /deals
   - Create, view, edit, delete deals/opportunities
   - Fields: title, linked account, linked contact, assigned user, stage,
     value, currency, probability (%), expected close date, description
   - Pipeline stages: Prospect (10%) → Proposal (25%) → Negotiation (50%)
                      → Won (100%) / Lost (0%)
   - Pipeline view: Kanban-style stage overview at /deals/pipeline

6. ACTIVITIES
   URL: /activities
   - Log and track: Calls, Meetings, Tasks, Emails
   - Link activities to any entity (Lead, Contact, Account, Deal) via
     polymorphic relationship
   - Fields: type, title, description, due date/time, status, priority,
     assigned user
   - Statuses: Pending, In Progress, Completed, Cancelled
   - Priorities: Low, Medium, High

7. REPORTS
   URL: /reports
   Sub-pages:
     /reports/leads      - Leads by status, source, priority; monthly trend
     /reports/deals      - Deals by stage (count & value); monthly won revenue
     /reports/activities - Activity types; status breakdown; completion rate
   Exports:
     /reports/export/leads  - Download all leads as CSV
     /reports/export/deals  - Download all deals as CSV

8. SETTINGS  (Admin only)
   URL: /settings

   a) User Management  (/settings/users)
      - List all users with role, status, last login
      - Create new users (name, email, phone, role, status, password)
      - Edit existing users (including optional password reset)
      - Delete users (cannot delete your own account)

   b) Module Management  (/settings/modules)
      - Toggle individual modules on or off
      - Core modules (Core, Auth, Dashboard, Settings) are always enabled
      - Module state is cached for 5 minutes; changes take effect immediately

   c) My Profile  (/settings/profile)
      - Update name, email, phone
      - Change password (requires current password)
      - Avatar is auto-generated from initials via UI Avatars

--------------------------------------------------------------------------------
USER ROLES & PERMISSIONS
--------------------------------------------------------------------------------

  ADMIN
    - Manage settings, users, modules
    - Full CRUD on all modules
    - View all records across the system

  MANAGER
    - Full CRUD on Leads, Contacts, Accounts, Deals, Activities
    - View and export Reports
    - Cannot access Settings or User Management

  USER
    - View/Create/Edit own Leads and Activities
    - View/Create/Edit Contacts and Deals
    - View Accounts
    - No access to Reports or Settings

--------------------------------------------------------------------------------
PROJECT STRUCTURE
--------------------------------------------------------------------------------

  crm-test/
  ├── Modules/
  │   ├── Core/         Framework helpers, middleware, module status table
  │   ├── Auth/         Login / logout
  │   ├── Dashboard/    Overview and charts
  │   ├── Leads/        Lead management with Livewire table
  │   ├── Contacts/     Contact management
  │   ├── Accounts/     Account/company management
  │   ├── Deals/        Deal pipeline management
  │   ├── Activities/   Activity tracking (calls, tasks, meetings, emails)
  │   ├── Reports/      Analytics, charts and CSV exports
  │   └── Settings/     Users, modules and profile management
  ├── app/
  │   ├── Models/User.php
  │   ├── Http/Middleware/AdminMiddleware.php
  │   └── Providers/AppServiceProvider.php
  ├── database/
  │   ├── migrations/   All table definitions
  │   └── seeders/      Demo data (AdminSeeder, ModuleSeeder)
  ├── resources/views/layouts/
  │   ├── app.blade.php   Main layout with sidebar navigation
  │   └── auth.blade.php  Login layout
  └── routes/web.php      Root redirect to /login

--------------------------------------------------------------------------------
TECHNOLOGY STACK
--------------------------------------------------------------------------------

  Backend
    Laravel 11          PHP framework
    Livewire 3          Reactive UI without writing JavaScript
    nwidart/modules     Modular application structure
    Spatie Permission   Role & permission management
    maatwebsite/excel   Excel export (available for extension)
    barryvdh/dompdf     PDF generation (available for extension)

  Frontend (all via CDN - no build step required)
    Tailwind CSS        Utility-first CSS framework
    Alpine.js 3         Lightweight JS for dropdowns, toggles, animations
    Chart.js            Dashboard and report charts
    Google Fonts        Inter typeface

  Database
    MySQL / MariaDB     Primary data store with soft deletes on all entities

--------------------------------------------------------------------------------
COMMON ARTISAN COMMANDS
--------------------------------------------------------------------------------

  php artisan migrate              Run all pending migrations
  php artisan migrate:fresh --seed Drop all tables, re-migrate, and re-seed
  php artisan db:seed              Run seeders (creates demo users)
  php artisan cache:clear          Clear application cache
  php artisan config:clear         Clear config cache
  php artisan view:clear           Clear compiled views
  php artisan route:list           List all registered routes
  php artisan tinker               Interactive REPL for debugging

--------------------------------------------------------------------------------
TROUBLESHOOTING
--------------------------------------------------------------------------------

  "Class not found" errors
    Run: composer dump-autoload

  Views not updating
    Run: php artisan view:clear

  Permission errors (Linux/Mac)
    chmod -R 775 storage bootstrap/cache

  Livewire components not loading
    Ensure the APP_URL in .env matches your actual URL exactly.
    Clear cache: php artisan cache:clear

  Module routes returning 404
    Check that modules.json has the module listed as "enabled": true.
    Run: php artisan cache:clear

  Database connection refused
    Verify DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD in .env.
    Ensure MySQL service is running.

--------------------------------------------------------------------------------
EXTENDING THE APPLICATION
--------------------------------------------------------------------------------

  Add a new module:
    1. Create directory: Modules/YourModule/
    2. Add module.json, Providers, Routes, Controllers, Resources/views
    3. Register in modules.json
    4. The sidebar in resources/views/layouts/app.blade.php uses
       module_enabled('YourModule') to show/hide nav items

  Add a new report:
    1. Add a method in Modules/Reports/Http/Controllers/ReportController.php
    2. Add a route in Modules/Reports/Routes/web.php
    3. Create a view in Modules/Reports/Resources/views/

  Add permissions:
    1. Define in database/seeders/AdminSeeder.php
    2. Run: php artisan db:seed --class=AdminSeeder
    3. Gate::allows() or @can() in Blade to check

--------------------------------------------------------------------------------
LICENSE
--------------------------------------------------------------------------------
  MIT License — free to use and modify.

================================================================================
