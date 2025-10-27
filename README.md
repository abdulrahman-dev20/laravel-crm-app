💼 Laravel CRM Project: Sistem Manajemen Perusahaan & Kontak

Aplikasi Web sederhana berbasis CRM (Customer Relationship Management) yang dibangun menggunakan Laravel 12. Proyek ini berfungsi untuk mengelola data Perusahaan dan Kontak secara terpusat. Dirancang dengan arsitektur bersih untuk memisahkan kebutuhan Web (Blade) dan fondasi API (Sanctum).

✨ Fitur Utama (Core Features)

Full CRUD (Perusahaan): Pengelolaan lengkap (Create, Read, Update, Delete) data perusahaan.

Pencarian Real-time: Filter data perusahaan berdasarkan nama atau website secara dinamis.

Pagination: Menampilkan data dalam halaman-halaman yang efisien (10 data per halaman) untuk performa yang lebih baik.

Data Scoping: Implementasi logika data ownership yang memastikan setiap pengguna hanya melihat data perusahaan yang mereka buat (kecuali untuk pengguna Admin).

Arsitektur Modular: Penggunaan Blade Components untuk tombol aksi dan tabel data, memastikan kode view ringkas dan mudah dipelihara.

🛠️ Tech Stack

Proyek ini menggunakan stack teknologi modern (TALL stack - variasi):

Backend Framework: Laravel 12

Database: PostgreSQL

Frontend Styling: Tailwind CSS

Authentication: Laravel Breeze (Scaffolding)

API Foundation: Laravel Sanctum (Untuk kesiapan mobile/SPA di masa depan)

🚀 Instalasi dan Menjalankan Proyek

Pastikan Anda telah menginstal Docker dan WSL (jika di Windows) sebelum memulai.

Clone Repository:

git clone https://github.com/abdulrahman-dev20/laravel-crm-app.git
cd laravel-crm-app


Setup Environment:

cp .env.example .env


Jalankan Lingkungan Docker (Sail):

sail up -d


Install Dependencies (Composer & NPM):

sail composer install
sail npm install


Generate App Key & Migrate Database:

sail artisan key:generate
sail artisan migrate


Kompilasi Aset (Untuk Tailwind CSS):
Buka Terminal/WSL baru dan biarkan perintah ini berjalan di latar belakang saat pengembangan:

sail npm run dev


Akses Aplikasi:
Akses aplikasi di browser: http://localhost

👤 Kontributor

Abdul Rahman - Initial Project Development

Proyek ini merupakan hasil pembelajaran pola arsitektur Laravel yang bersih dan efisien.
