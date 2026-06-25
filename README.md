# E-Ticket Kapal Laut

## Deskripsi

E-Ticket Kapal Laut adalah aplikasi berbasis web yang dikembangkan menggunakan Laravel untuk memudahkan proses pemesanan tiket kapal secara online. Aplikasi ini memiliki dua jenis pengguna, yaitu **Admin** dan **User**.

## Fitur

### Admin
- Login Admin
- Dashboard Admin
- Kelola Data Kapal
- Kelola Jadwal Kapal
- Kelola Data User
- Kelola Pemesanan
- Kelola Pembayaran

### User
- Registrasi
- Login
- Melihat Jadwal Kapal
- Melakukan Pemesanan Tiket
- Melakukan Pembayaran
- Melihat Riwayat Pemesanan

## Teknologi

- Laravel
- PHP
- MySQL
- Bootstrap
- HTML
- CSS
- JavaScript

## Database

Nama database:

```
e_ticket_kapal_laut
```

File database tersedia pada folder:

```
database/e_ticket_kapal_laut.sql
```

## Cara Menjalankan Project

```bash
composer install
```

```bash
copy .env.example .env
```

```bash
php artisan key:generate
```

Atur konfigurasi database pada file `.env`, kemudian import file:

```
database/e_ticket_kapal_laut.sql
```

Jalankan aplikasi:

```bash
php artisan serve
```

Buka browser:

```
http://127.0.0.1:8000
```

## Developer

**Fadia Azzahra**