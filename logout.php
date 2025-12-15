<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();
// Kembali ke halaman awal
header("Location: index.php");
exit;
?>