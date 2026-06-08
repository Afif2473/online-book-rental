# Online Book Store Renting System - Phase 1 Architecture Document

[cite_start]**Author:** Afif [cite: 2]
[cite_start]**Mentor:** Hakiim [cite: 2]
**Date:** April 2026
**Status:** In Development (Phase 1 Complete)

## 1. Project Overview
[cite_start]The Online Book Store Renting System is designed to assist students in renting books for study and research[cite: 18]. [cite_start]The system allows administrators to manage the book catalog and handle rental requests, while students can browse available books and track their rentals[cite: 16, 18, 19]. [cite_start]The core objective of this project is to build strong fundamentals in system architecture, database design, and independent development without reliance on AI agents[cite: 7, 8, 9].

## 2. Technology Stack
* [cite_start]**Backend:** Laravel PHP (v13.3) [cite: 12]
* [cite_start]**Frontend:** Laravel Blade [cite: 11] + Bootstrap 5 (via CDN)
* [cite_start]**Database:** MySQL (v8.4) [cite: 13]
* **Environment:** Docker (Laravel Sail), PHP 8.4

## 3. Database Architecture & Schema
The system utilizes a relational database architecture with a unified users table to handle role-based access control, preventing data duplication.

### 3.1 Entity Relationship Model
* **One-to-Many:** `User` has many `Rentals`
* **One-to-Many:** `Book` has many `Rentals`
* **Bridge Entity:** `Rental` belongs to a `User` and a `Book`

### 3.2 Table Definitions

**`users` Table** (Unified Admin & Student records)
| Column | Type | Constraints / Modifiers |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key, Auto Increment |
| `name` | String | Required |
| `email` | String | Required, Unique |
| `password` | String | Required, Hashed |
| `matric_no` | String | Unique, Nullable (For Students) |
| `staff_no` | String | Unique, Nullable (For Admins) |
| `role` | String | Default: 'student' |
| `timestamps`| Timestamp | created_at, updated_at |

**`books` Table** (Catalog Management)
| Column | Type | Constraints / Modifiers |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key, Auto Increment |
| `title` | String | Required |
| `author` | String | Required |
| `isbn` | String | Required, Unique |
| `quantity` | Integer | Required, Default: 1 |
| `timestamps`| Timestamp | created_at, updated_at |

**`rentals` Table** (Transaction Tracking)
| Column | Type | Constraints / Modifiers |
| :--- | :--- | :--- |
| `id` | BigInt | Primary Key, Auto Increment |
| `user_id` | BigInt | Foreign Key (users.id), Cascade Delete |
| `book_id` | BigInt | Foreign Key (books.id), Cascade Delete |
| `status` | String | Default: 'pending' |
| `rented_at` | Timestamp | Nullable |
| `expires_at`| Date | Required |
| `timestamps`| Timestamp | created_at, updated_at |

## 4. Application Logic Layer

### 4.1 Eloquent Models & Security
All models are strictly protected against mass-assignment vulnerabilities utilizing PHP Attributes:
* `User`: `#[Fillable(['name', 'email', 'password', 'matric_no', 'staff_no', 'role'])]`
* `Book`: `#[Fillable(['title', 'author', 'isbn', 'quantity'])]`
* `Rental`: `#[Fillable(['user_id', 'book_id', 'status', 'rented_at', 'expires_at'])]`

### 4.2 Routing & Controllers
The system utilizes standard RESTful architecture via Laravel's Resource routing.
* **Endpoint:** `/books`
* **Controller:** `BookController`
* **Implemented Methods:**
  * `index()`: Retrieves all `Book::all()` records and returns the catalog view.
  * `create()`: Returns the new book submission form.
  * `store(Request $request)`: Validates input (including `unique:books,isbn` constraint) and executes `Book::create()`.

## 5. Frontend Architecture
The presentation layer is built on Laravel Blade components utilizing a Master Layout pattern to ensure DRY (Don't Repeat Yourself) principles.
* **`layout.blade.php`**: The master wrapper containing the HTML skeleton, meta tags, and Bootstrap 5 CDN assets.
* **`books/index.blade.php`**: The catalog view utilizing a dynamic Bootstrap table (`table-striped`, `table-hover`) and Blade's `@forelse` directive to handle empty states gracefully.
* **`books/create.blade.php`**: The submission interface featuring CSRF protection (`@csrf`) and Bootstrap form controls.

## 6. Developer Notes & Troubleshooting Log
* **MySQL Authentication:** MySQL 8.4 enforces `caching_sha2_password`. If connecting via local clients without SSL, the Sail MySQL user may need to be altered to `mysql_native_password`.
* **Sail Port Conflicts:** If another Laravel instance is running, Vite will trigger a port allocation error on `5173`. Resolution requires either stopping the conflicting container or mapping a new `VITE_PORT` in the `.env` file.