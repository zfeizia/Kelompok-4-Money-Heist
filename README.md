# 🏦 LA CASA DE PAPEL: MISSION CONTROL

> *"Listen to me. In this world, everything is governed by balance. There's what you stand to gain and what you stand to lose. Today, we are not just coding... we are making history."* — **The Professor**

## 🎭 About The Website
Selamat datang di Resistance. Sistem ini adalah "Otak" dari operasi kita. Dibangun untuk memastikan komunikasi antara The Professor (Admin) dan para Crew (User) di lapangan. Tidak ada ruang untuk kesalahan. Aplikasi ini mengatur segalanya: dari merancang skenario perampokan, memantau situasi, hingga eksekusi rencana pelarian.

**Target Operasi:** Menyelesaikan tugas Praktikum Pemrograman Web dengan nilai sempurna.

## 🗺️ The Master Plan (Fitur)
Sistem ini dibekali fitur-fitur untuk kelancaran misi:

* 🕵️‍♂️ Akses khusus sang Mastermind. Membuat misi, mengubah strategi, dan menghapus jejak (CRUD Misi).
* 👺 Akses khusus untuk Tokyo, Rio, Denver. Menerima briefing rahasia dan menjalankan misi.
* 📡 Professor bisa mengubah fase misi dan Crew akan menerima perintahnya.
* 📝Setiap keputusan yang diambil Crew terekam abadi di database. 

## The Arsenal (Teknologi)
Senjata yang kita gunakan untuk membangun sistem ini:

* HTML & CSS 
* PHP 
* MySQL 
* Visual Studio Code 
* XAMPP 
* Git 

## 🔐 Protocol: Initiation (Cara Install)

Ikuti instruksi ini dengan hati-hati. Jangan sampai tertangkap basah.

1.  **Infiltrasi (Download):**
    Clone atau download repository ini.
2.  **Secure Location (Move File):**
    Pindahkan folder project ke dalam folder htdocs pada XAMPP (biasanya di C:\xampp\htdocs\money_heist).
3.  **Activate Server:**
    Nyalakan **Apache** dan **MySQL**.
4.  **Inject Database:**
    * Masuk ke `localhost/phpmyadmin`.
    * Buat database baru dengan nama: `money_heist`.
    * Import file `money_heist.sql` yang sudah kami sediakan.
5.  **Connect:**
    Buka browser dan akses jalur aman: `localhost/money_heist`.

## Operative (Demo Website)


## 📂 The Blueprints (Struktur File)

```text
money_heist/
│
├── assets/             # Menyimpan file statis (CSS, Gambar, Font)
│   ├── css/            # Stylesheet tema Money Heist
│   └── img/            # Aset gambar karakter & background
│
├── config/             # Konfigurasi Backend Utama
│   ├── koneksi.php     # Koneksi ke database MySQL
│   └── functions.php   # Kumpulan function (CRUD & Helper)
│
├── professor/          # Halaman khusus Admin (The Professor)
│   ├── dashboard.php   # Landing page & list misi aktif
│   ├── create.php      # Form pembuatan misi baru
│   └── monitor.php     # Live monitoring & control panel
│
├── crew/               # Halaman khusus User (Crew)
│   ├── briefing.php    # Halaman detail misi & strategi
│   ├── action.php      # Halaman eksekusi pilihan aksi
│   └── summary.php     # Laporan hasil aksi crew
│
├── index.php           # Halaman awal / Redirect
├── login.php           # Halaman autentikasi pengguna
├── register.php        # Halaman pendaftaran crew baru
└── logout.php          # Script terminasi sesi

```

## Kontributor 👷‍♂️
1. Putri Isnaini Laksita Utami (H1D024078 / email)
2. Zainab Feizia (H1D024097 / zainab.feizia@mhs.unsoed.ac.id)
3. AGASTYA ITSAR MAULANA (H1D024113 / Email)
