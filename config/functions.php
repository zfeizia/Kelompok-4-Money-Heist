<?php
// 1. PANGGIL FILE KONEKSI (Supaya nyambung ke database)
require 'koneksi.php';

// 2. FUNGSI QUERY (Untuk mengambil data)
function query($query) {
    global $conn; // Mengambil variabel $conn dari koneksi.php
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}

// 3. FUNGSI TAMBAH MISI (Create)
function tambah_misi($data) {
    global $conn;
    
    // Ambil data dan amankan dari karakter aneh
    $judul = htmlspecialchars($data["judul"]);
    $lokasi = htmlspecialchars($data["lokasi"]);
    $crew = htmlspecialchars($data["jumlah_crew"]);
    $strategi = htmlspecialchars($data["strategi"]);
    
    // Set nilai default awal misi
    $fase = 'Planning';
    $status = 'Active';
    $opsi_a = 'Menunggu Instruksi...';
    $opsi_b = 'Menunggu Instruksi...';

    // Masukkan ke database
    $query = "INSERT INTO missions 
              (title, location, crew_count, strategy, current_phase, status_mission, option_a_text, option_b_text)
              VALUES
              ('$judul', '$lokasi', '$crew', '$strategi', '$fase', '$status', '$opsi_a', '$opsi_b')
              ";
              
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
?>