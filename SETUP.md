# POS Rizal — Setup dari awal

## 1. Persyaratan
- PHP 8.2+
- Composer
- Node.js + npm
- MySQL/MariaDB jika ingin memakai database Laragon

## 2. Install dependency
Di folder project:

```powershell
composer install
npm install
```

## 3. Buat file environment
```powershell
Copy-Item .env.example .env
php artisan key:generate
```

### Pilihan A — SQLite (paling cepat)
Buat file kosong `database/database.sqlite`, lalu pastikan `.env` berisi:

```env
DB_CONNECTION=sqlite
```

### Pilihan B — MySQL Laragon
Buat database, misalnya `apkpos`, lalu ubah `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=apkpos
DB_USERNAME=root
DB_PASSWORD=
```

## 4. Migrasi dan data awal

Untuk database baru:
```powershell
php artisan migrate:fresh --seed
```

Akun seed:
- Admin: `admin@example.com`
- Password: `password`
- Kasir: `kasir@example.com`
- Password: `password`

> Ganti password tersebut setelah login pada aplikasi nyata.

## 5. Aktifkan penyimpanan foto produk
```powershell
php artisan storage:link
```

## 6. Build asset Vite
```powershell
npm run build
```

Perintah ini membuat `public/build/manifest.json`. Jangan menghapus folder `public/build` setelah build jika aplikasi dijalankan tanpa Vite dev server.

## 7. Jalankan aplikasi
Terminal 1:
```powershell
php artisan serve
```

Buka:
`http://127.0.0.1:8000`

Untuk pengembangan dengan auto-reload:
```powershell
npm run dev
```

## 8. Jika muncul error setelah perubahan
```powershell
php artisan optimize:clear
php artisan route:list
php artisan migrate:status
npm run build
```

## 9. Alur yang sudah diperbaiki
- Login/logout dan session regeneration.
- Role admin/kasir melalui middleware.
- Produk: list, detail, tambah, edit, hapus.
- Foto produk dan `storage:link`.
- Penjualan: transaksi baru, keranjang, ubah qty, hapus item, checkout, batal, detail, riwayat.
- Stok dikurangi saat item masuk keranjang dan dikembalikan saat item dihapus/transaksi dibatalkan.
- Checkout menghitung ulang total dari database.
- User: list, search, tambah, edit, hapus.
- Policy mencegah akses berdasarkan role dan kepemilikan transaksi.
- Search user memakai `LIKE`, sehingga tidak bergantung pada fitur FULLTEXT database.
- Route resource duplikat dihapus.
- Nama class/model dibuat konsisten dengan PSR-4 (`Produk`, `ItemPenjualan`).
