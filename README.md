Instalasi

⚠️ Proyek ini belum sepenuhnya berjalan. Langkah-langkah berikut disiapkan untuk tahap awal setup bagi kontributor.

Clone repositori ini:
```
git clone https://github.com/kristiandimasadiwicaksono/evaluasi.git
cd evaluasi
```

Install dependency (jika menggunakan Laravel / Node / Composer / dsb):
```
composer install
npm install
```

Salin file environment:
```
cp .env.example .env
```
Sesuaikan konfigurasi database pada .env.

Generate app key (jika Laravel):
```
php artisan key:generate
```
Jalankan migrasi database (jika sudah tersedia):
```
php artisan migrate
```