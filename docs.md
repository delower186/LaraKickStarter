# LaraKickStarter Documentation

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel)](https://laravel.com/)  
[![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php)](https://www.php.net/)  
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)  

## Table of Contents

1. [Overview](#overview)
2. [Technology Stack](#technology-stack)
3. [Installation](#installation)
4. [Project Structure](#project-structure)
5. [Database Schema](#database-schema)
6. [API Endpoints](#api-endpoints)
7. [Livewire Components](#livewire-components)
8. [Permission System](#permission-system)
9. [Configuration Management](#configuration-management)
10. [Authentication](#authentication)
11. [Testing](#testing)
12. [Development Scripts](#development-scripts)

---

## ✨ Features

- ⚡️ Laravel **12.x** ready  
- 🔑 Authentication (Login, Register, Password Reset, Email Verification)  
- 🛡️ Role & Permission Management (using [spatie/laravel-permission](https://github.com/spatie/laravel-permission))  
- 🎨 TailwindCSS + Alpine.js frontend setup  
- 📦 Pre-configured with **Vite** for assets  
- 🧪 Testing setup with PHPUnit & Pest  
- 🔐 API-ready with Sanctum authentication  
- 📂 Modular & scalable folder structure  
- 🌍 Multi-language support (i18n ready)  
- 📨 Notifications & Mail setup
- 🤖 Google reCAPTCHA v3 on login & registration  

---

## Overview

LaraKickStarter is a Laravel-based starter kit for Livewire applications. It provides a complete CMS (Content Management System) with role-based permissions, user management, blog management, and site configuration capabilities. This application uses modern Laravel features including Livewire, Flux UI components, and Spatie's permission package.

---

## Technology Stack

### Backend Dependencies (composer.json)

| Package | Version | Purpose |
|---------|---------|---------|
| PHP | ^8.2 | Runtime environment |
| Laravel Framework | ^12.0 | Web application framework |
| Laravel Sanctum | ^4.0 | API authentication |
| Livewire Volt | ^1.6.7 | Single-file Livewire components |
| Livewire Flux | ^2.0 | UI component library |
| Spatie Laravel Permission | ^6.16 | Role and permission management |
| Livewire Alert | ^4.0 | SweetAlert2 notifications |

---

### Frontend Dependencies (package.json)

| Package | Version | Purpose |
|---------|---------|---------|
| Vite | ^6.0 | Asset bundling |
| TailwindCSS | ^4.0.7 | CSS framework |
| Axios | ^1.7.4 | HTTP client |
| SweetAlert2 | ^11.17.2 | Alert dialogs |

---

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm
- Database (MySQL, PostgreSQL, or SQLite)

### Installation Steps

```bash
# 1. Clone the repository
git clone https://github.com/delower186/LaraKickStarter.git

cd LaraKickStarter

# 2. Install dependencies
composer install
npm install && npm run dev

# 3. Copy environment file
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Connect MySQL database
change DB_CONNECTION=sqlite to DB_CONNECTION=mysql
uncomment:
#DB_HOST=127.0.0.1
#DB_PORT=3306
#DB_DATABASE=
#DB_USERNAME=
#DB_PASSWORD=

add database credential


# 5. Run migrations
php artisan migrate --seed

# 6. Start the server
php artisan serve
```

---

## 📖 Usage

- Visit [http://localhost:8000](http://localhost:8000) for the main application.  

- Default login credentials (from seeders):
  - **Super Admin:** `super@super.com / password`  
  - **Admin:** `admin@admin.com / password`  
  - **User:** `user@user.com / password`


### 🔐 reCAPTCHA Setup  

Please add the following lines to your `.env` file and fill them with your Google reCAPTCHA v3 keys to enable bot protection on login & registration forms:

```dotenv
RECAPTCHA_PUBLIC_KEY=
RECAPTCHA_SECRET_KEY=
```

### 🔐 TinyMCE Editor Setup  

Please add the following lines to your `.env` file and fill them with your TinyMCE API Key to enable TinyMCE editor on blog Create & Edit forms:

```dotenv
TINYMCE_API_KEY=
```
---

### Environment Configuration (.env)

```env
APP_NAME=LaraKickStarter
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Cache Configuration
CACHE_STORE=database
```

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── API/V1/
│   │       ├── AuthController.php      # Authentication endpoints
│   │       ├── BlogController.php      # Blog CRUD (stub)
│   │       ├── CategoryController.php  # Category CRUD
│   │       └── UserController.php      # User CRUD
│   └── Requests/
│       ├── Auth/
│       │   ├── LoginRequest.php
│       │   └── RegisterRequest.php
│       ├── Categories/
│       │   ├── CategoryStoreRequest.php
│       │   └── CategoryUpdateRequest.php
│       └── Users/
│           └── UserUpdateRequest.php
├── Livewire/
│   ├── Actions/
│   │   └── Logout.php
│   ├── Blogs/
│   │   ├── Blogs.php                  # Blog listing
│   │   ├── Create.php                 # Blog creation
│   │   └── Edit.php                   # Blog editing
│   ├── Categories/
│   │   ├── Categories.php           # Category listing
│   │   ├── Create.php                 # Category creation
│   │   └── Edit.php                   # Category editing
│   ├── Configuraton/
│   │   └── Configuration.php            # Site configuration
│   ├── Permissions/
│   │   ├── Permissions.php            # Permission listing
│   │   ├── Create.php                 # Permission creation
│   │   └── Edit.php                   # Permission editing
│   ├── Roles/
│   │   ├── Roles.php                  # Role listing
│   │   ├── Create.php                 # Role creation
│   │   └── Edit.php                   # Role editing
│   └── Users/
│       ├── Users.php                  # User listing
│       └── Edit.php                   # User editing
├── Models/
│   ├── Blog.php
│   ├── Category.php
│   ├── Configuration.php
│   ├── Setting.php
│   └── User.php
├── Policies/
│   └── BlogPolicy.php
└── Tools/
    ├── Helpers.php                      # Utility helpers
    ├── Permission.php                   # Permission formatter
    └── Response.php                     # API response formatter
```

## Database Schema

### Users Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| name | string | User's full name |
| email | string (unique) | User's email |
| email_verified_at | timestamp (nullable) | Email verification timestamp |
| password | string | Hashed password |
| status | enum(0,1) | Active (1) / Inactive (0) |
| remember_token | string (nullable) | Remember me token |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

---

### Blogs Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Author reference |
| category_id | bigint (FK) | Category reference |
| title | string | Blog title |
| content | longText | Blog content |
| image | string (nullable) | Featured image path |
| status | enum(0,1) | Draft (0) / Published (1) |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

---

### Categories Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| user_id | bigint (FK) | Creator reference |
| title | string | Category name |
| status | enum(0,1) | Inactive (0) / Active (1) |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

---

### Configurations Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| site_name | string | Website name |
| logo | string | Logo file path |
| favicon | string | Favicon file path |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

---

### Settings Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint (PK) | Primary key |
| key | string | Setting key |
| value | string | Setting value |
| created_at | timestamp | Record creation time |
| updated_at | timestamp | Record update time |

---

## API Endpoints

### Authentication

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/register` | Register new user | No |
| POST | `/api/login` | Login and get token | No |
| POST | `/api/logout` | Invalidate token | Yes |
| GET | `/api/user` | Get authenticated user | Yes |

---

### Users

| Method | Endpoint | Description | Auth Required | Permission |
|--------|----------|-------------|---------------|------------|
| GET | `/api/users` | List users (paginated) | Yes | view.user |
| GET | `/api/users/{id}` | Get specific user | Yes | view.user |
| PUT | `/api/users/{id}` | Update user | Yes | update.user |
| DELETE | `/api/users/{id}` | Delete user | Yes | delete.user |

---

### Categories

| Method | Endpoint | Description | Auth Required | Permission |
|--------|----------|-------------|---------------|------------|
| GET | `/api/categories` | List categories (paginated) | Yes | view.category |
| POST | `/api/categories` | Create category | Yes | create.category |
| GET | `/api/categories/{id}` | Get specific category | Yes | view.category |
| PUT | `/api/categories/{id}` | Update category | Yes | update.category |
| DELETE | `/api/categories/{id}` | Delete category | Yes | delete.category |

---

### Blogs

| Method | Endpoint | Description | Auth Required | Permission |
|--------|----------|-------------|---------------|------------|
| GET | `/api/blogs` | List blogs (paginated) | Yes | view.blog |
| POST | `/api/blogs` | Create blog | Yes | create.blog |
| GET | `/api/blogs/{id}` | Get specific blog | Yes | view.blog |
| PUT | `/api/blogs/{id}` | Update blog | Yes | update.blog |
| DELETE | `/api/blogs/{id}` | Delete blog | Yes | delete.blog |

---

## Livewire Components

### Blogs

**Route:** `/dashboard/blogs`

Features:
- List blogs with search functionality
- Create, edit, and delete blogs
- Image upload support (JPG, PNG)
- TinyMCE rich text editor integration
- Status management (Draft/Published)
- Confirmation dialogs for delete actions

---

### Categories

**Route:** `/dashboard/categories`

Features:
- List categories with search functionality
- Create, edit, and delete categories
- Status management

---

### Roles

**Route:** `/dashboard/roles`

Features:
- List roles with search functionality
- Create roles with multiple permissions
- Edit roles and sync permissions
- Super Admin role has special handling (all permissions)

---

### Permissions

**Route:** `/dashboard/permissions`

Features:
- List permissions with search functionality
- Delete permissions
- Based on Spatie Permission package

---

### Configuration

**Route:** `/dashboard/configuration`

Features:
- Update site name
- Upload site logo (JPG, PNG)
- Upload favicon (ICO format)

---

### Users

**Route:** `/dashboard/users`

Features:
- List users with search functionality
- Edit user details
- Delete users

---

## Permission System

### Resources and Permissions

The application uses a permission format: `{resource}.{action}`

**Available Resources:**
- `blog`
- `category`
- `user`
- `role`
- `permission`
- `configuration`

**Available Actions:**
- `view` - View/list resources
- `create` - Create new resources
- `edit` / `update` - Edit existing resources
- `delete` - Delete resources

---

### Permission Helper Class

Located at `App\Tools\Permission.php`:

```php
// Usage examples:
Permission::format('view', 'blog')    // Returns: "blog.view"
Permission::format('create', 'user')  // Returns: "user.create"
Permission::format('edit', 'role')    // Returns: "role.edit"
```

---

### Authorization in Livewire

```php
// Check permission in component:
$this->authorize(Permission::format('view', 'blog'), Blog::class);

// Check permission in Blade views:
@can($permission->format('view', 'blog'))
    // Show content
@endcan
```

---

## Configuration Management

### Helper Functions

Located at `App\Tools\Helpers.php`:

```php
// Format string:
Helpers::format('Blog Title', '-')  // Returns: "blog-title"

// Get configuration value:
Helpers::getValue('site_name', 'Default Name')
```

---

### File Storage

The application uses a custom `uploads` disk for image storage:

```
storage/
└── app/
    └── public/
        └── uploads/
            ├── images/
            │   ├── blog/    # Blog images
            │   └── logo/    # Site logo
```

---

## Authentication

### Features

- Login/logout functionality
- Registration
- Password reset
- Email verification
- API token authentication via Sanctum
- Session-based web authentication

---

### Routes

| Route | Description |
|-------|-------------|
| `/login` | Login page |
| `/register` | Registration page |
| `/forgot-password` | Password reset request |
| `/reset-password/{token}` | Password reset form |
| `/verify-email` | Email verification |
| `/confirm-password` | Password confirmation |

---

## Testing

Test files are located in the `tests/` directory:

### Feature Tests

| Test File | Description |
|-----------|-------------|
| `Auth/AuthenticationTest.php` | Login/logout tests |
| `Auth/RegistrationTest.php` | User registration tests |
| `Auth/PasswordResetTest.php` | Password reset tests |
| `Auth/PasswordConfirmationTest.php` | Password confirmation tests |
| `Auth/EmailVerificationTest.php` | Email verification tests |
| `DashboardTest.php` | Dashboard access tests |
| `Settings/ProfileUpdateTest.php` | Profile update tests |
| `Settings/PasswordUpdateTest.php` | Password change tests |

---

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/Auth/AuthenticationTest.php

# Run with Pest
./vendor/bin/pest
```

---

## Development Scripts

### Available npm Scripts

```json
{
    "build": "vite build",
    "dev": "vite"
}
```

---

### Available Composer Scripts

```bash
# Development server with queue listener
composer dev

# Run migrations
php artisan migrate

# Run tests
php artisan test
```

---

## Middleware Groups

### Web Routes Middleware

```php
Route::middleware(['auth', 'verified'])->group(function () {
    // Protected routes requiring authentication and email verification
    Route::get('/dashboard', 'dashboard');
    // ... other dashboard routes
});
```

---

### API Routes Middleware

```php
Route::middleware('auth:sanctum')->group(function () {
    // Protected API routes
});
```

---

## Blade Components

### Layout Components

- `layouts.app` - Main application layout with sidebar
- `layouts.auth` - Authentication layout
- `components.settings.layout` - Settings page layout

---

### Flux Components Used

- `flux:button` - Styled buttons
- `flux:input` - Form inputs
- `flux:select` - Select dropdowns
- `flux:badge` - Status badges
- `flux:navlist` - Navigation lists
- `flux:modal` - Modal dialogs
- `flux:dropdown` - Dropdown menus

---

## License

This project is based on Laravel Livewire Starter Kit and is licensed under the MIT License.

## Notes

- Blog API controller methods are currently stub implementations
- TinyMCE integration requires an API key in `config/services.php`
- The application uses Livewire Alerts for user notifications
- Super Admin role cannot be deleted or edited through the UI