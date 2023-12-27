<?php
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
include_once(dirname($dir_name) . '/tin/class_tin.php');

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
if ($_POST["action"] === "chan_so_theo_mien") {

    $response['log'] .= "action=chan_so_theo_mien;";
    $response['success'] = 0;

    if (!isset($_POST["so_chan"]) ) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không có số chặn";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $so_chan = $_POST["so_chan"];

    $ten_tai_khoan = $_POST["ten_tai_khoan"];

    if(isset($so_chan)){

        $jsonString = str_replace("'", '"', $so_chan);

        $so_chan = json_decode($jsonString);

        $sql_connector = new sql_connector();

        if(!$sql_connector->conn){ //Nếu có lỗi kết nối csdl
            $response['log'] .= "Loi ket noi csdl; ";
            $response['error'] = $sql_connector->get_connect_error();
            $response['success'] = 0;
            echo json_encode($response);
            exit();
        }

        for ($i = 0; $i < count($so_chan); $i++) {
            
            $dai_chan = $so_chan[$i]->dai;

            $lst_so = $so_chan[$i]->so;

            for ($j = 0; $j < count($lst_so); $j++) {
                
                $so = $lst_so[$j];

                # kiểm tra xem số đã có hay chưa

                $sql_select = "SELECT 1 FROM `limit_number` WHERE `number_limit` = '$so' AND `vung_mien` = '$dai_chan' AND `tai_khoan_tao` = '$ten_tai_khoan';";

                if ($sql_connector->get_query_result($sql_select)->num_rows == 0){

                    $sql = "INSERT IGNORE INTO `limit_number` (`number_limit`, `vung_mien`, `tai_khoan_tao`) VALUES ('$so', '$dai_chan','$ten_tai_khoan')";

                    $result = $sql_connector->get_query_result($sql);
                
                    if(!$result){

                        $response['success'] = 0;

                    }

                }
            }

        }

        $response['success'] = 1;
    }

    echo json_encode($response);
    
}

if ($_POST["action"] === "chan_dai") {

    $response['log'] .= "action=chan_dai;";

    if (!isset($_POST["dai_chan"]) ) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không có số chặn";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $dai_chan = $_POST["dai_chan"];
    $vung_mien = $_POST["vung_mien"];

    $ten_tai_khoan = $_POST["ten_tai_khoan"];
    
    $sql_connector = new sql_connector();

    if(!$sql_connector->conn){ //Nếu có lỗi kết nối csdl
        $response['log'] .= "Loi ket noi csdl; ";
        $response['error'] = $sql_connector->get_connect_error();
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $sql_select = "SELECT 1 FROM `limit_number` WHERE `dai_limit` = '$dai_chan' AND `vung_mien` ='$vung_mien'  AND `tai_khoan_tao` = '$ten_tai_khoan';";

    if ($sql_connector->get_query_result($sql_select)->num_rows == 0){

        $sql = "INSERT IGNORE INTO `limit_number` (`dai_limit`, `vung_mien`, `tai_khoan_tao`) VALUES ('$dai_chan','$vung_mien' ,'$ten_tai_khoan')";

        $result = $sql_connector->get_query_result($sql);
    
        if(!$result){

            $response['success'] = 0;

        }

    }

    $response['success'] = 1;

    echo json_encode($response);
    
}


?>