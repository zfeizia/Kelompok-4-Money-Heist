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

// --- LOGIKA AUTO-FLOW: MENENTUKAN FASE USER ---
$fase_user_aktif = 'Planning'; // Default awal
$option_a_display = "...";
$option_b_display = "...";

if ($misi_data) {
    $id_misi = $misi_data['id'];
    
    // Cek Log User
    $logs = query("SELECT phase FROM mission_logs WHERE user_id = $user_id AND mission_id = $id_misi");
    $fase_selesai = array_column($logs, 'phase'); 

    // Tentukan Fase Aktif
    if (!in_array('Planning', $fase_selesai)) {
        $fase_user_aktif = 'Planning';
    } elseif (!in_array('Execution', $fase_selesai)) {
        $fase_user_aktif = 'Execution';
    } elseif (!in_array('Negotiation', $fase_selesai)) {
        $fase_user_aktif = 'Negotiation';
    } elseif (!in_array('Escape', $fase_selesai)) {
        $fase_user_aktif = 'Escape';
    } else {
        // Semua selesai
        header("Location: result.php");
        exit;
    }

    // AMBIL TEKS DARI KOLOM SPESIFIK (HASIL ALTER TABLE)
    $col_a = strtolower($fase_user_aktif) . '_a';
    $col_b = strtolower($fase_user_aktif) . '_b';
    
    $option_a_display = $misi_data[$col_a] ?? "MENUNGGU INSTRUKSI...";
    $option_b_display = $misi_data[$col_b] ?? "MENUNGGU INSTRUKSI...";
    
    // Jika masih kosong (Professor belum buat), tampilkan waiting
    if(empty($option_a_display)) $option_a_display = "MENUNGGU INSTRUKSI...";
    if(empty($option_b_display)) $option_b_display = "MENUNGGU INSTRUKSI...";
}

// --- LOGIKA SUBMIT ---
if (isset($_POST['kirim_opsi'])) {
    if ($misi_data) {
        $pilihan = $_POST['pilihan'];
        if(!empty($pilihan)) {
            $id_misi = $misi_data['id'];
            
            // Simpan ke database sesuai FASE USER
            $query = "INSERT INTO mission_logs (user_id, mission_id, phase, choice)
                      VALUES ('$user_id', '$id_misi', '$fase_user_aktif', '$pilihan')";
            mysqli_query($conn, $query);

            // Redirect Langsung
            if ($fase_user_aktif == 'Escape') {
                header("Location: result.php");
            } else {
                header("Location: action.php?view=mission");
            }
            exit;
        }
    }
}

