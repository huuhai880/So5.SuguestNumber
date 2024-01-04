<?php
$dir_name = dirname(__FILE__);
require_once(dirname($dir_name) . '/app/class_sql_connector.php');

//=============================== Lớp Cấu Hình =====================================
class cau_hinh
{
    public $id, $tai_khoan;
    private $chi_tiet_cau_hinh_list = array(), $ds_thu_tu_dai = array();

    public function getDsChiTietCauHinh()
    {
        return $this->chi_tiet_cau_hinh_list;
    }
    public function getDsThuTuDai()
    {
        return $this->ds_thu_tu_dai;
    }
    public function getTenDaiTheoNgay($ngay_trong_tuan)
    {
        foreach ($this->ds_thu_tu_dai as $thu_tu_dai) {
            if ($thu_tu_dai->ngay_trong_tuan == $ngay_trong_tuan)
                return $thu_tu_dai->ten_dai_theo_thu_tu;
        }
        return null;
    }
    public function setDsChiTietCauHinh(array $ds)
    {
        $this->chi_tiet_cau_hinh_list = $ds;
    }
    public function setDsThuTuDai(array $ds)
    {
        $this->ds_thu_tu_dai = $ds;
    }
    public function themChiTietCauHinh(chi_tiet_cau_hinh $chi_tiet)
    {
        $this->chi_tiet_cau_hinh_list[] = $chi_tiet;
    }


    //Lấy cấu hình tương ứng với $tai_khoan
    public static function LayCauHinh(string $tai_khoan): cau_hinh
    {
        $cau_hinh = new cau_hinh();
        $ds_chi_tiet = array();
        $ds_thu_tu_dai = array();
        $sql_connector = new sql_connector();
        $sql = "SELECT * FROM cau_hinh WHERE tai_khoan = '$tai_khoan'";
        if ($result = $sql_connector->get_query_result($sql)) {
            if ($result->num_rows > 0) {

                $row = $result->fetch_assoc();
                $cau_hinh->id = $row["id"];
                $cau_hinh->tai_khoan = $row["tai_khoan"];

                $sql_chi_tiet = "SELECT * FROM chi_tiet_cau_hinh WHERE id_cau_hinh = '$cau_hinh->id'";

                if ($result_chi_tiet = $sql_connector->get_query_result($sql_chi_tiet)) {
                    while ($row = $result_chi_tiet->fetch_assoc()) {
                        $chi_tiet_cau_hinh = new chi_tiet_cau_hinh();
                        $chi_tiet_cau_hinh->id = $row['id'];
                        $chi_tiet_cau_hinh->id_cau_hinh = $row['id_cau_hinh'];
                        $chi_tiet_cau_hinh->kieu_danh = $row['kieu_danh'];
                        $chi_tiet_cau_hinh->co = $row['co'];
                        $chi_tiet_cau_hinh->trung = $row['trung'];
                        $chi_tiet_cau_hinh->vung_mien = $row['vung_mien'];
                        $cau_hinh->chi_tiet_cau_hinh_list[] = $chi_tiet_cau_hinh;
                    }
                }
                $sql_thu_tu_dai = "SELECT * FROM thu_tu_dai WHERE id_cau_hinh = '$cau_hinh->id'";
                if ($result_chi_tiet = $sql_connector->get_query_result($sql_thu_tu_dai)) {
                    while ($row = $result_chi_tiet->fetch_assoc()) {
                        $thu_tu_dai = new thu_tu_dai();
                        $thu_tu_dai->id = $row["id"];
                        $thu_tu_dai->id_cau_hinh = $row['id_cau_hinh'];
                        $thu_tu_dai->ngay_trong_tuan = $row['ngay_trong_tuan'];
                        $thu_tu_dai->ten_dai_theo_thu_tu = $row['ten_dai_theo_thu_tu'];
                        $cau_hinh->ds_thu_tu_dai[] = $thu_tu_dai;
                    }
                }
            } else {
                echo 'Lay cau hinh: khong co du lieu';
            }
        } else {
            echo 'Lay cau hinh: khong ket noi duoc cs du lieu';
        }
        return $cau_hinh;
    }

