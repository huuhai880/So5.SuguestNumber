<?php 
    session_start();
    include('app/session_control.php'); 
?>
<!DOCTYPE html>
<html lang="vi">

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

</head>

<body class="app-background" data-modal-open-count="0" style=""><noscript><strong>We're sorry but GarenaLienQuan doesn't
            work properly without JavaScript enabled. Please enable it to continue.</strong></noscript>
    <?php
    include('thong_ke/web_thong_ke.php');
    ?>
    <div id="app" class="z-theme-dark_">
        <div id="main-app">
            <?php include('nav.php') ?>
            <div class="b-overlay-wrap position-relative">
                <div class="report container">
                    <div class="px-3">
                        <form action="thongke.php" method="post">
                            <div class="row mb-2 align-items-center">
                                <div class="mb-2 text-right col-sm-6 col-7">
                                    <select name="ngay_can_tim" class="custom-select custom-select-sm"
                                        onchange="submitForm()">
                                        <?php
                                        $days = array();
                                        $daysOfWeek = array('CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7');
                                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                                        for ($i = 0; $i < 7; $i++) {
                                            $days[] = date('d-m-Y', strtotime("-$i days"));
                                        }
                                        $ngay_cantim = date('d-m-Y');
                                        if (isset($_POST["ngay_can_tim"]))
                                            $ngay_cantim = $_POST["ngay_can_tim"];

                                        foreach ($days as $day) {
                                            if (date('d-m-Y', strtotime($ngay_can_tim)) === $day)
                                                echo "<option value='$day' selected>". $daysOfWeek[date('w',strtotime($day))] .' : '. $day ."</option>";
                                            else
                                                echo "<option value='$day'>". $daysOfWeek[date('w',strtotime($day))] .' : '. $day ."</option>";
                                        }
                                        if ($ngay_cantim === 'all')
                                            echo "<option value='all' selected>7 ngày gần đây</option>";
                                        else
                                            echo "<option value='all'>7 ngày gần đây</option>";
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-2 text-left col-sm-6 col-12">
                                    <div role="group" class="input-group input-group-sm"><!---->
                                        <select name='tai_khoan_can_tim' class="custom-select custom-select-sm"
                                            onchange="submitForm()"> <!-- DS tài khoản -->
                                            <option value="all">Tất cả khách</option>
                                            <?php
                                            include_once('app/class_sql_connector.php');
                                            $tk_dang_dang_nhap = $_SESSION['username'];
                                            $sql = "SELECT ten_tai_khoan FROM tai_khoan WHERE ten_tai_khoan = '$tk_dang_dang_nhap' OR tai_khoan_quan_ly = '$tk_dang_dang_nhap'";
                                            $sql_connector = new sql_connector();
                                            if ($result = $sql_connector->get_query_result($sql)) {
                                                $tk_can_tim = 'all';
                                                if (isset($_POST["tai_khoan_can_tim"]))
                                                    $tk_can_tim = $_POST["tai_khoan_can_tim"];
                                                while ($row = $result->fetch_assoc())
                                                    if ($row['ten_tai_khoan'] === $tk_can_tim)
                                                        echo '<option value="' . $row['ten_tai_khoan'] . '" selected>' . $row['ten_tai_khoan'] . '</option>';
                                                    else
                                                        echo '<option value="' . $row['ten_tai_khoan'] . '">' . $row['ten_tai_khoan'] . '</option>';

                                            }

                                            ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-outline-success">Tìm kiếm</button>
                                        </div><!---->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="content mb-5">
                        <div>
                            <div style="min-height: 1700px;">
                                <div class="report-table text-left table-responsive-false">
                                    <table role="table" aria-busy="false" aria-colcount="13" class="table b-table"
                                        id="__BVID__191"><!----><!---->
                                        <thead role="rowgroup" class=""><!---->
                                            <tr role="row" class="">
                                                <th role="columnheader" scope="col" aria-colindex="1" class="">
                                                    <div class="text-nowrap">Stt</div>
                                                </th>
                                                <th role="columnheader" scope="col" tabindex="0" aria-colindex="2"
                                                    aria-sort="none" class="">
                                                    <div class="text-nowrap">Khách hàng</div>
                                                </th>
                                                <th role="columnheader" scope="col" tabindex="0" aria-colindex="3"
                                                    aria-sort="none" class="">
                                                    <div class="text-nowrap">Số tin</div>
                                                </th>
                                                <th role="columnheader" scope="col" tabindex="0" aria-colindex="4"
                                                    aria-sort="none" class="">
                                                    <div class="text-nowrap">2D</div>
                                                </th>
                                                <th role="columnheader" scope="col" tabindex="0" aria-colindex="5"
                                                    aria-sort="none" class="">
                                                    <div class="text-nowrap">3D|4D</div>
                                                </th>
                                                <th role="columnheader" scope="col" tabindex="0" aria-colindex="6"
                                                    aria-sort="none" class="">
                                                    <div class="text-nowrap">Đá|Đá xiên</div>
                                                </th>
                                                <th role="columnheader" scope="col" tabindex="0" aria-colindex="7"
                                                    aria-sort="none" class="">
                                                    <div class="text-nowrap">Tiền xác</div>
                                                </th>
                                                <th role="columnheader" scope="col" tabindex="0" aria-colindex="8"
                                                    aria-sort="none" class="">
                                                    <div class="text-nowrap">Thực thu</div>
                                                </th>
                                                <th role="columnheader" scope="col" tabindex="0" aria-colindex="9"
                                                    aria-sort="none" class="">
                                                    <div class="text-nowrap">Tiền trúng</div>
                                                </th>
                                                <th role="columnheader" scope="col" tabindex="0" aria-colindex="10"
                                                    aria-sort="none" class="">
                                                    <div class="text-nowrap">Thắng/Thua</div>
                                                </th>
                                                <th role="columnheader" scope="col" tabindex="0" aria-colindex="11"
                                                    aria-sort="none" class="">
                                                    <div class="text-nowrap">Theo</div>
                                                </th>
                                                <th role="columnheader" scope="col" aria-colindex="12" class="">
                                                    <div class="text-nowrap">Trúng</div>
                                                </th>
                                                <th role="columnheader" scope="col" tabindex="0" aria-colindex="13"
                                                    aria-sort="none" class="">
                                                    <div class="text-nowrap">Action</div>
                                                </th>
                                            </tr>
                                        </thead>
                                        <?php echo xuat_html_thong_ke($thong_ke_list); ?>
                                    </table>
                                </div>
                                <script>
                                    function ShowDialog(ten_khach ,noi_dung_so) {
                                        var myTextarea = document.getElementById("textarea_noi_dung_so");
                                        myTextarea.innerHTML = noi_dung_so;
                                        var myDialogTitle = document.getElementById("modal-baoso-title");
                                        myDialogTitle.innerHTML = 'Báo sổ: ' + ten_khach + ' (Nhận)';
                                        var mydialog = document.getElementById("modal-baoso-modal-outer");
                                        mydialog.style.display = "block";
                                        //alert("Dialog show");
                                    }
                                    function HideDialog() {
                                        var mydialog = document.getElementById("modal-baoso-modal-outer");
                                        mydialog.style.display = "none";
                                        //alert("Dialog show");
                                    }
                                </script> 

                                <!-- Phân trang -->
                                <!-- <div class="row"> 
                                    <div class="text-left col-3"><select class="custom-select" id="__BVID__223">
                                            <option value="10">10</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select></div>
                                    <div class="text-right col-9">
                                        <ul role="menubar" aria-disabled="false" aria-label="Pagination"
                                            class="pagination b-pagination">
                                            <li role="presentation" aria-hidden="true" class="page-item disabled"><span
                                                    role="menuitem" aria-label="Go to first page"
                                                    aria-controls="my-table" aria-disabled="true"
                                                    class="page-link">«</span></li>
                                            <li role="presentation" aria-hidden="true" class="page-item disabled"><span
                                                    role="menuitem" aria-label="Go to previous page"
                                                    aria-controls="my-table" aria-disabled="true"
                                                    class="page-link">‹</span></li>
                                            <li role="presentation" class="page-item active"><button
                                                    role="menuitemradio" type="button" aria-controls="my-table"
                                                    aria-label="Go to page 1" aria-checked="true" aria-posinset="1"
                                                    aria-setsize="1" tabindex="0" class="page-link">1</button></li>
                                          
                                            <li role="presentation" aria-hidden="true" class="page-item disabled"><span
                                                    role="menuitem" aria-label="Go to next page"
                                                    aria-controls="my-table" aria-disabled="true"
                                                    class="page-link">›</span></li>
                                            <li role="presentation" aria-hidden="true" class="page-item disabled"><span
                                                    role="menuitem" aria-label="Go to last page"
                                                    aria-controls="my-table" aria-disabled="true"
                                                    class="page-link">»</span></li>
                                        </ul>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div><!---->
                </div><!---->
            </div>
            <?php include('footer.php');?>
        </div>
    </div>
    <div id="modal-baoso-modal-outer" style="position: absolute; z-index: 1040; display: none;">
        <div id="modal-baoso" role="dialog" aria-describedby="modal-baoso___BV_modal_body_" class="modal fade show"
            aria-modal="true" aria-labelledby="modal-baoso___BV_modal_title_"
            style="display: block; padding-right: 19px;">
            <div class="modal-dialog modal-md"><span tabindex="0"></span>
                <div id="modal-baoso___BV_modal_content_" tabindex="-1" class="modal-content">
                    <header id="modal-baoso___BV_modal_header_" class="modal-header">
                        <h5 id="modal-baoso-title" class="modal-title">Báo sổ: Cam (Nhận)</h5>
                        <button type="button" aria-label="Close" class="close" onclick = "HideDialog();">×</button>
                    </header>
                    <div id="modal-baoso___BV_modal_body_" class="modal-body">
                        <div class="bao-so px-3 container">
                            <div class="px-3_ mb-3_ mt-3_">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- <div label="" role="group" class="input-group mb-2 input-group-sm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Nợ cũ:</div>
                                            </div><input type="text" placeholder="-123 hoặc +123 (+là Lời -là Lỗ)"
                                                class="form-control" id="__BVID__284">
                                            <div class="input-group-append"><button type="button" id="button-addon2"
                                                    class="btn btn-outline-success"> Cập nhật </button></div>
                                        </div> -->
                                    </div>
                                    <div class="col-12">
                                        <!-- <div label="" role="group" class="input-group mb-2 input-group-sm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Nhân về:</div>
                                            </div><input type="text" placeholder="0.95" class="form-control"
                                                id="__BVID__285">
                                            <div class="input-group-append"><button type="button" id="button-addon2"
                                                    class="btn btn-outline-success"> Cập nhật </button></div>
                                        </div> -->
                                    </div>
                                    <div class="pr-0_ col-6">
                                        <!-- <div role="group" class="input-group mb-2 input-group-sm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Thực thu:</div>
                                            </div>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <div class="custom-control custom-checkbox"><input type="checkbox"
                                                            class="custom-control-input" value="true"
                                                            id="__BVID__286"><label class="custom-control-label"
                                                            for="__BVID__286"></label></div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="pr-0_ pl-0_ col-6">
                                        <!-- <div role="group" class="input-group mb-2 input-group-sm">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Tách 2c:</div>
                                            </div>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <div class="custom-control custom-checkbox"><input type="checkbox"
                                                            class="custom-control-input" value="true"
                                                            id="__BVID__287"><label class="custom-control-label"
                                                            for="__BVID__287"></label></div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="pr-0_ pl-0_ mb-2 col-12"><button type="button"
                                            class="btn w-100 btn-success btn-sm">Copy</button></div>
                                </div><textarea rows="12" wrap="soft" class="mb-2 form-control"
                                    id="textarea_noi_dung_so"></textarea>
                            </div>
                        </div>
                    </div><!---->
                </div><span tabindex="0"></span>
            </div>
        </div>
    </div>
</body>

</html>