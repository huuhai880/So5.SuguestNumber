<?php
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
include_once(dirname($dir_name) . '/tin/class_tin.php');
include_once(dirname($dir_name) . '/tin/class_noi_dung_tin.php');


date_default_timezone_set('Asia/Ho_Chi_Minh');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //Chuyển thông tin gửi lên từ post dạng object
    $tin_cu = new tin();
    $tin_moi = new tin();
    $thong_bao = '';
    $luu_thanh_cong = false;

    if (isset($_POST["smsid"])) {
        $id_tin = $_POST["smsid"];
        $tin_cu = tin::doc_tin_tu_db_theo_id($id_tin);
    }

    $tin_moi->noi_dung = strip_tags($_POST['noi_dung']);
    $tin_moi->thoi_gian_danh = date('Y-m-d', strtotime($_POST["thoi_gian_danh"]));
    $tin_moi->tai_khoan_danh = $_POST["tai_khoan_danh"];
    $tin_moi->tai_khoan_tao = $_POST['account_create'];
    $tin_moi->thoi_gian_tao = date('Y-m-d H:i:s');
    $action = $_POST["action"];
    $vung_mien = $_POST["vung_mien"];
    $message_id = $_POST['message_id'];
    //Tin quá dài
    if (strlen($tin_moi->noi_dung) > 4990) {
        echo 'Tin quá dài';
        exit();
    }


    //Tạo đối tượng noi_dung_tin để thực hiện kiểm tra và bóc tách
    $day_of_week = date('w', strtotime($tin_moi->thoi_gian_danh));
    $noi_dung_tin = new NoiDungTin($tin_moi->noi_dung, $day_of_week, $tin_moi->tai_khoan_danh);

    $tin_moi->noi_dung = $noi_dung_tin->noi_dung_str; //Cập nhật lại nội dung đã được chuẩn hoá
  
    $ket_qua_kiem_tra = '';
    if (!isset($_POST["smsid"])) {
        $ket_qua_kiem_tra = $noi_dung_tin->KiemTraNoiDung($_POST["tai_khoan_danh"]);
    }

    if ($ket_qua_kiem_tra){
       
        $response = array("message" => $ket_qua_kiem_tra, 'status' => 400 );
        echo json_encode($response);
    }

   

    if (empty($ket_qua_kiem_tra)) { //Nếu ko có lỗi
        $ds_chi_tiet = $noi_dung_tin->BocTachDaiSoKieu();

        #kiểm tra tiếp danh sách chi tiết

        #kiểm tra limit điểm đánh theo đài và kiểu

        $sql_connector = new sql_connector();

        # lấy danh sách số chặn theo miền
        $sql_lay_limit_number = "SELECT *
        FROM `max_price`
        WHERE `tai_khoan_tao` = '$tin_moi->tai_khoan_danh'
        AND `vung_mien` = 'mn';";

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


        $result = tin::CapNhatThongKeChoTin($tin_moi, $ds_chi_tiet);

        $ds_chi_tiet = $result['ds_chi_tiet'];
        $ds_thong_ke = $result['ds_thong_ke'];
        $tin_moi = $result['tin'];

        // Define a callback function for array_reduce
        $grouped_by_so = array_reduce($ds_chi_tiet, function ($result, $item) {
            $so = $item->so;

            // Check if the key exists in the result array
            if (!array_key_exists($so, $result)) {
                $result[$so] = [];
            }

            // Append the current item to the result array under the corresponding key
            $result[$so][] = $item;

            return $result;
        }, []);

        if ($action === 'luu') {
            if (isset($_POST["smsid"])) { //Cập nhật
                $noi_dung_chinh_sua = 'Sửa bởi ' . $tin_moi->tai_khoan_tao . '\r\n';
                $noi_dung_chinh_sua = 'vào lúc ' . $tin_moi->thoi_gian_tao . '\r\n';
                $noi_dung_chinh_sua = 'Những thay đổi:\r\n';
                if (strcmp($tin_cu->tai_khoan_danh, $tin_moi->tai_khoan_danh) != 0)
                    $noi_dung_chinh_sua = 'Khách cũ: ' . $tin_cu->tai_khoan_danh . ' => mới: ' . $tin_moi->tai_khoan_danh . '\r\n';
                if (strcmp($tin_cu->thoi_gian_danh, $tin_moi->thoi_gian_danh) != 0)
                    $noi_dung_chinh_sua = 'Ngày đánh cũ: ' . $tin_cu->thoi_gian_danh . ' => mới: ' . $tin_moi->thoi_gian_danh . '\r\n';
                if (strcmp($tin_cu->noi_dung, $tin_moi->noi_dung) != 0)
                    $noi_dung_chinh_sua = 'Nội dung cũ: ' . $tin_cu->noi_dung . '\r\n => mới: ' . $tin_moi->noi_dung . '\r\n';

                $tin_moi->id = $tin_cu->id;
                $tin_moi->thoi_gian_tao = $tin_cu->thoi_gian_tao;
                $tin_moi->tai_khoan_tao = $tin_cu->tai_khoan_tao;
                $tin_moi->ghi_chu .= $noi_dung_chinh_sua;
                $tin_moi->cap_nhat_xuong_db();
                $thong_bao = "Cập nhật tin thành công!";
                $luu_thanh_cong = true;

                $response = array("data" => $ds_thong_ke,'ds_chi_tiet'=>$ds_chi_tiet, "message" => "success", 'status' => 200 );

                echo json_encode($response);

            } else { //ghi mới
                $kq_ghi = tin::GhiTinVaChiTiet($tin_moi, $ds_chi_tiet, $vung_mien, $message_id);
                //Ghi Tin và các chi tiết xuống csdl
                if ($kq_ghi) {
                    $thong_bao = "Lưu thành công!";
                    $luu_thanh_cong = true;

                    $response = array("data" => $ds_thong_ke,'ds_chi_tiet'=>$grouped_by_so, "message" => "success", 'status' => 200 );

                    echo json_encode($response);

                } else {
                    $thong_bao = "Lỗi! không lưu thành công";
                    $response = array("message" => "Lỗi! không lưu thành công", 'status' => 400 );
                    echo json_encode($response);
                }
            }
        }
    }
}
if (isset($_GET["smsid"])) {
    $id_tin = $_GET["smsid"];
    $tin_moi = tin::doc_tin_tu_db_theo_id($id_tin);

    $day_of_week = date('w', strtotime($tin_moi->thoi_gian_danh));
    $noi_dung_tin = new NoiDungTin($tin_moi->noi_dung, $day_of_week, $tin_moi->tai_khoan_danh);

    $ds_chi_tiet = $noi_dung_tin->BocTachDaiSoKieu();

    $result = tin::CapNhatThongKeChoTin($tin_moi, $ds_chi_tiet);

    $ds_chi_tiet = $result['ds_chi_tiet'];
    $ds_thong_ke = $result['ds_thong_ke'];
}

