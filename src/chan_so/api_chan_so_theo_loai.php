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



if ($_POST["action"] === "chan_so_theo_loai") {

    $response['log'] .= "action=chan_so_theo_loai;";
    $response['success'] = 0;

    if (!isset($_POST["lst_so_chan"]) ) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không có số chặn";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $lst_so_chan = $_POST["lst_so_chan"];

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
    
    # kiểm tra nếu tin chỉ là only_diem thì lưu db luôn

    $day_of_week = date('w', strtotime(date('Y-m-d H:i:s')));
    
    $jsonString = str_replace("'", '"', $lst_so_chan);

    $lst_so_chan = json_decode($jsonString);

    
    #kiểm tra số chặn có có kiểu đánh hay không

    for($index_list = 0; $index_list < count($lst_so_chan); $index_list ++  ){

        $noi_dung_tin = new NoiDungTin($lst_so_chan[$index_list], $day_of_week, 'admin');
        
        $noi_dung_tin->noi_dung_str =  $lst_so_chan[$index_list];

        $ds_chi_tiet = $noi_dung_tin->BocTachDaiSoKieu();


        if(isset($ds_chi_tiet) && count($ds_chi_tiet) > 0){

            for($item_chi_tiet = 0; $item_chi_tiet < count($ds_chi_tiet) ; $item_chi_tiet ++ ){

                $dai_chan = $ds_chi_tiet[$item_chi_tiet] -> dai;
                $so = $ds_chi_tiet[$item_chi_tiet] -> so;
                $kieu = $ds_chi_tiet[$item_chi_tiet] -> kieu;
                $diem = $ds_chi_tiet[$item_chi_tiet] -> diem;

                if(isset($so)){

                    #cắt chỗi số thành mảng
                    $lst_so = explode(" ", $so);

                    for($index = 0 ; $index < count($lst_so); $index++){

                        $_number = $lst_so[$index];

                       
    
                        $sql_select = "SELECT 1 FROM `limit_number` WHERE `number_limit` = '$_number' AND `dai_limit` = '$dai_chan' AND `tai_khoan_tao` = '$ten_tai_khoan' AND `kieu_so`='$kieu' AND `vung_mien` = '$vung_mien' ;";
                        
                       

                        if ($sql_connector->get_query_result($sql_select) && $sql_connector->get_query_result($sql_select)->num_rows == 0){
    
                            $sql = "INSERT INTO `limit_number` (`number_limit`, `dai_limit`, `tai_khoan_tao`,`kieu_so`,`diem_chan`,`vung_mien`) VALUES ('$_number', '$dai_chan','$ten_tai_khoan','$kieu','$diem','$vung_mien')";
                            
                            $result = $sql_connector->get_query_result($sql);
                            
                            if(!$result){
    
                                $response['success'] = 0;
                                echo json_encode($response);
                                exit();

                            }
    
                        }
    
                    }

                    $response['success'] = 1;


                }

            }

        }


    }

    
    // if(isset($so_chan)){

    //     $jsonString = str_replace("'", '"', $so_chan);

    //     $so_chan = json_decode($jsonString);

        

    //     for ($i = 0; $i < count($ds_chi_tiet); $i++) {
            
    //         $dai_chan = $ds_chi_tiet[$i] -> dai;
    //         $so = $ds_chi_tiet[$i] -> so;
    //         $kieu = $ds_chi_tiet[$i] -> kieu;
    //         $diem = $ds_chi_tiet[$i] -> diem;
            
    //         #kiểm tra điểm của lệnh
    //         if(isset($diem)){

    //             # kiểm tra xem số đã có hay chưa
    //             $lst_so = explode(" ", $so);

    //             if (count($lst_so) > 0){

    //                 for($index = 0 ; $index < count($lst_so); $index++){

    //                     $_number = $lst_so[$index];
    
    //                     $sql_select = "SELECT 1 FROM `max_price` WHERE `number_limit` = '$_number' AND `dai_limit` = '$dai_chan' AND `tai_khoan_tao` = '$ten_tai_khoan' AND `kieu_so`='$kieu' AND `vung_mien` = '$vung_mien' ;";
    
    //                     if ($sql_connector->get_query_result($sql_select)->num_rows == 0){
    
    //                         $sql = "INSERT IGNORE INTO `max_price` (`number_limit`, `dai_limit`, `tai_khoan_tao`,`kieu_so`,`diem_chan`,`vung_mien`) VALUES ('$_number', '$dai_chan','$ten_tai_khoan','$kieu','$diem','$vung_mien')";
    
    //                         $result = $sql_connector->get_query_result($sql);
                        
    //                         if(!$result){
    
    //                             $response['success'] = 0;
    
    //                         }
    
    //                     }
    
    //                 }

    //                 $response['success'] = 1;

    //             }else{

    //                 $sql_select = "SELECT 1 FROM `max_price` WHERE  `dai_limit` = '$dai_chan' AND `tai_khoan_tao` = '$ten_tai_khoan' AND `kieu_so`='$kieu' AND `vung_mien` = '$vung_mien' ;";
    
    //                 if ($sql_connector->get_query_result($sql_select)->num_rows == 0){

    //                     $sql = "INSERT IGNORE INTO `max_price` ( `dai_limit`, `tai_khoan_tao`,`kieu_so`,`diem_chan`,`vung_mien`) VALUES ('$dai_chan','$ten_tai_khoan','$kieu','$diem','$vung_mien')";

    //                     $result = $sql_connector->get_query_result($sql);
                        
    //                     if(!$result){

    //                         $response['success'] = 0;

    //                     }

    //                 }

    //                 $response['success'] = 1;

    //             }

    //         }else{
                
    //             $response['success'] = 0;
    //             echo json_encode($response);
    //             exit();
    //         }
            
    //     }

        
    // }

    

    echo json_encode($response);
    
}

?>