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

//-------------------------Nếu là kiểm tra tin ---------------------------------
if ($_POST["action"] === "kiem_tra") {

    $response['log'] .= "action=kiem_tra;";
    if (!isset($_POST["tin"])) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "khong co tin";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    //Chuyển thông tin gửi lên từ post dạng object
    $tin_object = json_decode($_POST['tin']);

    //Chuyển dạng object sang lớp tin và array lớp chi tiet tin
    $tin = new tin();
    $tin->lay_du_lieu($tin_object);
    //Kiểm tra thời gian giữa server và client
    $khoang_cach_thoi_gian = KhoangCachThoiGianVoiHienTai($tin->thoi_gian_tao);
    if ($khoang_cach_thoi_gian > 59) { //Lệch giữa server và client ko quá 59 giây
        $response['success'] = -1; //Báo thời gian không đồng bộ
        $response['html_kq_kiem_tra'] = "Thời gian không đồng bộ giữa thiết bị và server";
        echo json_encode($response);

        //exit();
        die();
    }
    //Tin quá dài
    if (strlen($tin->noi_dung) > 5000) {
        $response['success'] = -2; //Báo thời gian không đồng bộ
        $response['html_kq_kiem_tra'] = "Tin quá dài!<br/>Do hạn chế khả năng xử lý của thiết bị, hệ thống chỉ nhận tin có tối đa 300 ký tự";
        echo json_encode($response);
        exit();
    }
    //Tạo đối tượng noi_dung_tin để thực hiện kiểm tra và bóc tách
    $day_of_week = date('w', strtotime($tin->thoi_gian_danh));
    $noi_dung_tin = new NoiDungTin($tin->noi_dung, $day_of_week, $tin->tai_khoan_danh);
    $ket_qua_kiem_tra = $noi_dung_tin->KiemTraNoiDung();
    if (empty($ket_qua_kiem_tra) == false) {
        $response['html_kq_kiem_tra'] = $ket_qua_kiem_tra;
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $ds_chi_tiet = $noi_dung_tin->BocTachDaiSoKieu();

    $result = tin::CapNhatThongKeChoTin($tin, $ds_chi_tiet);

    $html_kq_kiem_tra = $result['html_kq_kiem_tra'];
    $response['html_kq_kiem_tra'] = $html_kq_kiem_tra;
    $response['success'] = 1;
    echo json_encode($response);
    exit();
}


//-------------------------Nếu là ghi  ---------------------------------
if ($_POST["action"] === "ghi") {

    $response['log'] .= "action=ghi;";
    if (!isset($_POST["tin"])) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "khong co tin";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    //Chuyển thông tin gửi lên từ post dạng object
    $tin_object = json_decode($_POST['tin']);

    //Chuyển dạng object sang lớp tin và array lớp chi tiet tin
    $tin = new tin();
    $tin->lay_du_lieu($tin_object);
    //Kiểm tra thời gian giữa server và client
    $khoang_cach_thoi_gian = KhoangCachThoiGianVoiHienTai($tin->thoi_gian_tao);
    if ($khoang_cach_thoi_gian > 59) { //Lệch giữa server và client ko quá 59 giây
        $response['success'] = -1; //Báo thời gian không đồng bộ
        $response['html_kq_kiem_tra'] = "Thời gian không đồng bộ giữa thiết bị và server";
        echo json_encode($response);

        exit();
    }
    //Tin quá dài
    if (strlen($tin->noi_dung) > 5000) {
        $response['success'] = -2; //Báo tin qua dai
        $response['html_kq_kiem_tra'] = "Tin quá dài!<br/>Do hạn chế khả năng xử lý của thiết bị, hệ thống chỉ nhận tin có tối đa 300 ký tự";
        echo json_encode($response);
        exit();
    }
    //Tạo đối tượng noi_dung_tin để thực hiện kiểm tra và bóc tách
    $day_of_week = date('w', strtotime($tin->thoi_gian_danh));
    $noi_dung_tin = new NoiDungTin($tin->noi_dung, $day_of_week, $tin->tai_khoan_danh);
    $ket_qua_kiem_tra = $noi_dung_tin->KiemTraNoiDung();
    if (empty($ket_qua_kiem_tra) == false) {
        $response['html_kq_kiem_tra'] = $ket_qua_kiem_tra;
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }
    $ds_chi_tiet = $noi_dung_tin->BocTachDaiSoKieu();

    $result = tin::CapNhatThongKeChoTin($tin, $ds_chi_tiet);

    // //Tạo mã cho tin
    // $ma_tin = date('dmY'); //Lấy số ghép từ dmY
    // $tong_so_danh = 0;
    // foreach ($ds_chi_tiet as $chi_tiet) { //Tổng các số đánh
    //     if(is_numeric($chi_tiet->so)) //Kiểm tra để loại trừ đá
    //         $tong_so_danh += $chi_tiet->so; 
    //     else{
    //         $tong_so_dang += substr($chi_tiet->so,0,2); //Nếu là đá thì lấy 2 số đầu
    //         $tong_so_dang += substr($chi_tiet->so, -2); //và 2 số cuối
    //     }

    // }
    // $num_length = strlen((string)$tong_so_danh); //Đếm kích thước của tổng 
    // $ma_tin = ($ma_tin + ($tong_so_danh*(100000/pow(10,$num_length)))) / 3.1415;//Mã hoá
    // $ma_tin = explode('.', $ma_tin)[0];
    // $ma_tin = substr($ma_tin, -5); //Lấy 5 ký tự cuối
    // $tin->ma_tin = $ma_tin;


    $html_qkq_kiem_tra = $result['html_kq_kiem_tra'];
    $tin = $result['tin'];
    $ds_chi_tiet = $result['ds_chi_tiet'];

    $kq_ghi = tin::GhiTinVaChiTiet($tin, $ds_chi_tiet);
    //Ghi Tin và các chi tiết xuống csdl
    if ($kq_ghi) {
        $response['log'] .= "thành công; ";
        $response['success'] = 1;
    } else {
        $response['success'] = 0;
    }

    $response['html_kq_kiem_tra'] = $html_qkq_kiem_tra;
    echo json_encode($response);
    exit();
}


//-------------------------Nếu là xoa  ---------------------------------
if ($_POST["action"] === "xoa") {

    $response['log'] .= "action = xoa;";
    if (!isset($_POST["id_tin"])) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "khong thay danh sach can xoa ";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $id_tin_can_xoa = $_POST["id_tin"];

    //Xoá tin
    $sql_connector = new sql_connector();
    if(!$sql_connector->conn){ //Nếu có lỗi kết nối csdl
        $response['log'] .= "Loi ket noi csdl; ";
        $response['error'] = $sql_connector->get_connect_error();
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $sql = "DELETE FROM tin WHERE id = '$id_tin_can_xoa'";

    if($sql_connector->get_query_result($sql)){ //Nếu thực hiện câu lệnh sql thành công
        $response['log'] .= "thành công; ";
        $response['success'] = 1;
    }
    else
    {
        $response['log'] .= "Khong thành công; ";
        $response['error'] = $sql_connector->get_connect_error();
        $response['success'] = 0;
    }
    
    echo json_encode($response);
    exit();
}



/**
 * Hàm tính khoảng cách thời gian của một chuỗi thời gian định dạng y-m-d H:m:s với hiện tại
 * @return int khoảng cách tính bằng mili giây
 */
function KhoangCachThoiGianVoiHienTai(string $time_str): int
{
    $milis_time = strtotime($time_str);
    $milis_current = time();
    return $milis_current - $milis_time;
}



?>