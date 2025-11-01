# 🌌 Loly - Virtual World Rental System

## Nama Kelompok
Kelompok Loly

## Nama Team
- Teguh Bangun

## Nama Project
Virtual World Rental Management System

## Deskripsi Singkat
Sistem ini merupakan aplikasi manajemen penyewaan dunia virtual. Pengguna dapat menyewa berbagai dunia virtual, sementara admin dapat memantau semua transaksi, menyetujui pengembalian, dan mengelola data dunia virtual. Fitur modern seperti live search, penghitungan denda, dan notifikasi penyewaan tersedia untuk meningkatkan pengalaman pengguna.

## List Fitur

### User
- Melihat daftar dunia virtual yang tersedia
- Live search berdasarkan nama dan kode dunia virtual
- Menyewa dunia virtual dengan durasi otomatis maksimal 5 hari
- Menyewa Max 2 dunia virtual secara bersamaan
- Formulir pengajuan pengembalian dunia virtual
- Riwayat penyewaan lengkap dengan status pengembalian dan denda
- Notifikasi jika penyewaan sedang berlangsung atau terlambat
- Pembayaran denda dilakukan dengan integrasi payment gateway jika terlambat mengembalikan

### Admin
- Melihat daftar semua dunia virtual
- CRUD dunia virtual (Tambah, Edit, Hapus)
- Melihat daftar semua penyewaan (Rental)
- ACC pengembalian dunia virtual dari user
- Kalkulasi otomatis denda jika terlambat mengembalikan
- Filter penyewaan berdasarkan user (hanya role user)
- Dashboard ringkasan: Total Users, Total Admins, Total Members
- Notifikasi penyewaan baru

### Sistem
- Status rental: `ongoing`, `overdue`, `returned`
- Menghitung otomatis hari keterlambatan dan total denda
- Virtual world otomatis berubah menjadi tersedia setelah pengembalian
- Validasi maksimal 2 unit sewa aktif per user
- Validasi durasi sewa maksimal 5 hari

## Teknologi
- Laravel 10 (PHP Framework)
- MySQL (Database)
- TailwindCSS (UI Styling)
- Blade Templating
- Integrasi Pembayaran: Midtrans Snap API  
