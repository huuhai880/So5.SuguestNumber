<?php 
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
include_once(dirname($dir_name) . '/thong_ke/class_thong_ke.php');
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

//-------------------------Nếu là đọc thống kê ---------------------------------
if ($_POST["action"] === "doc") { 
    $response['log'] .= "action=doc;";
    if (!isset($_POST["ten_tai_khoan"]) || !isset($_POST["loai_tai_khoan"]) ) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không biết ai xin đọc; chức vụ?";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $ten_tai_khoan = $_POST['ten_tai_khoan'];
    $loai_tai_khoan = $_POST['loai_tai_khoan'];
    $ngay = date('Y-m-d', strtotime(str_replace(' ', '', $_POST["ngay"])));
        
    
    if ($loai_tai_khoan === 'god') {
        //Nếu god thì thoát, tạm thời chưa làm với god
        $response['log'] .= " chưa hoạt động với god";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    //Cập nhật kết quả các tin trước khi đọc
    tin::CapNhatKetQuaCacTin($ten_tai_khoan, $loai_tai_khoan, $ngay);

    //Lấy danh sách thống kế

    $result_thong_ke = tin::LayChiTietThongKeTin($ten_tai_khoan, $ngay);

    //Chuẩn bị danh sách các thống kê
    $thong_ke_list = array();

    $thong_ke = new thong_ke(); //Tạo thống kê với mỗi tài khoản

    $thong_ke->ten_tai_khoan = $ten_tai_khoan; //Cập nhật
    $thong_ke->ten_hien_thi = $ten_tai_khoan; //Cập nhật


    //Tạo câu sql truy vấn danh sách tin theo iểu truy vấn tương ứng.
    $sql_lay_tin = "SELECT * FROM tin WHERE tai_khoan_danh = '$ten_tai_khoan'
                        AND vung_mien='mn' AND thoi_gian_danh = '$ngay' AND trang_thai != -1 order by thoi_gian_danh ASC ";      

    $tin_list = tin::doc_tin_tu_db($sql_lay_tin);

    $thong_ke = CapNhatThongKeTheoDanhSachTin($tin_list, $thong_ke); //Hàm cập nhật thống kê theo danh sách tin

    # tạo câu truy vấn lấy chi tiết tin

    $ds_chi_tiet = [];

    foreach ($tin_list as $index_tin => $tin) {
        // Call the 'lay_chi_tiet_cua_tin' method with the 'id' of the current '$tin' element
        $chi_tiet_tin = chi_tiet_tin::lay_chi_tiet_cua_tin_trung($tin->id);

        if(count($chi_tiet_tin) > 0){
            // Use the index_tin as the key in $ds_chi_tiet
            $ds_chi_tiet[$index_tin+1] = $chi_tiet_tin;
        }
        
    }

    $response ["thong_ke"] = json_encode($thong_ke);

    $response ["ds_chi_tiet"] = json_encode($ds_chi_tiet);

    $response ["result_thong_ke"] = json_encode($result_thong_ke);


    echo json_encode($response);

}

function CapNhatThongKeTheoDanhSachTin(array $tin_list, thong_ke $thong_ke): array
{
    // Initialize an associative array to store grouped elements
    $grouped_tin_list = array();

    foreach ($tin_list as $tin) {
        if($tin->vung_mien =='mn'){
            $thong_ke->so_tin++;
            $thong_ke->hai_c += $tin->hai_c;
            $thong_ke->ba_c += $tin->ba_c;
            $thong_ke->bon_c += $tin->bon_c;
            $thong_ke->da_daxien += $tin->da_daxien;
            $thong_ke->xac += $tin->xac;
            $thong_ke->thuc_thu += $tin->thuc_thu;
            $thong_ke->tien_trung += ($tin->tien_trung != -1) ? $tin->tien_trung : 0;

            // Group by 'vung_mien'
            $vung_mien = $tin->vung_mien;
            if (!isset($grouped_tin_list[$vung_mien])) {
                $grouped_tin_list[$vung_mien] = new thong_ke(); // Initialize a new thong_ke object for each group
            }

            // Update statistics for each group
            $grouped_tin_list[$vung_mien]->so_tin++;
            $grouped_tin_list[$vung_mien]->hai_c += $tin->hai_c;
            $grouped_tin_list[$vung_mien]->ba_c += $tin->ba_c;
            $grouped_tin_list[$vung_mien]->bon_c += $tin->bon_c;
            $grouped_tin_list[$vung_mien]->da_daxien += $tin->da_daxien;
            $grouped_tin_list[$vung_mien]->xac += $tin->xac;
            $grouped_tin_list[$vung_mien]->thuc_thu += $tin->thuc_thu;
            $grouped_tin_list[$vung_mien]->tien_trung += ($tin->tien_trung != -1) ? $tin->tien_trung : 0;
        }

    }

    // Calculate 'thang_thua' for each group
    foreach ($grouped_tin_list as $vung_mien => $grouped_thong_ke) {
        $grouped_tin_list[$vung_mien]->thang_thua = $grouped_thong_ke->tien_trung - $grouped_thong_ke->thuc_thu;
    }

    // Now, $grouped_tin_list is an associative array where keys are 'vung_mien' values
    // and values are thong_ke objects containing statistics for each group.
    return $grouped_tin_list;
}

?>