# SI_perpustakaan
SI_perpustakaan (Sistem Informasi Perpustakaan) adalah proyek aplikasi perpustakaan. Digunakan untuk keperluan latihan ujikom.

## Getting Started

### Deps 
- [NodeJS 22](https://nodejs.org)
- [Composer 2.8](https://getcomposer.org)
- [PHP 8](https://www.php.net/)

### 1. Install dependensi

```powershell
composer install
```

saat ini ada beberapa dependensi yang jadul, gunakan command berikut jika diminta oleh composer untuk update
```powershell
composer update
```

### 2. Generate dan sesuaikan file .env

- 1. generate

```powershell
copy .env.example .env
```

- 2. sesuaikan database (jenis database dan nama database_)

```txt
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel 
# DB_USERNAME=root
# DB_PASSWORD=
```

### 3. Generate application key

```powershell
php artisan key:generate
```

### 4. Database migration

```powershell
php artisan migrate
```

### 4. Jalankan development server

```powershell
composer run dev
```

Buka <a href="http://127.0.0.1:8000">http://127.0.0.1:8000</a> Dengan browser untuk melihat hasilnya.




## Misc

repositori GitHub: [https://github.com/Dirga36/SI_penjualan](https://github.com/Dirga36/SI_penjualan)

manual book: [https://github.com/Dirga36/SI_penjualan/wiki/Manual-Book](https://github.com/Dirga36/SI_penjualan/wiki/Manual-Book)

