<?php
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
include_once(dirname($dir_name) . '/tin/class_tin.php');


$vi_tri_bat_dau = 0; //Các chi tiết cấu hình khi gửi về server sẽ đc chuyển thành mảng, biến này dùng để tạo giá trị liên tục của indexx

$ds_chi_tiet_cau_hinh = []; // khởi tạo mảng các đối tượng
$ds_thu_tu_dai = [];
//Nếu là POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $chi_tiet_s = $_POST['chi_tiet']; // lấy dữ liệu từ $_POST, chi_tiet ở dạng mảng
    $thu_dai_s = $_POST['thu_dai']; // lấy dữ liệu từ $_POST, thu_dai ở dạng mảng
    $tai_khoan_moi = $_POST['tk_can_tao'];

    foreach ($chi_tiet_s as $item) {
        $chi_tiet_cau_hinh = new chi_tiet_cau_hinh(); // tạo một đối tượng mới
        $chi_tiet_cau_hinh->id = $item['id'];
        $chi_tiet_cau_hinh->kieu_danh = $item['kieu_danh'];
        $chi_tiet_cau_hinh->co = $item['co'];
        $chi_tiet_cau_hinh->trung = $item['trung'];
        $chi_tiet_cau_hinh->vung_mien = $item['vung_mien'];
        $ds_chi_tiet_cau_hinh[] = $chi_tiet_cau_hinh; // thêm đối tượng vào mảng
    }


    foreach ($thu_dai_s as $item) {
        $thu_dai = new thu_tu_dai(); // tạo một đối tượng mới
        $thu_dai->id = $item['id'];
        $thu_dai->ngay_trong_tuan = $item['ngay_trong_tuan'];
        $thu_dai->ten_dai_theo_thu_tu = $item['ten_dai_theo_thu_tu'];

        $ds_thu_tu_dai[] = $thu_dai; // thêm đối tượng vào mảng
    }
    //print_r($ds_chi_tiet_cau_hinh); // hiển thị mảng các đối tượng
    //print_r($ds_thu_tu_dai); // hiển thị mảng các đối tượng


    if (isset($_POST["cap_nhat"])) {
        //Cập nhật
        $connector = new sql_connector();
        foreach ($ds_chi_tiet_cau_hinh as $item) {
            $item->cap_nhat_xuong_db($connector);
        }
        foreach ($ds_thu_tu_dai as $item) {
            $item->cap_nhat_xuong_db($connector);
        }
        echo "<script>";
        echo "var result = confirm('Cập nhật tài khoản thành công. Bấm OK để chuyển đến trang quản lý tài khoản.');";
        echo "if (result == true) {";
        echo "window.location.href='ql_tai_khoan.php';";
        echo "} else {";
        echo "window.location.href='trang_chu.php';";
        echo "}";
        echo "</script>";

    } else {
        //Tạo mới
        //Kiểm tra tài khoản đã tồn tại 
        $sql = "SELECT ten_tai_khoan FROM tai_khoan 
                WHERE ten_tai_khoan = '$tai_khoan_moi'";
        $sql_connector = new sql_connector();
        $result = $sql_connector->get_query_result($sql);
        if ($result->num_rows > 0) { //Tài khoản đã tồn tại
            echo "tai khoan da ton tai";
        } else {
            $tai_khoan_quan_ly = $_SESSION["username"];
            $loai_tai_khoan = ($_SESSION["loai_tai_khoan"] === 'god') ? 'admin' : 'std';
            // thêm tk mới vào
            $sql = "INSERT INTO tai_khoan (ten_tai_khoan, mat_khau, loai_tai_khoan, tai_khoan_quan_ly, trang_thai, ten_hien_thi)
                        VALUES ('$tai_khoan_moi', '123', '$loai_tai_khoan', '$tai_khoan_quan_ly', '0', ' ')";
            if ($result = $sql_connector->get_query_result($sql)) {
                //Nếu thêm tài khoản thành công thì ghi cấu hình.
                $cau_hinh = new cau_hinh();
                $cau_hinh->tai_khoan = $tai_khoan_moi;
                $cau_hinh->setDsChiTietCauHinh($ds_chi_tiet_cau_hinh);
                $cau_hinh->setDsThuTuDai($ds_thu_tu_dai);
                $cau_hinh->ghi_xuong_db(); //Ghi lại xuống csdl
                echo "<script>";
                echo "var result = confirm('Tạo tài khoản thành công. Bấm OK để chuyển đến trang quản lý tài khoản.');";
                echo "if (result == true) {";
                echo "window.location.href='ql_tai_khoan.php';";
                echo "} else {";
                echo "window.location.href='trang_chu.php';";
                echo "}";
                echo "</script>";

            } else
                echo "Them tk khong thanh cong";
        }
    }

}

$ten_tai_khoan = 'admin';

$cau_hinh = cau_hinh::LayCauHinh($ten_tai_khoan);

//Xuất ra

