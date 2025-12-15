<?php
session_start();
require '../config/functions.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'professor') {
    header("Location: ../login.php");
    exit;
}

// Ambil Misi Terakhir
$misi_result = query("SELECT * FROM missions ORDER BY id DESC LIMIT 1");
if (empty($misi_result)) {
    echo "<script>alert('Belum ada misi!'); location.href='create_mission.php';</script>";
    exit;
}
$misi_data = $misi_result[0];
$id_misi = $misi_data['id'];

// --- LOGIKA UPDATE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Ganti Fase (Klik Timeline)
    if (isset($_POST['set_phase'])) {
        $new_phase = $_POST['set_phase'];
        mysqli_query($conn, "UPDATE missions SET current_phase='$new_phase' WHERE id=$id_misi");
    }
    
    // 2. Kirim Perintah (Update Teks)
    if (isset($_POST['update_monitor'])) {
        $opsi_a = htmlspecialchars($_POST['opsi_a_text']);
        $opsi_b = htmlspecialchars($_POST['opsi_b_text']);
        mysqli_query($conn, "UPDATE missions SET option_a_text='$opsi_a', option_b_text='$opsi_b' WHERE id=$id_misi");
        echo "<script>alert('Perintah Terkirim ke Crew!');</script>";
    }

    // 3. Hapus Instruksi
    if (isset($_POST['hapus_instruksi'])) {
        $reset = "Menunggu Instruksi...";
        mysqli_query($conn, "UPDATE missions SET option_a_text='$reset', option_b_text='$reset' WHERE id=$id_misi");
    }

    // Refresh data agar tampilan update
    $misi_result = query("SELECT * FROM missions WHERE id=$id_misi");
    $misi_data = $misi_result[0];
}

