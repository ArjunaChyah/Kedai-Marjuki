# 🍽️ Kedai Marjuki'S - E-Commerce Web Application

Aplikasi Web E-Commerce Kedai Marjuki'S berbasis **Laravel 11**, dilengkapi manajemen produk, keranjang belanja, checkout QRIS/Cash, panel admin, laporan penjualan, dan **Database SQLite Mandiri (Zero-Config)**.

---

## 🚀 Fitur Utama

- **Katalog Menu Lengkap**: Makanan (Soto, Rames, Indomie), Camilan (Mendoan, Tahu Bakso, Bakwan Jagung), dan Minuman Segar (Es Teh, Es Jeruk).
- **Smart Image Detection**: Otomatis mendeteksi dan menampilkan foto produk asli dari folder `public/foto_website/produk/`.
- **Panel Administrator Lengkap**:
  - Dashboard statistik & total pendapatan.
  - Kelola Produk & Kategori (Tambah, Edit, Hapus, Upload Foto).
  - Kelola Pesanan & Verifikasi Pembayaran (QRIS / Tunai).
  - Laporan Penjualan & Data Pelanggan.
- **Database Murni SQLite**: 100% bebas dari XAMPP/MySQL port crash, cepat, dan ringan.

---

## 🔐 Akun Login Bawaan

| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@marjukis.test` | `password` |
| **Pelanggan Demo** | `user@marjukis.test` | `password` |

---

## 🛠️ Cara Menjalankan Project

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/ArjunaChyah/Kedai-Marjuki.git
   cd Kedai-Marjuki
   ```

2. **Install Dependency**:
   ```bash
   composer install
   npm install
   ```

3. **Setup Konfigurasi (.env)**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi & Isi Database (SQLite)**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Buka browser di: **[http://localhost:8000](http://localhost:8000)**

---

*Dibuat oleh Arjunaa*
