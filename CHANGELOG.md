# Changelog DriveSurat

Semua perubahan signifikan pada proyek DriveSurat akan didokumentasikan di file ini.

Format changelog mengikuti [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
dan proyek ini mengikuti [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-09-19

### Added

-   Sistem arsip surat lengkap untuk Kelurahan Karangduren
-   CRUD operations untuk surat dan kategori
-   Upload dan preview file PDF
-   Fitur pencarian surat berdasarkan nomor surat
-   Dashboard dengan statistik surat
-   Responsive design dengan Bootstrap 5.3.3
-   UI modern dengan efek glassmorphism
-   Authentication system
-   Role-based access control
-   Export data ke berbagai format
-   Dark mode support
-   Multi-language support (Indonesia/English)

### Features

-   **Manajemen Surat**: Tambah, edit, hapus, dan view surat
-   **Kategori Surat**: Organisasi surat berdasarkan kategori
-   **Upload File**: Support upload PDF dengan validasi
-   **Pencarian**: Search functionality untuk nomor surat
-   **Dashboard**: Overview statistik dan aktivitas terbaru
-   **Responsive**: Mobile-friendly interface
-   **Security**: CSRF protection, input validation, file upload security

### Technical Features

-   Laravel 12.x framework
-   MySQL database dengan migrations
-   Vite untuk asset compilation
-   Bootstrap 5.3.3 untuk UI components
-   Font Awesome icons
-   Custom CSS dengan modern effects
-   PHPUnit untuk testing
-   Composer untuk dependency management

### Security

-   Input sanitization dan validation
-   File upload restrictions (PDF only, size limit)
-   CSRF protection pada semua forms
-   Secure file storage dengan symbolic links
-   Password hashing dengan bcrypt

---

## Development Notes

### Dependencies

-   PHP 8.1+
-   Laravel 12.x
-   MySQL 8.0+
-   Node.js 16+
-   Composer
-   NPM

### Installation

Lihat [README.md](README.md) untuk instruksi instalasi lengkap.

### Contributing

Lihat [CONTRIBUTING.md](CONTRIBUTING.md) untuk panduan berkontribusi.

---

**Catatan**: Versi ini adalah release awal untuk submission LSP Politeknik Negeri Malang.
