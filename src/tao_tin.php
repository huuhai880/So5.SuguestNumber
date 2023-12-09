<?php
session_start();
include('app/session_control.php');
?>
<!DOCTYPE html>
<html lang="">

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

  <link href="/css/taotin.bootstrap4.6.css" rel="stylesheet">
  <link href="/css/taotin.app.css" rel="stylesheet">
  <link href="/css/tao_tin.css" rel="stylesheet">
<!-- 
  <link rel="icon" type="image/png" sizes="32x32" href="https://lienquan5.com/img/icons/favicon-32x32.png">
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
  <!-- JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="app-background">
  <noscript><strong>We're sorry but GarenaLienQuan doesn't work properly without JavaScript
      enabled. Please enable it to continue.</strong></noscript>
  <?php
  include('tin/web_tao_tin.php');
  ?>
  <?php include('nav.php') ?>
  <div id="app" class="z-theme-dark_">
    <div id="main-app">

      <div class="b-overlay-wrap position-relative">
        <form action="tao_tin.php" method="post" id="form-tao-tin">
          <div class="bet-sms container">
            <div class="px-3">
              <div class="row filter">
                <div class="text-center text-light_ d-sm-none col-11">
                  <h4 class="mb-0 text-muted">Nhập tin</h4>
                </div>
              </div>

              <div class="row ">
                <div class="col-sm-6 col-md-6 col-6 form-inline">
                  <label for="thoi_gian_danh">Ngày đánh: </label>
                  <select id="thoi_gian_danh" name="thoi_gian_danh" class="custom-select custom-select-sm"
                    onchange="submitForm()">
                    <?php //Xuất các thời gian đánh
                    $days = array();
                    $daysOfWeek = array('CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7');
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    for ($i = 0; $i < 7; $i++) {
                      $days[] = date('d-m-Y', strtotime("-$i days"));
                    }
                    $thoi_gian_danh = date('d-m-Y');
                    if (isset($_POST["thoi_gian_danh"]))
                      $thoi_gian_danh = $_POST["thoi_gian_danh"];
                    if (isset($_GET["smsid"]))
                      $thoi_gian_danh = $tin_moi->thoi_gian_danh;
                    foreach ($days as $day) {
                      if (date('d-m-Y', strtotime($thoi_gian_danh)) === $day)
                        echo "<option value='$day' selected>" . $daysOfWeek[date('w', strtotime($day))] . ' : ' . $day . "</option>";
                      else
                        echo "<option value='$day'>" . $daysOfWeek[date('w', strtotime($day))] . ' : ' . $day . "</option>";
                    }
                    ?>
                  </select>
                </div>


                <div class="col-sm-6 col-md-6 col-6 form-inline">
                  <label for="tai_khoan_danh">Khách: </label>
                  <select id='tai_khoan_danh' name='tai_khoan_danh' class="custom-select ">
                    <?php
                    //Xuất ds tài khoản
                    include_once('app/class_sql_connector.php');
                    $tk_dang_dang_nhap = $_SESSION['username'];
                    $sql = "SELECT ten_tai_khoan FROM tai_khoan WHERE tai_khoan_quan_ly = '$tk_dang_dang_nhap'";
                    $sql_connector = new sql_connector();
                    if ($result = $sql_connector->get_query_result($sql)) {
                      $tk_danh = $tk_dang_dang_nhap;
                      if (isset($_POST["tai_khoan_danh"]))
                        $tk_danh = $_POST["tai_khoan_danh"];
                      if (isset($_GET["smsid"]))
                        $tk_danh = $tin_moi->tai_khoan_danh;
                      //In ra cho tài khoản hiện tại
                      if ($tk_danh === $tk_dang_dang_nhap)
                        echo '<option value="' . $tk_dang_dang_nhap . '" selected>' . '--- Không ai ---' . '</option>';
                      else
                        echo '<option value="' . $tk_dang_dang_nhap . '" >' . '--- Không ai ---' . '</option>';
                      //In ra cho các tài khoản con
                      while ($row = $result->fetch_assoc())
                        if ($row['ten_tai_khoan'] === $tk_danh) {
                          echo '<option value="' . $row['ten_tai_khoan'] . '" selected>' . $row['ten_tai_khoan'] . '</option>';
                        } else {
                          echo '<option value="' . $row['ten_tai_khoan'] . '">' . $row['ten_tai_khoan'] . '</option>';
                        }

                    }

                    ?>
                  </select>

                </div>

              </div>
            </div>
            <div dec="" class="card-group">
              <div class="card mb-0 card-editor card-border-top"><!----><!---->
                <div class="card-body"><!----><!---->
                  <div>
                    <div id="sms-editor" name="noi_dung" contenteditable="true" class="mb-2 m-input card-border-top"
                      style="padding: 5px; text-align: left; min-height: 130px; overflow-wrap: break-word;">
                      <?php
                      if(isset($luu_thanh_cong) && $luu_thanh_cong == true){
                        //Nếu lưu thành công thì không xuất nội dung
                      }
                      else{
                        if (isset($ket_qua_kiem_tra) && isset($tin_moi))
                          echo xuat_html_noi_dung_tin($ket_qua_kiem_tra, $tin_moi->noi_dung);
                        if (isset($_GET["smsid"]))
                          echo xuat_html_noi_dung_tin('', $tin_moi->noi_dung);
                      }
                     
                      ?>
                    </div>

                    <div class="btn-group w-100 mb-2">
                      <button type="button" class="btn mr-2 btn-success btn-sm" onclick="Submit('kiem_tra')">Kiểm
                        tra</button>
                      <button type="button" class="btn ml-2 btn-primary btn-sm" onclick="Submit('luu')">Lưu</button>
                      <button type="button" class="btn ml-2 btn-danger btn-sm">Xóa</button>
                      <input type="hidden" name="action" id="action">
                      <input type="hidden" name="noi_dung" id="noi_dung_an">
                      <?php
                       if(isset($luu_thanh_cong) && $luu_thanh_cong == true){
                        //Nếu lưu thành công thì không xuất nội dung
                      }
                      else{
                          //Lưu vết id tin đang xử lý
                        if (isset($_GET["smsid"]))
                          echo '<input type="hidden" name="smsid" id="smsid" value="' . $_GET["smsid"] . '">';
                        if (isset($_POST["smsid"]))
                          echo '<input type="hidden" name="smsid" id="smsid" value="' . $_POST["smsid"] . '">';
                      }
                      
                      ?>

                    </div>

                    <div class="msg-error">
                      <!-- Error here -->
                      <?php
                      if ($_SERVER['REQUEST_METHOD'] == 'POST')
                        echo xuat_html_loi($ket_qua_kiem_tra);
                      ?>
                    </div>
                  </div>
                </div><!----><!---->
              </div>

              <div class="card"><!----><!---->
                <div class="card-body"><!----><!---->
                  <div class="xac-trung card-border-bottom">
                    <!-- Table thong ke -->
                    <table role="table" class="table b-table" id="__BVID__439">
                      <thead role="rowgroup" class="text-sub">
                        <tr role="row" class="">
                          <th role="columnheader" scope="col" class="">Kiểu</th>
                          <th role="columnheader" scope="col" class="text-right">
                            <div class="custom-control custom-switch"><input type="checkbox" name="check-button"
                                class="custom-control-input" value="true" id="__BVID__444"><label
                                class="custom-control-label" for="__BVID__444"> Xác </label></div>
                          </th>
                          <th role="columnheader" scope="col" class="text-right">Thực Thu</th>
                          <th role="columnheader" scope="col" class="text-right">Trúng</th>
                        </tr>
                      </thead>
                      <?php
                      //--------------PHP Xuất HTML Thống kê
                       if(isset($luu_thanh_cong) && $luu_thanh_cong == true){
                        //Nếu lưu thành công thì không xuất nội dung
                        }
                        else{
                          if (isset($ds_thong_ke))
                            echo xuat_html_thong_ke($ds_thong_ke);
                        } 
                
                      ?>
                    </table>
                  </div>
                </div><!----><!---->
              </div>
            </div>

            <div class="card-group">
              <div class="card number-win"><!----><!---->
                <div class="row no-gutters">
                  <div class="col-2"><svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img"
                      aria-label="star half" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                      class="bi-star-half number-win-icon b-icon bi text-secondary">
                      <g transform="translate(8 8) scale(2.5 2.5) translate(-8 -8)">
                        <path
                          d="M5.354 5.119L7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.519.519 0 0 1-.146.05c-.341.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.171-.403.59.59 0 0 1 .084-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027c.08 0 .16.018.232.056l3.686 1.894-.694-3.957a.564.564 0 0 1 .163-.505l2.906-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.002 2.223 8 2.226v9.8z">
                        </path>
                      </g>
                    </svg></div>
                  <div class="col-10">
                    <div class="card-body text-center"><!----><!---->
                      <!-- Số trúng -->
                      <?php
                      if(isset($luu_thanh_cong) && $luu_thanh_cong == true){
                        //Nếu lưu thành công thì không xuất nội dung
                        }
                        else{
                          if (isset($tin)) {
                            if (!empty($tin->so_trung)) {
                              $ds_so_trung = explode(';', $tin->so_trung);
                              foreach ($ds_so_trung as $item) {
                                echo "<p>$item</p>";
                              }
                            }
                          }
                        } 
                      ?>
                    </div>
                  </div>
                </div><!----><!---->
              </div>
              <div class="card mb-1"><!----><!---->
                <div class="card-body"><!----><!---->
                  <table role="table" aria-busy="false" aria-colcount="5" class="table b-table table-borderless"
                    id="__BVID__425"><!----><!---->
                    <thead role="rowgroup" class="">
                      <tr role="row" class="">
                        <th role="columnheader" scope="col" aria-colindex="1" class=""><span class="text-sub">Đài</span>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="2" class=""><span class="text-sub">Số</span>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="3" class=""><span
                            class="text-sub">Kiểu</span>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="4" class=""><span
                            class="text-sub">Điểm</span>
                        </th>
                        <th role="columnheader" scope="col" aria-colindex="5" class=""><span
                            class="text-sub">Tiền</span>
                        </th>
                      </tr>
                    </thead>
                    <tbody role="rowgroup"><!---->
                      <!-- Chi tiết tin ở đây -->
                      <?php
                      if(isset($luu_thanh_cong) && $luu_thanh_cong == true){
                        //Nếu lưu thành công thì không xuất nội dung
                        }
                        else{
                          if (isset($ds_chi_tiet))
                            echo xuat_html_chitiettin($ds_chi_tiet);
                        } 
                      
                      ?>
                    </tbody><!---->
                  </table>
                </div><!----><!---->
              </div>
            </div>

          </div><!---->
          <form action="tao_tin.php" method="post">
      </div><!---->
      <!-- ---------------------------------Script submit----------------------- -->
      <script>
        function Submit(action) {

          var div_noidung = document.getElementById('sms-editor');
          var noi_dung = div_noidung.innerHTML;
          noi_dung = noi_dung.replace(/(<([^>]+)>)/ig, ''); //Bỏ ký tự html
          noi_dung = noi_dung.replace(/&nbsp;/g, ' ');
          noi_dung = noi_dung.replace(/\s+/g, ' ');//Hàm này sẽ thay &nbsp bằng khoảng trắng
          noi_dung = noi_dung.trim(); //Hàm loại bỏ khoảng trắng thừa
          var hiden_input_noidung = document.getElementById('noi_dung_an');
          hiden_input_noidung.value = noi_dung;

          var hiden_input_action = document.getElementById('action');
          hiden_input_action.value = action;
          var form_tao_tin = document.getElementById('form-tao-tin');
          form_tao_tin.submit();
        }
      </script>
      <?php include('footer.php'); ?>
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