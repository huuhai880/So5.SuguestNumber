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

if ($_POST["action"] === "cai_dat_han_muc") {

    $response['log'] .= "action=cai_dat_han_muc;";
    $response['success'] = 0;

    if (!isset($_POST["so_chan"]) ) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không có số chặn";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $so_chan = $_POST["so_chan"];

    $vung_mien = $_POST["vung_mien"];

    $ten_tai_khoan = $_POST["ten_tai_khoan"];

    $type_tin = $_POST["type_tin"];


    $sql_connector = new sql_connector();

    if(!$sql_connector->conn){ //Nếu có lỗi kết nối csdl
        $response['log'] .= "Loi ket noi csdl; ";
        $response['error'] = $sql_connector->get_connect_error();
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }
    
    # kiểm tra nếu tin chỉ là only_diem thì lưu db luôn


    if($type_tin == "only_diem"){

        $sql_select = "SELECT 1 FROM `max_price` WHERE   `tai_khoan_tao` = '$ten_tai_khoan' AND  `vung_mien` = '$vung_mien' AND `diem_chan` ='$so_chan' AND `kieu_so` IS NULL AND `dai_limit` IS NULL  ;";
        
        if ($sql_connector->get_query_result($sql_select) && $sql_connector->get_query_result($sql_select)->num_rows == 0){

            $sql = "INSERT IGNORE INTO `max_price` (`number_limit`, `dai_limit`, `tai_khoan_tao`,`kieu_so`,`diem_chan`,`vung_mien`) VALUES (NULL, NULL,'$ten_tai_khoan',NULL,'$so_chan','$vung_mien')";

            $result = $sql_connector->get_query_result($sql);
            
            if(!$result){

                $response['success'] = 0;

            }

        }

        $response['success'] = 1;
        
    }else if($type_tin == "dai_and_diem"){

        $_so_chan = explode(" ", $so_chan);

        $dai_limit  = $_so_chan[0];

        $diem_chan = $_so_chan[1];


        $sql_select = "SELECT 1 FROM `max_price` WHERE `number_limit` = IS NULL AND `dai_limit` = '$dai_limit' AND `tai_khoan_tao` = '$ten_tai_khoan' AND `diem_chan` ='$diem_chan' AND `kieu_so` IS NULL AND `vung_mien` = '$vung_mien' ;";
        
        if ($sql_connector->get_query_result($sql_select) && $sql_connector->get_query_result($sql_select)->num_rows == 0){

            $sql = "INSERT IGNORE INTO `max_price` (`number_limit`, `dai_limit`, `tai_khoan_tao`,`kieu_so`,`diem_chan`,`vung_mien`) VALUES (NULL, '$dai_limit','$ten_tai_khoan',NULL,'$diem_chan','$vung_mien')";

            $result = $sql_connector->get_query_result($sql);
        
            if(!$result){

                $response['success'] = 0;

            }

        }

        $response['success'] = 1;
    }
    else{

        $day_of_week = date('w', strtotime(date('Y-m-d H:i:s')));
        $noi_dung_tin = new NoiDungTin($so_chan, $day_of_week, 'admin');

        $noi_dung_tin->noi_dung_str =  $so_chan;


        #kiểm tra số chặn có có kiểu đánh hay không

        $ds_chi_tiet = $noi_dung_tin->BocTachDaiSoKieu();

        if(isset($so_chan)){

            $jsonString = str_replace("'", '"', $so_chan);

            $so_chan = json_decode($jsonString);

            

            for ($i = 0; $i < count($ds_chi_tiet); $i++) {
                
                $dai_chan = $ds_chi_tiet[$i] -> dai;
                $so = $ds_chi_tiet[$i] -> so;
                $kieu = $ds_chi_tiet[$i] -> kieu;
                $diem = $ds_chi_tiet[$i] -> diem;
                
                #kiểm tra điểm của lệnh
                if(isset($diem)){

                    # kiểm tra xem số đã có hay chưa
                    $lst_so = explode(" ", $so);

                    if (count($lst_so) > 0){

                        for($index = 0 ; $index < count($lst_so); $index++){

                            $_number = $lst_so[$index];
        
                            $sql_select = "SELECT 1 FROM `max_price` WHERE `number_limit` = '$_number' AND `dai_limit` = '$dai_chan' AND `tai_khoan_tao` = '$ten_tai_khoan' AND `kieu_so`='$kieu' AND `vung_mien` = '$vung_mien' ;";
        
                            if ($sql_connector->get_query_result($sql_select)->num_rows == 0){
        
                                $sql = "INSERT IGNORE INTO `max_price` (`number_limit`, `dai_limit`, `tai_khoan_tao`,`kieu_so`,`diem_chan`,`vung_mien`) VALUES ('$_number', '$dai_chan','$ten_tai_khoan','$kieu','$diem','$vung_mien')";
        
                                $result = $sql_connector->get_query_result($sql);
                            
                                if(!$result){
        
                                    $response['success'] = 0;
        
                                }
        
                            }
        
                        }

                        $response['success'] = 1;

                    }else{

                        $sql_select = "SELECT 1 FROM `max_price` WHERE  `dai_limit` = '$dai_chan' AND `tai_khoan_tao` = '$ten_tai_khoan' AND `kieu_so`='$kieu' AND `vung_mien` = '$vung_mien' ;";
        
                        if ($sql_connector->get_query_result($sql_select)->num_rows == 0){

                            $sql = "INSERT IGNORE INTO `max_price` ( `dai_limit`, `tai_khoan_tao`,`kieu_so`,`diem_chan`,`vung_mien`) VALUES ('$dai_chan','$ten_tai_khoan','$kieu','$diem','$vung_mien')";

                            $result = $sql_connector->get_query_result($sql);
                            
                            if(!$result){

                                $response['success'] = 0;

                            }

                        }

                        $response['success'] = 1;

                    }

                }else{
                    
                    $response['success'] = 0;
                    echo json_encode($response);
                    exit();
                }
                
            }

            
        }

    }

    echo json_encode($response);
    
}


if ($_POST["action"] === "xoa_tin") {

    $response['log'] .= "action=xoa_tin;";

    if (!isset($_POST["message_id"]) ) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không có message_id";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $message_id = $_POST["message_id"];
    $ten_tai_khoan = $_POST["ten_tai_khoan"];
    
    
    $sql_connector = new sql_connector();

    if(!$sql_connector->conn){ //Nếu có lỗi kết nối csdl
        $response['log'] .= "Loi ket noi csdl; ";
        $response['error'] = $sql_connector->get_connect_error();
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $sql_select = "DELETE FROM `tin` WHERE message_id = '$message_id' AND tai_khoan_danh ='$ten_tai_khoan' ";

    if ($sql_connector->get_query_result($sql_select)){

        $response['success'] = 1;

        echo json_encode($response);
        
    }    
}


?>