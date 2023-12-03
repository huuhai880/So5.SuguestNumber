<?php
    $dir_name = dirname(__FILE__);
    require_once(dirname($dir_name) . '/app/class_sql_connector.php');
    require_once(dirname($dir_name) . '/app/config.php');
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$ten_tai_khoan = $_SESSION["username"];
        $mk_cu = $_POST['mk_cu'];
        $mk_moi = $_POST['mk_moi'];
        $mk_moi2 = $_POST['mk_moi2'];
    
		$sql = "SELECT ten_tai_khoan, loai_tai_khoan, trang_thai FROM tai_khoan 
			WHERE ten_tai_khoan = '$ten_tai_khoan' AND mat_khau = '$mk_cu'";

		$sql_connector = new sql_connector();
        $result = $sql_connector->get_query_result($sql);
		if(mysqli_num_rows($result) == 0){
            echo "<script>";
            echo "alert('Lỗi, mật khẩu cũ không chính xác');";
            echo "</script>";
		}
        else if( $mk_moi!==$mk_moi2){
            echo "<script>";
            echo "alert('Lỗi, mật khẩu mới và mật khẩu nhập lại phải giống nhau');";
            echo "</script>";
        }
        else{
            $trang_thai = TrangThaiTaiKhoan::DANG_HOAT_DONG;
            $sql = "UPDATE tai_khoan SET mat_khau = '$mk_moi', trang_thai = $trang_thai WHERE ten_tai_khoan = '$ten_tai_khoan'";
            if($sql_connector->get_query_result($sql) == true){
                header("Location: ./tao_tin.php");
            }
        }

       
            
    }
?>