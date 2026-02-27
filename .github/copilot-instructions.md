# Copilot Instructions for app-perpustakaan-V2

## Project Snapshot
- Stack: Laravel 12 (PHP 8.2+), Filament 5, Vite 7, Tailwind 4.
- This repository is currently a **fresh Laravel + Filament baseline** (minimal domain logic).
- Primary app flows are expected through Filament admin (`/admin`), not through custom web controllers yet.

## Architecture & Entry Points
- HTTP bootstrap is configured in [bootstrap/app.php](bootstrap/app.php) with web routes from [routes/web.php](routes/web.php).
- Service providers are registered in [bootstrap/providers.php](bootstrap/providers.php), including [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php).
- Filament panel details:
  - panel id: `admin`, path: `/admin`, auth enabled via `->login()`.
  - resource/page/widget auto-discovery expects:
    - `app/Filament/Resources`
    - `app/Filament/Pages`
    - `app/Filament/Widgets`
- Public web route currently only returns the default welcome page (`/`) in [routes/web.php](routes/web.php).

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
- Prefer Laravel defaults and keep changes minimal/surgical; this codebase is still scaffold-level.
- When adding admin CRUD/features, implement them as Filament Resources/Pages/Widgets under `app/Filament/*` so auto-discovery picks them up.
- Keep provider-based configuration centralized (e.g., admin panel behavior in [app/Providers/Filament/AdminPanelProvider.php](app/Providers/Filament/AdminPanelProvider.php)).
- If you introduce queue/session/cache-dependent behavior, ensure corresponding DB tables/migrations are present and migrated.

## Integration Notes
- Filament assets are managed via composer hooks (`post-autoload-dump` runs `php artisan filament:upgrade`; `post-update-cmd` publishes assets) in [composer.json](composer.json).
- Frontend bootstrap is minimal (`resources/js/app.js` imports `resources/js/bootstrap.js` with Axios setup); avoid adding heavy frontend architecture unless explicitly requested.

## Practical Guidance for AI Agents
- If a feature request mentions “admin panel”, start from Filament classes and panel config, not `routes/web.php` controllers.
- If auth-related behavior is requested, check `App\Models\User` and Filament auth middleware first.
- For debugging local async behavior, inspect queue and logs from `composer run dev` processes (queue + pail are already included).

## Commenting & Documentation
Any comments should be written in Indonesian

Commit Message Convention

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