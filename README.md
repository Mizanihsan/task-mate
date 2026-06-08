# TaskMate - Aplikasi Manajemen Tugas Akademik

TaskMate adalah aplikasi berbasis web modern untuk mengelola tugas-tugas akademik Anda secara efisien. Proyek ini dibangun menggunakan **Laravel 11 (PHP)** untuk sisi backend dan **Tailwind CSS** untuk antarmuka pengguna yang responsif.

---

## 🛠️ Prasyarat (Prerequisites)

Pastikan komputer Anda sudah terinstal beberapa perangkat lunak berikut:
- **PHP >= 8.2**
- **Composer** (untuk PHP dependency manager)
- **Node.js & NPM** (untuk frontend compiler)
- **Laragon / XAMPP** (sebagai server lokal)
- **Ngrok** (opsional, jika ingin menguji aplikasi secara online di handphone)

---

## 🚀 Langkah Instalasi & Setup Dependencies

Ikuti langkah-langkah di bawah ini untuk menyiapkan proyek di komputer lokal Anda:

### 1. Ekstrak / Tempatkan Folder Proyek
Pastikan folder proyek diletakkan di dalam direktori server lokal Anda. Jika menggunakan Laragon, letakkan folder ini di:
`C:\laragon\www\task-mate-app`

### 2. Instal PHP Dependencies (Composer)
Buka terminal/CMD di dalam folder proyek Anda, lalu jalankan perintah:
```bash
composer install
```

### 3. Instal Frontend Dependencies (NPM)
Instal paket-paket JavaScript dan Tailwind CSS yang dibutuhkan proyek:
```bash
npm install
```

### 4. Salin & Konfigurasi Environment File (`.env`)
Salin file konfigurasi template `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
*(Catatan di Windows: Jika perintah `cp` tidak dikenali di CMD biasa, Anda bisa menyalin dan mengubah nama file tersebut secara manual).*

### 5. Generate Application Key
Jalankan perintah ini untuk mengamankan enkripsi session aplikasi Anda:
```bash
php artisan key:generate
```

### 6. Konfigurasi & Migrasi Database
Secara default, Laravel 11 dikonfigurasi menggunakan **SQLite** (tidak perlu setup database server terpisah). Namun jika Anda ingin menggunakan database MySQL dari Laragon, edit file `.env` di baris database menjadi seperti ini:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task-mate-app
DB_USERNAME=root
DB_PASSWORD=
```
*(Pastikan Anda telah membuat database kosong bernama `task-mate-app` di MySQL).*

Setelah database dikonfigurasi, jalankan perintah migrasi tabel beserta pengisian data uji coba (seeder) bawaan:
```bash
php artisan migrate --seed
```

---

## 👤 Akun Uji Coba (Data Dummy)

Setelah proses `--seed` selesai, Anda dapat langsung login menggunakan akun testing yang sudah disiapkan di sistem:

| Nama User | Email | Password | Jumlah Tugas Default |
|---|---|---|---|
| **Yuzu** | `yuzu@example.com` | `password` | 10 Tugas + Sub-tugas |
| **Cece** | `cece@example.com` | `password` | 10 Tugas + Sub-tugas |

---

## 💻 Cara Menjalankan Project

### 1. Menjalankan Server Lokal (Backend)
Anda memiliki dua cara untuk membuka web ini di browser Anda:

*   **Cara A (Menggunakan Laragon / Apache):**
    Cukup nyalakan Laragon (klik **Start All**), lalu akses alamat berikut di browser:
    `http://task-mate-app.test`
    
*   **Cara B (Menggunakan Artisan Serve):**
    Jalankan perintah ini di terminal:
    ```bash
    php artisan serve
    ```
    Lalu akses aplikasi melalui alamat: `http://127.0.0.1:8000`

### 2. Menjalankan Compiler Asset (Vite & Tailwind)
*   **Mode Development (Pengerjaan/Live-editing):**
    Untuk mendeteksi perubahan tampilan secara real-time saat Anda mengedit code:
    ```bash
    npm run dev
    ```
*   **Mode Production (Rekomendasi Sebelum Share / Deploy):**
    Untuk mengompilasi CSS & JS menjadi file statis agar aplikasi berjalan lebih ringan dan kompatibel saat di-share:
    ```bash
    npm run build
    ```

---

## 📱 Cara Berbagi Akses Menggunakan Ngrok (Untuk Mobile/HP)

Agar aplikasi dapat diuji responsivitasnya secara langsung di smartphone, gunakan Ngrok dengan cara berikut:

1.  Pastikan aplikasi backend dan server Laragon sudah berjalan.
2.  Buka terminal/CMD, lalu jalankan perintah pemintas agar redirect HTTPS Laravel mengarah dengan benar ke browser mobile:
    ```bash
    ngrok http 127.0.0.1:80 --host-header=task-mate-app.test
    ```
3.  Salin link **HTTPS** yang ditampilkan oleh Ngrok (misal: `https://xxxx-xxxx.ngrok-free.app`) dan kirim ke handphone Anda.
4.  Buka link tersebut di browser handphone. Jika muncul halaman peringatan dari Ngrok, cukup klik tombol **"Visit Site"**.

---

Selamat mencoba dan mengelola tugas Anda dengan TaskMate! 🚀
