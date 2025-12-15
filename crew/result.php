<?php
session_start();
require '../config/functions.php';

// 1. CEK KEAMANAN
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'crew') {
    header("Location: ../login.php");
    exit;
}

// 2. AMBIL DATA USER
$user_id  = $_SESSION['user_id'];
$codename = strtolower($_SESSION['codename']); // "tokyo", "rio", atau "denver"

// 3. TENTUKAN ID SCREEN SUPAYA CSS MASUK
$screenID = $codename . 'ResultScreen'; 

// 4. AMBIL DATA PILIHAN DARI DATABASE
$misi_terakhir = query("SELECT id FROM missions ORDER BY id DESC LIMIT 1")[0];
$id_misi = $misi_terakhir['id'];

$logs = query("SELECT * FROM mission_logs WHERE user_id = $user_id AND mission_id = $id_misi");

// Susun data (Array Associative)
$pilihan = [];
foreach ($logs as $log) {
    $pilihan[$log['phase']] = $log['choice'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Mission Result - <?= strtoupper($codename); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css"> 
</head>
<body>

    <div id="<?= $screenID; ?>" class="screen active" style="display: flex !important;">
        
        <div class="bank-background"></div>
        
        <div class="result-card">
            <h2 class="result-title">MISI SELESAI INI LAH KEPUTUSAN MU :</h2>

            <div class="result-list">
                PLANNING : <?= $pilihan['Planning'] ?? '-'; ?><br>
                EXECUTION : <?= $pilihan['Execution'] ?? '-'; ?><br>
                NEGOTIATION : <?= $pilihan['Negotiation'] ?? '-'; ?><br>
                ESCAPE : <?= $pilihan['Escape'] ?? '-'; ?>
            </div>
            
            <br>
            
            <a href="../logout.php" class="result-logout-btn" style="text-decoration:none; display:inline-block;">LOGOUT</a>
        </div>
    </div>

</body>
</html>