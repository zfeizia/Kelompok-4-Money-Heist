<?php
session_start();
require '../config/functions.php';

// 1. CEK KEAMANAN
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'crew') {
    header("Location: ../login.php");
    exit;
}

// 2. DATA USER & MISI
$codename = strtoupper($_SESSION['codename']); 
$user_id  = $_SESSION['user_id'];

// Ambil Misi Terakhir
$misi_result = query("SELECT * FROM missions ORDER BY id DESC LIMIT 1");
$misi_data   = !empty($misi_result) ? $misi_result[0] : null;

$view_mode = isset($_GET['view']) ? $_GET['view'] : 'landing';

// --- LOGIKA SUBMIT JAWABAN (DIPERBARUI) ---
if (isset($_POST['kirim_opsi'])) {
    if ($misi_data) {
        $pilihan = $_POST['pilihan'];
        
        if(!empty($pilihan)) {
            $fase    = $misi_data['current_phase'];
            $id_misi = $misi_data['id'];

            // 1. Simpan ke database
            $query = "INSERT INTO mission_logs (user_id, mission_id, phase, choice)
                      VALUES ('$user_id', '$id_misi', '$fase', '$pilihan')";
            mysqli_query($conn, $query);

            // 2. LOGIKA REDIRECT (Tanpa Alert)
            if ($fase == 'Escape') {
                // Jika fase ESCAPE, langsung lempar ke RESULT
                header("Location: result.php");
                exit;
            } else {
                // Jika fase lain, refresh halaman ini saja
                header("Location: action.php?view=mission");
                exit;
            }
        }
    }
}

