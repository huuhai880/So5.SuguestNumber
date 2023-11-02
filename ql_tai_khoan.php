<?php 
    session_start();
    include('app/session_control.php'); 
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
 <!-- JQuery -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="app-background"><noscript><strong>We're sorry but GarenaLienQuan doesn't work properly without JavaScript
            enabled. Please enable it to continue.</strong></noscript>

    <?php
        include('tai_khoan/web_quan_ly_tai_khoan.php');
        
    ?>
    
    <div id="app" class="z-theme-dark_">
        <div id="main-app">
            <?php include('nav.php')?> 
            <div class="b-overlay-wrap position-relative">
                <div class="customer-list container">
                    <div class="d-flex align-items-center mt-2 mb-3 px-3">
                        <h4 class="mr-auto mt-2">Danh sách khách hàng</h4><a href="/tao_tai_khoan.php"
                            class="btn btn-primary" target="_self"><svg viewBox="0 0 16 16" width="1em" height="1em"
                                focusable="false" role="img" aria-label="person plus" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" class="bi-person-plus b-icon bi">
                                <g>
                                    <path
                                        d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z">
                                    </path>
                                </g>
                            </svg> Tạo mới </a>
                    </div>
                    <div class="card card-border-top mb-5"><!----><!---->
                        <div class="card-body"><!----><!---->
                            <div role="group" class="input-group input-group-sm"><!----><input type="text"
                                    placeholder="Nhập tên khách hàng" class="form-control" id="__BVID__80"><!----></div>
                            <table role="table" aria-busy="false" aria-colcount="4"
                                class="table b-table content table-borderless" id="__BVID__81"><!----><!---->
                                <thead role="rowgroup" class=""><!---->
                                    <tr role="row" class="">
                                        <th role="columnheader" scope="col" aria-colindex="1" class="">
                                            <div>Stt</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="2" class="text-left">
                                            <div>Tên</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="3" class="text-left">
                                            <div>Cảnh báo</div>
                                        </th>
                                        <th role="columnheader" scope="col" aria-colindex="4" class="text-right">
                                            <div>Action</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody role="rowgroup"><!---->
                                    <?php 
                                        echo xuat_html_ds_tk($danh_sach_tai_khoan);
                                    ?>
                                </tbody><!---->
                            </table>
                        </div><!----><!---->
                    </div><!---->
                </div><!---->
            </div><!---->
            <!-- footer here -->
            <?php 
                include('footer.php')
            ?>
        </div>
    </div>

     <!-- Thông báo -->
  <div id="b-toaster-bottom-right" class="b-toaster b-toaster-bottom-right mb-5">
    <div class="b-toaster-slot vue-portal-target">
      <div role="alert" aria-live="assertive" aria-atomic="true"
        class="b-toast b-toast-solid b-toast-append b-toast-success" style="">
        <div id="toaster-body" tabindex="0" class="toast">
          <?php 
            if(isset($thong_bao)){
              if($thong_bao != ''){
                echo '<div class="toast-body">'. $thong_bao .'</div>';
              }
            }
          ?>
        <!-- <div class="toast-body">Cược thành công 122,310 !</div> -->
        </div>
      </div>
    </div>
  </div>
  <!-- Hết thông báo -->

    <script  type="text/javascript">
        $(document).ready(function(){
			// Hiển thị popup
			$('.b-toaster-bottom-right').fadeIn();

			// Bắt sự kiện click trên trang web
			$(document).click(function(event) { 
				$('.b-toaster-bottom-right').fadeOut();
			});
		});
        
        //Hàm xử lý Submit
            function CallSubmit(username) {
                let result = confirm("Bạn có muốn  xoá tài khoản: " + username);
                if (result) {
                let form = document.getElementById(username);
                form.submit();
                } else {
                // làm gì đó nếu người dùng nhấn Cancel
                }
            }  
        </script>

</body>

</html>