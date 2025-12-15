<?php
require 'config/functions.php';

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $codename = strtoupper($_POST['codename']); // Ubah ke huruf besar
    $password = $_POST['password'];

    // --- LOGIKA OTOMATIS ROLE ---
    // Kalau namanya "PROFESSOR", otomatis jadi role professor
    // Kalau nama kota lain (Tokyo, Berlin, dll), jadi crew
    if ($codename === 'PROFESSOR') {
        $role = 'professor';
        $avatar = 'professor-face.png';
    } else {
        $role = 'crew';
        $avatar = 'tokyo-face.png'; // Default avatar crew
    }

    $query = "INSERT INTO users (email, codename, password, role, avatar) 
              VALUES ('$email', '$codename', '$password', '$role', '$avatar')";
    
   if(mysqli_query($conn, $query)){
        // Langsung pindahkan user ke choose_role.php tanpa notifikasi
        header("Location: choose_role.php");
        exit;
    } else {
        echo "<script>alert('Gagal Daftar!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div id="registerScreen" class="screen active" style="display:flex !important;"> 
        <div class="bank-background"></div>
        <div class="register-modal">
            <h2 class="register-title">RECRUITMENT FORM</h2>
            <p class="register-subtitle">PILIH NAMA KOTA SEBAGAI CODE NAME ANDA INI AKAN MENJADI<br>IDENTITAS SELAMANYA
            </p>

            <form method="POST">
                <div class="form-group">
                    <label class="form-label">EMAIL</label>
                    <input type="email" name="email" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">NAMA KOTA ( CODENAME )</label>
                    <input type="text" name="codename" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label">PASSWORD</label>
                    <input type="password" name="password" class="form-input" required>
                </div>

                <button type="submit" name="register" class="btn-submit">JOIN THE HEIST</button>
            </form>

           <a href="index.php" class="back-link">KEMBALI KE LOGIN</a>
        </div>
    </div>
</body>
</html>