// Helper untuk class active button
function activeClass($phase, $current) {
    return ($phase === $current) ? 'active' : '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Live Monitor</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        /* Target semua input teks instruksi */
        .instr-input-box {
            background-color: rgba(20, 20, 20, 0.9) !important; /* Latar Gelap */
            color: #ffffff !important; /* Teks Putih */
            border: 2px solid #C31C22 !important; /* Garis Merah */
            padding: 15px !important;
            font-family: 'Bebas Neue', sans-serif !important;
            font-size: 20px !important;
            letter-spacing: 2px;
            outline: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
            width: 100%;
            text-transform: uppercase;
        }

        /* Efek saat diklik */
        .instr-input-box:focus {
            border-color: #D4AF37 !important; /* Jadi Emas saat aktif */
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
            background-color: #000 !important;
        }
    </style>
</head>
<body>
    <div id="liveMonitorScreen" class="screen active" style="display:flex !important;">
        <div class="mission-sidebar">
            <div class="sidebar-header">
                <div class="back-icon" onclick="location.href='dashboard.php'" style="cursor:pointer;">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4">
                        <path d="M19 12H5M12 19l-7-7 7-7" />
                    </svg>
                </div>
                <div class="professor-id">
                    <h2 class="prof-title">PROFESSOR</h2>
                    <span class="id-text">ID : MASTERMIND_01</span>
                </div>
            </div>

            <div class="sidebar-menu">
                <div class="menu-item active" style="margin-top: 10px;">
                    <span class="monitor-icon">🖥</span>
                    LIVE MONITOR
                </div>
            </div>

            <div class="sidebar-footer">
                <button class="logout-btn" onclick="location.href='../logout.php'">LOGOUT</button>
            </div>
        </div>

        <form class="mission-content" method="POST" style="height:100vh; display:flex; flex-direction:column;">
            <h1 class="page-title">MISSION TIMELINE</h1>

            <div class="timeline-container">
                <button type="submit" name="set_phase" value="Planning" class="timeline-btn <?= activeClass('Planning', $misi_data['current_phase']); ?>">1.PLANNING</button>
                <button type="submit" name="set_phase" value="Execution" class="timeline-btn <?= activeClass('Execution', $misi_data['current_phase']); ?>">2.EXECUTION</button>
                <button type="submit" name="set_phase" value="Negotiation" class="timeline-btn <?= activeClass('Negotiation', $misi_data['current_phase']); ?>">3.NEGOTIATION</button>
                <button type="submit" name="set_phase" value="Escape" class="timeline-btn <?= activeClass('Escape', $misi_data['current_phase']); ?>">4.ESCAPE</button>
            </div>

            <div class="red-divider full-width"></div>

            <div class="monitor-split">
                <div class="phase-card">
                    <div class="phase-content">
                        <h2 id="phaseTitle" class="phase-title">PHASE SAAT INI :<br><?= strtoupper($misi_data['current_phase']); ?></h2>
                        <div id="phaseIcon" class="phase-icon">
                            <?php if($misi_data['current_phase'] == 'Planning'): ?>
                                <svg width="80" height="140" viewBox="0 0 80 140" fill="none"><rect x="5" y="5" width="70" height="130" rx="10" stroke="#800000" stroke-width="8" fill="#1a1a1a" /><path d="M25 70 L35 80 L55 50" stroke="#800000" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" /></svg>
                            <?php elseif($misi_data['current_phase'] == 'Execution'): ?>
                                <svg width="100" height="100" viewBox="0 0 100 100" fill="none"><rect x="10" y="10" width="80" height="80" rx="15" fill="#800000"/><path d="M30 50 L45 65 L70 35" stroke="#1a1a1a" stroke-width="12" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <?php elseif($misi_data['current_phase'] == 'Negotiation'): ?>
                                <svg width="100" height="100" viewBox="0 0 100 100" fill="none"><circle cx="50" cy="35" r="15" stroke="#800000" stroke-width="8" /><path d="M20 80 Q50 40 80 80" stroke="#800000" stroke-width="8" stroke-linecap="round" fill="none" /><line x1="20" y1="80" x2="80" y2="80" stroke="#800000" stroke-width="8" stroke-linecap="round" /></svg>
                            <?php else: // Escape ?>
                                <svg width="100" height="100" viewBox="0 0 100 100" fill="none"><circle cx="50" cy="20" r="10" fill="#800000" /><path d="M50 30 L50 60" stroke="#800000" stroke-width="8" stroke-linecap="round" /><path d="M50 35 L30 50 M50 35 L70 50" stroke="#800000" stroke-width="8" stroke-linecap="round" /><path d="M50 60 L35 90 M50 60 L65 90" stroke="#800000" stroke-width="8" stroke-linecap="round" /></svg>
                            <?php endif; ?>
                        </div>
                        <p id="phaseDesc" class="phase-desc">STATUS: ACTIVE<br>SILAKAN UPDATE INSTRUKSI</p>
                    </div>
                </div>

                <div class="instruction-panel">
                    <h2 class="instr-title">INSTRUKSI PROFESSOR</h2>

                    <div class="instr-group">
                        <label class="instr-label">OPSI A : ( AGGRESIVE )</label>
                        <input type="text" name="opsi_a_text" class="instr-input-box" value="<?= $misi_data['option_a_text']; ?>">
                    </div>

                    <div class="instr-group">
                        <label class="instr-label">OPSI B : ( DEFENSIVE )</label>
                        <input type="text" name="opsi_b_text" class="instr-input-box" value="<?= $misi_data['option_b_text']; ?>">
                    </div>

                    <div class="instr-actions-row">
                        <button type="submit" name="hapus_instruksi" class="action-small-btn delete" onclick="return confirm('Hapus Instruksi?')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="square" stroke-linejoin="miter">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                            DELETE
                        </button>
                        <button type="button" class="action-small-btn re-strat" onclick="location.reload()">REFRESH</button>
                    </div>

                    <button type="submit" name="update_monitor" class="btn-send-command">KIRIM PERINTAH</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>