function xuat_html_hideninput_smsid(){
    
}
function xuat_html_noi_dung_tin(string $ket_qua_kiem_tra, string $noi_dung): string
{
    if (empty($ket_qua_kiem_tra))
        return $noi_dung;
    $noi_dung_html = substr($ket_qua_kiem_tra, 0, strpos($ket_qua_kiem_tra, '</p>'));
    $noi_dung_html = str_replace('<p>', '', $noi_dung_html);
    return $noi_dung_html;
}
function xuat_html_loi(string $ket_qua_kiem_tra): string
{
    if (empty($ket_qua_kiem_tra))
        return '';
    $loi_html = substr($ket_qua_kiem_tra, strpos($ket_qua_kiem_tra, '</p>') + 4);
    $loi_html = str_replace('<p>', '', $loi_html);
    return $loi_html;
}
function xuat_html_thong_ke(array $ds_thong_ke): string
{
    $result = '<tbody role="rowgroup">';
    $tong = new tin_thongke(""); //Biến tổng để lưu tổng các thống kê, giúp xuất tổng
    foreach ($ds_thong_ke as $item) {
        //$thong_ke = new tin_thongke('');
        //$thong_ke->sao_chep($item);
        $result .= $item->toHTML_web(); //xuất các dòng 2c,3c...
        //Lưu vào 
        $tong->xac += $item->xac;
        $tong->thuc_thu += $item->thuc_thu;
        $tong->tien_trung += $item->tien_trung;
    }
    $result .= ' </tbody>
                <tfoot role="rowgroup" class="">';

    $result .= '<tr role="row" class="">
                        <th role="columnheader" scope="col" class="font-italic font-weight-light"> </th>
                        <th role="columnheader" scope="col" class="info">' . number_format($tong->xac, 1) . '<!----></th>
                        <th role="columnheader" scope="col" class="info">' . number_format($tong->thuc_thu, 1) . '</th>
                        <th role="columnheader" scope="col" class="info">' . number_format($tong->tien_trung, 1) . '</th>
                    </tr>';
    $result .= ' <tr role="row" class="">
                        <td colspan="2" role="columnheader" scope="colspan" class=""></td>
                        <td colspan="2" role="columnheader" scope="colspan" class="text-right summary">
                        <div>
                            <span class="text-danger">Ăn |</span>
                            <span class="text-primary"> Thua</span>:';
    if (($tong->tien_trung - $tong->thuc_thu) >= 0)
        $result .= '<b><span class="text-primary"> ' . number_format($tong->tien_trung - $tong->thuc_thu, 1) . ' </span></b>';
    else
        $result .= '<b><span class="text-danger"> ' . number_format($tong->tien_trung - $tong->thuc_thu, 1) . ' </span></b>';

    $result .= '</div><!---->
                </td>
            </tr>
            </tfoot>';
    return $result;
}
function xuat_html_chitiettin(array $ds_chi_tiet): string
{
    $result = '';
    $tong = new tin_thongke(""); //Biến tổng để lưu tổng các thống kê, giúp xuất tổng
    foreach ($ds_chi_tiet as $item) {
        //$thong_ke = new tin_thongke('');
        //$thong_ke->sao_chep($item);
        $result .= $item->toHTML_web(); //xuất các dòng 2c,3c...
        //Lưu vào 
    }
    return $result;
}



?>