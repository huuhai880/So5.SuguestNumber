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

  <!-- <link rel="icon" type="image/png" sizes="32x32" href="https://lienquan5.com/img/icons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="https://lienquan5.com/img/icons/favicon-16x16.png"> -->

  <meta name="theme-color" content="#4DBA87">
  <meta name="apple-mobile-web-app-capable" content="no">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="Garena Liên Quân">

  <!-- <link rel="apple-touch-icon" href="https://lienquan5.com/img/icons/apple-touch-icon-152x152.png">
  <link rel="mask-icon" href="https://lienquan5.com/img/icons/safari-pinned-tab.svg" color="#4DBA87"> -->

  <meta name="msapplication-TileImage" content="/img/icons/msapplication-icon-144x144.png">
  <meta name="msapplication-TileColor" content="#000000">

  <link rel="stylesheet" type="text/css" href="css/footer.css"> <!-- css footer -->


    <link rel="stylesheet" type="text/css" href="css/app.css">
    <link rel="stylesheet" type="text/css" href="css/ql_tin.css">

     <!-- JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>

<body class="app-background" data-modal-open-count="0" style=""><noscript><strong>We're sorry but GarenaLienQuan doesn't
            work properly without JavaScript enabled. Please enable it to continue.</strong></noscript>
    <?php 
        include('tin/web_ql_tin.php');
    ?>
    <div id="app" class="z-theme-dark_">
        <div id="main-app">
            <?php include('nav.php') ?>
            <div class="b-overlay-wrap position-relative">
                <div class="bet-list mb-5 container">
                <form action="ql_tin.php" method="post" id="form_kieu_tim_kiem">
                    <div class="px-3"> <!-- Thanh điều khiển -->
                        <div class="row mt-2 mb-2 align-items-center">
                            
                                <div class="mb-2 select_box col-sm-6 col-md-3 col-6">
                                    <select name='tai_khoan_can_tim' class="custom-select custom-select-sm" onchange="submitForm()"> <!-- DS tài khoản -->
                                        <?php
                                        if($tai_khoan_can_tim === 'all')
                                            echo '<option value="all" selected>Tất cả khách</option>';
                                        else
                                            echo '<option value="all">Tất cả khách</option>';

                                        include_once('app/class_sql_connector.php');
                                        $tk_dang_dang_nhap = $_SESSION['username'];
                                        $sql = "SELECT ten_tai_khoan FROM tai_khoan WHERE ten_tai_khoan = '$tk_dang_dang_nhap' OR tai_khoan_quan_ly = '$tk_dang_dang_nhap'";
                                        $sql_connector = new sql_connector();
                                        if ($result = $sql_connector->get_query_result($sql)){
                                            while ($row = $result->fetch_assoc()){
                                                if($row['ten_tai_khoan'] === $tai_khoan_can_tim)
                                                    echo '<option value="' . $row['ten_tai_khoan'] . '" selected>' . $row['ten_tai_khoan'] . '</option>';
                                                else
                                                    echo '<option value="' . $row['ten_tai_khoan'] . '">' . $row['ten_tai_khoan'] . '</option>';
                                            }
                                        }
                                            
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-2 col-sm-6 col-md-2 col-6"> <!-- Ngày tháng -->
                                    <select name="ngay_can_tim" class="custom-select custom-select-sm" onchange="submitForm()">
                                        <?php

                                        $days = array();
                                        $daysOfWeek = array('CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7');
                                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                                        for ($i = 0; $i < 7; $i++) {
                                            $days[] = date('d-m-Y', strtotime("-$i days"));
                                        }
                                        foreach ($days as $day) {
                                            if(date('d-m-Y', strtotime($ngay_can_tim)) === $day)
                                                echo "<option value='$day' selected>". $daysOfWeek[date('w',strtotime($day))] .' : '. $day ."</option>";
                                            else 
                                                echo "<option value='$day'>". $daysOfWeek[date('w',strtotime($day))] .' : '. $day ."</option>";
                                        }
                                            if($ngay_can_tim === 'all')
                                                echo "<option value='all' selected>7 ngày gần đây</option>";
                                            else
                                                echo "<option value='all'>7 ngày gần đây</option>";
                                        ?>
                                    </select>
                                </div>
                            
                     

                            <div class="mb-2 col-sm-3 col-md-2 col-12">
                                <button type="button" class="btn w-100 btn-danger btn-sm">Xóa</button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <form id="form-sua-tin" action="tao_tin.php" method="post">
                        <input type="hidden" name="smsid">
                    </form>
                    <script>
                        // hàm để submit form kiểu tìm kiếm
                        function submitForm() {
                            let form = document.getElementById("form_kieu_tim_kiem");
                            form.submit();
                        }

                    </script>
                    <div>
                        <div class="list-group">
                            <?php
                                echo xuat_html_ds_tin($ds_tin);
                            ?>
                        </div>
                        <div data-v-644ea9c9="" class="infinite-loading-container">
                            <div data-v-644ea9c9="" class="infinite-status-prompt"
                                style="color: rgb(102, 102, 102); font-size: 14px; padding: 10px 0px; display: none;"><i
                                    data-v-46b20d22="" data-v-644ea9c9="" class="loading-default"></i></div>
                            <div data-v-644ea9c9="" class="infinite-status-prompt" style="">
                                <div data-v-644ea9c9=""></div>
                            </div>
                            <div data-v-644ea9c9="" class="infinite-status-prompt" style="display: none;">
                                <div data-v-644ea9c9=""></div>
                            </div>
                            <div data-v-644ea9c9="" class="infinite-status-prompt"
                                style="color: rgb(102, 102, 102); font-size: 14px; padding: 10px 0px; display: none;">
                                Opps, something went wrong :(
                                <br data-v-644ea9c9=""> <button data-v-644ea9c9=""
                                    class="btn-try-infinite">Retry</button>
                            </div>
                        </div>
                    </div>
                </div><!---->
            </div><!---->
            <!-- footer here -->
            <?php include('footer.php') ?>
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

  <!-- Script thông báo -->
    <script type="text/javascript">
		$(document).ready(function(){
			// Hiển thị popup
			$('.b-toaster-bottom-right').fadeIn();

			// Bắt sự kiện click trên trang web
			$(document).click(function(event) { 
				$('.b-toaster-bottom-right').fadeOut();
			});
		});
	</script>
</body>

</html>