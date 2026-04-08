<div align="center">
  <h1 style="color: #F9A3A3; font-weight: bold;">🎀 Sociolla E-Commerce</h1>
  <p>A Full-Stack Beauty & Cosmetics E-Commerce Web Application built with Laravel</p>
</div>

---

## 🛒 About The Project
Aplikasi **Sociolla E-Commerce** ini adalah platform toko *online* modern yang dibangun menggunakan framework **Laravel**. Proyek ini ditujukan untuk memfasilitasi transaksi jual-beli produk kosmetik dan *skincare* dengan fitur terpusat yang mencakup *role management* (Admin, Petugas, dan Pelanggan), keranjang belanja dinamis, hingga *tracking* asisten transaksi & laporan penjualan.

Aplikasi ini menonjolkan desain visual (UI) estetik berwarna dominan *Pink* khas kosmetik untuk memanjakan visual pengguna.

## ✨ Key Features
**👩‍💻 Customer (Pelanggan) Features**
- Otentikasi Pengguna & Lupa Password Ekstra Aman (Verifikasi 4 Data).
- Katalog produk dinamis berdasarkan tren & kategori.
- *Add to Cart* dinamis dengan kalkulasi harga seketika (Checklist item).
- Integrasi pembayaran *Bank Transfer* (Upload Struk QRIS) & *Cash On Delivery (COD)*.
- Real-time Order Tracking (Status logistik secara langsung).

**👮🏻‍♂️ Admin & Petugas (Staff) Dashboard**
- **Sistem Role Multi-Tier:** Login dibedakan untuk Admin, Petugas, & User Biasa. Pembuatan Staff dibatasi oleh *Security Token* (`SOCIOLLA123`).
- **Data Master:** Tambah, edit, dan hapus katalog Produk & Pengguna.
- **Order Management:** Mengubah status pemesanan Pelanggan (Dikemas, Dikirim, Selesai).
- **Laporan Penjualan (Reports):** Pencatatan riwayat transaksi dan kalkulasi omzet.
- **Database Backup:** Admin bisa melakukan *Backup* `.sql` secara instan dari dalam UI Dashboard tanpa harus menyentuh *phpMyAdmin*.

## 💻 Tech Stack
- **Framework:** Laravel 10 / 11 (PHP)
- **Database:** MySQL
- **Frontend / UI:** Native HTML5, Vanilla CSS, Javascript Vanilla, FontAwesome
- **Styling Method:** Custom CSS (Without Tailwind/Bootstrap) to ensure maximum flexibility and aesthetic layouts.
- **Server Environment:** XAMPP / Apache

## 🚀 How To Install & Run Locally

Ikuti langkah-langkah di bawah ini untuk menjalankan *project* ini di komputer pribadi Anda:

### Persyaratan Terdahulu (Prerequisites)
Pastikan komputer/laptop Anda telah terpasang:
- [XAMPP](https://www.apachefriends.org/) (Sangat disarankan memakai PHP minimal v8.1)
- [Composer](https://getcomposer.org/)

### Langkah Instalasi
1. **Clone Repository (Unduh)**
   Silakan *clone* repository ini atau *download* berformat ZIP, pindahkan filenya ke dalam folder `c:\xampp\htdocs\` lalu ekstrak.
   ```bash
   git clone https://github.com/USERNAME_ANDA/NAMA_REPOSITORY.git sociolla
   cd sociolla
   ```

2. **Install Dependensi Framework**
   Instal perpustakaan sistem bawaan Laravel yang tidak ikut ter-push ke GitHub:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment Database**
   Buat salinan salinan berkas `.env`:
   - Copy file `.env.example` dan ubah namanya menjadi `.env`.
   - Buka file `.env` di teks editor, sesuaikan nama database:
     ```env
     DB_DATABASE=sociolla_db
     ```

4. **Generate Application Key**
   Buat Application Key baru untuk keamanan sesi Web:
   ```bash
   php artisan key:generate
   ```

5. **Import Database**
   - Jalankan modul `Apache` dan `MySQL` pada program XAMPP.
   - Buka browser dan pergi ke tautan `http://localhost/phpmyadmin`
   - Buat database baru berwarna dengan nama: `sociolla_db`
   - Masuk ke tab **Import** dan pilih file ekspor database `.sql` yang ada pada folder project ini. Lalu klik **Go**.

6. **Jalankan Aplikasi!**
   Ketik perintah sakti Laravel ini pada Terminal:
   ```bash
   php artisan serve
   ```
   Buka Browser dan pergi ke alamat `http://localhost:8000` atau cukup `http://localhost/sociolla` (tergantung konfigurasi path XAMPP Anda). 

## 🔐 Akun Default
Jika Anda tidak ingin mendaftar (*Register*), Anda dapat masuk menggunakan peran *Admin* menggunakan data yang ada di database.

*(Catatan:* Untuk meregistrasi *Admin / Petugas* baru lewat halaman Register, pastikan memasukan token: **`SOCIOLLA123`** di kolom "Security Token".)

---
**Dibuat dan dirancang untuk keperluan UKK E-Commerce Web Design & System.**
