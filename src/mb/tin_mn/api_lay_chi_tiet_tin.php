<?php 

$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
include_once($dir_name . '/class_tin.php');
include_once($dir_name . '/class_noi_dung_tin.php');

$response = array();
$response['log'] = "";
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    //Nếu không phải POST thì thoát
    $response['log'] = "không phải post;";
    $response['success'] = 0;
    echo json_encode($response);
    exit();
}

//-------------------------Nếu là đọc chi tiết tin ---------------------------------
if ($_POST["action"] === "doc_chi_tiet_tin") {

    $response['log'] .= "action=doc_chi_tiet_tin;";
    if (!isset($_POST["id_tin"])) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "khong co tin";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $id_tin = $_POST["id_tin"];
    $response['log'] .= "id_tin = " . $id_tin;


    $tin = tin::DocTinTuDbTheoID($id_tin);
   
    
    //$result = tin::CapNhatThongKeChoTin($tin, $ds_chi_tiet);

    $html_kq = $tin->toHTML();
    $ds_chi_tiet = $tin->lay_chi_tiet();
    $response['html_ket_qua'] = $html_kq;
    $response['success'] = 1;
    $response['tin'] = json_encode($tin);
    echo json_encode($response);
    exit();
}

?>