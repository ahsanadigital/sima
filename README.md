## SIMA
Sistem Kegiatan Mahasiswa "College Life"

Cara pasang
1. Unduh semua berkas ini atau gunakan `git clone https://github.com/dasakreativa/sima
2. Ekstrak ke folder root server atau direktori localhost
3. Jalankan `composer install`.
4. Ubah file `.env.example` menjadi `.env` lalu ubah konfigurasi database pada bagian
  ```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=sima
  DB_USERNAME=root
  DB_PASSWORD=
  ```
5. Jalankan `php artisan migrate --seed`
6. Jika berhasil, buka database dan lihat usernamenya, lalu untuk passwordnya yakni `password`.
7. Selamat menggunakan.