$ds_chitiet_cau_hinh_mien_bac = $cau_hinh->lay_ds_chitiet_theo_vungmien('Miền Bắc');
$ds_chitiet_cau_hinh_mien_nam = $cau_hinh->lay_ds_chitiet_theo_vungmien('Miền Nam');
$ds_chitiet_cau_hinh_mien_trung = $cau_hinh->lay_ds_chitiet_theo_vungmien('Miền Trung');
$ds_thu_tu_dai = $cau_hinh->getDsThuTuDai();

function xuat_html_chitiet(array $ds_chi_tiet, int &$vi_tri_bat_dau): string
{
    $result = '<div class="row mb-config">';

    usort($ds_chi_tiet, function ($a, $b) {
        return strcmp($a->kieu_danh, $b->kieu_danh);
    });
    $i = 0;
    for ($i = 0; $i < count($ds_chi_tiet); $i++) {
        $result .= ' <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 col-12">
            <div role="group" class="input-group mb-2 config-com-rate input-group-sm"><!---->
                <div class="input-group-prepend"><span
                        class="input-group-text text-sub">' . $ds_chi_tiet[$i]->kieu_danh . '</span>
                        <input type="hidden" name="chi_tiet[' . ($i + $vi_tri_bat_dau) . '][kieu_danh]" value="' . $ds_chi_tiet[$i]->kieu_danh . '" >
                        <input type="hidden" name="chi_tiet[' . ($i + $vi_tri_bat_dau) . '][vung_mien]" value="' . $ds_chi_tiet[$i]->vung_mien . '" >
                        <input type="hidden" name="chi_tiet[' . ($i + $vi_tri_bat_dau) . '][id]" value="' . $ds_chi_tiet[$i]->id . '" >
                        </div>
                <div class="comm-label input-group-prepend">
                    <div class="input-group-text"><b>Cò:</b></div>
                </div>
                <input type="text" class="form-control commission text-right" value="' . $ds_chi_tiet[$i]->co . '" name="chi_tiet[' . ($i + $vi_tri_bat_dau) . '][co]">
                <div class="rate-label input-group-prepend">
                    <div class="input-group-text"><b>Trúng:</b></div>
                </div><input type="text" class="rate form-contro text-right" value="' . $ds_chi_tiet[$i]->trung . '" name="chi_tiet[' . ($i + $vi_tri_bat_dau) . '][trung]">
                
            </div>
        </div>';
    }
    $result .= '</div>';
    $vi_tri_bat_dau = $i;
    return $result;
}
function xuat_html_thudai(array $ds_thu_tu_dai): string
{
    $result = '<div class="row priority-channel">';
    for ($i = 0; $i < count($ds_thu_tu_dai); $i++) {
        $thu = ($ds_thu_tu_dai[$i]->ngay_trong_tuan == 0) ? 'C.Nhật' : 'Thứ ' . ($ds_thu_tu_dai[$i]->ngay_trong_tuan + 1);
        $result .= '<div class="priority-channel col-sm-12 col-md-6 col-lg-6 col-xl-6 col-12">
            <div id="tags-component-select" role="group"
                aria-describedby="tags-component-select___selected_tags__"
                class="b-form-tags form-control h-auto mb-2 form-control-lg">
                <div role="group" class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <div class="input-group-text">' . $thu . '</div>
                        <input type="hidden" name="thu_dai[' . $i . '][id]" value = "' . $ds_thu_tu_dai[$i]->id . '">
                        <input type="hidden" name="thu_dai[' . $i . '][ngay_trong_tuan]" value = "' . $ds_thu_tu_dai[$i]->ngay_trong_tuan . '">
                        <input type="hidden" name="thu_dai[' . $i . '][ten_dai_theo_thu_tu]" value = "' . $ds_thu_tu_dai[$i]->ten_dai_theo_thu_tu . '">
                    </div>';
        $ds_dai = explode(';', $ds_thu_tu_dai[$i]->ten_dai_theo_thu_tu);
        foreach ($ds_dai as $ten_dai) {
            $ten_arr = explode(' ', $ten_dai);
            $ten = mb_substr($ten_arr[0], 0, 1) . '.' . $ten_arr[1];
            $result .= '<span title="' . $ten . '"
                class="badge b-form-tag d-inline-flex align-items-baseline mw-100 badge-info"
                id="__BVID__626" aria-labelledby="__BVID__626__taglabel_"><span
                    class="b-form-tag-content flex-grow-1 text-truncate"
                    id="__BVID__626__taglabel_">' . $ten . '</span><button
                    aria-keyshortcuts="Delete" type="button" aria-label="Remove tag"
                    class="close b-form-tag-remove" aria-controls="__BVID__626"
                    aria-describedby="__BVID__626__taglabel_">×</button></span>';
        }
        $result .= '<select
                        id="tags-component-select___input__" disabled="disabled" class="custom-select">
                        <option disabled="disabled" value="">...</option>
                    </select><!---->
                </div><!---->
            </div>
        </div>';
    }

    $result .= '</div>';
    return $result;
}


?>