<?php
 $dir_name = dirname(__FILE__);
 require_once(dirname($dir_name) . '/app/class_sql_connector.php');
 require_once(dirname($dir_name) . '/app/config.php');

$ten_tai_khoan = $_SESSION["username"];
$danh_sach_tai_khoan = [];

$thong_bao = '';
//Nếu là POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ten_tk_can_xoa = $_POST["ten_tk_can_xoa"];
    if($ten_tk_can_xoa){
        $sql = "DELETE FROM tai_khoan WHERE ten_tai_khoan = '$ten_tk_can_xoa'";
        $sql_connector = new sql_connector();
        if ($result = $sql_connector->get_query_result($sql)) {
            $thong_bao = "Xoá tài khoản \" $ten_tk_can_xoa \" thành công!";
        }
        else
            $thong_bao = "Không xoá tài khoản \" $ten_tk_can_xoa \" thành công!";;
    }
}
    //Đọc các tài khoản và xuất lên cơ sở dữ liệu
    if ($ten_tai_khoan === "god")
        $sql = "SELECT ten_tai_khoan, loai_tai_khoan, ten_hien_thi 
                FROM tai_khoan WHERE ten_tai_khoan != '$ten_tai_khoan'";
    else
        $sql = "SELECT ten_tai_khoan
                FROM tai_khoan WHERE tai_khoan_quan_ly = '$ten_tai_khoan'";
   
    $sql_connector = new sql_connector();

    if ($result = $sql_connector->get_query_result($sql)) {
        while ($row = $result->fetch_assoc()) {
            $danh_sach_tai_khoan[] = $row;
        }
    } 

   


function xuat_html_ds_tk(array $ds_tk): string
{
    $result = '';
    foreach ($ds_tk as $item) {
        $result .= 
        '<tr role="row" class="">
        <form action = "ql_tai_khoan.php" method = "post" id = "'.$item["ten_tai_khoan"].'">
        <td aria-colindex="1" role="cell" class=""> 1 </td>
        <td aria-colindex="2" role="cell" class="text-left"><a
                href="ql_tin.php?name='. $item["ten_tai_khoan"] .'&date=all" class="" target="_self">'. $item["ten_tai_khoan"] .'</a>
                <input type="hidden" name="ten_tk_can_xoa" value="' . $item["ten_tai_khoan"] . '" >
        </td>
        <td aria-colindex="3" role="cell" class="text-left">Không</td>
        <td aria-colindex="4" role="cell" class="text-right">
            <div role="group" class="btn-group">
                <a href="tao_tai_khoan.php?user='.$item["ten_tai_khoan"].'"vclass="btn btn-outline-primary btn-sm" target="_self">Cấuhình
                </a>
                <button type="button" class="btn btn-danger btn-sm" onclick="CallSubmit(\''.$item["ten_tai_khoan"].'\')">
                    <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="trash" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" class="bi-trash b-icon bi">
                        <g>
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z">
                            </path>
                            <path fill-rule="evenodd"
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z">
                            </path>
                        </g>
                    </svg>
                </button>
            </div>
        </td>
        </form>
    </tr>'; 
    }
    return $result;
}



?>