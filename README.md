# App Perpustakaan V2

Proyek aplikasi perpustakaan. Digunakan untuk keperluan latihan ujikom.

## Getting Started

### Dependensi
- [NodeJS 22](https://nodejs.org)
- [Composer 2.8](https://getcomposer.org)
- [PHP 8](https://www.php.net/)

### 1. Install dependensi

```powershell
composer install
```

### 2. Generate dan sesuaikan file .env

```powershell
copy .env.example .env
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

Buka <a href="http://127.0.0.1:8000">http://127.0.0.1:8000</a> Dengan browser untuk melihat _public portal_.

### 5. Membuka panel admin

1. Jalankan command berikut
```powershell
php artisan make:filament-user
```

2. Isi data user baru
```
Name:
Email:
Password:
```

2. Buka <a href="http://127.0.0.1:8000/admin">http://127.0.0.1:8000/admin</a> Dengan browser untuk login ke panel admin.

3. Login menggunakan data user yang telah dibuat sebelumnya

## Misc

- repositori GitHub: [https://github.com/Dirga36/app-perpustakaan-V2](https://github.com/Dirga36/app-perpustakaan-V2)

- manual book: [https://docs.google.com/document/d/1zbTdueasjDsAlA2FS-GWjYi6zWRnRQJAeQ5BU_r30gE/edit?usp=sharing](https://docs.google.com/document/d/1zbTdueasjDsAlA2FS-GWjYi6zWRnRQJAeQ5BU_r30gE/edit?usp=sharing)

## Note

Mengapa nama belakangnya V2? Dikarenakan ini adalah versi baru dari proyek yang telah ada sebelumnya yaitu [app_perpustakaan](https://github.com/Dirga36/app-perpustakaan).
