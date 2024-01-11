<?php
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
include_once(dirname($dir_name) . '/tin/class_tin.php');
include_once(dirname($dir_name) . '/tin/class_noi_dung_tin.php');

$response = array();
$response['log'] = "";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    //Nếu không phải POST thì thoát
    $response['log'] = "không phải post;";
    $response['success'] = 0;
    echo json_encode($response);
    exit();
}

//-------------------------Nếu là lấy cấu hình ---------------------------------
if ($_POST["action"] === "list_tin_huy") {

    $response['log'] .= "action=list_tin_huy;";

    if (!isset($_POST["ten_tai_khoan"]) ) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không có ten_tai_khoan";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $ten_tai_khoan = $_POST["ten_tai_khoan"];
    
    
    $sql_connector = new sql_connector();

    if(!$sql_connector->conn){ //Nếu có lỗi kết nối csdl
        $response['log'] .= "Loi ket noi csdl; ";
        $response['error'] = $sql_connector->get_connect_error();
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $sql_select = "SELECT * FROM `limit_number` WHERE `tai_khoan_tao` = '$ten_tai_khoan'";

    $lst_number_limit =[];

    if ($limit_number = $sql_connector->get_query_result($sql_select)) {
        while ($row = $limit_number->fetch_assoc()) {

            $lst_number_limit[] = $row;
        }
    }

    $response['success'] = 1;

    $response['lst_number_limit'] = $lst_number_limit;

    echo json_encode($response);

}

if ($_POST["action"] === "huy_chan_tin") {

    $response['log'] .= "action=huy_chan_tin;";

    if (!isset($_POST["ten_tai_khoan"]) ) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không có ten_tai_khoan";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $ten_tai_khoan = $_POST["ten_tai_khoan"];
    $tin_huy = $_POST["tin_huy"];


    $sql_connector = new sql_connector();

    if(!$sql_connector->conn){ //Nếu có lỗi kết nối csdl
        $response['log'] .= "Loi ket noi csdl; ";
        $response['error'] = $sql_connector->get_connect_error();
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $sql_select = "DELETE FROM `limit_number` WHERE `id_limit` IN($tin_huy) ";

   
    $response['success'] = 0;

    if ($limit_number = $sql_connector->get_query_result($sql_select)) {
        $response['success'] = 1;
    }

    

    echo json_encode($response);

}


?>