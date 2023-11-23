<?php 
    session_start();
    include('app/session_control.php'); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Site</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
    crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" href="css/login.css">
  <link rel="stylesheet" type="text/css" href="css/app.css">

</head>
<?php
    include('tai_khoan/web_doi_mat_khau.php');
  ?>

<body class="bg-default"><noscript><strong>We're sorry but GarenaLienQuan doesn't work properly without JavaScript
      enabled. Please enable it to continue.</strong></noscript>
  <div id="app" class="z-theme-dark_">
    <div class="bg-default">
      <div class="header bg-gradient-success py-7 py-lg-8 pt-lg-9">
        <div class="container">
          <div class="header-body text-center mb-5">
            <div class="row justify-content-center">
              <div class="px-5 col-md-8 col-lg-6 col-xl-5"><img alt="Logo" src="img/logo.d21508bd.png" height="100"
                  class="mb-3">
                <h1 class="text-white">Đổi Mật Khẩu</h1>
                <p class="text-lead text-white"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="separator separator-bottom separator-skew zindex-100"><svg x="0" y="0" viewBox="0 0 2560 100"
            preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <polygon points="2560 0 2560 100 0 100" class="fill-default"></polygon>
          </svg></div>
      </div>
      <form action="doi_mat_khau.php" method="post">
        <div class="mt--8 pb-5 container">
          <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
              <div class="card bg-secondary card-dang-nhap border-0 mb-0"><!----><!---->
                <div class="card-body px-lg-5 py-lg-5"><!----><!---->
                  <form role="form" class="">
                    <input name="mk_cu" type="password" placeholder="Mật Khẩu Cũ" class="mb-3 form-control" pattern="^[^\s]{3,30}$">
                    <input name="mk_moi" type="password"  placeholder="Mật Khẩu Mới" class="mb-3 form-control" pattern="^[^\s]{3,30}$">
                    <input name="mk_moi2" type="password"  placeholder="Nhập lại mật khẩu mới" class="mb-3 form-control" pattern="^[^\s]{3,30}$">
                    <div class="text-center"><button type="submit" class="btn my-4 btn-danger">Đổi Mật Khẩu</button></div>
                  </form>
                </div><!----><!---->
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
  <script src="/js/chunk-vendors.97e11f41.js"></script>
  <script src="/js/app.b20296d0.js"></script>
</body>

</html>