<?php 
    if ($_SESSION["loai_tai_khoan"] === 'std'){
        header('Location: tao_tin.php');
        exit;
    }
?>