# Copilot Instructions for app-perpustakaan-V2

## Overview
This is a Laravel 12 library management application with two interfaces:
- Admin dashboard (Filament, authenticated) for managing books and categories
- Public portal (guest-accessible) for browsing, filtering, and reading book details

## Core Stack
- Backend: Laravel 12
- Admin panel: Filament 5
- Frontend: Blade + Tailwind + Vite
- Database: MySQL/MariaDB with Laravel migrations
- Testing: PHPUnit via `php artisan test`

## Important Project Conventions
- Write all source code comments in English.
- Keep route names for public pages under the `public.*` namespace.
- Public portal layout component is `x-layouts.public-portal` and maps to `resources/views/components/layouts/public-portal.blade.php`.
- Books and categories use slug generation in model lifecycle hooks and keep slug uniqueness even across soft-deleted records.
- `Book` uses slug route binding (`getRouteKeyName(): slug`).
- Prefer preserving existing naming style in DB/model fields (`authorName`, `publishedYear`, `coverImage`, `ISBN`).

## Current Public Routes
Defined in `routes/web.php`:
- `GET /` -> `PublicHomeController@index` as `public.home`
- `GET /books` -> `PublicBookController@index` as `public.books.index`
- `GET /books/{book}` -> `PublicBookController@show` as `public.books.show`
- `GET /about` -> `PublicHomeController@about` as `public.about`

## Public Portal Behavior (Current)
`PublicBookController@index` currently supports:
- Search (`search`) across `title`, `authorName`, `ISBN`
- Category filter (`category`) with strict integer validation
- Sort (`sort`) with allowed values:
	- `latest`, `oldest`
	- `title_asc`, `title_desc`
	- `year_desc`, `year_asc`
- Pagination size: 12 items with query string persistence

`PublicBookController@show`:
- Uses route model binding (slug)
- Loads category and up to 4 related books from same category

## Data Model Notes
### Category
- Table: `categories`
- Key fields: `name`, `slug`, soft deletes
- Relation: has many books

### Book
- Table: `books`
- Key fields: `title`, `authorName`, `ISBN`, `publishedYear`, `coverImage`, `category_id`, `slug`, soft deletes
- Relation: belongs to category
- Slug is auto-generated on save and used as route key

## Filament Admin Structure
Admin panel is configured in `app/Providers/Filament/AdminPanelProvider.php`:
- Panel path: `/admin`
- Authentication: enabled via Filament auth middleware
- Resources are auto-discovered from `app/Filament/Resources`

Resource organization:
- Books: `app/Filament/Resources/Books/...`
- Categories: `app/Filament/Resources/Categories/...`
- Pattern uses separate Form/Table schema classes and Page classes

## Testing Guidance
- Run all tests: `php artisan test`
- Public portal tests are in `tests/Feature/PublicPortalTest.php`
- For feature tests touching book/category queries, use `RefreshDatabase`.
- Verify route naming and response contracts when changing public controllers/views.

## Agent Workflow Recommendations
- Before editing, inspect related controller + model + view + test files to avoid behavior regression.
- If changing public filtering/sorting/query logic, update or add feature tests in `PublicPortalTest`.
- Keep slugs stable and unique logic intact when touching `Book` or `Category` models.
- Do not remove soft delete behavior unless explicitly requested.
- Keep changes scoped; avoid unrelated refactors.

## Commenting & Documentation
- All comments in source codes should be written in English.

## Conventional Commit Format
Format: `type: description`

Allowed types:
- `feat` - new feature
- `fix` - bug fix
- `docs` - documentation
- `style` - formatting
- `refactor` - code reorganization
- `test` - tests
- `chore` - maintenance

Example: `docs | expand copilot instructions with current routes and model conventions`
