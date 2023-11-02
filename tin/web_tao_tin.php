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
    $tin_moi->tai_khoan_tao = $_SESSION['username'];
    $tin_moi->thoi_gian_tao = date('Y-m-d H:i:s');
    $action = $_POST["action"];
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
        $ket_qua_kiem_tra = $noi_dung_tin->KiemTraNoiDung();
    }

    if (empty($ket_qua_kiem_tra)) { //Nếu ko có lỗi
        $ds_chi_tiet = $noi_dung_tin->BocTachDaiSoKieu();

        $result = tin::CapNhatThongKeChoTin($tin_moi, $ds_chi_tiet);

        $ds_chi_tiet = $result['ds_chi_tiet'];
        $ds_thong_ke = $result['ds_thong_ke'];
        $tin_moi = $result['tin'];

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
            } else { //ghi mới
                $kq_ghi = tin::GhiTinVaChiTiet($tin_moi, $ds_chi_tiet);
                //Ghi Tin và các chi tiết xuống csdl
                if ($kq_ghi) {
                    $thong_bao = "Lưu thành công!";
                    $luu_thanh_cong = true;
                } else {
                    $thong_bao = "Lỗi! không lưu thành công";
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