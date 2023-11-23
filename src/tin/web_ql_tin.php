<?php
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');
include_once(dirname($dir_name) . '/tin/class_tin.php');
include_once(dirname($dir_name) . '/tin/class_noi_dung_tin.php');



date_default_timezone_set('Asia/Ho_Chi_Minh');

$tai_khoan_dang_dang_nhap = $_SESSION["username"];
$loai_tai_khoan = $_SESSION["loai_tai_khoan"];

$tai_khoan_can_tim = $_GET["name"]?? 'all';
$ngay_can_tim = $_GET["date"]?? date("Y-m-d");

$thong_bao = '';

$sql_connector = new sql_connector();

    if(isset($_POST["tai_khoan_can_tim"]))
        $tai_khoan_can_tim = $_POST["tai_khoan_can_tim"];
    if(isset($_POST["ngay_can_tim"])){
        if($_POST["ngay_can_tim"] === 'all')
            $ngay_can_tim = 'all';
        else
            $ngay_can_tim = date("Y-m-d", strtotime($_POST["ngay_can_tim"]));
    }

    if(isset($_POST["id_can_xoa"])){//Nếu là request xoá
        $id_can_xoa = $_POST["id_can_xoa"];
        $sql = "DELETE FROM tin WHERE id = '$id_can_xoa'";
        if($sql_connector->get_query_result($sql)){ //Nếu thực hiện câu lệnh sql thành công
            $thong_bao = "Xoá thành công";
            exit();
        }
        else
        {
            $thong_bao = "Không xoá thành công";;
        }
    }


//Cập nhật kết quả các tin trước khi đọc
//tin::CapNhatKetQuaCacTin($tai_khoan_dang_dang_nhap, $loai_tai_khoan);
//Tạo lệnh truy vấn cho tin.
//Mặc định

if ($tai_khoan_can_tim === 'all' && $ngay_can_tim === 'all') {
    if ($loai_tai_khoan === 'god')
        $sql = "SELECT * FROM tin";
    else
        $sql = "SELECT * FROM tin WHERE tai_khoan_danh = '$tai_khoan_dang_dang_nhap' OR 
                tai_khoan_danh IN (SELECT ten_tai_khoan FROM tai_khoan WHERE tai_khoan_quan_ly = '$tai_khoan_dang_dang_nhap')";
}

if ($tai_khoan_can_tim === 'all' && $ngay_can_tim != 'all') {
    if ($loai_tai_khoan === 'god')
        $sql = "SELECT * FROM tin WHERE thoi_gian_danh = '$ngay_can_tim'";
    else
        $sql = "SELECT * FROM tin WHERE (tai_khoan_danh = '$tai_khoan_dang_dang_nhap' OR 
                tai_khoan_danh IN (SELECT ten_tai_khoan FROM tai_khoan WHERE tai_khoan_quan_ly = '$tai_khoan_dang_dang_nhap')) 
                    AND thoi_gian_danh = '$ngay_can_tim'";
}

if ($tai_khoan_can_tim != 'all' && $ngay_can_tim === 'all') {
    $sql = "SELECT * FROM tin WHERE tai_khoan_danh = '$tai_khoan_can_tim'";
}

if ($tai_khoan_can_tim != 'all' && $ngay_can_tim != 'all') {
    $sql = "SELECT * FROM tin WHERE tai_khoan_danh = '$tai_khoan_can_tim' AND thoi_gian_danh = '$ngay_can_tim'";
    ;
}

if (!$sql_connector->conn) { //Nếu có lỗi kết nối csdl
    echo 'SQL connector error: ' . $sql_connector->get_connect_error();
    exit;
}
$ds_tin = tin::doc_tin_tu_db($sql, $sql_connector);
if (($sql_error = $sql_connector->get_connect_error())) {
    echo 'SQL connector error: ' . $sql_connector->get_connect_error();
    exit;
}

function xuat_html_ds_tin(array $ds_tin): string
{
    $result = '';
    for ($i = 0; $i < count($ds_tin); $i++) {
        $noi_dung_rut_gon = substr($ds_tin[$i]->noi_dung,0, 30) . '...';
        $result .= '
            <div class="list-group-item px-3 d-flex d-flex align-items-center_ bet-item primary">
            <div><button type="button"
                    class="btn b-avatar mr-2 mt-2 btn-primary rounded-circle">
                        <span class="b-avatar-text"><span>' . ($i + 1) . '</span></span><!-- Số tt -->
                        </button> 
                        <form action="ql_tin.php" method="POST" id = "'. $ds_tin[$i]->id .'">
                        <input type="hidden" name="id_can_xoa" value="'. $ds_tin[$i]->id .'">
                         <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="trash" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        class="bi-trash delete-icon b-icon bi text-secondary" onclick="xoa('. $ds_tin[$i]->id .')">
                        <g>
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z">
                            </path>
                            <path fill-rule="evenodd"
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z">
                            </path>
                        </g>
                    </svg> 
                        
                    </form>
                    </div>
                    <a href="tao_tin.php?smsid='. $ds_tin[$i]->id .'" class="d-flex link" target="_self">
                        <div class="mr-auto info pr-3">
                            <div class="player-name"><span>' . $ds_tin[$i]->tai_khoan_danh . '</span> </div> <!-- Tên tk danh-->
                            <small class="sms">' . $noi_dung_rut_gon . '</small> <!-- Nội dung -->
                            <small class="date">' . $ds_tin[$i]->thoi_gian_tao . '</small> <!-- Thời gian tạo -->
                        </div>
                        <div class="card-profile-stats d-flex"> 
                        <div class="text-left"> <!-- So trung --> 
                            <span class="description">2c: '.$ds_tin[$i]->hai_c.'</span>
                            <span class="description">3c: '.$ds_tin[$i]->ba_c.'</span>
                            <span class="description">4c: '.$ds_tin[$i]->bon_c.'</span>
                            <span class="description">dadx: '.$ds_tin[$i]->da_daxien.'</span></div>
                        </div>
                    </a>
        </div>';
    }
    $result .= '
        <script>
            function xoa(id) {
                let result = confirm("Bạn có muốn  xoá tin");
                if (result) {
                let form = document.getElementById(id);
                form.submit();
                } else {
                // làm gì đó nếu người dùng nhấn Cancel
                }
            }  
        </script>
    ';
    return $result;
}
?>