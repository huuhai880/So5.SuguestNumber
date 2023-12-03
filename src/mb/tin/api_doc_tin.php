<?php 
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
include_once($dir_name . '/class_tin.php');
include_once($dir_name . '/class_noi_dung_tin.php');


date_default_timezone_set('Asia/Ho_Chi_Minh');

//include_once('soi_ket_qua.php');

$response = array();
$response['log'] = "";
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    //Nếu không phải POST thì thoát
    $response['log'] = "không phải post;";
    $response['success'] = 0;
    echo json_encode($response);
    exit();
}
//-------------------------Nếu là đọc tin ---------------------------------
if ($_POST["action"] === "doc") {

    $response['log'] .= "action=doc;";
    if (!isset($_POST["ten_tai_khoan"]) || !isset($_POST["loai_tai_khoan"])) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không biết ai xin đọc; chức vụ?";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $ten_tai_khoan = $_POST['ten_tai_khoan'];
    $loai_tai_khoan = $_POST['loai_tai_khoan'];
    $kieu_truy_van = $_POST["kieu_truy_van"]; //Kiểu đọc: {"Tất cả", hoặc ngày cụ thể};

    //Cập nhật kết quả các tin trước khi đọc
    tin::CapNhatKetQuaCacTin($ten_tai_khoan, $loai_tai_khoan);
    //Tạo lệnh truy vấn cho tin.
    //Mặc định
    $sql = "SELECT * FROM tin WHERE tai_khoan_danh = '$ten_tai_khoan' OR 
    tai_khoan_danh IN (SELECT ten_tai_khoan FROM tai_khoan WHERE tai_khoan_quan_ly = '$ten_tai_khoan')";
    //Tạo sql theo bộ lọc
    if($kieu_truy_van === 'Tất cả')
    {
        if ($loai_tai_khoan === 'god') {
            $sql = "SELECT * FROM tin";
        }
        if ($loai_tai_khoan === 'admin') {
            $sql = "SELECT * FROM tin WHERE tai_khoan_danh = '$ten_tai_khoan' OR 
                tai_khoan_danh IN (SELECT ten_tai_khoan FROM tai_khoan WHERE tai_khoan_quan_ly = '$ten_tai_khoan')";
        }
        if ($loai_tai_khoan === 'std') {
            $sql = "SELECT * FROM tin WHERE tai_khoan_danh = '$ten_tai_khoan'";
        }
    }
    else{//Nếu là một ngày tháng cụ thể dạng d-m-Y
        $kieu_truy_van = str_replace(' ', '', $kieu_truy_van);
        $date = date("Y-m-d", strtotime($kieu_truy_van));
        if ($loai_tai_khoan === 'god') {
            $sql = "SELECT * FROM tin WHERE thoi_gian_danh = '$date'";
        }
        if($loai_tai_khoan === 'admin') {
            $sql = "SELECT * FROM tin WHERE thoi_gian_danh = '$date' AND ( tai_khoan_danh = '$ten_tai_khoan' OR 
                tai_khoan_danh IN (SELECT ten_tai_khoan FROM tai_khoan WHERE tai_khoan_quan_ly = '$ten_tai_khoan'))";
        }
        if ($loai_tai_khoan === 'std') {
            $sql = "SELECT * FROM tin WHERE thoi_gian_danh = '$date' AND tai_khoan_danh = '$ten_tai_khoan'";
        }
    }
  
    
    //Thực hiện truy vấn    
    $sql_connector = new sql_connector();
    if(!$sql_connector->conn){ //Nếu có lỗi kết nối csdl
        $response['log'] .= "Loi ket noi csdl; ";
        $response['error'] = $sql_connector->get_connect_error();
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }
    $ds_tin = tin::doc_tin_tu_db($sql, $sql_connector);
    if(($sql_error = $sql_connector->get_connect_error())){
        $response['log'] .= "Lỗi truy vấn csdl; ";
        $response['error'] = $sql_connector->get_connect_error();
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }
    $response['success'] = 1;
    $response['ds_tin'] = json_encode($ds_tin);
    echo json_encode($response);
    exit();
}

?>