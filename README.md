# Sistem Informasi Konversi Mahasiswa RPL (Rekognisi Pembelajaran Lampau)

[![Laravel Version](https://img.shields.io/badge/Laravel-v12.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-v8.2-777BB4?logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-v8.0-4479A1?logo=mysql&logoColor=white)](https://mysql.com)

Sistem Informasi Konversi Mahasiswa RPL adalah platform berbasis web yang dirancang untuk mengotomatisasi proses birokrasi konversi kredit akademik bagi mahasiswa jalur Rekognisi Pembelajaran Lampau (RPL). Sistem ini mentransformasi pencatatan manual menjadi digital secara terstruktur guna memastikan **akurasi perhitungan kredit 100% sesuai standar akademik institusi**.

## 🚀 Fitur Utama

- **Automated Credit Calculation Logic:** Mesin kalkulasi otomatis berbasis Laravel yang memproses riwayat kerja dan studi lampau calon mahasiswa menjadi ekuivalensi SKS.
- **Dynamic Criteria Mapping:** Skema pemetaan mata kuliah yang fleksibel dan dapat dikonfigurasi secara dinamis sesuai kurikulum program studi.
- **Real-Time SQL Validation & Data Integrity:** Perancangan model basis data relasional yang ketat untuk menjamin validitas hitungan angka SKS secara instan tanpa risiko duplikasi data.
- **Secure RESTful API Integration:** Arsitektur backend yang siap diintegrasikan dengan Sistem Informasi Akademik (SIAKAD) utama institusi.
- **Interactive Dashboard & Reporting:** Visualisasi data pendaftaran, status konversi, serta generasi dokumen laporan otomatis untuk kebutuhan administrasi kelulusan.

## 🛠️ Tech Stack & Arsitektur

- **Backend Framework:** PHP (Laravel)
- **Database:** MySQL (Query Optimization & Relational Data Modeling)
- **Architecture Pattern:** Model-View-Controller (MVC) & Clean Business Logic Layer
- **API Management:** RESTful API Endpoint (JSON Response)

## 📋 Prasyarat Sistem

Sebelum menjalankan proyek ini secara lokal, pastikan perangkat Anda telah memenuhi spesifikasi berikut:

- PHP >= 8.2 (dengan ekstensi BCMath, Ctype, PDO, dll)
- Composer >= 2.x
- MySQL Server >= 8.0
