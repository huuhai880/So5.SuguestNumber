<?php
/*
Trang tạo người dùng mới
input: ten_tai_khoan, loai_tai_khoan, tai_khoan_quan_ly (mật khẩu mặc định trong config)
output: $response["success"] = 1: thành công; 0: không thành công; -1: tài khoản đã tồn tại.
*/
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
include_once(dirname($dir_name) .'/cau_hinh/class_cau_hinh.php');

$response = array(); //Biến lưu kết quả để trả về cho client

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Kiểm tra phương thức POST

	//Lấy các giá trị gửi lên từ request
	$ten_tai_khoan = $_POST['ten_tai_khoan'];
	$loai_tai_khoan = $_POST['loai_tai_khoan'];
	$tai_khoan_quan_ly = $_POST["tai_khoan_quan_ly"];
	$ten_hien_thi = $_POST["ten_hien_thi"];
	$mat_khau_mac_dinh = "123";
	
	//  $ten_tai_khoan = "admin7";
	//  $loai_tai_khoan = "admin";
	//  $tai_khoan_quan_ly = "god";
	//  $ten_hien_thi = "test";
	//  $mat_khau_mac_dinh = "123";

	//Kiểm tra tài khoản đã tồn tại 
	$sql = "SELECT ten_tai_khoan FROM tai_khoan 
			WHERE ten_tai_khoan = '$ten_tai_khoan'";

	$sql_connector = new sql_connector();
	$result = $sql_connector->get_query_result($sql);
	if ($result->num_rows > 0) { //Tài khoản đã tồn tại
		$response["success"] = -1;
	} 
	
	else { //Tài khoản chưa tồn tại thì thêm tk mới vào
		$sql = "INSERT INTO tai_khoan (ten_tai_khoan, mat_khau, loai_tai_khoan, tai_khoan_quan_ly, trang_thai, ten_hien_thi)
			VALUES ('$ten_tai_khoan', '$mat_khau_mac_dinh', '$loai_tai_khoan', '$tai_khoan_quan_ly', '0', '$ten_hien_thi')";
		$response['sql'] = $sql;
		if ($result = $sql_connector->get_query_result($sql)) {
			$response["success"] = 1;
			if ($loai_tai_khoan != "god") //Nếu là tài khoản quản lý thì cần tạo cấu hình.
			{
				$cau_hinh = cau_hinh::LayCauHinh($tai_khoan_quan_ly); //La
				$cau_hinh->tai_khoan = $ten_tai_khoan; //Cập nhật tên tài khoản mới
				$cau_hinh->ghi_xuong_db(); //Ghi lại xuống csdl
			}
		} 
		else
			$response["success"] = 0;
	}

	/**Return json*/
	//echo $sql;
	echo json_encode($response);
}
?>