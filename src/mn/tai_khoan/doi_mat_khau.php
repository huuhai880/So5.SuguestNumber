<?php
    $dir_name = dirname(__FILE__);
    require_once(dirname($dir_name) . '/app/class_sql_connector.php');
    require_once(dirname($dir_name) . '/app/config.php');
	
    $response = array();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$ten_tai_khoan = $_POST['ten_tai_khoan'];
        $mat_khau_moi = $_POST['mat_khau'];
        $trang_thai = TrangThaiTaiKhoan::DANG_HOAT_DONG;
		$sql = "UPDATE tai_khoan SET mat_khau = '$mat_khau_moi', trang_thai = $trang_thai WHERE ten_tai_khoan = '$ten_tai_khoan'";
        $conn = new sql_connector();
        if($conn->get_query_result($sql) == true){
            $response["success"] = 1; //Thành công
        }else
            $response["success"] = 0; //thất bại
            
    }
	//echo $ten_tai_khoan;
    //echo ":".$mat_khau_moi;
    //echo ":".$trang_thai.":";
    $response["sql"] = $sql;
    echo json_encode($response);
	
?>