    public function lay_chi_tiet_cau_hinh(string $kieu_danh, string $vung_mien) : chi_tiet_cau_hinh
    {
        foreach ($this->chi_tiet_cau_hinh_list as $chi_tiet_cau_hinh) {
            if ($chi_tiet_cau_hinh->kieu_danh === $kieu_danh && $chi_tiet_cau_hinh->vung_mien === $vung_mien)
                return $chi_tiet_cau_hinh;
        }
        return new chi_tiet_cau_hinh();
    }
    public function lay_ds_chitiet_theo_vungmien(string $vung_mien):array{
        $result = array();
        foreach ($this->chi_tiet_cau_hinh_list as $chi_tiet_cau_hinh) {
            if ($chi_tiet_cau_hinh->vung_mien === $vung_mien)
                $result[] = $chi_tiet_cau_hinh;
        }
        return $result;
    }
    public function lay_chi_tiet_2d_dau(string $vung_mien):chi_tiet_cau_hinh
    {
        if ($vung_mien === 'mb')
            return $this->lay_chi_tiet_cau_hinh("2D-Đầu", "Miền Bắc");
        return $this->lay_chi_tiet_cau_hinh("2D-Đầu", $vung_mien);
    }
    public function lay_chi_tiet_2d_duoi(string $vung_mien):chi_tiet_cau_hinh
    {
        if ($vung_mien === 'mb')
            return $this->lay_chi_tiet_cau_hinh("2D-Đuôi", "Miền Bắc");
        return $this->lay_chi_tiet_cau_hinh("2D-Đuôi", $vung_mien);
    }
    public function lay_chi_tiet_xiu_dau(string $vung_mien):chi_tiet_cau_hinh
    {
        if ($vung_mien === 'mb')
            return $this->lay_chi_tiet_cau_hinh("3D-Đầu", "Miền Bắc");
        return $this->lay_chi_tiet_cau_hinh("3D-Đầu", $vung_mien);
    }
    public function lay_chi_tiet_xiu_duoi(string $vung_mien):chi_tiet_cau_hinh
    {
        if ($vung_mien === 'mb')
            return $this->lay_chi_tiet_cau_hinh("3D-Đuôi", "Miền Bắc");
        return $this->lay_chi_tiet_cau_hinh("3D-Đuôi", $vung_mien);
    }
    public function lay_chi_tiet_bao_lo(string $vung_mien, int $con):chi_tiet_cau_hinh
    {
        if($con == 2)
            return $this->lay_chi_tiet_cau_hinh("2D-Bao", $vung_mien);

        if($con == 3)
            return $this->lay_chi_tiet_cau_hinh("3D-Bao", $vung_mien);

        if($con == 4)
            return $this->lay_chi_tiet_cau_hinh("4D-Bao", $vung_mien);
        return new chi_tiet_cau_hinh();
    }
    public function lay_chi_tiet_da(string $vung_mien):chi_tiet_cau_hinh
    {
        return $this->lay_chi_tiet_cau_hinh("Đá Thẳng", $vung_mien);
    }
    public function lay_chi_tiet_da_xien():chi_tiet_cau_hinh
    {
        return $this->lay_chi_tiet_cau_hinh("Đá Xiên", "Miền Nam");
    }
    public function lay_chi_tiet_7lo_2con():chi_tiet_cau_hinh
    {
        return $this->lay_chi_tiet_cau_hinh("2D-7Lô", "Miền Nam");
    }
    public function lay_chi_tiet_7lo_3con():chi_tiet_cau_hinh
    {
        return $this->lay_chi_tiet_cau_hinh("3D-7Lô", "Miền Nam");
    }
    public function lay_ten_dai_theo_thu_tu(int $day_of_week) : string{
        foreach ($this->ds_thu_tu_dai as $thu_tu_dai) {
            if($thu_tu_dai->ngay_trong_tuan == $day_of_week)
                return $thu_tu_dai->ten_dai_theo_thu_tu;
        }
        return '';
    }
  
    public function ghi_xuong_db()
    {
        $sql_connector = new sql_connector();
        $sql = "INSERT INTO cau_hinh (tai_khoan) VALUES ('$this->tai_khoan')";
        if ($result = $sql_connector->get_query_result($sql)) { //Ghi cấu hình
            $id = $sql_connector->get_insert_id();

            $sql_chi_tiet = "INSERT INTO chi_tiet_cau_hinh (id_cau_hinh, kieu_danh, co, trung, vung_mien) VALUES ";
            foreach ($this->chi_tiet_cau_hinh_list as $ct) {
                $sql_chi_tiet .= "(" . $id . ",'" . $ct->kieu_danh . "'," . $ct->co . "," . $ct->trung . ",'" . $ct->vung_mien . "'),";
            }
            $sql_chi_tiet = rtrim($sql_chi_tiet, ',');

            $sql_connector->get_query_result($sql_chi_tiet); //ghi chi tiết cấu hình

            $sql_thu_tu_dai = "INSERT INTO thu_tu_dai (id_cau_hinh, ngay_trong_tuan, ten_dai_theo_thu_tu) VALUES ";
            foreach ($this->ds_thu_tu_dai as $tt) {
                $sql_thu_tu_dai .= "(" . $id . "," . $tt->ngay_trong_tuan . ",'" . $tt->ten_dai_theo_thu_tu . "'),";
            }
            $sql_thu_tu_dai = rtrim($sql_thu_tu_dai, ',');

            $sql_connector->get_query_result($sql_thu_tu_dai); //ghi thứ tự đài

        } else {
            echo 'Ghi cau hinh: Khong ghi duoc table cau_hinh';
        }
    }

