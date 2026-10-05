# Tasks for Today Management System TSA2

A CodeIgniter 4 continuation of TSA1. Welcome, All Tasks, Profile, and About remain public. A signed-in user can create, edit, and archive tasks. Archiving sets `is_archived = 1`, so the task stays in MySQL and disappears from both public lists.

## Requirements

- PHP 8.2 or newer with the extensions needed by CodeIgniter 4, Composer, and MySQL or MariaDB.
- A web server serving the `public/` folder, or the CodeIgniter development server.

## Set up a fresh copy

1. In phpMyAdmin, create a database named `tms` and import `database/tms_tsa1.sql`. The SQL export creates the original TSA1 tables and eight sample tasks. The sample email address in this shared export is `demo@example.com`.
2. From this project directory, run `composer install` if the `vendor/` folder is absent.
3. Copy `.env.example` to `.env`. Set your own database connection details and a private `TSA_DEMO_PASSWORD` with at least 12 characters. Do not commit `.env` or put your chosen password in the README.
4. Run `php spark migrate` to add `users.password` and `tasks.is_archived` to the imported tables. Then run `php spark db:seed DemoUserPasswordSeeder`. The seeder uses PHP `password_hash()` to set the demo user's password.
5. Run `php spark serve`. Visit `http://localhost:8080/` if using the example base URL. The username is `gabsaulo`; the password is the one you placed in `.env`.

On Windows with XAMPP, use `C:\xampp\php\php.exe spark migrate`, `C:\xampp\php\php.exe spark db:seed DemoUserPasswordSeeder`, and `C:\xampp\php\php.exe spark serve` if `php` is not on your PATH. Run these commands from the directory that contains `spark`.

**If TSA1 is already installed:** keep your existing database and records. Start at step 2, point `.env` to the existing database, then run the migration and seeder. Do not import the sample SQL over your existing database. The seeder updates the `gabsaulo` record and may be rerun after changing `TSA_DEMO_PASSWORD` to set a new password.

The original eight sample tasks are dated September 26–28, 2026. On later dates the Welcome page may correctly show “No tasks scheduled for today.” Add a task with today's date after logging in to check that page.

## Routes and access

| URL | Method | Access | Purpose |
| --- | --- | --- | --- |
| `/`, `/tasks`, `/profile`, `/about` | GET | Public | View the original TSA1 pages and active tasks |
| `/login` | GET, POST | Public | Display login form and verify password |
| `/logout` | POST | Signed in | Destroy session |
| `/tasks/new` | GET | Signed in | Create form |
| `/tasks` | POST | Signed in | Validate and create a task |
| `/tasks/{id}/edit` | GET | Signed in | Edit form for an active task |
| `/tasks/{id}/update` | POST | Signed in | Validate and update an active task |
| `/tasks/{id}/archive` | POST | Signed in | Set `is_archived` to 1 |

All write forms use CSRF fields. The `auth` filter protects every management route. Auto routing is disabled in `app/Config/Routing.php`, so methods cannot be reached via unintended URLs.

## Quick manual check

1. While logged out, open all four public pages. Open `/tasks/new` and `/tasks/1/edit` and confirm each redirects to `/login`.
2. Sign in with `gabsaulo` and your chosen password. Submit the New Task form with a missing title and then a missing date; errors should appear, and no task should be saved.
3. Create a valid task, edit its title or status, and confirm the change appears in All Tasks. Use today's date to also check the Welcome page.
4. Archive that task. Confirm it disappears from both public lists, while its row remains in the `tasks` table with `is_archived = 1`.
5. Log out, then repeat the protected-page checks. A POST without a CSRF token may instead be rejected by CSRF protection, which is expected.

## GitHub and hosting

Keep `.env`, `vendor/`, and `writable/` generated files out of Git; `.gitignore` already excludes these. Include `database/tms_tsa1.sql`, the migration, the seeder, and `composer.lock` so someone can recreate the database. For hosting, point the web document root to `public/`, set a production base URL and private database and password settings, install Composer dependencies, import the SQL into a fresh database, and run the migration and seeder there. Verify the hosted site and submit its URL separately alongside the repository URL.
