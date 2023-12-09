<?php
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
include_once(dirname($dir_name) . '/thong_ke/class_thong_ke.php');
include_once(dirname($dir_name) . '/tin/class_tin.php');

$tai_khoan_dang_dang_nhap = $_SESSION["username"];
$loai_tai_khoan = $_SESSION["loai_tai_khoan"];

$tai_khoan_can_tim = $_POST['tai_khoan_can_tim'] ?? 'all';

$ngay_can_tim = date("Y-m-d");
//$ngay_can_tim = 'all';
if(isset($_POST["ngay_can_tim"])){
    if($_POST["ngay_can_tim"] === 'all')
        $ngay_can_tim = 'all';
    else
        $ngay_can_tim = date("Y-m-d", strtotime($_POST["ngay_can_tim"]));
}


if ($loai_tai_khoan === 'god') {
    //Nếu god thì thoát, tạm thời chưa làm với god
    echo 'Khônng hoạt động với god';
    exit();
}

//Cập nhật kết quả các tin trước khi đọc
tin::CapNhatKetQuaCacTin($tai_khoan_dang_dang_nhap, $loai_tai_khoan);

//Chuẩn bị danh sách các thống kê
$thong_ke_list = array();

//Bắt đầu đọc tài khoản cấp dưới nếu có
$sql_connector = new sql_connector();
if ($tai_khoan_can_tim === 'all')
    $sql_lay_tai_khoan = "SELECT ten_tai_khoan FROM tai_khoan 
                                        WHERE (tai_khoan_quan_ly = '$tai_khoan_dang_dang_nhap') OR (ten_tai_khoan = '$tai_khoan_dang_dang_nhap')";
else
    $sql_lay_tai_khoan = "SELECT ten_tai_khoan FROM tai_khoan WHERE ten_tai_khoan = '$tai_khoan_can_tim'";

if ($result_tai_khoan = $sql_connector->get_query_result($sql_lay_tai_khoan)) {
    while ($row = $result_tai_khoan->fetch_assoc()) {

        $ten_tk = $row['ten_tai_khoan']; //Lấy được tên tài khoản 

        $thong_ke = new thong_ke(); //Tạo thống kê với mỗi tài khoản

        $thong_ke->ten_tai_khoan = $row['ten_tai_khoan']; //Cập nhật

        //Tạo câu sql truy vấn danh sách tin theo iểu truy vấn tương ứng.
        if ($ngay_can_tim === "all") {
            $sql_lay_tin = "SELECT * FROM tin WHERE tai_khoan_danh = '$ten_tk'";
        } else {
            $sql_lay_tin = "SELECT * FROM tin WHERE tai_khoan_danh = '$ten_tk'
                                AND thoi_gian_danh = '$ngay_can_tim'";
        }
        $tin_list = tin::doc_tin_tu_db($sql_lay_tin);
        $thong_ke = CapNhatThongKeTheoDanhSachTin($tin_list, $thong_ke); //Hàm cập nhật thống kê theo danh sách tin
        $thong_ke->TaoNoiDungSo($ngay_can_tim);
        $thong_ke_list[] = $thong_ke;
    }

}

