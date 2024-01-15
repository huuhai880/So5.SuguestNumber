<?php
$dir_name = dirname(__FILE__);

include_once(dirname($dir_name) . '/tin/class_boc_tach_tin.php');
require_once(dirname($dir_name) . '/app/class_sql_connector.php');

class kiem_tra_diem_chan
{
    
    public static function kiem_tra_diem_chan($ds_chi_tiet, $tai_khoan_danh) {

        $sql_connector = new sql_connector();

        # lấy danh sách số chặn theo miền
        $sql_lay_limit_number = "SELECT *
        FROM `max_price`
        WHERE `tai_khoan_tao` = '$tai_khoan_danh'
        AND `vung_mien` = 'mb';";

        $danh_sach_chan_diem =[];

        if ($limit_number = $sql_connector->get_query_result($sql_lay_limit_number)) {
            while ($row = $limit_number->fetch_assoc()) {

                $danh_sach_chan_diem[] = $row;
            }
        }

        # nếu có dữ liệu thì bắt đầu kiểm tra dữ liệu
        if (count($danh_sach_chan_diem) > 0){

            for($index = 0; $index < count( $ds_chi_tiet); $index ++){

                $item_chi_tiet =  $ds_chi_tiet[$index];

                #kiểm tra trong list có những phần thử trùng hay không

                for($index_limit = 0; $index_limit < count($danh_sach_chan_diem); $index_limit ++){

                    $item_limit = $danh_sach_chan_diem[$index_limit];

                    #nếu không có số chặn là có đài chặn và kiểu chặn

                    if(!isset($item_limit['number_limit']) && isset($item_limit['dai_limit']) && isset($item_limit['kieu_so']) && $item_limit['dai_limit'] == $item_chi_tiet->dai){
                        
                        # không số, có đài, có kiểu

                        if(isset($item_limit['kieu_so']) && $item_limit['kieu_so'] == $item_chi_tiet->kieu){
                        
                            #nếu có kiểu đánh trùng thì tiếp tục check xem số điểm đánh có lớn hơn điểm chặn hay không
                            if ($item_limit['diem_chan'] < $item_chi_tiet->diem) {
                               
                                $diem_chan = $item_limit['diem_chan'];

                                $response = array("message" => "điểm của đài '$item_chi_tiet->dai' không được vượt quá $diem_chan ", 'status' => 400 );
                                echo json_encode($response);
                                exit();

                            }
    
                        }
                        
                    }else if(!isset($item_limit['number_limit']) && !isset($item_limit['dai_limit']) && isset($item_limit['kieu_so']) ){

                        # không số, không đài, có kiểu
                        
                        if(isset($item_limit['kieu_so']) && $item_limit['kieu_so'] == $item_chi_tiet->kieu){
                        
                            #nếu có kiểu đánh trùng thì tiếp tục check xem số điểm đánh có lớn hơn điểm chặn hay không
                            if ($item_limit['diem_chan'] < $item_chi_tiet->diem) {
                               
                                $diem_chan = $item_limit['diem_chan'];

                                $response = array("message" => "điểm của kiểu '$item_chi_tiet->kieu' không được vượt quá $diem_chan ", 'status' => 400 );
                                echo json_encode($response);
                                exit();

                            }
    
                            # nếu đài trùng thì kiểm tra xem có cùng với kiểu hay không
                            
                        }

                    }else if(isset($item_limit['number_limit']) && isset($item_limit['dai_limit']) && !isset($item_limit['kieu_so'])){
                        # có số, có đài, không có kiểu
                        
                        if (strpos($item_chi_tiet->so, $item_limit['number_limit']) !== false) {

                            if(isset($item_limit['dai_limit']) && $item_limit['dai_limit'] == $item_chi_tiet->dai){
                        
                                # nếu đài trùng thì kiểm tra xem có cùng với kiểu hay không
        
                                #nếu có kiểu đánh trùng thì tiếp tục check xem số điểm đánh có lớn hơn điểm chặn hay không
                                if ($item_limit['diem_chan'] < $item_chi_tiet->diem) {
                                    
                                    $diem_chan = $item_limit['diem_chan'];

                                    $number_limit = $item_limit['number_limit'];

                                    $response = array("message" => "điểm của đài '$item_chi_tiet->dai' với số đánh $number_limit không được vượt quá $diem_chan ", 'status' => 400 );
                                    echo json_encode($response);
                                    exit();
    
                                }

                            }

                            
                        }


                    }else if(isset($item_limit['number_limit']) && !isset($item_limit['dai_limit']) && !isset($item_limit['kieu_so'])){
                        # có số, ko có đài, không có kiểu
                        
                        if (strpos($item_chi_tiet->so, $item_limit['number_limit']) !== false) {

                            if ($item_limit['diem_chan'] < $item_chi_tiet->diem) {
                                    
                                $diem_chan = $item_limit['diem_chan'];

                                $number_limit = $item_limit['number_limit'];

                                $response = array("message" => "điểm của đài '$item_chi_tiet->dai' với số đánh $number_limit không được vượt quá $diem_chan ", 'status' => 400 );
                                echo json_encode($response);
                                exit();

                            }
                            
                        }


                    }
                    else if(isset($item_limit['number_limit']) && !isset($item_limit['dai_limit']) && isset($item_limit['kieu_so'])){
                        # có số, ko có đài, có kiểu
                        
                        if (strpos($item_chi_tiet->so, $item_limit['number_limit']) !== false) {

                            if(isset($item_limit['kieu_so']) && $item_limit['kieu_so'] == $item_chi_tiet->kieu){
                        
                                if ($item_limit['diem_chan'] < $item_chi_tiet->diem) {
                                    
                                    $diem_chan = $item_limit['diem_chan'];
    
                                    $number_limit = $item_limit['number_limit'];
    
                                    $response = array("message" => "điểm của đài <code>$item_chi_tiet->dai</code> với số đánh <code>$number_limit</code> kiểu <code>$item_chi_tiet->kieu</code> không được vượt quá $diem_chan ", 'status' => 400 );
                                    echo json_encode($response);
                                    exit();
    
                                }
          
                            }
                            
                        }


                    }else if(!isset($item_limit['number_limit']) && isset($item_limit['dai_limit']) && !isset($item_limit['kieu_so'])){
                        # không số, có đài, không kiểu
                
                        if(isset($item_limit['dai_limit']) && $item_limit['dai_limit'] == $item_chi_tiet->dai){
                        
                            if ($item_limit['diem_chan'] < $item_chi_tiet->diem) {
                                    
                                $diem_chan = $item_limit['diem_chan'];
    
                                $number_limit = $item_limit['number_limit'];
    
                                $response = array("message" => "điểm của đài <code>$item_chi_tiet->dai</code>  không được vượt quá $diem_chan ", 'status' => 400 );
                                echo json_encode($response);
                                exit();
    
                            }

                        }


                    }

                }

            }


        }
    }

}

?>