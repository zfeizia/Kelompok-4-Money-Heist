<?php
session_start();

// 1. CEK KEAMANAN: Pastikan user sudah login dan role-nya adalah 'professor'
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'professor') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Professor Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <div id="professorLandingScreen" class="screen active" style="display:block !important;">
        
        <button class="back-button" onclick="location.href='../logout.php'" style="top: 30px; left: 30px; z-index: 100; cursor: pointer;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="4" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>

        <div class="hero-text-layer">
            <span class="hero-el">EL</span>
            <span class="hero-profesor">PROFESOR</span>
        </div>

        <img src="../assets/img/professor-full.png" alt="Professor" class="full-screen-prof">

        <div class="prof-menu-container">
            <div class="menu-card">
                <div class="card-icon-circle">
                    <img src="../assets/img/create-mission.png" onerror="this.style.display='none'" alt="Blue Icon"
                        class="card-icon-img">
                </div>
                <button class="menu-action-btn" onclick="location.href='create_mission.php'">CREATE MISSION</button>
            </div>

            <div class="menu-card">
                <div class="card-icon-circle">
                    <img src="../assets/img/live-monitor.png" onerror="this.style.display='none'" alt="Red Icon"
                        class="card-icon-img">
                </div>
                <button class="menu-action-btn" onclick="location.href='live_monitor.php'">LIVE MONITOR</button>
            </div>
        </div>

        <div class="prof-bio-section">
            <div class="bio-left">
                <h1 class="bio-title-vertical">EL PROFESSOR</h1>
                <img src="../assets/img/professor-landing.png" alt="Professor Face" class="bio-face">
            </div>
            <div class="bio-right">
                <p class="bio-text">
                    THE PROFESSOR, ATAU SERGIO MARQUINA, ADALAH SOSOK MASTERMIND YANG MENGATUR SELURUH OPERASI
                    PERAMPOKAN DENGAN PRESISI SEPERTI SEORANG ILMUWAN MENYIAPKAN EKSPERIMEN. IA BUKAN TIPE KRIMINAL YANG
                    MENGANDALKAN KEKERASAN; KEKUATANNYA ADA PADA LOGIKA, STRATEGI, DAN KEMAMPUAN MEMBACA GERAKAN MUSUH
                    BEBERAPA LANGKAH KE DEPAN. SETIAP SKENARIO YANG IA RANCANG SELALU MEMILIKI RENCANA CADANGAN, BAHKAN
                    RENCANA CADANGAN DARI RENCANA CADANGAN ITU SENDIRI.
                </p>
            </div>
        </div>
    </div>

</body>
</html>