function CapNhatThongKeTheoDanhSachTin(array $tin_list, thong_ke $thong_ke): thong_ke
{
    foreach ($tin_list as $tin) { //Mới mỗi tin
        $thong_ke->so_tin++; //Tăng biến đếm số tin
        $thong_ke->hai_c += $tin->hai_c;
        $thong_ke->ba_c += $tin->ba_c;
        $thong_ke->bon_c += $tin->bon_c;
        $thong_ke->da_daxien += $tin->da_daxien;
        $thong_ke->xac += $tin->xac;
        $thong_ke->thuc_thu += $tin->thuc_thu;
        $thong_ke->tien_trung += ($tin->tien_trung != -1) ? $tin->tien_trung : 0;
    }
    $thong_ke->thang_thua = $thong_ke->tien_trung - $thong_ke->thuc_thu;
    return $thong_ke;
}
function xuat_html_thong_ke(array $ds_thong_ke):string{
    $result = '';
    $tong_so_tin = $tong_hai_c = $tong_babon_c = $tong_da_daxien = $tong_xac = $tong_thuc_thu = $tong_trung = $tong_thang_thua = 0.0;
    for ($i=0; $i < count($ds_thong_ke); $i++) { 
        $noi_dung_so = str_replace('</p><p>', '\r\n', $ds_thong_ke[$i]->so);
        $noi_dung_so = str_replace('<p>', "", $noi_dung_so);
        $noi_dung_so = str_replace('</p>', "", $noi_dung_so);
        $result .= '
            <tbody role="rowgroup"><!---->
                <tr role="row" class="">
                    <td aria-colindex="1" role="cell" class=""> '. ($i + 1) .' </td> <!-- STT -->
                    <td aria-colindex="2" role="cell" class=""><a
                            href="ql_tin.php?name='. $ds_thong_ke[$i]->ten_tai_khoan .'&date=all"
                            class="text-primary"> '. $ds_thong_ke[$i]->ten_tai_khoan .' </a></td> <!-- Tên khách -->
                    <td aria-colindex="3" role="cell" class=""><span>'. $ds_thong_ke[$i]->so_tin .'</span></td> <!-- Số tin -->
                    <td aria-colindex="4" role="cell" class="">'. number_format($ds_thong_ke[$i]->hai_c, 1, ",", ".")  .'</td> <!-- 2d -->
                    <td aria-colindex="5" role="cell" class="">'. number_format(($ds_thong_ke[$i]->ba_c + $ds_thong_ke[$i]->bon_c), 1, ",", ".") .'</td> <!-- 3d4d -->
                    <td aria-colindex="6" role="cell" class="">'. number_format($ds_thong_ke[$i]->da_daxien, 1, ",", ".")  .'</td> <!-- da dx -->
                    <td aria-colindex="7" role="cell" class="">'. number_format($ds_thong_ke[$i]->xac, 1, ",", ".")  .'</td> <!-- xac -->
                    <td aria-colindex="8" role="cell" class="">'. number_format($ds_thong_ke[$i]->thuc_thu, 1, ",", ".")  .'</td> <!-- thucthu -->
                    <td aria-colindex="9" role="cell" class="">'. number_format($ds_thong_ke[$i]->tien_trung, 1, ",", ".")  .'</td> <!-- trung -->
                    <td aria-colindex="10" role="cell" class=""><span><span 
                                class=" text-danger">'. number_format($ds_thong_ke[$i]->thang_thua, 1, ",", ".")  .'</span></span></td> <!-- thang thua -->
                    <td aria-colindex="11" role="cell" class=""><span></span></td>
                    <td aria-colindex="12" role="cell" class=""></td> <!-- so trung -->
                    <td aria-colindex="13" role="cell" class=""><button type="button"
                            class="btn btn-secondary btn-sm" onclick="ShowDialog(\''. $ds_thong_ke[$i]->ten_tai_khoan .'\',\''. $noi_dung_so .'\');"> Sổ </button></td> <!-- Sổ -->
                </tr><!----><!----> 
            </tbody>';
            $tong_so_tin += $ds_thong_ke[$i]->so_tin;
            $tong_hai_c += $ds_thong_ke[$i]->hai_c;
            $tong_babon_c += $ds_thong_ke[$i]->ba_c + $ds_thong_ke[$i]->bon_c;
            $tong_da_daxien += $ds_thong_ke[$i]->da_daxien;
            $tong_xac += $ds_thong_ke[$i]->xac;
            $tong_thuc_thu += $ds_thong_ke[$i]->thuc_thu;
            $tong_trung +=$ds_thong_ke[$i]->tien_trung;
            $tong_thang_thua += $ds_thong_ke[$i]->thang_thua;
    }
    $result .= '<tfoot role="rowgroup" class="">
                    <tr role="row" class="">
                        <th role="columnheader" scope="col" aria-colindex="1" class="">
                            <span></span>
                        </th>
                        <th role="columnheader" scope="col" tabindex="0" aria-colindex="2"
                            aria-sort="none" class=""><span>Tổng:</span></th>
                        <th role="columnheader" scope="col" tabindex="0" aria-colindex="3"
                            aria-sort="none" class=""><span>'. $tong_so_tin .'</span></th> <!-- so tin -->
                        <th role="columnheader" scope="col" tabindex="0" aria-colindex="4"
                            aria-sort="none" class=""><span>'. number_format($tong_hai_c , 1, ",", ".") .'</span></th><!-- 2d -->
                        <th role="columnheader" scope="col" tabindex="0" aria-colindex="5"
                            aria-sort="none" class=""><span>'. number_format($tong_babon_c , 1, ",", ".") .'</span></th> <!-- 3d4d -->
                        <th role="columnheader" scope="col" tabindex="0" aria-colindex="6"
                            aria-sort="none" class=""><span>'. number_format($tong_da_daxien , 1, ",", ".") .'</span></th> <!-- da dx -->
                        <th role="columnheader" scope="col" tabindex="0" aria-colindex="7"
                            aria-sort="none" class=""><span>'. number_format($tong_xac , 1, ",", ".") .'</span></th> <!-- xac -->
                        <th role="columnheader" scope="col" tabindex="0" aria-colindex="8"
                            aria-sort="none" class=""><span>'. number_format($tong_thuc_thu , 1, ",", ".") .'</span></th> <!-- thucthu -->
                        <th role="columnheader" scope="col" tabindex="0" aria-colindex="9"
                            aria-sort="none" class=""><span>'. number_format($tong_trung , 1, ",", ".") .'</span></th> <!-- trung -->
                        <th role="columnheader" scope="col" tabindex="0" aria-colindex="10"
                            aria-sort="none" class=""><span class="text-danger">'. number_format($tong_thang_thua , 1, ",", ".") .'</span>
                        </th> <!-- thang thua -->
                        <th role="columnheader" scope="col" tabindex="0" aria-colindex="11"
                            aria-sort="none" class=""><span></span></th>
                        <th role="columnheader" scope="col" aria-colindex="12" class="">
                            <span></span>
                        </th>
                        <th role="columnheader" scope="col" tabindex="0" aria-colindex="13"
                            aria-sort="none" class=""><span></span></th>
                    </tr>
                </tfoot>';
    return $result;
}

?>