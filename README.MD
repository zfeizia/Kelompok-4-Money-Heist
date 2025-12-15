# 🏦 Money Heist: Mission Control System

## Deskripsi Aplikasi 🎭

**Money Heist: Mission Control** adalah aplikasi berbasis web yang dirancang sebagai simulasi sistem komando taktis. Aplikasi ini berfungsi sebagai jembatan komunikasi aman antara **The Professor** (Admin) sebagai pengatur strategi, dan **The Crew** (User) sebagai eksekutor di lapangan.

Sistem ini bertindak sebagai "Otak" operasi yang memusatkan seluruh alur informasi. Admin memiliki kendali penuh untuk merancang skenario, memantau fase perampokan, dan mengirimkan instruksi. Sebaliknya, User dapat mengakses antarmuka khusus untuk menerima perintah dan melakukan pengambilan keputusan (Voting) sesuai dengan kondisi yang ditetapkan oleh Admin.

Proyek ini disusun untuk memenuhi tugas responsi **Praktikum Pemrograman Web**.

## Fitur Utama 🚀

Sistem ini membagi hak akses menjadi dua peran utama dengan fungsionalitas yang berbeda:

### 1. The Professor (Administrator)
Bertanggung jawab atas manajemen strategi dan pengawasan operasi.
* Fitur untuk membuat dan menyusun detail rencana operasi (Target, Lokasi, Strategi Utama).
* Dashboard pemantauan fase operasi secara berurutan (*Planning, Execution, Negotiation, Escape*).
* Mengirimkan instruksi taktis (Opsi A / Opsi B) yang akan disinkronkan secara langsung ke perangkat Crew.

### 2. The Crew (User)
Bertanggung jawab sebagai penerima perintah dan eksekutor lapangan.
* Akses masuk menggunakan identitas karakter (Codename: Tokyo, Rio, Denver, dll).
* Antarmuka pengguna yang otomatis memperbarui tampilan berdasarkan fase dan instruksi yang dikirim oleh Professor.
* Fitur interaktif untuk memilih tindakan (Voting) berdasarkan instruksi yang diterima.

## Teknologi yang Digunakan 🛠️
Aplikasi ini dibangun menggunakan teknologi web standar:
* HTML 
* CSS
* JavaScript
* PHP Native
* MySQL
* Visual Studio Code
* XAMPP
* Git

## Struktur Project 📂

```text
MONEY_HEIST
│
├── 📂 assets/              # Asset (Gambar & Style)
│   ├── 📂 css/             # Stylesheet (style.css)
│   ├── 📂 img/             # Karakter (Tokyo, Rio, Professor) & Background
│   └── 📂 js/              # Script interaksi 
│
├── 📂 config/              # Konfigurasi
│   ├── functions.php       # Kumpulan fungsi CRUD
│   └── koneksi.php         # Koneksi Database MySQL
│
├── 📂 crew/                # Interface untuk Crew
│   ├── action.php          # Halaman Voting & Menerima Perintah
│   └── result.php          # Halaman Hasil Akhir Misi
│
├── 📂 professor/           # Interface untuk Professor
│   ├── create_mission.php  # Form Buat Misi
│   ├── dashboard.php       # Menu Utama Professor
│   └── live_monitor.php    # Pusat Kontrol Misi (Timeline)
│
├── choose_role.php         # Pemilihan Karakter
├── index.php               # Splash Screen
├── login.php               # Halaman Login
└── register.php            # Pendaftaran Akun Baru

```

## Demo Aplikasi 🎥
Berikut adalah simulasi penggunaan aplikasi Money Heist: Mission Control.
[![Demo Web](https://img.youtube.com/vi/F0Yo_Om1qZU/0.jpg)](https://www.youtube.com/watch?v=F0Yo_Om1qZU)
*Klik gambar di atas untuk melihat video demonstrasi.*

## Cara Instalasi 💻
1. Clone/Download repository ini dan letakkan di folder htdocs (XAMPP) atau www (Laragon).
2. Buat database baru di PHPMyAdmin dengan nama money_heist.
3. Import file money_heist.sql ke dalam database tersebut.
4. Pastikan konfigurasi di config/koneksi.php sudah sesuai.
5. Akses aplikasi melalui browser: localhost/money_heist.

## Kontributor 👷‍♂️
Kelompok 4 - Praktikum Pemrograman Web
Putri Isnaini Laksita Utami - (H1D024078) - putri.isnaini.l@mhs.unsoed.ac.id
Zainab Feizia - (H1D024097) - zainab.feizia@mhs.unsoed.ac.id
Agastya Itsar Maulana - (H1D024113) - agastya.maulana@mhs.unsoed.ac.id 

> *"Listen to me. In this world, everything is governed by balance. There's what you stand to gain and what you stand to lose. Today, we are not just coding... we are making history."* — The Professor