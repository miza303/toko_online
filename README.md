# Toko Online (Laravel)

Aplikasi toko online dengan role **Penjual (admin)** dan **Pembeli (customer)**.

## Fitur
- ✅ Autentikasi (login & register) — registrasi publik otomatis jadi **Pembeli**
- ✅ Role Penjual & Pembeli dengan tampilan (dashboard, menu) yang berbeda
- ✅ CRUD Produk (tambah, edit, hapus, lihat) — khusus Penjual
- ✅ Restok barang + histori stok (restock/sale) — khusus Penjual
- ✅ Katalog produk, keranjang, checkout langsung — khusus Pembeli
- ✅ Stok otomatis berkurang saat checkout
- ✅ Histori transaksi untuk Penjual (semua order) & Pembeli (order milik sendiri)

## Instalasi

1. **Clone / extract folder ini**, lalu masuk ke foldernya:
   ```bash
   cd toko-online
   ```

2. **Install dependency PHP:**
   ```bash
   composer install
   ```

3. **Install dependency JS (opsional, untuk build asset Vite):**
   ```bash
   npm install
   npm run build
   ```
   > Catatan: tampilan sudah menggunakan Tailwind CDN di layout, jadi styling tetap jalan meski kamu skip langkah ini. Vite hanya dipakai untuk asset tambahan jika diperlukan.

4. **Copy environment file** (jika belum ada `.env`):
   ```bash
   cp .env.example .env
   ```

5. **Set konfigurasi database** di `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=toko_online
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Buat database `toko_online` di MySQL kamu terlebih dahulu.

6. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

7. **Migrasi database + seeder data contoh:**
   ```bash
   php artisan migrate --seed
   ```

8. **Buat symbolic link storage** (agar gambar produk bisa diakses):
   ```bash
   php artisan storage:link
   ```

9. **Jalankan server:**
   ```bash
   php artisan serve
   ```
   Buka `http://localhost:8000`

## Akun Demo (dari seeder)

| Role     | Email              | Password |
|----------|---------------------|----------|
| Penjual  | admin@toko.test     | password |
| Pembeli  | customer@toko.test  | password |

## Struktur Penting

- `app/Models` — User, Product, Category, Order, OrderItem, StockHistory
- `app/Http/Controllers/Admin` — Dashboard, ProductController (CRUD), StockController (restok), OrderController (histori penjualan)
- `app/Http/Controllers/Customer` — CatalogController, CartController, OrderController (checkout & histori pribadi)
- `app/Http/Middleware/EnsureUserHasRole.php` — middleware `role:admin` / `role:customer`
- `routes/web.php` — semua route, dipisah per role
- `resources/views/admin/*` — tampilan khusus penjual
- `resources/views/customer/*` — tampilan khusus pembeli

## Alur Bisnis
1. Penjual login → kelola produk & restok stok.
2. Pembeli login → lihat katalog → tambah ke keranjang → checkout.
3. Saat checkout: order tercatat, stok produk otomatis berkurang, dan histori stok (`type: sale`) tercatat otomatis.
4. Semua histori transaksi bisa dilihat penjual (semua order) dan pembeli (order miliknya sendiri).

## Menambahkan Role Penjual Baru
Karena sistem ini pakai **satu penjual/admin** yang mengelola semua produk, kamu bisa ubah role user manual lewat Tinker:
```bash
php artisan tinker
>>> User::where('email', 'email@contoh.com')->update(['role' => 'admin']);
```