    public function xoa_khoi_db()
    {
        $sql_connector = new sql_connector();
        $sql = "DELETE FROM cau_hinh WHERE tai_khoan = '$this->tai_khoan'";
        if ($result = $sql_connector->get_query_result($sql)) { //Xoá ở bảng cau_hinh
            $id = $sql_connector->get_insert_id();

            $sql_chi_tiet = "DELETE FROM chi_tiet_cau_hinh WHERE id_cau_hinh = '$this->id'";

            $sql_connector->get_query_result($sql_chi_tiet); //xoá chi tiết cấu hình

            $sql_thu_tu_dai = "DELETE FROM thu_tu_dai WHERE id_cau_hinh = '$this->id'";

            $sql_connector->get_query_result($sql_thu_tu_dai); //ghi thứ tự đài

        } else {
            echo 'Ghi cau hinh: Khong xoa duoc table cau_hinh';
        }
    }

    public static function CapNhatTheoTenTaiKhoan(string $ten_tai_khoan, sql_connector $sql_connector = null)
    {
        $sql_connector = $sql_connector?? new sql_connector();
        //Lấy id cấu hình của tài khoản
        $sql_lay_cau_hinh = "SELECT id FROM cau_hinh WHERE tai_khoan = '$ten_tai_khoan'";
        if ($result = $sql_connector->get_query_result($sql_lay_cau_hinh)) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id = $row["id"]; //Lấy được id của cấu hình tài khoản
                

                $sql_xoa_cau_hinh = "DELETE FROM cau_hinh WHERE id = '$id'";
                if ($result = $sql_connector->get_query_result($sql_xoa_cau_hinh)) { //Xoá ở bảng cau_hinh
                    
                    $sql_xoa_chi_tiet = "DELETE FROM chi_tiet_cau_hinh WHERE id_cau_hinh = '$id'";
                    $sql_connector->get_query_result($sql_xoa_chi_tiet);
                    
                    $sql_xoa_thu_tu_dai = "DELETE FROM thu_tu_dai WHERE id_cau_hinh = '$id'";
                    $sql_connector->get_query_result($sql_xoa_thu_tu_dai); //ghi thứ tự đài
                }
                else{
                    echo 'xoa_cau_hinh_theo_tk: khong ket noi duoc cs du lieu';
                    return false;
                }
            }
            else{
                echo 'xoa_cau_hinh_theo_tk: Không tìm được tài khoản cần xoá';
                return false;
            }
        }else 
        {
            echo 'xoa_cau_hinh_theo_tk: khong ket noi duoc cs du lieu';
            return false;
        }
        return true;
    }

    /**
     * Cập nhật cấu hình xuống db, chỉ cập nhật chi tiêt và thứ tự đài
     * @return void
     */
    public function cap_nhat_xuong_db(sql_connector $sql_connector = null)
    {
        $sql_connector = $sql_connector?? new sql_connector();

        foreach ($this->chi_tiet_cau_hinh_list as $ct) {
            $sql_chi_tiet = "UPDATE chi_tiet_cau_hinh SET co = '$ct->co', trung='$ct->trung' WHERE id = '$ct->id'";
            $sql_connector->get_query_result($sql_chi_tiet);
        }

        foreach ($this->ds_thu_tu_dai as $tt) {
            $sql_thu_tu_dai = "UPDATE thu_tu_dai SET ten_tai_theo_thu_tu = '$tt->ten_dai_theo_thu_tu' WHERE id = '$tt->id'";
            $sql_connector->get_query_result($sql_thu_tu_dai);
        }
    }

}

//======================================Lớp Chi tiết cấu hình =======================================
class chi_tiet_cau_hinh
{
    public $id, $id_cau_hinh, $kieu_danh, $co, $trung, $vung_mien;
    
    public function lay_du_lieu_tu_object(object $var)
    {
        foreach ($var as $key => $value)
            $this->{$key} = $value;
    }

    public function cap_nhat_xuong_db(sql_connector $sql_connector = null){
        $sql_connector = $sql_connector?? new sql_connector();
        $sql_chi_tiet = "UPDATE chi_tiet_cau_hinh SET co = '$this->co', trung='$this->trung' WHERE vung_mien = '$this->vung_mien' AND kieu_danh ='$this->kieu' AND id_cau_hinh='$this->id_cau_hinh' ";
        return $sql_connector->get_query_result($sql_chi_tiet);
    }
    

}

//================================ Lớp Thứ Tự Đài =============================
class thu_tu_dai
{
    public $id, $id_cau_hinh, $ngay_trong_tuan, $ten_dai_theo_thu_tu;
    public function lay_du_lieu_tu_object(object $var)
    {
        foreach ($var as $key => $value)
            $this->{$key} = $value;
    }
    public function cap_nhat_xuong_db(sql_connector $sql_connector = null){
        $sql_connector = $sql_connector?? new sql_connector();
        $sql_thu_tu_dai = "UPDATE thu_tu_dai SET ten_dai_theo_thu_tu = '$this->ten_dai_theo_thu_tu' WHERE id = '$this->id'";
        $resul = $sql_connector->get_query_result($sql_thu_tu_dai);
        return $resul;
    }
}

?>