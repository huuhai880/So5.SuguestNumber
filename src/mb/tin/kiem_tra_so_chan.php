<?php
$dir_name = dirname(__FILE__);

include_once(dirname($dir_name) . '/tin/class_boc_tach_tin.php');
require_once(dirname($dir_name) . '/app/class_sql_connector.php');

class kiem_tra_so_chan
{
    
    public static function kiem_tra_so_chan_tin($ds_chi_tiet, $tai_khoan_danh) {
        $sql_connector = new sql_connector();
         
        # lấy danh sách số chặn theo miền
        $sql_lay_limit_number = "SELECT *
        FROM `limit_number`
        WHERE `tai_khoan_tao` = '$tai_khoan_danh'
        AND `vung_mien` = 'mb' AND `number_limit` IS NOT NULL;";


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

                #kiểm tra xem kiểu có phải là "da" không nếu là da thì tách số

                if($item_chi_tiet -> kieu =='da'){

                    $_item_so = $item_chi_tiet -> so;

                    $lst_so = explode(",", $_item_so);

                    for($index_number = 0 ; $index_number < count($lst_so); $index_number++){

                        $_number = $lst_so[$index_number];

                        #kiểm tra trong list có những phần thử trùng hay không

                        for($index_limit = 0; $index_limit < count($danh_sach_chan_diem); $index_limit ++){

                            $item_limit = $danh_sach_chan_diem[$index_limit];


                            #nếu không có số chặn là có đài chặn và kiểu chặn

                            if(isset($item_limit['number_limit']) && isset($item_limit['dai_limit']) && isset($item_limit['kieu_so'])){

                                
                                if (strpos($_number, $item_limit['number_limit']) !== false) {

                                    
                                   
                                    if(isset($item_limit['dai_limit']) && $item_limit['dai_limit'] == $item_chi_tiet->dai){
                                        
                                        # nếu đài trùng thì kiểm tra xem có cùng với kiểu hay không
                
                                        #nếu có kiểu đánh trùng thì tiếp tục check xem số điểm đánh có lớn hơn điểm chặn hay không
                                        if(isset($item_limit['kieu_so']) && $item_limit['kieu_so'] == $item_chi_tiet->kieu){

                                            if ($item_limit['diem_chan'] == $item_chi_tiet->diem) {
                                                
                                                $diem_chan = $item_limit['diem_chan'];
                
                                                $number_limit = $item_limit['number_limit'];

                                                $kieu_so = $item_limit['kieu_so'];
                
                                                $response = array("message" => "Số đánh  <code> $number_limit </code> đã bị chặn trong kiểu <code> $kieu_so </code> với điểm <code> $diem_chan </code> ", 'status' => 400 );
                                                echo json_encode($response);
                                                exit();
                
                                            }
                    
                                        }

                                    }

                                    
                                }


                            }else if(isset($item_limit['number_limit']) && !isset($item_limit['dai_limit']) && isset($item_limit['kieu_so'])){
                                # có số, ko có đài, có kiểu
                                
                                if (strpos($_number, $item_limit['number_limit']) !== false) {

                                    if(isset($item_limit['kieu_so']) && $item_limit['kieu_so'] == $item_chi_tiet->kieu){
                                
                                        if ($item_limit['diem_chan'] == $item_chi_tiet->diem) {
                                            
                                            $diem_chan = $item_limit['diem_chan'];
            
                                            $number_limit = $item_limit['number_limit'];

                                            $kieu_so = $item_limit['kieu_so'];
            
                                            $response = array("message" => "Số đánh  <code> $number_limit </code> đã bị chặn trong kiểu <code> $kieu_so </code> với điểm <code> $diem_chan </code> ", 'status' => 400 );
                                            echo json_encode($response);
                                            exit();
            
                                        }
                
                                    }
                                    
                                }


                            }

                        }
                    }

                }else{

                    #kiểm tra trong list có những phần thử trùng hay không

                    for($index_limit = 0; $index_limit < count($danh_sach_chan_diem); $index_limit ++){

                        $item_limit = $danh_sach_chan_diem[$index_limit];


                        #nếu không có số chặn là có đài chặn và kiểu chặn
                        if(isset($item_limit['number_limit']) && isset($item_limit['dai_limit']) && isset($item_limit['kieu_so'])){

                            if (strpos($item_chi_tiet->so, $item_limit['number_limit']) !== false) {

                               
                                if(isset($item_limit['dai_limit']) && $item_limit['dai_limit'] == $item_chi_tiet->dai){
                            
                                    # nếu đài trùng thì kiểm tra xem có cùng với kiểu hay không
            
                                    #nếu có kiểu đánh trùng thì tiếp tục check xem số điểm đánh có lớn hơn điểm chặn hay không
                                    if(isset($item_limit['kieu_so']) && $item_limit['kieu_so'] == $item_chi_tiet->kieu){
                            
                                        if ($item_limit['diem_chan'] == $item_chi_tiet->diem) {
                                            
                                            $diem_chan = $item_limit['diem_chan'];
                
                                            $number_limit = $item_limit['number_limit'];

                                            $kieu_so = $item_limit['kieu_so'];
            
                                            $response = array("message" => "Số đánh  <code> $number_limit </code> đã bị chặn trong kiểu <code> $kieu_so </code> với điểm <code> $diem_chan </code> ", 'status' => 400 );
                                            echo json_encode($response);
                                            exit();
            
                                        }
                
                                    }

                                }

                                
                            }

                        }
                        
                        else if(isset($item_limit['number_limit']) && !isset($item_limit['dai_limit']) && isset($item_limit['kieu_so'])){
                            # có số, ko có đài, có kiểu
                            
                            if (strpos($item_chi_tiet->so, $item_limit['number_limit']) !== false) {

                                if(isset($item_limit['kieu_so']) && $item_limit['kieu_so'] == $item_chi_tiet->kieu){
                            
                                    if ($item_limit['diem_chan'] == $item_chi_tiet->diem) {
                                        
                                        $diem_chan = $item_limit['diem_chan'];
            
                                        $number_limit = $item_limit['number_limit'];

                                        $kieu_so = $item_limit['kieu_so'];
        
                                        $response = array("message" => "Số đánh  <code> $number_limit </code> đã bị chặn trong kiểu <code> $kieu_so </code> với điểm <code> $diem_chan </code> ", 'status' => 400 );
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
    }

}

?>