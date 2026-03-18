# Copilot Instructions for app-perpustakaan-V2

## Project Snapshot
- Stack: Laravel 12 (PHP 8.2+), Filament 5, Vite 7, Tailwind 4.
- This repository is now a **library information system scaffold** with initial domain entities and admin CRUD.
- Current domain modules: `Book` and `Category` (Eloquent + Filament resources).
- Primary app flows are through Filament admin (`/admin`); public web route is still minimal.

## Architecture & Entry Points
- HTTP bootstrap is configured in [bootstrap/app.php](bootstrap/app.php) with web routes from [routes/web.php](routes/web.php).
- Service providers are registered in [bootstrap/providers.php](bootstrap/providers.php), including [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php).
- Filament panel details:
  - panel id: `admin`, path: `/admin`, auth enabled via `->login()`.
  - custom brand: `Project Library VI`.
  - color palette configured in panel provider (including custom primary `#004380`).
  - theme package in use: `openplain/filament-shadcn-theme`.
  - resource/page/widget auto-discovery expects:
    - `app/Filament/Resources`
    - `app/Filament/Pages`
    - `app/Filament/Widgets`
- Public web route currently only returns the default welcome page (`/`) in [routes/web.php](routes/web.php).

## Implemented Domain & Admin Features
- Models:
  - [app/Models/Book.php](app/Models/Book.php): uses `SoftDeletes`, belongs to `Category`, fillable fields include `title`, `authorName`, `ISBN`, `publishedYear`, `coverImage`, `category_id`.
  - [app/Models/Category.php](app/Models/Category.php): uses `SoftDeletes`, has many `Book`, fillable field `name`.
- Migrations:
  - [database/migrations/2026_03_17_083309_create_categories_table.php](database/migrations/2026_03_17_083309_create_categories_table.php): categories table with soft deletes.
  - [database/migrations/2026_03_17_083351_create_books_table.php](database/migrations/2026_03_17_083351_create_books_table.php): books table, FK `category_id` constrained with cascade delete, and soft deletes.
- Filament Resources:
  - [app/Filament/Resources/Books/BookResource.php](app/Filament/Resources/Books/BookResource.php)
  - [app/Filament/Resources/Categories/CategoryResource.php](app/Filament/Resources/Categories/CategoryResource.php)
- Notable admin behavior:
  - Books form supports image upload for `coverImage` into `books/covers` and category relation select.
  - Books table includes `TrashedFilter` and restore/force delete bulk actions.
  - Category CRUD is available; soft-delete column is visible in the table.

## Data & Runtime Defaults
- Default `.env` uses `DB_CONNECTION=sqlite` in [.env.example](.env.example).
- Queue/session/cache default to `database` drivers in [.env.example](.env.example), so migrations are required before normal runtime.
- Testing uses in-memory SQLite via [phpunit.xml](phpunit.xml) (`DB_DATABASE=:memory:`), independent from local `.env` DB.

## Developer Workflows (use these first)
- Initial setup: `composer run setup`
  - Installs PHP/Node deps, creates `.env`, generates key, runs migrations, builds frontend.
- Daily development: `composer run dev`
  - Runs `php artisan serve`, `php artisan queue:listen`, `php artisan pail`, and `npm run dev` concurrently.
- Run tests: `composer run test` (clears config first, then runs `php artisan test`).

## Project Conventions to Follow
- Prefer Laravel defaults and keep changes minimal/surgical.
- When adding admin CRUD/features, implement them as Filament Resources/Pages/Widgets under `app/Filament/*` so auto-discovery picks them up.
- Keep provider-based configuration centralized (e.g., admin panel behavior in [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php)).
- If you introduce queue/session/cache-dependent behavior, ensure corresponding DB tables/migrations are present and migrated.
- Keep naming consistency in existing schema/API where fields currently use camelCase in DB columns (`authorName`, `publishedYear`, `coverImage`).

## Integration Notes
- Filament assets are managed via composer hooks (`post-autoload-dump` runs `php artisan filament:upgrade`; `post-update-cmd` publishes assets) in [composer.json](composer.json).
- Frontend bootstrap is minimal (`resources/js/app.js` imports `resources/js/bootstrap.js` with Axios setup); avoid adding heavy frontend architecture unless explicitly requested.

## Practical Guidance for AI Agents
- If a feature request mentions “admin panel”, start from Filament classes and panel config, not `routes/web.php` controllers.
- If auth-related behavior is requested, check `App\Models\User` and Filament auth middleware first.
- For debugging local async behavior, inspect queue and logs from `composer run dev` processes (queue + pail are already included).
- For book/category feature requests, update Eloquent model relations, migrations, and Filament form/table schemas together to avoid admin/runtime drift.
- When adding book media-related features, verify storage path and visibility for files uploaded by `FileUpload`.

## Commenting & Documentation
- Any comments should be written in Indonesian.

## Conventional Commit keeps history clean and readable.

Format:

```type: short description```

Common types:
```feat``` - new feature
```fix``` - bug fix
```docs``` - changes documentation only
```style``` - formatting, no logic change
```refactor``` - code change that neither fixes a bug nor adds a feature
```test``` - adding or fixing tests
```chore``` - tooling, config, maintenance

Example:
```docs: add README```