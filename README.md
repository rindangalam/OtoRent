<p align="center">
    <a href="https://github.com/rindangalam/OtoRent">
        <img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=flat-square&logo=php&logoColor=white" alt="PHP 8.2">
        <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white" alt="Laravel 12">
        <img src="https://img.shields.io/badge/Tailwind%20CSS-3-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 3">
        <img src="https://img.shields.io/badge/SQLite-Default-003B57?style=flat-square&logo=sqlite&logoColor=white" alt="SQLite">
        <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="MIT License">
    </a>
</p>

# OtoRent 🚗

**OtoRent** adalah sistem manajemen rental mobil berbasis web yang dibangun dengan **Laravel 12**. Aplikasi ini menangani seluruh alur bisnis rental kendaraan — dari katalog kendaraan, pemesanan (booking), pembayaran, hingga manajemen armada, driver, dan jadwal — dengan tiga peran pengguna: **Admin**, **Staff**, dan **Customer**.

## ✨ Fitur

### 🏠 Publik
- Landing page dengan hero animasi WebGL
- Katalog kendaraan dengan filter jenis (SUV, MPV, Sedan, dll.) dan sortir harga
- Halaman detail kendaraan
- Halaman layanan & kontak (form kontak)

### 👤 Customer
- Dashboard ringkasan
- Pemesanan kendaraan (buat, riwayat, detail booking)
- Pembayaran booking
- Pengelolaan profil

### 🛠️ Admin & Staff
- Dashboard ringkasan bisnis
- Manajemen kendaraan (CRUD)
- Manajemen driver (CRUD)
- Penjadwalan kendaraan
- Pengelolaan booking & pembaruan status
- Verifikasi / penolakan pembayaran
- Riwayat service kendaraan
- Laporan

## 🧰 Teknologi

| Lapisan | Teknologi |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | Blade, Tailwind CSS 3, Alpine.js, Vite |
| Database | SQLite (default) / MySQL |
| Queue & Cache | Database driver (default) |

## 📋 Persyaratan

- PHP >= 8.2
- Composer
- Node.js & npm (untuk asset frontend)

## 🚀 Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/rindangalam/OtoRent.git
cd OtoRent

# 2. Install dependency PHP
composer install

# 3. Siapkan environment
copy .env.example .env        # Windows
# cp .env.example .env        # Linux / macOS

# 4. Generate key aplikasi
php artisan key:generate

# 5. Buat database SQLite
#    (buat file database/database.sqlite jika menggunakan SQLite)

# 6. Hubungkan storage
php artisan storage:link

# 7. Jalankan migrasi + seeder
php artisan migrate --seed

# 8. Install & build asset frontend
npm install
npm run build
```

> **Alternatif cepat:** `composer run setup` menjalankan langkah 2–8 otomatis (kecuali migrate dengan seeder — jalankan `php artisan migrate --seed` setelahnya).

## 👥 Akun Demo

Seeder menghasilkan data contoh beserta akun berikut (password: `password`):

| Role | Email |
|---|---|
| Admin | `admin@otorent.com` |
| Staff | `staff@otorent.com` |
| Customer | `andi@example.com` |

## ▶️ Menjalankan Aplikasi (Pengembangan)

Jalankan server, queue worker, dan Vite sekaligus:

```bash
composer run dev
```

Atau secara manual:

```bash
php artisan serve          # Server (http://localhost:8000)
php artisan queue:listen   # Queue worker
npm run dev                # Vite dev server
```

## 🧪 Testing

```bash
composer run test
# atau
php artisan test
```

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).