// --- VARIABEL ASSETS (Sama seperti sebelumnya) ---
if ($codename == 'TOKYO') {
    $img_full    = '../assets/img/tokyo-full.png';
    $img_landing = '../assets/img/tokyo-landing.png';
    $bio_text    = "TOKYO ADALAH NARATOR CERITA SEKALIGUS JANTUNG EMOSIONAL KELOMPOK. DIBAWA MASUK KE GRUP OLEH PROFESOR SETELAH HIDUPNYA KACAU, DIA IMPULSIF, PENUH GAIRAH, DAN MUDAH TERBAWA EMOSI.";
    $id_crew     = "CREW_01";
} elseif ($codename == 'RIO') {
    $img_full    = '../assets/img/rio-full.png';
    $img_landing = '../assets/img/rio-landing.png';
    $bio_text    = "RIO ADALAH OTAK TEKNOLOGI DI BALIK PERAMPOKAN. MESKI JENIUS DI BIDANGNYA, SECARA EMOSIONAL DIA SANGAT MUDA, NAIF, DAN MUDAH PANIK. KETERGANTUNGANNYA PADA TOKYO SERING DIUJI.";
    $id_crew     = "CREW_03";
} elseif ($codename == 'DENVER') {
    $img_full    = '../assets/img/denver-full.png';
    $img_landing = '../assets/img/denver-landing.png';
    $bio_text    = "DENVER ADALAH PETARUNG JALANAN DENGAN HATI EMAS. DI BALIK TAWA KHASNYA YANG MENGGELEGAR, IA MEMILIKI KETULUSAN DAN LOYALITAS TINGGI KEPADA AYAHNYA, MOSCOW, DAN KELOMPOK.";
    $id_crew     = "CREW_02";
} else {
    $img_full    = '../assets/img/tokyo-full.png';
    $img_landing = '../assets/img/tokyo-landing.png';
    $bio_text    = "UNKNOWN CREW MEMBER";
    $id_crew     = "UNKNOWN";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Mission Control - <?= $codename; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <style>
        /* CSS KHUSUS LANDING PAGE CREW */
        #crewLandingScreen {
            background: radial-gradient(circle at center 40%, #800000 0%, #000000 90%);
            background-attachment: fixed;
            position: relative;
            width: 100vw;
            height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
        }
        
        #crewLandingScreen::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60%; 
            background: linear-gradient(to top, #000000 30%, transparent 100%);
            z-index: 5; 
            pointer-events: none;
        }

        .crew-hero-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            text-align: center;
            width: 100%;
            height: 100vh;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .crew-big-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 20vw;
            color: rgba(255, 255, 255, 0.1);
            letter-spacing: 10px;
            line-height: 1;
        }

        .crew-full-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            object-fit: cover;
            object-position: center top;
            z-index: 2;
            pointer-events: none;
        }

        .crew-menu-container {
            position: relative;
            z-index: 10;
            margin-top: 100vh; 
            display: flex;
            justify-content: center;
            padding-bottom: 100px;
            padding-top: 50px;
            background: #000000;
            width: 100%;
        }

        .crew-menu-container::before {
            content: '';
            position: absolute;
            top: -150px;
            left: 0;
            width: 100%;
            height: 150px;
            background: linear-gradient(to bottom, transparent, #000000);
            pointer-events: none;
        }

        .prof-bio-section {
            background: #C31C22;
            position: relative;
            z-index: 20;
            box-shadow: 0 -20px 50px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body>

    <?php if ($view_mode == 'landing') : ?>
        
        <div id="crewLandingScreen" class="screen active" style="display: block !important;">
            
            <button class="back-button" onclick="location.href='../logout.php'" style="top: 30px; left: 30px; z-index: 100; cursor: pointer;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div class="crew-hero-text">
                <span class="crew-big-name"><?= $codename; ?></span>
            </div>

            <img src="<?= $img_full; ?>" onerror="this.src='../assets/img/tokyo-full.png'" alt="Character" class="crew-full-img">

            <div class="crew-menu-container">
                <div class="menu-card">
                    <div class="card-icon-circle">
                        <img src="../assets/img/live-monitor.png" alt="Dali" class="card-icon-img">
                    </div>
                    <button class="menu-action-btn" onclick="location.href='action.php?view=mission'">CHOOSE PLAN</button>
                </div>
            </div>

            <div class="prof-bio-section">
                <div class="bio-left">
                    <h1 class="bio-title-vertical"><?= $codename; ?></h1>
                    <img src="<?= $img_landing; ?>" onerror="this.src='../assets/img/tokyo-landing.png'" alt="Face" class="bio-face" style="height: 550px;">
                </div>
                <div class="bio-right">
                    <p class="bio-text"><?= $bio_text; ?></p>
                </div>
            </div>

        </div>

    <?php else : ?>

        <div id="tokyoMissionScreen" class="screen active" style="display: flex !important; height: 100vh; overflow: hidden;">
            <div class="tokyo-sidebar">
                <div class="tokyo-sidebar-header">
                    <a href="action.php?view=landing" class="tokyo-sidebar-back" style="text-decoration:none;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <div class="header-text-col">
                        <h1 class="tokyo-sidebar-title"><?= $codename; ?></h1>
                        <span class="tokyo-id-text">ID : <?= $id_crew; ?></span>
                    </div>
                </div>

                <div class="gold-divider-line"></div>

                <button class="tokyo-menu-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    LOG MISSION
                </button>

                <a href="../logout.php" class="tokyo-logout-btn" style="text-decoration:none; text-align:center;">LOGOUT</a>
            </div>

            <div class="tokyo-mission-content">
                <h1 class="tm-header-title">LOG MISSION</h1>

                <div class="tm-card">
                    <div class="tm-card-top-bar"></div>

                    <div class="tm-card-body">
                        <div class="tm-target-row">
                            <span class="tm-label">TARGET LOKASI</span>
                            <span class="tm-value">
                                <?= $misi_data ? strtoupper($misi_data['location']) : 'MENUNGGU DATA...'; ?>
                            </span>
                        </div>
                        <div class="tm-divider-gold"></div>

                        <div id="tmPhaseTitle" class="tm-plan-title">
                            PHASE SEKARANG : <?= $misi_data ? strtoupper($misi_data['current_phase']) : '-'; ?>
                        </div>

                        <form method="POST" id="formPilihan">
                            <button type="button" class="tm-plan-btn" id="btnA" onclick="selectOption('A')">
                                PLAN A : <?= $misi_data ? $misi_data['option_a_text'] : '...'; ?>
                            </button>

                            <button type="button" class="tm-plan-btn" id="btnB" onclick="selectOption('B')">
                                PLAN B : <?= $misi_data ? $misi_data['option_b_text'] : '...'; ?>
                            </button>

                            <input type="hidden" name="pilihan" id="inputPilihan">
                            <button type="submit" name="kirim_opsi" class="tm-submit-btn">KIRIM OPSI</button>
                        </form>

                        <script>
                            function selectOption(val) {
                                document.getElementById('btnA').style.background = 'transparent';
                                document.getElementById('btnA').style.borderColor = '#444';
                                document.getElementById('btnB').style.background = 'transparent';
                                document.getElementById('btnB').style.borderColor = '#444';

                                const activeBtn = document.getElementById('btn' + val);
                                activeBtn.style.background = '#2a2a2a';
                                activeBtn.style.borderColor = '#D4AF37';
                                document.getElementById('inputPilihan').value = val;
                            }
                        </script>

                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

</body>
</html>