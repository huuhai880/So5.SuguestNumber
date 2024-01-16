<?php
$dir_name = dirname(__FILE__);

include_once(dirname($dir_name) . '/tin/class_boc_tach_tin.php');
require_once(dirname($dir_name) . '/app/class_sql_connector.php');

class kiem_tra_tang_diem
{
    
    public static function kiem_tra_tang_diem($tai_khoan_danh) {
        $sql_connector = new sql_connector();
         
        # lấy danh sách số chặn theo miền
        $sql_lay_limit_number = "SELECT * FROM `up_price` WHERE `tai_khoan_tao` = '$tai_khoan_danh'
        AND CAST(`time_exp` AS DATE) = CAST(NOW() AS DATE) AND `vung_mien`='mb';";


        $danh_sach_chan_diem =[];

        if ($limit_number = $sql_connector->get_query_result($sql_lay_limit_number)) {
            while ($row = $limit_number->fetch_assoc()) {

                $danh_sach_chan_diem[] = $row;
            }
        }

        return $danh_sach_chan_diem;

    }


    public static function lay_so_diem_tang($danh_sach_chan_diem, $kieu_danh, $dai, $numbersToCheck) {
        
        $msg_diem_tang = '';
        $diem_tang = 0;
        $result = [];
    
        for ($index = 0; $index < count($danh_sach_chan_diem); $index++) {
    
            $item_diem = $danh_sach_chan_diem[$index];
    
            // Check if the betting limit matches
            if ($item_diem['dai_limit'] == $dai) {
    
                // Check if the betting type matches
                if ($item_diem['kieu_so'] == $kieu_danh) {
    
                    foreach ($numbersToCheck as $so) {
    
                        // Check if the number matches the specified condition
                        if ($item_diem['number_limit'] == $so) {
                            $diem_tang = $item_diem['diem_chan'];
                            $msg_diem_tang .= '- Số ' . $so . " đài " . $dai . " kiểu " . $kieu_danh . " điểm trúng được tăng lên " . $item_diem['diem_chan'] . "\n";
                        }
                    }
                }
            }
        }
    
        $result['msg_diem_tang'] = $msg_diem_tang;
        $result['diem_tang'] = $diem_tang;
    
        return $result;
    }

}

?>