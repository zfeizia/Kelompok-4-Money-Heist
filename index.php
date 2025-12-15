<?php
session_start();
// Redirect kalau sudah login (biar gak bolak-balik)
if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] == 'professor') {
        header("Location: professor/dashboard.php");
    } else {
        header("Location: crew/action.php");
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Casa De Papel</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div id="homeScreen" class="screen active">
        <div class="bank-background"></div>
        <div class="home-modal">
            <div class="logo-container">
                <div class="logo-line-1"><span class="white">LA CASA </span><span class="red">DE</span></div>
                <div class="logo-line-2">PAPEL</div>
            </div>
            <p class="tagline">Rencanakan perampokan dengan<br>professor dan crew</p>
            <div class="button-group">
                <a href="choose_role.php" class="btn" style="text-decoration:none;">SIGN IN</a>
                <a href="register.php" class="btn" style="text-decoration:none;">SIGN UP</a>
            </div>
        </div>
    </div>
</body>
</html>