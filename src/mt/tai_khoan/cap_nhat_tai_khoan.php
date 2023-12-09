
<?php
	/*
        Cập nhật tên hiển thị của tài khoản
     */
	$dir_name = dirname(__FILE__);
	require_once(dirname($dir_name) . '/app/class_sql_connector.php');
	/** Array for JSON response*/
	$response = array();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$ten_tai_khoan = $_POST['ten_tai_khoan'];
		$ten_hien_thi = $_POST['ten_hien_thi'];

        //Kiểm tra tài khoản đã tồn tại 
		$sql = "UPDATE tai_khoan
                    SET ten_hien_thi = '$ten_hien_thi'
                        WHERE ten_tai_khoan = '$ten_tai_khoan'";
		$sql_connector = new sql_connector();

		if ($result = $sql_connector->get_query_result($sql)){ 
            $response["success"] = 1; 
        }        
		else{
			$response["success"] = 0;
        }
        
        $response['ten_tai_khoan'] = $ten_tai_khoan;
        $response['ten_hien_thi'] = $ten_hien_thi;
        $response["sql"] = $sql;
		echo json_encode($response);
	} 
?>