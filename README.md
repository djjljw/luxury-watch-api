# ⌚ Luxury Watch Store RESTful API (Toko Jam Mewah)

Layanan RESTful API mandiri menggunakan **Laravel 12** dan basis data **MySQL** untuk sistem manajemen **Toko Jam Mewah (Luxury Watch Store)**. API ini dirancang untuk mengelola katalog jam tangan eksklusif secara profesional, lengkap dengan dokumentasi interaktif **Scramble** di `/docs/api`, validasi request yang ketat, standarisasi respons JSON berbasis `JsonResource` berformat amplop (`message` & `data`), serta siap dideploy secara live ke cloud.

---

## 🚀 Fitur Utama

- **Framework**: Laravel 12 (versi 12.70.1) & PHP 8.3+
- **Database**: MySQL 8.0 dengan tabel `koleksi_jam`
- **Dokumentasi Interaktif**: Terintegrasi otomatis dengan [Scramble](https://scramble.dedoc.co/) di endpoint `/docs/api` dan spesifikasi OpenAPI di `/docs/api.json`
- **Validasi Ketat**: Form Request kustom (`StoreWatchRequest` & `UpdateWatchRequest`) dengan pesan error multibahasa (Bahasa Indonesia)
- **Format Amplop JSON**: Standardisasi respon menggunakan `WatchResource` dengan struktur seragam `message` dan `data`
- **Unit & Feature Testing**: Pengujian otomatis dengan 12 skenario pengujian komprehensif (63 assertions, 100% pass)
- **Siap Deploy Cloud**: Dilengkapi `Dockerfile`, `docker-compose.yml`, `Procfile`, dan konfigurasi environment untuk deploy instan ke Railway, Render, Fly.io, Heroku, atau VPS.

---

## 📋 Struktur Data Entitas Utama (`koleksi_jam` / `watches`)

| Atribut | Tipe Data | Keterangan & Contoh |
| --- | --- | --- |
| `id` | BigInteger (Auto Increment) | ID unik jam tangan |
| `nama` | String (255) | Nama model jam tangan (*Rolex Submariner Date*) |
| `brand` | String (100) | Merek jam tangan (*Rolex*, *Patek Philippe*, *Audemars Piguet*) |
| `harga` | UnsignedBigInteger | Harga dalam IDR (*250000000*) |
| `tahun_rilis` | Integer | Tahun pembuatan/rilis (*2023*) |
| `tipe_gerakan` | String / Enum | Tipe pergerakan (*Automatic*, *Manual*, *Quartz*) |
| `material` | String (100) | Bahan jam tangan (*Oystersteel*, *Rose Gold 18k*, *Platinum*) |
| `status` | Enum | Ketersediaan (*tersedia*, *terjual*) |
| `foto` | String / URL (500) | URL foto jam tangan (*https://...*) |
| `created_at` | Timestamp | Waktu data dibuat |
| `updated_at` | Timestamp | Waktu data terakhir diperbarui |

---

## 📌 Daftar 5 Endpoint CRUD Wajib

| Method | Endpoint | Deskripsi Tugas | Status Sukses |
| --- | --- | --- | --- |
| **GET** | `/api/jam-tangan` | Mengambil seluruh daftar koleksi jam mewah (mendukung filter & pencarian) | `200 OK` |
| **GET** | `/api/jam-tangan/{id}` | Mengambil detail 1 jam mewah berdasarkan ID | `200 OK` |
| **POST** | `/api/jam-tangan` | Menambahkan data jam mewah baru (dengan validasi ketat) | `201 Created` |
| **PUT/PATCH** | `/api/jam-tangan/{id}` | Memperbarui data jam mewah yang tersimpan | `200 OK` |
| **DELETE** | `/api/jam-tangan/{id}` | Menghapus data jam mewah dari basis data | `200 OK` |

---

## 📖 Dokumentasi Interaktif (Scramble OpenAPI)

Akses dokumentasi interaktif API langsung melalui peramban:

```
http://localhost:8000/docs/api
```

Dokumentasi ini menyediakan UI interaktif untuk mencoba (Try It) setiap endpoint langsung, melihat skema data request body, validasi, dan contoh respons.

---

## 💡 Contoh Format Respons JSON (Format Amplop)

### 1. GET `/api/jam-tangan` (200 OK)
```json
{
  "message": "Daftar koleksi jam mewah berhasil diambil",
  "data": [
    {
      "id": 1,
      "nama": "Rolex Submariner Date",
      "brand": "Rolex",
      "harga": 250000000,
      "tahun_rilis": 2023,
      "tipe_gerakan": "Automatic",
      "material": "Oystersteel",
      "status": "tersedia",
      "foto": "https://images.unsplash.com/photo-1523275335684-37898b6baf30"
    }
  ]
}
```

### 2. GET `/api/jam-tangan/{id}` (200 OK)
```json
{
  "message": "Detail jam mewah berhasil diambil",
  "data": {
    "id": 1,
    "nama": "Rolex Submariner Date",
    "brand": "Rolex",
    "harga": 250000000,
    "tahun_rilis": 2023,
    "tipe_gerakan": "Automatic",
    "material": "Oystersteel",
    "status": "tersedia",
    "foto": "https://images.unsplash.com/photo-1523275335684-37898b6baf30"
  }
}
```

### 3. POST `/api/jam-tangan` (201 Created)
**Request Body:**
```json
{
  "nama": "Patek Philippe Nautilus 5711/1R",
  "brand": "Patek Philippe",
  "harga": 1850000000,
  "tahun_rilis": 2022,
  "tipe_gerakan": "Automatic",
  "material": "Rose Gold 18k",
  "status": "tersedia",
  "foto": "https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9"
}
```
**Response (201 Created):**
```json
{
  "message": "Data jam mewah berhasil ditambahkan",
  "data": {
    "id": 2,
    "nama": "Patek Philippe Nautilus 5711/1R",
    "brand": "Patek Philippe",
    "harga": 1850000000,
    "tahun_rilis": 2022,
    "tipe_gerakan": "Automatic",
    "material": "Rose Gold 18k",
    "status": "tersedia",
    "foto": "https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9"
  }
}
```

### 4. PUT/PATCH `/api/jam-tangan/{id}` (200 OK)
**Request Body:**
```json
{
  "harga": 265000000,
  "status": "terjual"
}
```
**Response (200 OK):**
```json
{
  "message": "Data jam mewah berhasil diperbarui",
  "data": {
    "id": 1,
    "nama": "Rolex Submariner Date",
    "brand": "Rolex",
    "harga": 265000000,
    "tahun_rilis": 2023,
    "tipe_gerakan": "Automatic",
    "material": "Oystersteel",
    "status": "terjual",
    "foto": "https://images.unsplash.com/photo-1523275335684-37898b6baf30"
  }
}
```

### 5. DELETE `/api/jam-tangan/{id}` (200 OK)
**Response (200 OK):**
```json
{
  "message": "Data jam mewah berhasil dihapus",
  "data": null
}
```

### Respons Kesalahan Validasi (422 Unprocessable Content)
```json
{
  "message": "Validasi gagal, silakan periksa data input Anda",
  "errors": {
    "nama": [
      "nama jam tangan wajib diisi."
    ],
    "harga": [
      "harga jam tangan wajib diisi."
    ]
  }
}
```

### Respons Tidak Ditemukan (404 Not Found)
```json
{
  "message": "Data jam mewah tidak ditemukan",
  "data": null
}
```

---

## 🛠️ Panduan Instalasi & Menjalankan di Lokal (Laragon / Terminal)

### Prasyarat
- PHP >= 8.3
- MySQL >= 8.0
- Composer >= 2.4

### Langkah Menjalankan:
1. Masuk ke direktori proyek:
   ```bash
   cd luxury-watch-api
   ```
2. Pastikan file `.env` sudah sesuai (contoh konfigurasi MySQL default):
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=luxury_watches_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Jalankan migrasi dan seeding database:
   ```bash
   php artisan migrate --seed
   ```
4. Jalankan development server:
   ```bash
   php artisan serve
   ```
5. Akses API dan Dokumentasi di browser:
   - Katalog API: `http://127.0.0.1:8000/api/jam-tangan`
   - Dokumentasi Interaktif Scramble: `http://127.0.0.1:8000/docs/api`

---

## 🧪 Menjalankan Pengujian Otomatis (Automated Testing)

Jalankan test suite menggunakan PHPUnit / Artisan:

```bash
php artisan test
```

Semua 12 pengujian Feature & Unit akan dieksekusi menggunakan in-memory database secara independen dan aman.

---

## ☁️ Panduan Deploy ke Cloud (Clever Cloud, Railway, Render, Docker)

Proyek ini telah dilengkapi konfigurasi deployment siap pakai, khususnya **Clever Cloud**:

### 🌟 Pilihan 1: Deploy ke Clever Cloud (Rekomendasi)

Proyek ini sudah dikonfigurasi khusus untuk **Clever Cloud** dengan:
- Script otomatisasi [`clevercloud/post_build.sh`](clevercloud/post_build.sh) (otomatis migrate, seed, dan cache saat build).
- Konfigurasi [`config/database.php`](config/database.php) yang langsung mengenali variabel bawaan add-on MySQL Clever Cloud (`MYSQL_ADDON_HOST`, `MYSQL_ADDON_DB`, `MYSQL_ADDON_USER`, dll).

#### Cara A: Melalui Dashboard Clever Cloud Web Console (Paling Mudah)
1. Buka [Clever Cloud Console](https://console.clever-cloud.com/).
2. Buat aplikasi PHP:
   * Klik **"Create..."** > **"an application"** > pilih **PHP**.
   * Hubungkan repositori GitHub/GitLab Anda atau push git langsung.
3. Buat Add-on MySQL:
   * Klik **"Create..."** > **"an add-on"** > pilih **MySQL** (pilih paket Dev / Free).
   * Beri nama misalnya `luxury-watch-mysql`.
   * Pada halaman berikutnya, **Link (hubungkan)** add-on ini ke aplikasi PHP yang baru saja Anda buat. *(Variabel database otomatis terhubung!)*
4. Konfigurasi **Environment Variables** aplikasi di Clever Cloud:
   * `CC_WEBROOT` = `/public`
   * `CC_PHP_VERSION` = `8.3`
   * `CC_POST_BUILD_HOOK` = `./clevercloud/post_build.sh`
   * `APP_KEY` = `base64:SkKZjOJ5x2B4S5tlRX0oZ72CbGxfEJiHTCVf+7+u5YM=` *(atau generate via `php artisan key:generate --show`)*
   * `APP_ENV` = `production`
   * `APP_DEBUG` = `false`
   * `APP_URL` = `https://<app-id>.cleverapps.io`
5. Jalankan deploy! Aplikasi akan live dengan dokumentasi di `https://<domain-clever>/docs/api`.

#### Cara B: Melalui Terminal (`clever-tools` CLI)
Clever Tools CLI sudah terinstall di sistem Anda:
```bash
# 1. Login ke akun Clever Cloud
clever login

# 2. Inisialisasi aplikasi PHP
clever create --type php luxury-watch-api

# 3. Buat add-on MySQL dan hubungkan langsung
clever addon create mysql-addon --plan dev luxury-watch-mysql --link luxury-watch-api

# 4. Set variabel environment penting
clever env set CC_WEBROOT /public
clever env set CC_PHP_VERSION 8.3
clever env set CC_POST_BUILD_HOOK ./clevercloud/post_build.sh
clever env set APP_KEY base64:SkKZjOJ5x2B4S5tlRX0oZ72CbGxfEJiHTCVf+7+u5YM=
clever env set APP_ENV production
clever env set APP_DEBUG false

# 5. Deploy aplikasi langsung via git
clever deploy

# 6. Buka aplikasi di browser
clever open
```

---

### Pilihan 2: Deploy via Railway / Render
1. Push repositori ke GitHub / GitLab.
2. Buat layanan baru di **Railway** atau **Render**.
3. Tambahkan MySQL Database service di dashboard platform.
4. Set Environment Variables dari template `.env.production.example`:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_KEY=base64:...` (jalankan `php artisan key:generate --show` untuk mendapatkan key)
   - `DB_CONNECTION=mysql`
   - `DB_HOST=<cloud-mysql-host>`
   - `DB_PORT=3306`
   - `DB_DATABASE=<cloud-db-name>`
   - `DB_USERNAME=<cloud-db-user>`
   - `DB_PASSWORD=<cloud-db-password>`
5. Proyek akan otomatis menjalankan `Procfile` atau `Dockerfile` dan langsung live!

### Pilihan 2: Deploy menggunakan Docker Compose
```bash
docker-compose up -d --build
```
Aplikasi dan database MySQL akan berjalan di container terisolasi pada port `8000` dan `3307`.

---

## 📄 Lisensi

Proyek ini bersifat open-source dan dilisensikan di bawah [MIT License](LICENSE).
