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
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


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
                <!-- Tabs navs -->
  <nav>
    <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
      <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Hướng dẫn</button>
      <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Tên đài</button>
      <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Tên kiểu</button>
      
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
    <p>Có nhiều <code>cú pháp</code> với các kiểu nhận tin khác nhau</p>
                <p><code>Lưu ý:</code> TẤT CẢ TIN NHẮN KHÔNG PHẢI XUỐNG HÀNG KHI KẾT THÚC CƯỢC </p>
                <ul style="padding-left: 15px; padding-bottom: 0px;">
                  <li style="padding: 5px 0px;"><code>1. Đài-số-kiểu</code><br> - Nhập tên đài trước, số muốn đánh, kiểu
                    đánh, số điểm. <p><code>Ví dụ:</code><br> Dc 52.70 da60. 938 xc150. 779 xc300 xd40. 277xc130 xd10.
                      573 x240 xd3. 73 dau300 dui200n. 425.119 xc130 xd10. dp 119x20. 779.277 xc200 xd10 </p>
                  </li>
                  <li style="padding: 5px 0px;"><code>2. Số-kiểu-đài</code><br> - Nhập số muốn đánh trước, kiểu đánh, số
                    điểm, tên đài. <p><code>Ví dụ:</code><br> 52.70 da60. 938 xc150. 779 xc300 xd40. 277xc130 xd10. 573
                      x240 xd3. 73 dau300 dui200n. 425.119 xc130 xd10. dp 119x20. 779.277 xc200 xd10 Dc </p>
                  </li>
                  <li style="padding: 5px 0px;"><code>3. Đài-số-kiểu-AB</code> <br> - Nhập tên đài trước, số muốn đánh,
                    kiểu đánh, số điểm. <br> - Tương tự như kiểu 1 nhưng chấp nhận a đầu, b đuôi, ab đầu đuôi. <p>
                      <code>Ví dụ:</code><br> Dc 79a10 32ab20 </p>
                  </li>
                  <li style="padding: 5px 0px;"><code>4. Số-kiểu-đài-AB</code> <br> - Nhập số trước, kiểu muốn đánh, số
                    điểm, đài.<br> - Tương tự như kiểu 2 nhưng chấp nhận a đầu, b đuôi, ab đầu đuôi. <p>
                      <code>Ví dụ:</code><br> 79a10 32ab20 Dc </p>
                  </li>
                </ul>
                <p><span class="m-badge m-badge--wide m-badge--danger m-badge--rounded">CHÚ Ý:</span> Nhập đúng đài và
                  kiểu muốn cược theo tên đã định nghĩa ở menu bên cạnh </p>
    </div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
      
    <table role="table" aria-busy="false" aria-colcount="2" class="table b-table table-striped table-hover"
                  id="__BVID__87"><!----><!---->
                  <thead role="rowgroup" class=""><!---->
                    <tr role="row" class="">
                      <th role="columnheader" scope="col" aria-colindex="1" class="">
                        <div>Name</div>
                      </th>
                      <th role="columnheader" scope="col" aria-colindex="2" class="">
                        <div>Code</div>
                      </th>
                    </tr>
                  </thead>
                  <tbody role="rowgroup"><!---->
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Miền Bắc</td>
                      <td aria-colindex="2" role="cell" class="">hn, mb, hanoi</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Thừa T. Huế</td>
                      <td aria-colindex="2" role="cell" class="">tth</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Phú Yên</td>
                      <td aria-colindex="2" role="cell" class="">py</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đắk Lắk</td>
                      <td aria-colindex="2" role="cell" class="">dl</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Quảng Nam</td>
                      <td aria-colindex="2" role="cell" class="">qn, quangnam</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đà Nẵng</td>
                      <td aria-colindex="2" role="cell" class="">dng</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Khánh Hòa</td>
                      <td aria-colindex="2" role="cell" class="">kh</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bình Định</td>
                      <td aria-colindex="2" role="cell" class="">bdi</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Quảng Trị</td>
                      <td aria-colindex="2" role="cell" class="">qt</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Quảng Bình</td>
                      <td aria-colindex="2" role="cell" class="">qb</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Gia Lai</td>
                      <td aria-colindex="2" role="cell" class="">gl</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Ninh Thuận</td>
                      <td aria-colindex="2" role="cell" class="">nt</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Quảng Ngãi</td>
                      <td aria-colindex="2" role="cell" class="">qn, quangngai</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đắk Nông</td>
                      <td aria-colindex="2" role="cell" class="">dno</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Kon Tum</td>
                      <td aria-colindex="2" role="cell" class="">kt</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Kon Tum</td>
                      <td aria-colindex="2" role="cell" class="">kt</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Hồ Chí Minh</td>
                      <td aria-colindex="2" role="cell" class="">tp, hcm</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đồng Tháp</td>
                      <td aria-colindex="2" role="cell" class="">dt</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Cà Mau</td>
                      <td aria-colindex="2" role="cell" class="">cm, camau</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bến Tre</td>
                      <td aria-colindex="2" role="cell" class="">bt, btr, btre</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Vũng Tàu</td>
                      <td aria-colindex="2" role="cell" class="">vt</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bạc Liêu</td>
                      <td aria-colindex="2" role="cell" class="">blieu, baclieu</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đồng Nai</td>
                      <td aria-colindex="2" role="cell" class="">dn</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Cần Thơ</td>
                      <td aria-colindex="2" role="cell" class="">ct</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Sóc Trăng</td>
                      <td aria-colindex="2" role="cell" class="">st, soctrang</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Tây Ninh</td>
                      <td aria-colindex="2" role="cell" class="">tn</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">An Giang</td>
                      <td aria-colindex="2" role="cell" class="">ag</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bình Thuận</td>
                      <td aria-colindex="2" role="cell" class="">bt, binhthuan</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Vĩnh Long</td>
                      <td aria-colindex="2" role="cell" class="">vl</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bình Dương</td>
                      <td aria-colindex="2" role="cell" class="">sbe, bd, sb</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Trà Vinh</td>
                      <td aria-colindex="2" role="cell" class="">tv, travinh</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Long An</td>
                      <td aria-colindex="2" role="cell" class="">la</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Hậu Giang</td>
                      <td aria-colindex="2" role="cell" class="">hg, haugiang</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Tiền Giang</td>
                      <td aria-colindex="2" role="cell" class="">tg</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Kiên Giang</td>
                      <td aria-colindex="2" role="cell" class="">kg</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đà Lạt</td>
                      <td aria-colindex="2" role="cell" class="">dl, dalat</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bình Phước</td>
                      <td aria-colindex="2" role="cell" class="">bp, binhphuoc</td>
                    </tr><!----><!---->
                  </tbody><!---->
                </table>
              
    </div>
    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
    <table role="table" aria-busy="false" aria-colcount="2" class="table b-table table-striped table-hover"
                  id="__BVID__132"><!----><!---->
                  <thead role="rowgroup" class=""><!---->
                    <tr role="row" class="">
                      <th role="columnheader" scope="col" aria-colindex="1" class="">
                        <div>Name</div>
                      </th>
                      <th role="columnheader" scope="col" aria-colindex="2" class="">
                        <div>Code</div>
                      </th>
                    </tr>
                  </thead>
                  <tbody role="rowgroup"><!---->
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đầu</td>
                      <td aria-colindex="2" role="cell" class="">dau, a</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đuôi</td>
                      <td aria-colindex="2" role="cell" class="">duoi, dui</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đuôi AB</td>
                      <td aria-colindex="2" role="cell" class="">duoi, dui, b</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đầu đuôi</td>
                      <td aria-colindex="2" role="cell" class="">dd, dauduoi, daudui, ab</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bao lô</td>
                      <td aria-colindex="2" role="cell" class="">b, bao, bl, blo, lo, doc</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bao lô AB</td>
                      <td aria-colindex="2" role="cell" class="">bao, bl, blo, lo</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bao lô đảo thứ 6</td>
                      <td aria-colindex="2" role="cell" class="">baodao, daolo, dlo, bld, bdao, dbao, db, blodao, dbl,
                        bldao</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bao lô đảo</td>
                      <td aria-colindex="2" role="cell" class="">baodao, daolo, dlo, bld, bdao, dbao, db, bd, blodao,
                        dbl, bldao</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bảy lô</td>
                      <td aria-colindex="2" role="cell" class="">slo, baylo</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Bảy lô đảo</td>
                      <td aria-colindex="2" role="cell" class="">slodao, daoslo, daobaylo, baylodao</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Xỉu chủ</td>
                      <td aria-colindex="2" role="cell" class="">xc, x, tl, tlo, sc, siu</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Xỉu chủ đầu</td>
                      <td aria-colindex="2" role="cell" class="">xdau, xcdau, tldau, tlodau</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Xỉu chủ đuôi</td>
                      <td aria-colindex="2" role="cell" class="">xduoi, xcdui, xcduoi, xdui, tldui, tlduoi, tlodui,
                        tloduoi</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Xỉu chủ đảo</td>
                      <td aria-colindex="2" role="cell" class="">xd, xcd, dxc, daox, daoxc, xdao, xcdao, tld, dtl,
                        daotl, tldao, tlod, dtlo, daotlo, tlodao, suidao</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Xỉu chủ đảo đầu</td>
                      <td aria-colindex="2" role="cell" class="">xdaudao, xddau, daoxdau, xcdaudao, daoxcdau, tldaudao,
                        daotldau, tlduidao, tlodaudao, daotlodau</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Xỉu chỉ đảo đuôi</td>
                      <td aria-colindex="2" role="cell" class="">xduoidao, xduidao, xddui, xdduoi, daoxdui, daoxduoi,
                        xcduidao, xcduoidao, daoxcdui, daoxcduoi, tlduoidao, daotldui, daotlduoi, tloduidao, tloduoidao,
                        daotlodui, daotloduoi</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đá</td>
                      <td aria-colindex="2" role="cell" class="">da</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đá thẳng</td>
                      <td aria-colindex="2" role="cell" class="">dat</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đá vòng</td>
                      <td aria-colindex="2" role="cell" class="">dv, dav</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đá xiên xỉu đảo</td>
                      <td aria-colindex="2" role="cell" class="">dx</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đá xiên</td>
                      <td aria-colindex="2" role="cell" class="">dx, dax, dxien, daxien, cheo</td>
                    </tr>
                    <tr role="row" class="">
                      <td aria-colindex="1" role="cell" class="">Đá xiên vòng</td>
                      <td aria-colindex="2" role="cell" class="">dxv, daxv, dvx</td>
                    </tr><!----><!---->
                  </tbody><!---->
                </table>
    </div>
  </div>
            </div>
            <?php include('footer.php');?>
        </div>
    </div>

<!-- Bootstrap core JavaScript
        ================================================== -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

</body>

</html>