// --- ASSETS ---
if ($codename == 'TOKYO') {
    $img_full = '../assets/img/tokyo-full.png';
    $img_landing = '../assets/img/tokyo-landing.png';
    $bio_text = "Tokyo adalah narator cerita sekaligus jantung emosional kelompok. Dibawa masuk ke grup oleh Profesor setelah hidupnya kacau, dia impulsif, penuh gairah, dan mudah terbawa emosi. Sifatnya yang panas sering menjadi sumber konflik, tetapi keberanian dan loyalitasnya tak diragukan. Dia mewakili kekacauan dan naluri bertahan hidup.";
    $id_crew = "CREW_01";
} elseif ($codename == 'RIO') {
    $img_full = '../assets/img/rio-full.png';
    $img_landing = '../assets/img/rio-landing.png';
    $bio_text = "Rio adalah otak teknologi di balik perampokan. Meski jenius di bidangnya, secara emosional dia sangat muda, naif, dan mudah panik. Ketergantungannya pada Tokyo dan kerapuhan mentalnya sering diuji dalam tekanan perampokan. Rio mewakili ketidakdewasaan yang dipaksa menjadi dewasa dalam situasi ekstrem.";
    $id_crew = "CREW_03";
} elseif ($codename == 'DENVER') {
    $img_full = '../assets/img/denver-full.png';
    $img_landing = '../assets/img/denver-landing.png';
    $bio_text = "denver yang berasal  dari Moscow ini terlihat menyeramkan tetapi sebenarnya paling polos dan sensitif di kelompok. Hatinya mudah tersentuh, cepat jatuh cinta, dan punya tawa khas yang menular. Denver adalah karakter yang tumbuh paling pesat: dari seorang bocah yang mengikuti perintah ayahnya menjadi pria yang mengambil tanggung jawab untuk orang yang dicintainya.";
    $id_crew = "CREW_02";
} else {
    $img_full = '../assets/img/tokyo-full.png';
    $img_landing = '../assets/img/tokyo-landing.png';
    $bio_text = "UNKNOWN CREW MEMBER";
    $id_crew = "UNKNOWN";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Mission Control - <?= $codename; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    
    <?php if ($option_a_display == "MENUNGGU INSTRUKSI...") : ?>
        <meta http-equiv="refresh" content="3">
    <?php endif; ?>

    <style>
        #crewLandingScreen { background: radial-gradient(circle at center 40%, #800000 0%, #000000 90%); background-attachment: fixed; position: relative; width: 100vw; height: 100vh; overflow-x: hidden; overflow-y: auto; }
        #crewLandingScreen::after { content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 60%; background: linear-gradient(to top, #000000 30%, transparent 100%); z-index: 5; pointer-events: none; }
        .crew-hero-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1; text-align: center; width: 100%; height: 100vh; pointer-events: none; display: flex; align-items: center; justify-content: center; }
        .crew-big-name { font-family: 'Bebas Neue', sans-serif; font-size: 20vw; color: rgba(255, 255, 255, 0.1); letter-spacing: 10px; line-height: 1; }
        .crew-full-img { position: absolute; top: 0; left: 0; width: 100%; height: 100vh; object-fit: cover; object-position: center top; z-index: 2; pointer-events: none; }
        .crew-menu-container { position: relative; z-index: 10; margin-top: 100vh; display: flex; justify-content: center; padding-bottom: 100px; padding-top: 50px; background: #000000; width: 100%; }
        .crew-menu-container::before { content: ''; position: absolute; top: -150px; left: 0; width: 100%; height: 150px; background: linear-gradient(to bottom, transparent, #000000); pointer-events: none; }
        .prof-bio-section { background: #C31C22; position: relative; z-index: 20; box-shadow: 0 -20px 50px rgba(0,0,0,0.5); }
    </style>
</head>
<body>

    <?php if ($view_mode == 'landing') : ?>
        <div id="crewLandingScreen" class="screen active" style="display: block !important;">
            <button class="back-button" onclick="location.href='../logout.php'" style="top: 30px; left: 30px; z-index: 100; cursor: pointer;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M5 12L12 19M5 12L12 5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <div class="crew-hero-text"><span class="crew-big-name"><?= $codename; ?></span></div>
            <img src="<?= $img_full; ?>" onerror="this.src='../assets/img/tokyo-full.png'" alt="Character" class="crew-full-img">
            <div class="crew-menu-container">
                <div class="menu-card">
                    <div class="card-icon-circle"><img src="../assets/img/live-monitor.png" alt="Dali" class="card-icon-img"></div>
                    <button class="menu-action-btn" onclick="location.href='action.php?view=mission'">CHOOSE PLAN</button>
                </div>
            </div>
            <div class="prof-bio-section">
                <div class="bio-left">
                    <h1 class="bio-title-vertical"><?= $codename; ?></h1>
                    <img src="<?= $img_landing; ?>" onerror="this.src='../assets/img/tokyo-landing.png'" alt="Face" class="bio-face" style="height: 300px;">
                </div>
                <div class="bio-right"><p class="bio-text"><?= $bio_text; ?></p></div>
            </div>
        </div>
    <?php else : ?>
        <div id="tokyoMissionScreen" class="screen active" style="display: flex !important; height: 100vh; overflow: hidden;">
            <div class="tokyo-sidebar">
                <div class="tokyo-sidebar-header">
                    <a href="action.php?view=landing" class="tokyo-sidebar-back" style="text-decoration:none;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M19 12H5M5 12L12 19M5 12L12 5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <div class="header-text-col"><h1 class="tokyo-sidebar-title"><?= $codename; ?></h1><span class="tokyo-id-text">ID : <?= $id_crew; ?></span></div>
                </div>
                <div class="gold-divider-line"></div>
                <button class="tokyo-menu-btn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
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
                            <span class="tm-value"><?= $misi_data ? strtoupper($misi_data['location']) : 'MENUNGGU DATA...'; ?></span>
                        </div>
                        <div class="tm-divider-gold"></div>
                        <div id="tmPhaseTitle" class="tm-plan-title">PHASE SEKARANG : <?= strtoupper($fase_user_aktif); ?></div>

                        <form method="POST" id="formPilihan">
                            <button type="button" class="tm-plan-btn" id="btnA" onclick="selectOption('A')">PLAN A : <?= $option_a_display; ?></button>
                            <button type="button" class="tm-plan-btn" id="btnB" onclick="selectOption('B')">PLAN B : <?= $option_b_display; ?></button>
                            <input type="hidden" name="pilihan" id="inputPilihan">
                            <button type="submit" name="kirim_opsi" class="tm-submit-btn">KIRIM OPSI</button>
                        </form>

                        <script>
                            function selectOption(val) {
                                document.getElementById('btnA').style.background = 'transparent'; document.getElementById('btnA').style.borderColor = '#444';
                                document.getElementById('btnB').style.background = 'transparent'; document.getElementById('btnB').style.borderColor = '#444';
                                const activeBtn = document.getElementById('btn' + val);
                                activeBtn.style.background = '#2a2a2a'; activeBtn.style.borderColor = '#D4AF37';
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