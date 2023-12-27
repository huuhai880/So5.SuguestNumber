<?php
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
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

//-------------------------Nếu là lấy cấu hình ---------------------------------
if ($_POST["action"] === "doc") {

    $response['log'] .= "action=doc;";
    if (!isset($_POST["ten_tai_khoan"]) ) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không biết ai xin đọc";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $ten_tai_khoan = $_POST['ten_tai_khoan'];
    
    $cau_hinh = cau_hinh::LayCauHinh($ten_tai_khoan);

    //Xuất ra
    $response['cau_hinh'] = json_encode($cau_hinh);
    $response['ds_chi_tiet_cau_hinh'] = json_encode($cau_hinh->getDsChiTietCauHinh());
    $response['ds_thu_tu_dai'] = json_encode($cau_hinh->getDsThuTuDai());
    $response['success'] = 1;
}

//-------------------------Nếu là ghi  ---------------------------------
if ($_POST["action"] === "ghi") {
    $response['log'] .= "action=ghi;";
  
}


//-------------------------Nếu là xoa  ---------------------------------
if ($_POST["action"] === "xoa") {
    $response['log'] .= "action=xoa;";
  
}
//-------------------------Nếu là Cập Nhật chi tiết kiểu đánh  ---------------------------------
if ($_POST["action"] === "cap_nhat_chi_tiet") {
    $response['log'] .= "action = cap nhat chi tiet;";

    if (!isset($_POST["config_price"])) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không rõ chi tiết gửi xuống";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $config_price = $_POST['config_price'];
    $ten_tai_khoan = $_POST['ten_tai_khoan'];

    $cau_hinh = cau_hinh::LayCauHinh($ten_tai_khoan);

    $id_cau_hinh = $cau_hinh->id;

    if (isset($id_cau_hinh)){

        $jsonString = str_replace("'", '"', $config_price);
        $array_price = json_decode($jsonString, true);
        
        if ($array_price === null && json_last_error() !== JSON_ERROR_NONE) {
            
            $response['log'] .= "không rõ chi tiết gửi xuống";
            $response['success'] = 0;
            echo json_encode($response);

        } else {

            if(isset($array_price)){

                foreach ($array_price as $price) {
        
                    $chi_tiet_cau_hinh = new chi_tiet_cau_hinh();
                    $chi_tiet_cau_hinh->id_cau_hinh = $id_cau_hinh; 
                    $chi_tiet_cau_hinh->co = $price['co']; 
                    $chi_tiet_cau_hinh->trung = $price['trung'];
                    $chi_tiet_cau_hinh->vung_mien = $price['vung_mien']; 
                    
                    $chi_tiet_cau_hinh->cap_nhat_xuong_db();
        
                }
            }
            
            $response['success'] = 1;

            $response['chi_tiet_cau_hinh'] = json_encode($response);
        }
    }
    
}

//-------------------------Nếu là Cập Nhật chi tiết Thứ tự đài  ---------------------------------
if ($_POST["action"] === "cap_nhat_thu_tu_dai") {
    $response['log'] .= "action = cap nhat chi tiet;";
    if (!isset($_POST["id"]) || !isset($_POST["ds_ten_cac_dai"])) {
        //Nếu chưa có thông tin thì thoát
        $response['log'] .= "không rõ chi tiết gửi xuống";
        $response['success'] = 0;
        echo json_encode($response);
        exit();
    }

    $id = $_POST['id'];
    $ds_ten_cac_dai = $_POST["ds_ten_cac_dai"];

    $thu_tu_dai = new thu_tu_dai();
    $thu_tu_dai->id = $id;
    $thu_tu_dai->ten_dai_theo_thu_tu = $ds_ten_cac_dai;

    if($thu_tu_dai->cap_nhat_xuong_db())
        $response['success'] = 1;
    else
        $response['success'] = 0;
    //Xuất ra
    $response['thu_tu_dai'] = json_encode($thu_tu_dai);

}
echo json_encode($response);
?>