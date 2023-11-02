<?php
    /* 
        Trang lấy danh sách các tài khoản theo người quản lý
        Nếu người dùng là god sẽ lấy tất cả, trừ god
        Nếu là admin thì 
     */
	$dir_name = dirname(__FILE__);
    require_once(dirname($dir_name) . '/app/class_sql_connector.php');


	$response = array();
    $tai_khoan = array();
	if($_SERVER['REQUEST_METHOD']!='POST' || !isset($_POST["ten_tai_khoan"]))
    {
         //Nếu chưa có thông tin thì thoát
         $response['log'] .= "khong phai POST hoac tai khoan sai ";
         $response['success'] = 0;
         echo json_encode($response);
         exit();
    }
	$ten_tai_khoan = $_POST['ten_tai_khoan'];
    if($ten_tai_khoan === "god")
		$sql = "SELECT ten_tai_khoan, loai_tai_khoan, ten_hien_thi 
                FROM tai_khoan WHERE ten_tai_khoan != '$ten_tai_khoan'";
    else 
        $sql = "SELECT ten_tai_khoan, loai_tai_khoan, ten_hien_thi  
                FROM tai_khoan WHERE tai_khoan_quan_ly = '$ten_tai_khoan'";
    //echo $sql;
    //$sql_connector = new sql_connector();
    $sql_connector = new sql_connector();

    if ($result = $sql_connector->get_query_result($sql)) {
        while ($row = $result -> fetch_assoc()) {
                $tai_khoan[] = $row;
                //echo $row;
        }
        $response["success"] = 1; //Thành công
        $response["danh_sach_tai_khoan"] = $tai_khoan;
    }
    else
        $response["success"] = 0; //Không đọc được dữ liệu
	
	echo json_encode($response);
?>