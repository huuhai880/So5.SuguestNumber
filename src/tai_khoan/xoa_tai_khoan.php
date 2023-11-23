
<?php
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
include_once(dirname($dir_name) . '/tin/class_tin.php');
include_once(dirname($dir_name) . '/cau_hinh/class_cau_hinh.php');


/** Array for JSON response*/
$response = array();
/**
 * Trang Xoá tài khoản, khi một tài khoản bị xoá thì tất cả những gì liên quan đều bị xoá theo  
 * */
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    //Nếu không phải POST thì thoát
    $response['log'] = "không phải post;";
    $response['success'] = 0;
    echo json_encode($response);
    exit();
}
//Lấy các giá trị từ post
$ten_tai_khoan = $_POST['ten_tai_khoan'];
$loai_tai_khoan = $_POST["loai_tai_khoan"];
//Tạo câu lệnh truy vấn
$sql = "DELETE FROM tai_khoan WHERE ten_tai_khoan = '$ten_tai_khoan'";
$sql_connector = new sql_connector();
if ($result = $sql_connector->get_query_result($sql)) 
{ //Xoá tài khoản
    if($loai_tai_khoan === "admin")
    {  
        // //Nếu tài khoản là admin thì xoá tất cả tài khoản nó đang quản lý
        // $sql_lay_tai_khoan_cap_duoi =  "SELECT id, ten_tai_khoan FROM tai_khoan WHERE tai_khoan_quan_ly = '$ten_tai_khoan'";
        // if ($result_tai_khoan_cap_duoi = $sql_connector->get_query_result($sql_lay_tai_khoan_cap_duoi)) {
        //     //Với mỗi tài khoản, trước khi xoá thì cần xoá tất cả tin mà nó tạo ra
        //     while ($row = $result_tai_khoan_cap_duoi -> fetch_assoc()) {
        //         $ten_tai_khoan_cap_duoi = $row['ten_tai_khoan']; //Lấy được tên tài khoản cần xoá
        //         //tin::xoa_tat_ca_tin_theo_tai_khoan($ten_tai_khoan_cap_duoi);
        //         //cau_hinh::xoa_cau_hinh_theo_ten_tai_khoan($ten_tai_khoan_cap_duoi);
        //     }
        // }
        $sql_xoa_tai_khoan_cap_duoi = "DELETE FROM tai_khoan WHERE tai_khoan_quan_ly = '$ten_tai_khoan'";
        $sql_connector->get_query_result($sql_xoa_tai_khoan_cap_duoi);      
    }

    //tin::xoa_tat_ca_tin_theo_tai_khoan($ten_tai_khoan);
    //cau_hinh::xoa_cau_hinh_theo_ten_tai_khoan($ten_tai_khoan);
    $response["success"] = 1; //Thành công
}
else
    $response["success"] = 0;
/**Return json*/
//echo timetos;
$response['sql'] = $sql;
echo json_encode($response);
?>