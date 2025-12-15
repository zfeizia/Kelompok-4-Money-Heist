<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Pilih Peran</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* CSS Khusus Halaman Ini untuk presisi UI */
        .choose-role-modal {
            background: #222;
            width: 500px;
            padding: 40px;
            border-radius: 20px;
            position: relative;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .choose-role-modal::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 10px;
            background: #C31C22;
            border-radius: 20px 20px 0 0;
        }
        .choose-role-title {
            color: #d4af37;
            font-size: 24px;
            letter-spacing: 2px;
            text-align: left; /* Sesuai gambar */
            margin-bottom: 5px;
        }
        .choose-role-subtitle {
            font-size: 10px;
            color: #ccc;
            letter-spacing: 1px;
            margin-bottom: 40px;
            text-transform: uppercase;
        }
        
        .avatar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            margin-bottom: 40px;
        }
        .avatar-row-top {
            display: flex;
            justify-content: center;
        }
        .avatar-row-bottom {
            display: flex;
            justify-content: center;
            gap: 30px; /* Jarak antar crew */
        }

        .avatar-item {
            position: relative;
            width: 110px; /* Diperbesar sesuai request */
            height: 110px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, #ff4d4d, #990000);
            border: 5px solid #600000; /* Border lebih tebal & gelap */
            box-shadow: 0 5px 15px rgba(0,0,0,0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.3s;
            text-decoration: none;
            overflow: hidden; /* Supaya gambar kepotong lingkaran */
        }
        .avatar-item:hover {
            transform: scale(1.1);
            background: radial-gradient(circle at 30% 30%, #ff6666, #b30000);
        }
        .avatar-img {
            width: 90px; /* Gambar diperbesar */
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            object-position: top;
            margin-bottom: 5px; /* Geser ke atas dikit biar nama muat */
        }
        .avatar-name {
            position: absolute;
            bottom: 8px; /* Posisi teks di bawah */
            color: #fff;
            font-size: 16px; /* Font dibesarkan */
            font-weight: 400;
            text-shadow: 2px 2px 4px #000; /* Shadow lebih kuat agar terbaca */
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 1.5px;
            z-index: 2;
        }
        
        .back-link-custom {
            display: block;
            text-align: left;
            color: #3498db;
            font-size: 12px;
            text-decoration: none;
            letter-spacing: 1px;
            margin-top: 10px;
        }
        .back-link-custom:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div id="chooseRoleScreen" class="screen active" style="align-items: center; justify-content: center; background: #000;">
        <div class="bank-background"></div>
        
        <div class="choose-role-modal" style="z-index: 10;">
            <h2 class="choose-role-title">CHOOSE ROLE</h2>
            <p class="choose-role-subtitle">PILIH SALAH SATU CREW UNTUK JOIN PERAMPOKAN</p>

            <div class="avatar-container">
                <!-- ROW 1: PROFESSOR -->
                <div class="avatar-row-top">
                    <a href="login.php?role=professor" class="avatar-item">
                        <img src="assets/img/professor-face.png" class="avatar-img" alt="Professor">
                        <span class="avatar-name">EL PROFESOR</span>
                    </a>
                </div>

                <!-- ROW 2: CREW -->
                <div class="avatar-row-bottom">
                    <a href="login.php?role=crew" class="avatar-item">
                        <img src="assets/img/tokyo-face.png" class="avatar-img" alt="Tokyo">
                        <span class="avatar-name">TOKYO</span>
                    </a>
                    <a href="login.php?role=crew" class="avatar-item">
                        <img src="assets/img/rio-face.png" class="avatar-img" alt="Rio">
                        <span class="avatar-name">RIO</span>
                    </a>
                    <a href="login.php?role=crew" class="avatar-item">
                        <img src="assets/img/denver-face.png" class="avatar-img" alt="Denver">
                        <span class="avatar-name">DENVER</span>
                    </a>
                </div>
            </div>
            
            <a href="index.php" class="back-link-custom">KEMBALI KE LOGIN</a>
        </div>
    </div>
</body>
</html>