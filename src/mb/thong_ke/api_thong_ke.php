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
    if (($_POST["ngay"]) === "Tất cả")
        $ngay = "Tất cả";
    else
        $ngay = date('Y-m-d', strtotime(str_replace(' ', '', $_POST["ngay"])));
    
    
    //$ten_tai_khoan = "admin1";
    //$loai_tai_khoan = "admin";

    if ($loai_tai_khoan === 'god') {
        //Nếu god thì thoát, tạm thời chưa làm với god
        $response['log'] .= " chưa hoạt động với god";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    //Cập nhật kết quả các tin trước khi đọc
    tin::CapNhatKetQuaCacTin($ten_tai_khoan, $loai_tai_khoan);

    //Chuẩn bị danh sách các thống kê
    $thong_ke_list = array();

    //Bắt đầu đọc tài khoản cấp dưới nếu có
    $sql_connector = new sql_connector();
    $sql_lay_tai_khoan = "SELECT ten_tai_khoan,ten_hien_thi FROM tai_khoan 
                                        WHERE (tai_khoan_quan_ly = '$ten_tai_khoan') OR (ten_tai_khoan = '$ten_tai_khoan')";
    
    if ($result_tai_khoan = $sql_connector->get_query_result($sql_lay_tai_khoan)) {
    
        //Với mỗi tài khoản cấp dưới, tạo thống kê tương ứng
        while ($row = $result_tai_khoan -> fetch_assoc()) {

            $ten_tk = $row['ten_tai_khoan']; //Lấy được tên tài khoản 

            $thong_ke = new thong_ke(); //Tạo thống kê với mỗi tài khoản

            $thong_ke->ten_tai_khoan = $row['ten_tai_khoan']; //Cập nhật
            $thong_ke->ten_hien_thi = $row['ten_hien_thi']; //Cập nhật

            //Tạo câu sql truy vấn danh sách tin theo iểu truy vấn tương ứng.
            if($ngay === "Tất cả"){
                $sql_lay_tin = "SELECT * FROM tin WHERE tai_khoan_danh = '$ten_tk'";
            }
            else{
                $sql_lay_tin = "SELECT * FROM tin WHERE tai_khoan_danh = '$ten_tk'
                                AND thoi_gian_danh = '$ngay'";
            }            
            $tin_list = tin::doc_tin_tu_db($sql_lay_tin);
            $thong_ke = CapNhatThongKeTheoDanhSachTin($tin_list, $thong_ke); //Hàm cập nhật thống kê theo danh sách tin
            $thong_ke->TaoNoiDungSo($ngay);
            $thong_ke_list[] = $thong_ke;
        }   
        
    }

    $response ["thong_ke_list"] = json_encode($thong_ke_list);
    echo json_encode($response);

     
}

function CapNhatThongKeTheoDanhSachTin(array $tin_list, thong_ke $thong_ke):thong_ke
{
    foreach ($tin_list as $tin) { //Mới mỗi tin
        $thong_ke->so_tin ++; //Tăng biến đếm số tin
        $thong_ke->hai_c         += $tin->hai_c;
        $thong_ke->ba_c     += $tin->ba_c;
        $thong_ke->bon_c     += $tin->bon_c;
        $thong_ke->da_daxien    += $tin->da_daxien;
        $thong_ke->xac          += $tin->xac;
        $thong_ke->thuc_thu     += $tin->thuc_thu;
        $thong_ke->tien_trung   += ($tin->tien_trung != -1)? $tin->tien_trung : 0 ; 
    }
    $thong_ke->thang_thua = $thong_ke->tien_trung - $thong_ke->thuc_thu;
    return $thong_ke;
}

?>