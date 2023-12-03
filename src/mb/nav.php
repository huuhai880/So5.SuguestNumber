<nav class="navbar d-none d-sm-flex navbar-light bg-light navbar-expand-lg">
        <div class="container">
          <a href="#" target="_self"
                    class="navbar-brand"><img src="./img/logo.d21508bd.png" height="35" class="max-h-35px"></a>
                    
     
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown" style="text-align:center;">
            <ul class="navbar-nav">
              <li class="nav-item"><a href="ql_tin.php" class="nav-link" target="_self">DS cược</a></li>
              <li class="nav-item"><a href="thongke.php" class="nav-link" target="_self">Báo cáo</a></li>
              <li class="nav-item"><a href="tao_tin.php" class="nav-link" target="_self">Thêm tin</a></li>
              <li class="nav-item"><a href="ql_tai_khoan.php" class="nav-link" target="_self" aria-current="page">Khách hàng</a></li>
              <li class="nav-item navi-link "><a href="huong_dan.php" class="nav-link" target="_self"> Hướng dẫn </a></li>
          </ul>
            <ul class="navbar-nav ml-auto">
              <li class="nav-item b-nav-dropdown dropdown" id="__BVID__15">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" 
                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                
                <em><?php echo $_SESSION["username"]?>
                  <small>(<?php 
                      if($_SESSION["loai_tai_khoan"] === 'std')
                        echo 'user';
                      else
                        echo $_SESSION["loai_tai_khoan"];
                  ?> )</small></em>
                </a>
            <ul tabindex="-1" class="dropdown-menu dropdown-menu-right"
                aria-labelledby="__BVID__15__BV_toggle_">
    
                <li role="presentation">
                    <header id="_bv_dropdown-group-1_group_dd_header" class="dropdown-header">Tài khoản
                    </header>
                    <ul id="dropdown-group-1" role="group"
                        aria-describedby="_bv_dropdown-group-1_group_dd_header" class="list-unstyled">
                       
                        <?php 
                          echo ' <li role="presentation"><a href="tao_tai_khoan.php?user='.$_SESSION["username"].'" class="dropdown-item" role="menuitem"
                          target="_self">Cài đặt</a></li>';
                        ?>
                        <li role="presentation"><a href="doi_mat_khau.php" class="dropdown-item"
                                role="menuitem" target="_self">Đổi mật khẩu</a></li>
                    </ul>
                </li>
                <li role="presentation">
                    <hr role="separator" aria-orientation="horizontal" class="dropdown-divider">
                </li>
                <li role="presentation"><a role="menuitem" href="dang_nhap.php" target="_self"
                        class="dropdown-item">Đăng xuất</a></li>
            </ul>
        </li>
            </ul>
          </div>
        </div>
      </nav>