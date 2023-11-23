<?php
class thong_ke
{
    public $id, $ten_tai_khoan, $ten_hien_thi, $so_tin, $hai_c, $ba_c, $bon_c, $da_daxien,
    $xac, $thuc_thu,  $tien_trung, $thang_thua, $so;

    public function __construct(){
        $this->ten_tai_khoan = $this->ten_hien_thi = $this->so = '';
        $this->so_tin = $this->hai_c = $this->ba_c =$this->bon_c = $this->da_daxien = $this->xac
            = $this->thuc_thu = $this->tien_trung = $this->thang_thua = 0.0;
    }

    public function ghi_xuong_db()
    {
        $sql = "INSERT INTO thong_ke (ten_tai_khoan, ten_hien_thi, so_tin, hai_c, ba_c, bon_c, da_daxien, xac, thuc_thu, tien_trung, thang_thua )
                VALUES ('$this->ten_tai_khoan','$this->ten_hien_thi', $this->so_tin, $this->hai_c,$this->ba_c, $this->bon_c, $this->da_daxien, 
                    $this->xac, $this->thuc_thu, $this->tien_trung, $this->thang_thua)";
        $sql_connector = new sql_connector();
        //echo $sql;
        return $sql_connector->get_query_result($sql);
    }

    public function cap_nhat_xuong_db()
    {
        $sql = "UPDATE thong_ke 
                    SET so_tin = $this->so_tin, haic = $this->hai_c, ba_c = $this->ba_c, bon_c = $this->bon_c, da_daxien = $this->da_daxien,  
                        xac = $this->xac, thuc_thu = $this->thuc_thu, tien_trung = $this->tien_trung thang_thua = $this->thang_thua
                    WHERE id = '$this->id'";
        $sql_connector = new sql_connector();
        //echo $sql . '<br/>';
        return $sql_connector->get_query_result($sql);
    }

    public function xoa_khoi_db()
    {
        $sql = "DELETE FROM chi_tiet_tin 
                WHERE id = '$this->id' ";
        $sql_connector = new sql_connector();
        //echo $sql . '<br/>';
        return $sql_connector->get_query_result($sql);
    }

    //Chuyển 1 row của table thong_ke trong csdl sang thong_ke
    public function lay_du_lieu($row)
    {
        foreach ($row as $key => $value)

            $this->{$key} = $value;
    }

    //Lấy tất cả các dòng
    public static function doc_thong_ke_tu_db($sql)
    {
        $thong_ke_list = array();
        $sql_connector = new sql_connector();
        if ($result = $sql_connector->get_query_result($sql)) {
            while ($row = $result->fetch_assoc()) {
                $thong_ke = new thong_ke();
                $thong_ke->lay_du_lieu($row);
                $thong_ke_list[] = $thong_ke;
            }
            return $thong_ke_list;
        }
        return null;
    }
    //Chỉ lấy dòng đầu tiên của kết quả
    public static function doc_thong_ke_tu_db_fist_row($sql)
    {
        $sql_connector = new sql_connector();
        if ($result = $sql_connector->get_query_result($sql)) {
            $row = $result->fetch_assoc();
            $thong_ke = new thong_ke();
            $thong_ke->lay_du_lieu($row);  
            return $thong_ke;
        }
        return null;
    }
    /**
     * Tạo nội dung cho sổ
     */
    public function TaoNoiDungSo(String $ngay){
        if($ngay === "Tất cả"){
            $current_date = date('d-m-Y'); // Lấy ngày hiện tại
            $previous_6day_date = date('d-m-Y', strtotime('-6 days')); // Lấy ngày trước đó 6 ngày
            $this->so = "<p>$current_date -> $previous_6day_date</p>";
        }
           
        else{
            $this->so = "<p>$ngay</p>";
        }
        $this->so .= "<p>Khách: $this->ten_tai_khoan</p>";
        $this->so .= '<p>';
        if($this->hai_c > 0)
            $this->so .= "2c: $this->hai_c ";  
        if($this->ba_c > 0)
            $this->so .= "3c: $this->ba_c ";
        if($this->bon_c > 0)
            $this->so .= "4c: $this->bon_c ";
        if($this->da_daxien > 0)
            $this->so .= "đá/đá xiên: $this->da_daxien ";    
        $this->so .= '</p>';
        $this->so .= "<p>Trúng: $this->tien_trung</p>";
        $this->so .= "<p>Cái lời: $this->thang_thua</p>";
    }


}

?>