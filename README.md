# SIM Platform Musik (PHP + MySQL)

Proyek mini ala Spotify untuk tugas Pemrograman Web (Universitas Muhammadiyah Malang). Aplikasi CRUD data lagu dengan UI dark mode berbasis Bootstrap 5.

## Fitur
- CRUD lengkap: tambah, lihat, edit, hapus lagu.
- Validasi: semua field wajib diisi, tahun harus angka.
- Pencarian: search bar judul/artis/album/genre.
- Keamanan: prepared statements (PDO).
- UI/UX: tema gelap ala Spotify, responsif desktop–mobile, flash alert sukses/gagal.

## Struktur Proyek
- `index.php` – redirect ke list.
- `list.php` – daftar lagu + search + aksi.
- `add.php` – form tambah lagu.
- `edit.php` – form edit dengan data terisi.
- `delete.php` – proses hapus (POST).
- `about.php` – info tugas dan kontributor.
- `config/db.php` – koneksi PDO.
- `includes/header.php` / `includes/footer.php` – layout & navbar.
- `assets/css/style.css` – tema gelap kustom.
- `database.sql` – schema + seed sample data.

## Persiapan Database
1. Buat database dan tabel menggunakan `database.sql`:
   ```bash
   mysql -u<user> -p < database.sql
   ```
2. Sesuaikan kredensial di `config/db.php` (`$dbHost`, `$dbName`, `$dbUser`, `$dbPass`).

## Menjalankan Aplikasi (Mode Built-in PHP Server)
```bash
php -S localhost:8000
```
Buka `http://localhost:8000/list.php`.

## Catatan Implementasi
- Semua query memakai prepared statements (PDO) untuk mitigasi SQL injection.
- Validasi server: required untuk seluruh field, `year` numeric.
- Flash message memakai session (set di proses, ditampilkan di header).
- Tema gelap kustom di `assets/css/style.css` menyesuaikan Bootstrap 5.

## Kontributor
1. WIJI FIKO TEREN – 202310370311437  
2. MUHAMMAD IQBAL FADEL – 202310370311268  
3. AHMAD ZAMRI ARDANI – 202310370311406  
4. AHMAD RISKI NUR – 202310370311430  
5. M. RIFQI DZAKI A. – 202310370311441  
