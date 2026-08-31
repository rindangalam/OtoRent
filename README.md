# OtoRent 🚗

> **Modern car rental management system built with Laravel 12**  
> Complete business workflow from vehicle catalog, booking, payment, to fleet management with multi-role access control.

[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind%20CSS-3-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)](https://tailwindcss.com/)
[![SQLite](https://img.shields.io/badge/SQLite-Default-003B57?style=flat-square&logo=sqlite&logoColor=white)](https://www.sqlite.org/)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

---

## 📋 Overview

**OtoRent** is a comprehensive web-based car rental management system built with **Laravel 12**. It handles the entire rental business workflow — from vehicle catalog, bookings, payments, to fleet management, driver scheduling, and service history — with three user roles: **Admin**, **Staff**, and **Customer**.

### Key Features
- Complete rental workflow automation
- Multi-role access control (Admin, Staff, Customer)
- Real-time booking and payment management
- Vehicle scheduling and driver assignment
- Service history tracking

---

## ✨ Features

### 🏠 Public Pages
- Landing page with WebGL hero animation
- Vehicle catalog with filtering (SUV, MPV, Sedan, etc.) and price sorting
- Detailed vehicle information pages
- Services & contact page with contact form

### 👤 Customer Portal
- Dashboard with booking summary
- Vehicle booking (create, history, details)
- Payment processing
- Profile management

### 🛠️ Admin & Staff Dashboard
- Business overview dashboard
- **Vehicle Management** (CRUD operations)
- **Driver Management** (CRUD operations)
- **Scheduling** (vehicle assignment)
- **Booking Management** (view, update status)
- **Payment Verification** (approve/reject)
- **Service History** tracking
- **Reports** generation

---

## 🧰 Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | PHP 8.2+, Laravel 12 |
| **Frontend** | Blade Templates, Tailwind CSS 3, Alpine.js, Vite |
| **Database** | SQLite (default) / MySQL |
| **Queue & Cache** | Database driver (default) |
| **Authentication** | Laravel Breeze |

---

## 📋 Requirements

- **PHP** >= 8.2
- **Composer**
- **Node.js** & npm (for frontend assets)

---

## 🚀 Installation

### Quick Setup

```bash
# 1. Clone repository
git clone https://github.com/rindangalam/OtoRent.git
cd OtoRent

# 2. Run automated setup (installs dependencies, generates key, links storage, builds assets)
composer run setup

# 3. Run migrations with demo data
php artisan migrate --seed
```

### Manual Setup

```bash
# 1. Clone repository
git clone https://github.com/rindangalam/OtoRent.git
cd OtoRent

# 2. Install PHP dependencies
composer install

# 3. Setup environment
copy .env.example .env        # Windows
# cp .env.example .env        # Linux / macOS

# 4. Generate application key
php artisan key:generate

# 5. Create SQLite database (if using SQLite)
# Create file: database/database.sqlite

# 6. Link storage
php artisan storage:link

# 7. Run migrations with seeders
php artisan migrate --seed

# 8. Install & build frontend assets
npm install
npm run build
```

---

## 👥 Demo Accounts

After running seeders, use these demo accounts (password: `password`):

| Role | Email | Access Level |
|------|-------|--------------|
| **Admin** | `admin@otorent.com` | Full system access |
| **Staff** | `staff@otorent.com` | Operations management |
| **Customer** | `andi@example.com` | Booking & payments |

---

## ▶️ Running the Application

### Development Mode (All-in-One)

```bash
composer run dev
```

This command concurrently runs:
- Laravel development server (`http://localhost:8000`)
- Queue worker (background jobs)
- Vite dev server (hot module replacement)

### Manual Mode

```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Queue worker
php artisan queue:listen

# Terminal 3: Vite dev server
npm run dev
```

Open browser at: `http://localhost:8000`

---

## 📁 Project Structure

```
OtoRent/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Application controllers
│   │   └── Middleware/      # Custom middleware
│   ├── Models/              # Eloquent models
│   └── Providers/           # Service providers
├── database/
│   ├── factories/           # Model factories
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Stylesheets
│   └── js/                  # JavaScript files
├── routes/
│   ├── web.php              # Web routes
│   └── api.php              # API routes
├── public/                  # Public assets
├── storage/                 # Logs, cache, uploads
└── tests/                   # PHPUnit tests
```

---

## 🗄️ Database Schema

### Key Tables
- `users` - User accounts (Admin, Staff, Customer)
- `vehicles` - Vehicle master data
- `drivers` - Driver information
- `bookings` - Rental bookings
- `payments` - Payment transactions
- `schedules` - Vehicle scheduling
- `services` - Vehicle service history

---

## 🧪 Testing

```bash
# Run all tests
composer run test

# Or directly
php artisan test

# Run specific test
php artisan test --filter=BookingTest
```

---

## 🔐 Security Features

- **Role-based access control** with middleware
- **CSRF protection** on all forms
- **Password hashing** with bcrypt
- **SQL injection prevention** via Eloquent ORM
- **XSS protection** with Blade escaping
- **Secure file uploads** with validation

---

## 📊 Business Workflow

### Customer Booking Flow
1. Customer browses vehicle catalog
2. Selects vehicle and date range
3. Creates booking (pending status)
4. Makes payment
5. Admin/Staff verifies payment
6. Booking confirmed → Vehicle assigned

### Admin Management Flow
1. Manages vehicle fleet (add, edit, deactivate)
2. Assigns drivers to bookings
3. Verifies customer payments
4. Updates booking status (confirmed, ongoing, completed)
5. Records vehicle service history
6. Generates business reports

---

## 🎨 UI/UX Features

- **Responsive design** (mobile, tablet, desktop)
- **WebGL hero animation** on landing page
- **Real-time search & filtering**
- **Toast notifications** for user feedback
- **Loading states** on async operations
- **Dark mode ready** (Tailwind CSS)

---

## 🚀 Deployment

### Production Build

```bash
# Build frontend assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set environment to production
# Edit .env: APP_ENV=production, APP_DEBUG=false
```

### Recommended Hosting
- **Shared Hosting**: Use SQLite database
- **VPS/Cloud**: MySQL/PostgreSQL + Redis for cache
- **Platform-as-Service**: Laravel Forge, Ploi, Heroku

---

## 🛠️ Development Commands

```bash
composer run dev       # Start dev server with queue & Vite
composer run setup     # Automated setup (install, key, storage link, build)
composer run test      # Run PHPUnit tests
composer run logs      # Tail application logs with Pail
```

---

## 📝 API Endpoints (Optional)

The application is primarily web-based, but you can extend it with API endpoints in `routes/api.php` for:
- Mobile app integration
- Third-party integrations
- Webhook handlers

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

## 👤 Author

**Rindang Alam Nur Muhammad**  
GitHub: [@rindangalam](https://github.com/rindangalam)

---

## 🙏 Acknowledgments

Built with:
- [Laravel](https://laravel.com/) - PHP web framework
- [Tailwind CSS](https://tailwindcss.com/) - Utility-first CSS framework
- [Alpine.js](https://alpinejs.dev/) - Lightweight JavaScript framework
- [Vite](https://vitejs.dev/) - Next generation frontend tooling

---

## 📧 Support

For issues or questions, please open an issue on [GitHub Issues](https://github.com/rindangalam/OtoRent/issues).
