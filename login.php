<?php
session_start();
require 'config/functions.php';

// Ambil mode role dari URL (untuk keperluan CSS/Style jika diperlukan, default: professor)
// Meskipun satu tampilan, kita tetap bisa tangkap ini untuk variasi background jika mau.
$role_mode = isset($_GET['role']) ? $_GET['role'] : 'professor'; 
// ID Screen default (bisa pakai professorLoginScreen karena stylenya sama untuk center & black bg)
$screenID = 'professorLoginScreen'; 

if (isset($_POST['login'])) {
    $codename = $_POST['codename'];
    $password = $_POST['password'];

    // Cek Database
    $result = query("SELECT * FROM users WHERE codename = '$codename' AND password = '$password'");

    if (!empty($result)) {
        // Simpan data user di sesi
        $_SESSION['login'] = true;
        $_SESSION['user_id'] = $result[0]['id'];
        $_SESSION['role'] = $result[0]['role']; // Role ASLI dari database (bukan dari URL)
        $_SESSION['codename'] = $result[0]['codename'];

        // Redirect sesuai Role ASLI
        if ($result[0]['role'] == 'professor') {
            header("Location: professor/dashboard.php");
        } else {
            header("Location: crew/action.php");
        }
        exit;
    } else {
        echo "<script>alert('Login Gagal! Cek Codename/Password.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login System</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
    <div id="<?= $screenID; ?>" class="screen active" style="display: flex !important;">
        
        <div class="bank-background"></div>
        
        <a href="choose_role.php" class="back-button" style="text-decoration:none;">←</a>
        
        <div class="register-modal">
            <div class="logo-container">
                <div class="logo-line-1">
                    <span class="white">LA CASA </span><span class="logo-d">D</span><span class="logo-e">E</span>
                </div>
                <div class="logo-line-2">PAPEL</div>
            </div>
            
            <p class="tagline" style="margin-bottom: 40px;">Rencanakan perampokan dengan<br>professor dan crew</p>

            <form method="POST">
                <div class="form-group">
                    <label class="form-label">CODENAME</label>
                    <input type="text" name="codename" class="form-input" placeholder="TOKYO" required>
                </div>

                <div class="form-group">
                    <label class="form-label">PASSWORD</label>
                    <input type="password" name="password" class="form-input" placeholder="******" required>
                </div>

                <button type="submit" name="login" class="btn-submit">MASUK SISTEM</button>
            </form>
        </div>
    </div>
</body>
</html>