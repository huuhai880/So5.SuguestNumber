<?php 
    session_start();

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // Người dùng chưa đăng nhập, chuyển hướng về trang đăng nhập.
        header('Location: dang_nhap.php');
        exit;
    }
    else
        header('Location: tao_tin.php');
?>