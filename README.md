# 🚢 E-Ticket Kapal Laut

Aplikasi **E-Ticket Kapal Laut** merupakan sistem berbasis web yang dikembangkan menggunakan **Laravel** untuk memudahkan proses pemesanan tiket kapal laut secara online. Sistem ini menyediakan fitur bagi pengguna untuk mencari jadwal kapal, melakukan pemesanan tiket, melakukan pembayaran, serta melihat riwayat pemesanan. Selain itu, tersedia panel administrator untuk mengelola seluruh data aplikasi.

---

# 📌 Fitur Utama

## 👤 User
- Registrasi akun
- Login
- Landing page dengan tampilan modern
- Melihat jadwal keberangkatan kapal
- Filter jadwal berdasarkan:
  - Jenis pengguna/kendaraan
  - Pelabuhan asal
  - Pelabuhan tujuan
  - Tanggal keberangkatan
- Pemesanan tiket kapal
- Upload bukti pembayaran
- Riwayat pemesanan
- Tema Light & Dark Mode

---

## 👨‍💼 Admin

### Dashboard Admin
- Dashboard statistik
- Kelola Data Kapal
- Kelola Jadwal Kapal
- Kelola Pemesanan
- Kelola Pembayaran
- Kelola Pengguna
- Laporan Penjualan

### Kelola Metode Pembayaran
Admin dapat mengelola metode pembayaran tanpa mengubah kode program.

Fitur yang tersedia:
- Menambah rekening bank
- Mengubah rekening bank
- Menghapus rekening bank
- Mengubah nama pemilik rekening
- Mengubah nomor rekening
- Mengganti gambar QRIS
- Mengaktifkan atau menonaktifkan metode pembayaran

---

# 🚢 Jenis Pengguna

Sistem mendukung beberapa kategori pengguna/kendaraan, yaitu:

- Pejalan Kaki
- Golongan I (Sepeda)
- Golongan II (Sepeda Motor < 500 cc)
- Golongan III (Sepeda Motor > 500 cc)
- Golongan IVA (Mobil Pribadi / Sedan)
- Golongan IVB (Mobil Barang / Pickup maksimal 5 meter)
- Golongan VA (Bus Sedang)
- Golongan VB (Truk Barang roda 4–6, panjang 5–7 meter)
- Golongan VIA (Bus Besar)
- Golongan VIB (Truk Barang Besar panjang 7–10 meter)
- Golongan VII (Truk Tronton lebih dari 6 roda)
- Golongan VIII (Kendaraan panjang 12–16 meter)
- Golongan IX (Kendaraan panjang lebih dari 16 meter)

---

# 🛠 Teknologi

- Laravel
- PHP
- MySQL
- Bootstrap 5
- HTML
- CSS
- JavaScript
- Font Awesome

---

# ⚙️ Instalasi

Clone repository

```bash
git clone https://github.com/fadiaazzahra/e_ticket_kapal_laut.git
```

Masuk ke folder project

```bash
cd e_ticket_kapal_laut
```

Install dependency

```bash
composer install
```

Copy file environment

```bash
copy .env.example .env
```

Generate key

```bash
php artisan key:generate
```

Import database

Import file:

```
database/e_ticket_kapal_laut.sql
```

Jalankan migration

```bash
php artisan migrate
```

Jalankan aplikasi

```bash
php artisan serve
```

---

# 📂 Struktur Fitur

```
Admin
├── Dashboard
├── Kelola Kapal
├── Kelola Jadwal
├── Kelola Pemesanan
├── Kelola Pembayaran
├── Kelola Metode Pembayaran
├── Kelola Pengguna
└── Laporan Penjualan

User
├── Home
├── Jadwal Kapal
├── Pemesanan Tiket
├── Pembayaran
└── Riwayat Pemesanan
```

---

# 👩‍💻 Developer

**Fadia Azzahra**

Project Mata Kuliah Pemrograman Web menggunakan Laravel.