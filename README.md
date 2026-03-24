# App Perpustakaan V2

> A library management system built with Laravel for educational purposes (ujikom certification exam).

**App Perpustakaan V2** is a full-stack web application that provides two distinct interfaces: a public-facing portal for browsing and reading books, and an admin dashboard for managing the library catalog. Built with Laravel 12, Filament 5.0, and Tailwind CSS.

---

## Table of Contents

- [Features](#features)
- [Architecture](#architecture)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Database Schema](#database-schema)
- [Getting Started](#getting-started)
- [Running Tests](#running-tests)
- [Key Implementation Details](#key-implementation-details)
- [Resources](#resources)

---

## Features

### 🌐 Public Portal
No authentication required. Visitors can:
- **Browse the catalog** — View all available books with full details (title, author, ISBN, cover, publication year)
- **Search** — Find books by title, author name, or ISBN with real-time input validation
- **Filter by category** — Narrow down results by selecting one or more categories
- **Sort results** — Latest added, oldest first, title (A-Z / Z-A), or publication year (newest/oldest)
- **Recent books** — Homepage showcase of the 6 most recently added books
- **Book details page** — Individual book page with complete information
- **About/Contact** — Information page about the library

### 🔐 Admin Dashboard
Authenticated administrators can:
- **Manage books** — Create, read, update, and delete books with soft deletes for data recovery
- **Manage categories** — Create, read, update, and delete book categories
- **Form validation** — Structured form schemas for data input
- **Table views** — List all records with filtering, sorting, and pagination
- Built on [Filament 5.0](https://filamentphp.com/) for fast admin panel development

---

## Architecture

The application separates concerns into two distinct interfaces:

```
┌─────────────────────────────────────────────────────┐
│          App Perpustakaan V2 (Laravel 12)           │
├─────────────────────────────────────────────────────┤
│                                                     │
│  ┌────────────────────┐  ┌──────────────────────┐   │
│  │  Public Portal     │  │  Admin Dashboard     │   │
│  │  (No Auth)         │  │  (Filament + Auth)   │   │
│  │                    │  │                      │   │
│  │ • Browse books     │  │ • CRUD books         │   │
│  │ • Search/Filter    │  │ • CRUD categories    │   │
│  │ • View details     │  │ • Form validation    │   │
│  │ • User-friendly    │  │ • Table management   │   │
│  │                    │  │                      │   │
│  └────────────────────┘  └──────────────────────┘   │
│           │                        │                │
│           └────────────┬───────────┘                │
│                        │                            │
│           ┌────────────▼────────────┐               │
│           │  Shared Models & DB     │               │
│           │  • Book                 │               │
│           │  • Category             │               │
│           │  • User                 │               │
│           └─────────────────────────┘               │
│                                                     │
└─────────────────────────────────────────────────────┘
```

---

## Technology Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| **Backend** | Laravel Framework | 12.x |
| **Admin Panel** | Filament | 5.0 |
| **Admin Theme** | openplain/filament-shadcn-theme | Latest |
| **Frontend** | Blade Templates + Tailwind CSS | Latest |
| **Build Tool** | Vite | Latest |
| **Language** | PHP | 8.2+ |
| **Package Manager** | Composer & npm | Latest |
| **Database** | MySQL/MariaDB (with migrations) | - |
| **Testing** | PHPUnit | 11.5 |

---

## Project Structure

```
app-perpustakaan-V2/
├── app/
│   ├── Http/Controllers/        # Request handlers (PublicBookController, etc.)
│   ├── Models/                  # Eloquent models (User, Book, Category)
│   ├── Filament/
│   │   └── Resources/           # Filament admin resource definitions
│   └── Providers/
├── database/
│   ├── migrations/              # Database schema definitions
│   ├── factories/               # Model factories for testing & seeding
│   └── seeders/                 # Database seeders
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php   # Public portal homepage
│   │   ├── layouts/            # Layout templates
│   │   └── public-portal/      # Portal-specific views
│   ├── js/                     # Frontend JavaScript
│   └── css/                    # Styling (Tailwind)
├── routes/
│   ├── web.php                 # Web routes (public + admin)
│   └── console.php             # CLI commands
├── tests/
│   ├── Feature/                # Feature tests
│   └── Unit/                   # Unit tests
├── config/
│   ├── filament.php            # Filament configuration
│   ├── auth.php                # Authentication settings
│   └── ...                     # Other Laravel configs
├── storage/
│   ├── app/                    # File storage
│   └── logs/                   # Application logs
└── public/
    ├── index.php               # Entry point
    └── storage/                # Publicly accessible files
```

---

## Database Schema

The application uses three main entities with relationships enforced at the database level:

### **Users**
- Standard Laravel authentication table
- Stores admin credentials and authentication tokens
- Fields: `id`, `name`, `email`, `password`, `email_verified_at`, `timestamps`

### **Categories**
- Book categories/classifications
- **Fields**:
  - `id` — Primary key
  - `name` — Category name (e.g., "Drama", "Science", "History")
  - `slug` — URL-friendly identifier, auto-generated from name using `sluggable` trait
  - `timestamps` — `created_at`, `updated_at`
  - `soft_deletes` — Allows deletion recovery

- **Relationships**: One-to-many with Books

### **Books**
- Book catalog entries
- **Fields**:
  - `id` — Primary key
  - `title` — Book title
  - `authorName` — Author full name
  - `ISBN` — International Standard Book Number (unique identifier)
  - `publishedYear` — Publication year (integer)
  - `coverImage` — Image URL or local path
  - `category_id` — Foreign key to Categories (required, with cascading deletes)
  - `slug` — URL-friendly identifier, auto-synced from title using lifecycle hooks
  - `timestamps` — `created_at`, `updated_at`
  - `soft_deletes` — Allows deletion recovery

- **Relationships**: Belongs-to Category

**Entity Relationship Diagram**:
```
Users (1) ──────────┐
                    │
                    └─→ Filament Admin Access
                    
Categories (1) ─────→ (Many) Books
```

---

## Getting Started

### Prerequisites

Ensure you have installed:
- **PHP 8.2+** ([php.net](https://www.php.net/))
- **Node.js** ([nodejs.org](https://nodejs.org))
- **Composer** ([getcomposer.org](https://getcomposer.org))

### Installation

1. **Clone and navigate to the project**
   ```powershell
   git clone https://github.com/Dirga36/app-perpustakaan-V2.git
   cd app-perpustakaan-V2
   ```

2. **Install PHP dependencies**
   ```powershell
   composer install
   ```

3. **Install Node.js dependencies** (optional, included for Vite bundling)
   ```powershell
   npm install
   ```

4. **Create environment configuration**
   ```powershell
   copy .env.example .env
   ```

5. **Generate application key**
   ```powershell
   php artisan key:generate
   ```

6. **Run database migrations**
   ```powershell
   php artisan migrate
   ```

### Running the Application

Open **two separate terminal windows** and run these commands simultaneously:

**Terminal 1 — Start Laravel server** (http://127.0.0.1:8000)
```powershell
php artisan serve
```

**Terminal 2 — Start frontend build watcher** (Vite)
```powershell
npm run dev
```

#### Access the Application

- **Public Portal**: http://127.0.0.1:8000
- **Admin Dashboard**: http://127.0.0.1:8000/admin

### Setting Up Admin Access

1. **Create an admin user account**
   ```powershell
   php artisan make:filament-user
   ```

2. **Follow the prompts** to enter:
   - **Name**: Admin name
   - **Email**: Admin email
   - **Password**: Admin password

3. **Login to the admin panel** at http://127.0.0.1:8000/admin with your credentials

---

## Running Tests

Run the test suite using PHPUnit:

```powershell
php artisan test
```

**Run a specific test file**:
```powershell
php artisan test tests/Feature/PublicPortalTest.php
```

**Run with verbose output**:
```powershell
php artisan test --verbose
```

Tests are located in the `tests/` directory. Use the included factories (`BookFactory`, `CategoryFactory`, `UserFactory`) for seeding test data.

---

## Key Implementation Details

### Slug-Based Routing
- Books and categories use auto-generated **slugs** for SEO-friendly URLs
- Slugs are stored in the database and auto-synced via Eloquent lifecycle hooks (`booted()` method)
- Example: Book titled "The Great Gatsby" → slug: `the-great-gatsby`
- Used in routes: `/books/{book:slug}` instead of `/books/{book:id}`

### Soft Deletes
- All data models support soft deletes using Laravel's `SoftDeletes` trait
- Deleted records are marked with a `deleted_at` timestamp instead of being removed
- Public portal only queries non-deleted records
- Admin dashboard can view and restore deleted items

### Input Validation & Sanitization
- **Search input**: Trimmed of whitespace, limited to 120 characters
- **Category filter**: Validated as integer IDs; invalid selections default to no filtering
- **Sort parameter**: Falls back to 'latest' if invalid sort option provided
- Prevents SQL injection and improves query performance

### Model Relationships & Eager Loading
- Book model uses `belongsTo(Category)` relationship
- Queries use eager loading (`.with('category')`) to prevent N+1 problems
- Category model defines inverse relationship: `hasMany(Book)`

### Filament Resource Architecture
- Admin forms and tables are separated into distinct schema classes (e.g., `BookForm`, `BooksTable`)
- Follows Filament's resource pattern for scalability and maintainability
- Form validation rules defined at resource level

### Comments in Indonesian
- All source code comments and docstrings follow the project language convention (Indonesian)
- Makes the codebase accessible to learners in the target region

---

## Resources

- **GitHub Repository**: [Dirga36/app-perpustakaan-V2](https://github.com/Dirga36/app-perpustakaan-V2)
- **Manual & Documentation**: [Google Doc (Indonesian)](https://docs.google.com/document/d/1zbTdueasjDsAlA2FS-GWjYi6zWRnRQJAeQ5BU_r30gE/edit?usp=sharing)
- **Previous Version**: [app_perpustakaan](https://github.com/Dirga36/app_perpustakaan) — The original project (v1)
- **Official Documentation**:
  - [Laravel Docs](https://laravel.com/docs)
  - [Filament Docs](https://filamentphp.com/docs)
  - [Tailwind CSS Docs](https://tailwindcss.com/docs)

---

## Notes

**Why "V2"?**
This is the second version of the app-perpustakaan project. The first version ([app_perpustakaan](https://github.com/Dirga36/app_perpustakaan)) served as a foundation. V2 was redesigned with a modern architecture using Filament for the admin panel and a cleaner public portal interface.
