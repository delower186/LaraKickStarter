# 🚀 LaraKickStarter  

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel)](https://laravel.com/)  
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php)](https://www.php.net/)  
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)  

LaraKickStarter is a modern **Laravel starter kit** designed to help developers quickly bootstrap new projects with best practices, clean architecture, and pre-configured features.  

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

## 📦 Installation

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

---

### 🔐 reCAPTCHA Setup  

Please add the following lines to your `.env` file and fill them with your Google reCAPTCHA v3 keys to enable bot protection on login & registration forms:

```dotenv
RECAPTCHA_PUBLIC_KEY=
RECAPTCHA_SECRET_KEY=
```
