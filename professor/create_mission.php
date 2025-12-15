<?php
session_start();
require '../config/functions.php';

// Cek Login & Role
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'professor') {
    header("Location: ../login.php");
    exit;
}

$success = false;

// Logic Simpan Misi
if (isset($_POST['buat_misi'])) {
    if (tambah_misi($_POST) > 0) {
        $success = true; // Trigger Modal
    } else {
        echo "<script>alert('Gagal membuat misi!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Create Mission</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div id="createMissionScreen" class="screen active" style="display:flex !important;">
        <div class="mission-sidebar">
            <div class="sidebar-header">
                <div class="back-icon" onclick="location.href='dashboard.php'" style="cursor:pointer;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </div>
                <div class="professor-id">
                    <h2 class="prof-title">PROFESSOR</h2>
                    <span class="id-text">ID : MASTERMIND_01</span>
                </div>
            </div>

            <div class="sidebar-menu">
                <div class="menu-item active">
                    <span class="wrench-icon">🔧</span>
                    CREATE MISSION
                </div>
            </div>

            <div class="sidebar-footer">
                <button class="logout-btn" onclick="location.href='../logout.php'">LOGOUT</button>
            </div>
        </div>

        <div class="mission-content">
            <h1 class="page-title">BUAT RENCANA</h1>
            <div class="red-divider"></div>

            <div class="mission-form-card">
                <form method="POST">
                    <div class="form-row">
                        <div class="form-col full">
                            <label>JUDUL OPERASI</label>
                            <input type="text" name="judul" class="mission-input" placeholder="OPPERATION : BANK INDONESIA" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col half">
                            <label>TARGET LOKASI</label>
                            <input type="text" name="lokasi" class="mission-input" placeholder="BANK INDONESIA , JAKARTA" required>
                        </div>
                        <div class="form-col half">
                            <label>JUMLAH CREW</label>
                            <input type="number" name="jumlah_crew" class="mission-input" placeholder="3" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col full">
                            <label>STRATEGI UTAMA ( DESKRIPSI )</label>
                            <textarea name="strategi" class="mission-textarea" placeholder="DESKRIPSIKAN STRATEGI..."></textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="action-btn abort" onclick="location.href='dashboard.php'">ABORT</button>
                        <div class="right-actions">
                            <button type="button" class="action-btn re-strategy" onclick="document.querySelector('textarea').value=''">RE STRATEGI</button>
                            <button type="submit" name="buat_misi" class="action-btn create">BUAT MISI</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="missionCreatedModal" class="mission-modal-overlay <?= $success ? 'active' : ''; ?>">
        <div class="mission-modal-content">
            <div class="modal-icon-container">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#C31C22" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                    </path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
            <div class="modal-details">
                <h2 class="modal-title">MISSION CREATED</h2>
                <div class="modal-buttons">
                    <button class="modal-btn new" onclick="location.href='create_mission.php'">NEW MISSION</button>
                    <button class="modal-btn complete" onclick="location.href='live_monitor.php'">COMPLETE</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>