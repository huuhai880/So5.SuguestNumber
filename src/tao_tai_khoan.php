<?php session_start();
include('app/session_control.php'); 
include('app/admin_check.php'); 
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,viewport-fit=cover">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="theme-color" content="#35363a">


  <style>
    body {
      font-family: Arial, Avenir, Helvetica, sans-serif !important
    }
  </style>
  <title>GarenaLienQuan</title>


  <!-- Quang trọng -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>

  <link href="css/taotin.bootstrap4.6.css" rel="stylesheet">
  <link href="css/taotin.app.css" rel="stylesheet">
  <link href="css/tao_tin.css" rel="stylesheet">

  <link rel="icon" type="image/png" sizes="32x32" href="https://lienquan5.com/img/icons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="https://lienquan5.com/img/icons/favicon-16x16.png">

  <meta name="theme-color" content="#4DBA87">
  <meta name="apple-mobile-web-app-capable" content="no">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="Garena Liên Quân">

  <link rel="apple-touch-icon" href="https://lienquan5.com/img/icons/apple-touch-icon-152x152.png">
  <link rel="mask-icon" href="https://lienquan5.com/img/icons/safari-pinned-tab.svg" color="#4DBA87">

  <meta name="msapplication-TileImage" content="/img/icons/msapplication-icon-144x144.png">
  <meta name="msapplication-TileColor" content="#000000">

  <link rel="stylesheet" type="text/css" href="css/footer.css"> <!-- css footer -->

  <link rel="stylesheet" type="text/css" href="css/chi_tiet_khach.css">
  <link rel="stylesheet" type="text/css" href="css/app.css">

</head>

<body class="app-background"><noscript><strong>We're sorry but GarenaLienQuan doesn't work properly without JavaScript
      enabled. Please enable it to continue.</strong></noscript>

  <?php
  // $document_root = $document_root ?? $_SERVER['DOCUMENT_ROOT'];
  // include($document_root . '/tai_khoan/web_tao_tai_khoan.php');
  $dir_name = dirname(__FILE__);
  require_once($dir_name . '/tai_khoan/web_tao_tai_khoan.php');
  ?>
  <div id="app" class="z-theme-dark_">
    <div id="main-app">
      <?php include('nav.php')?> 
      <form action="tao_tai_khoan.php" method="post">
        <div class="b-overlay-wrap position-relative">
          <div class="customer-detail container">
            <div class="px-3">
              <div class="row mt-2 mb-2 align-items-center">
                <div class="col-sm-6 col-2">
                  <a href="" class="button-back d-sm-none">
                    <!-- <button type="button" class="btn btn_p25 fz12 btn-outline-secondary_ btn-sm">
                                        <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img"
                                            aria-label="arrow left" xmlns="http://www.w3.org/2000/svg"
                                            fill="currentColor" class="bi-arrow-left b-icon bi">
                                            <g>
                                                <path fill-rule="evenodd"
                                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z">
                                                </path>
                                            </g>
                                        </svg></button> -->
                  </a>
                </div>
                <div class="text-right col-sm-4 col-7">
                  <?php 
                    if(isset($_GET["user"]))
                      echo '<input type="text" placeholder="Nhập tên khách hàng"
                        required="required" aria-required="true" class="form-control" id="" name="tk_can_tao" value = "'.$_GET["user"].'" disabled>';
                    else
                      echo '<input type="text" placeholder="Nhập tên khách hàng"
                        required="required" aria-required="true" class="form-control" id="" name="tk_can_tao" pattern="^(?!.*all)[a-zA-Z0-9_]{3,}$">';
                  ?>

                  

                </div>
                <div class="col-sm-2 col-2"><button type="submit" class="btn btn-primary btn-sm"> Lưu
                  </button></div>
              </div>
              <hr class="my-2">
            </div>
            <div class="content pt-3">
              <div class="px-3">
                <h3>Miền Bắc</h3>
                <?php echo xuat_html_chitiet($ds_chitiet_cau_hinh_mien_bac, $vi_tri_bat_dau); ?>


                <hr class="my-2">
                <h3>Miền Nam</h3>
                <?php echo xuat_html_chitiet($ds_chitiet_cau_hinh_mien_nam, $vi_tri_bat_dau); ?>

                <hr class="my-2">
                <h3>Miền Trung</h3>
                <?php echo xuat_html_chitiet($ds_chitiet_cau_hinh_mien_trung, $vi_tri_bat_dau); ?>

                <h3>Chọn thứ tự đài</h3>
                <div class="text-center text-info mb-2"><small>Cú pháp dc,dp nhận theo thứ tự bạn
                    chọn</small></div>
                <?php echo xuat_html_thudai($ds_thu_tu_dai); ?>
              </div>
              <div class="ml-3 mr-3"><button type="button" class="btn btn-primary btn-block">Lưu</button>
              </div>
              <div class="empty-block"></div>
            </div>
          </div><!---->
        </div><!---->
        <?php 
          if(isset($_GET["user"]) || isset($_POST["cap_nhat"]))
            echo '<input type="hidden" name="cap_nhat" value="cap_nhat">';
        ?>
      </form>
      <?php include('footer.php');?>
    </div>
  </div>
</body>

</html>