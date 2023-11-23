<?php
	/*
	Trang đăng nhập
	input: POST: ten_tai_khoan, mat_khau
	output: JSON: 	succes: 1 nếu thành công, 0 nếu không thành công
					loai_tai_khoan: quyền của người dùng
					trang_thai: trạng thái của tài khoản
	 */
	$dir_name = dirname(__FILE__);
    require_once(dirname($dir_name) . '/app/class_sql_connector.php');

	/** Array for JSON response*/
	$response = array();
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$username = $_POST['ten_tai_khoan'];
		$password = $_POST['mat_khau'];
		$is_web = $_POST['is_web'];
		$sql = "SELECT ten_tai_khoan, loai_tai_khoan, trang_thai FROM tai_khoan 
			WHERE ten_tai_khoan = '$username' AND mat_khau = '$password'";

		$sql_connector = new sql_connector();
        $result = $sql_connector->get_query_result($sql);
		if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_array($result);
				$response["loai_tai_khoan"] = $row["loai_tai_khoan"];
				$response["trang_thai"] = $row["trang_thai"];
				$response["success"] = 1;
		}
        else{
			$response["success"] = 0;
		}
		if($is_web && $response["success"]==1 ){
			session_start();
			$_SESSION['logged_in'] = true;
			$_SESSION['username'] = $username;	
			$_SESSION['loai_tai_khoan'] = $response["loai_tai_khoan"];
			
			$GLOBALS['session_timeout'] = 60;
			$_SESSION['last_activity_time'] = time() + $GLOBALS['session_timeout'];

			header("Location: ./tao_tin.php");
			exit();
		}
		if($is_web && $response["success"]!=1 )
		{
			echo "<script>alert('Lỗi! Tài khoản hoặc mật khẩu không chính xác');</script>";
		}
		echo json_encode($response);
		
	} 
	//echo "some thing";
?>