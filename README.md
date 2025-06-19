# 🎓 E-KaryaPTI (Galeri Karya Pendidikan Teknologi Informasi)

## 📜 Latar Belakang

E-KaryaPTI adalah platform digital yang dirancang untuk menampilkan dan mengelola karya-karya mahasiswa Program Studi Pendidikan Teknologi Informasi. Aplikasi ini bertujuan untuk memfasilitasi dokumentasi, penyimpanan, dan publikasi berbagai jenis karya mahasiswa seperti poster, video, aplikasi, website, dan lain-lain dalam satu platform terpadu. Dengan adanya E-KaryaPTI, karya-karya mahasiswa dapat lebih mudah diakses, dibagikan, dan diapresiasi oleh berbagai pihak, baik internal maupun eksternal.

## ✨ Fitur Utama

### 🌐 Fitur Publik

1. **🖼️ Galeri Karya**

   - Menampilkan semua karya mahasiswa dalam tampilan grid
   - Filter berdasarkan kategori, tahun, dan kata kunci pencarian
   - Pengurutan berdasarkan berbagai parameter (terbaru, judul, paling dilihat, tahun)
   - Tampilan thumbnail yang adaptif sesuai jenis file

2. **📋 Detail Karya**

   - Informasi lengkap mengenai karya (judul, deskripsi, pemilik, tahun)
   - Preview file langsung (gambar, PDF, video) atau tautan ke platform eksternal
   - Informasi kategori dan statistik tampilan
   - Karya terkait yang serupa

3. **🏷️ Kategori**

   - Pengelompokan karya berdasarkan kategori
   - Halaman khusus untuk setiap kategori

4. **🏠 Halaman Beranda**
   - Tampilan highlight karya-karya terbaru
   - Kategori populer
   - Statistik jumlah karya dan kontributor

### 👤 Fitur Pengguna Terdaftar

1. **📤 Manajemen Karya**

   - Unggah karya baru (file fisik atau tautan eksternal)
   - Edit informasi karya yang sudah ada
   - Hapus karya
   - Melihat statistik karya yang diunggah

2. **👤 Profil Pengguna**
   - Informasi pengguna
   - Daftar karya yang telah diunggah
   - Edit informasi profil

## 🛠️ Teknologi yang Digunakan

### 🖥️ Backend

- **PHP 8.0+** - Bahasa pemrograman utama
- **CodeIgniter 4** - Framework PHP yang digunakan
- **MySQL/MariaDB** - Database utama
- **SQLite** - Alternatif database untuk pengembangan

### 🎨 Frontend

- **HTML5, CSS3, JavaScript** - Bahasa markup dan styling dasar
- **Tailwind CSS** - Framework CSS untuk styling
- **Alpine.js** - Framework JavaScript ringan untuk interaktivitas
- **Font Awesome** - Icon pack

### 🔧 Fitur Teknis

- **📱 Responsif** - Tampilan adaptif untuk berbagai ukuran perangkat
- **⚡ AJAX** - Filtering dan pencarian tanpa refresh halaman
- **🖼️ Media Preview** - Thumbnail dan preview untuk berbagai jenis file
- **🔍 SEO Friendly** - URL yang mudah dibaca dan metadata yang optimal

## 📂 Struktur Aplikasi

### 📁 Direktori Utama

