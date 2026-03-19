## Plan: Public Portal MVP

Build a complete guest-facing portal in English with 4 pages: home, book catalog, book detail, and about/contact. Reuse existing Book/Category data and relationships, show only non-soft-deleted books, and keep reading behavior as metadata preview only (no PDF reader/download yet).

**Steps**
1. Phase 1: Foundation and routing  
1. Add public routes in [routes/web.php](routes/web.php) for `/`, `/books`, `/books/{book}`, `/about` with stable names like `public.home`, `public.books.index`, `public.books.show`, `public.about`.  
2. Create public controllers (for home and books) under [app/Http/Controllers](app/Http/Controllers) to separate landing logic from catalog/detail logic.  
3. Create a dedicated public layout and reusable nav/footer components in [resources/views/layouts](resources/views/layouts) and [resources/views/components](resources/views/components).  
Dependency note: steps 2 and 3 can run in parallel after route design is fixed.

2. Phase 2: Query behavior and page data  
1. Implement catalog query in books index:
1. Base query loads category relation and excludes soft-deleted records by default.
2. Add search across title, author, ISBN; category filter; and basic sort.
3. Add pagination with query-string persistence.
2. Implement detail query in books show:
1. Use route model binding for non-soft-deleted books.
2. Eager-load category.
3. Add related books section from same category.
3. Implement home query:
1. Recent books block.
2. Lightweight stats (books count, categories count).
3. CTA to catalog.

3. Phase 3: Public views (English UI)  
1. Refactor [resources/views/welcome.blade.php](resources/views/welcome.blade.php) into the public home page using the new public layout.  
2. Create catalog view in [resources/views](resources/views) with search/filter/sort/pagination and empty state.  
3. Create detail view in [resources/views](resources/views) showing full metadata plus placeholder “Read” area.  
4. Create about/contact static page in [resources/views](resources/views).

4. Phase 4: UX consistency and hardening  
1. Ensure desktop/mobile nav is usable and consistent.  
2. Keep visual style aligned with current brand color direction while making it feel like a real portal, not a one-page landing.  
3. Validate and sanitize query params for search/filter/sort.  
4. Confirm all user-facing text is English.

5. Phase 5: Testing and QA  
1. Add feature tests for:
1. Home/catalog/detail/about return expected status.
2. Catalog search/filter behavior.
3. Soft-deleted books return 404 on detail page.
2. Add missing factories for Book and Category (project currently has only User factory).  
3. Run targeted and full test suites.  
4. Do manual desktop/mobile verification for nav, empty states, pagination, and deep-link detail pages.

**Relevant files**
- [routes/web.php](routes/web.php) — add public route map and names.
- [app/Models/Book.php](app/Models/Book.php) — source of fields/relations for listing and detail.
- [app/Models/Category.php](app/Models/Category.php) — source for filter options and counts.
- [resources/views/welcome.blade.php](resources/views/welcome.blade.php) — convert to full home portal.
- [resources/views/layouts/focus.blade.php](resources/views/layouts/focus.blade.php) — baseline layout reference.
- [resources/css/app.css](resources/css/app.css) — public portal styling updates.
- [app/Filament/Resources/Books/Tables/BooksTable.php](app/Filament/Resources/Books/Tables/BooksTable.php) — reference searchable/sortable field patterns.
- [app/Filament/Resources/Books/Schemas/BookForm.php](app/Filament/Resources/Books/Schemas/BookForm.php) — canonical field set reference.
- [database/factories/UserFactory.php](database/factories/UserFactory.php) — pattern for creating Book/Category factories.
- [tests/Feature/ExampleTest.php](tests/Feature/ExampleTest.php) — starting point for public feature tests.

**Verification**
1. Check route registration with route list command (all `public.*` routes present).
2. Run targeted public feature tests.
3. Run full test suite to catch regressions.
4. Manual QA on desktop and mobile:
1. Home shows recent books and stats.
2. Catalog search/filter/sort/pagination works with persistent query strings.
3. Detail page shows metadata and blocks soft-deleted records.
4. About page accessible from nav.

**Decisions**
- Included:
1. Home, catalog, detail, about/contact.
2. Metadata-only read experience.
3. Show all non-soft-deleted books publicly.
4. English UI.
- Excluded for this MVP:
1. Public auth, bookmarking, rating/reviews.
2. New DB publish/featured fields.
3. PDF reader/download and external search engine.

I also saved this plan to session memory at /memories/session/plan.md for handoff continuity. If you want, I can refine this into a “Phase 1 only” quick-delivery variant next.