- **app/** - Kode inti aplikasi

  - **Controllers/** - Pengendali aplikasi
  - **Models/** - Model data
  - **Views/** - Tampilan aplikasi
  - **Config/** - Konfigurasi aplikasi
  - **Database/** - Migrasi dan seed database
  - **Filters/** - Filter untuk autentikasi dan otorisasi
  - **Helpers/** - Fungsi pembantu
  - **Libraries/** - Library tambahan

- **public/** - File yang dapat diakses publik
  - **assets/** - Aset statis (gambar, CSS, JS)
- **writable/** - Direktori dengan izin tulis
  - **cache/** - Cache aplikasi
  - **logs/** - Log sistem
  - **uploads/** - File yang diunggah pengguna
    - **thumbnails/** - Thumbnail untuk file yang diunggah

## 🚀 Cara Menjalankan Aplikasi

### 📋 Persyaratan Sistem

- PHP 8.0 atau versi lebih tinggi
- Ekstensi PHP: intl, mbstring, json, mysqlnd/sqlite3
- Composer
- MySQL/MariaDB atau SQLite
- Web server (Apache/Nginx) atau server PHP bawaan

### 📥 Langkah Instalasi

1. **📂 Kloning repositori**

   ```bash
   git clone https://github.com/username/E-KaryaPTI.git
   cd E-KaryaPTI
   ```

2. **📦 Instalasi dependency**

   ```bash
   composer install
   ```

3. **⚙️ Konfigurasi lingkungan**

   - Salin file `env` ke `.env`
   - Sesuaikan pengaturan database dan aplikasi di `.env`

   ```bash
   cp env .env
   ```

4. **🗃️ Setup database**

   - Untuk MySQL:
     ```bash
     # Buat database bernama 'ekaryapti'
     mysql -u root -p -e "CREATE DATABASE ekaryapti CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
     # Jalankan migrasi dan seeder
     php spark migrate
     php spark db:seed UserSeeder
     php spark db:seed CategorySeeder
     ```
   - Atau gunakan script SQL yang telah disediakan:
     ```bash
     mysql -u root -p ekaryapti < create_db.sql
     ```

5. **▶️ Jalankan server pengembangan**

   ```bash
   php spark serve
   ```

6. **🌐 Akses aplikasi**
   - Buka browser dan kunjungi `http://localhost:8080`

### 🔑 Akun Default

- **👑 Admin**:

  - Email: admin@ekaryapti.com
  - Password: admin123

- **👤 Pengguna**:
  - Email: user@example.com
  - Password: user123

## 📝 Mengelola Aplikasi

### 🔒 Pemberian Hak Akses

Aplikasi memiliki 3 level akses:

1. **👀 Guest** - Pengunjung tanpa login
2. **👤 User** - Pengguna terdaftar
3. **👑 Admin** - Administrator dengan akses penuh

### 📤 Pengaturan Upload

- File yang didukung: gambar, video, PDF, dokumen Office
- Ukuran maksimum file: 10MB
- Lokasi penyimpanan: `writable/uploads/`

### ��️ Maintenance Mode

Untuk mengaktifkan mode maintenance:

1. Edit file `.env`
2. Set `CI_ENVIRONMENT = maintenance`

## 🔄 Pengembangan Lanjutan

### 🏷️ Menambah Kategori Baru

Kategori dapat ditambahkan melalui:

1. Panel admin
2. Database seeder: `app/Database/Seeds/CategorySeeder.php`

### 🎨 Kustomisasi Tampilan

- Modifikasi file view di `app/Views/`
- Sesuaikan layout utama di `app/Views/layouts/main.php`
- Custom CSS dapat ditambahkan di `public/assets/css/`

### 📁 Menambah Jenis File

Untuk menambahkan dukungan jenis file baru:

1. Edit fungsi `get_file_type_info()` di `app/Helpers/custom_helper.php`
2. Tambahkan ekstensi file ke dalam grup yang sesuai
3. Siapkan thumbnail default di `public/assets/images/`

## ❓ Troubleshooting

### 🚨 Masalah Umum

- **❌ Error 500**: Periksa log di `writable/logs/`
- **⚠️ Gagal Upload**: Pastikan direktori `writable/uploads/` memiliki izin tulis
- **🖼️ Gambar Tidak Muncul**: Periksa path dan izin file di direktori uploads

### 📂 Izin File

Pastikan direktori berikut memiliki izin tulis:

```bash
chmod -R 755 writable/
chmod -R 755 public/assets/images/
```

## 👥 Kontributor

- 👨‍💻 Nama Developer
- 🎓 Program Studi Pendidikan Teknologi Informasi
- 🏛️ Universitas/Institusi

## 📄 Lisensi

[Sesuaikan dengan lisensi yang digunakan]

## 📞 Kontak

Untuk pertanyaan atau dukungan, silakan hubungi:

- ✉️ Email: contact@ekaryapti.com
- 🌐 Website: https://ekaryapti.com
