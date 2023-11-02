<?php
$dir_name = dirname(__FILE__);
include_once(dirname($dir_name) . '/ket_qua/class_ket_qua.php');
include_once(dirname($dir_name) . '/cau_hinh/class_cau_hinh.php');

//================================================== Class tin ===============================================
class tin
{
    public $id, $ma_tin, $tai_khoan_tao, $tai_khoan_danh, $thoi_gian_tao, $thoi_gian_danh, $noi_dung, $ghi_chu,
    $hai_c, $ba_c, $bon_c, $da_daxien, $xac, $thuc_thu, $tien_trung, $trung, $so_trung, $trang_thai;
    public static function doc_tin_tu_db(string $sql, sql_connector $sql_connector = null): array
    {
        $tins = array();
        if ($sql_connector === null)
            $sql_connector = new sql_connector();
        if ($result = $sql_connector->get_query_result($sql)) {
            while ($row = $result->fetch_assoc()) {
                $tin = new tin();
                $tin->lay_du_lieu($row);
                $tins[] = $tin;
            }

        }
        return $tins;
    }
    /**
     * Hàm trả về một tin theo id, nếu không tìm thấy trả về null
     */
    public static function doc_tin_tu_db_theo_id(string $id, sql_connector $sql_connector = null)
    {

        if ($sql_connector === null)
            $sql_connector = new sql_connector();
        $sql = "SELECT * FROM tin WHERE id = $id";
        $tin = new tin();
        if ($result = $sql_connector->get_query_result($sql)) {
            $row = $result->fetch_assoc();
            $tin = new tin();
            $tin->lay_du_lieu($row);
            return $tin;
        }
        return null;
    }
    public static function xoa_tin_theo_id(string $id, sql_connector $sql_connector = null)
    {

        if ($sql_connector === null)
            $sql_connector = new sql_connector();
        $sql = "DELETE FROM tin WHERE id = $id";
        $result = $sql_connector->get_query_result($sql);
        return $result;
    }
    public static function DocTinTuDbTheoID($id, sql_connector $sql_connector = null): tin
    {
        $tin = new tin();
        if ($sql_connector === null)
            $sql_connector = new sql_connector();
        $sql = "SELECT * FROM tin WHERE id = $id";

        if ($result = $sql_connector->get_query_result($sql)) {
            $row = $result->fetch_assoc();
            $tin->lay_du_lieu($row);
        }
        return $tin;
    }
    public function ghi_xuong_db(sql_connector $sql_connector = null)
    {
        if ($sql_connector === null)
            $sql_connector = new sql_connector();

        $sql = "INSERT INTO tin (ma_tin, tai_khoan_tao, tai_khoan_danh, thoi_gian_tao, thoi_gian_danh, noi_dung, ghi_chu,
            hai_c, ba_c, bon_c, da_daxien, xac, thuc_thu, tien_trung, so_trung, trang_thai)
            VALUES ('$this->ma_tin','$this->tai_khoan_tao','$this->tai_khoan_danh', '$this->thoi_gian_tao', '$this->thoi_gian_danh', '$this->noi_dung','$this->ghi_chu',
            $this->hai_c,$this->ba_c, $this->bon_c, $this->da_daxien, $this->xac, $this->thuc_thu, $this->tien_trung, '$this->so_trung', $this->trang_thai)";

        return $sql_connector->get_query_result($sql);

    }
    public function cap_nhat_xuong_db(sql_connector $sql_connector = null)
    {
        $sql = "UPDATE tin 
                SET
                    tai_khoan_tao = '$this->tai_khoan_tao',
                    tai_khoan_danh = '$this->tai_khoan_danh',
                    thoi_gian_tao = '$this->thoi_gian_tao',
                    thoi_gian_danh = '$this->thoi_gian_danh',
                    noi_dung = '$this->noi_dung',
                    ghi_chu = '$this->ghi_chu',
                    hai_c = $this->hai_c, 
                    ba_c = $this->ba_c, 
                    bon_c = $this->bon_c, 
                    da_daxien = $this->da_daxien, 
                    xac = $this->xac, 
                    thuc_thu = $this->thuc_thu,
                    tien_trung = $this->tien_trung, 
                    so_trung = '$this->so_trung',
                    trang_thai = $this->trang_thai
                WHERE id = '$this->id' ";

        if ($sql_connector === null)
            $sql_connector = new sql_connector();
        return $sql_connector->get_query_result($sql);
    }
    //Xoá bản thân
    public function xoa_khoi_db(sql_connector $sql_connector = null)
    {
        $sql = "DELETE FROM tin 
                    WHERE id = '$this->id' ";
        if ($sql_connector === null)
            $sql_connector = new sql_connector();
        return $sql_connector->get_query_result($sql);
    }

    public function toString()
    {
        return "Tin To String";
    }
    public function toHTML()
    {
        $html = '';
        $html .= "<p>Tạo bởi: $this->tai_khoan_tao, lúc: $this->thoi_gian_tao</p>";
        $html .= "<p>Ghi cho: $this->tai_khoan_danh, ngày: $this->thoi_gian_danh</p>";
        $html .= "<p>Nội dung</p>";
        $html .= "<p>$this->noi_dung</p>";
        $html .= "<p>Xác: $this->xac, thực thu: $this->thuc_thu, Tiền trúng: $this->tien_trung</p>";
        $html .= "<p>Số trúng: $this->so_trung</p>";

        return $html;
    }
    public function lay_du_lieu($row)
    {
        foreach ($row as $key => $value)
            $this->{$key} = $value;
    }

    public function lay_chi_tiet(sql_connector $sql_connector = null)
    {
        if ($sql_connector === null)
            return chi_tiet_tin::lay_chi_tiet_cua_tin($this->id);
        return chi_tiet_tin::lay_chi_tiet_cua_tin($this->id, $sql_connector);
    }
    static public function lay_du_lieu_tu_mang($arr_of_row)
    {
        $result = array();
        foreach ($arr_of_row as $row) {
            $tin = new tin();
            $tin->lay_du_lieu($row);
            $result[] = $tin;
        }
        return $result;
    }

    /**
     * Hàm đọc tất cả các tin chưa được soi kết quả (theo tài khoản), soi kết quả và cập nhật xuống db
     * @param string $ten_tai_khoan 
     * @param string $loai_tai_khoan
     */
    public static function CapNhatKetQuaCacTin(string $ten_tai_khoan, string $loai_tai_khoan)
    {
        $tins = tin::LayTinChuaCoKetQua($ten_tai_khoan, $loai_tai_khoan);
        if (sizeof($tins) == 0) {
            //echo 'Không có tin cần soi!';
            return;
        }
        foreach ($tins as $tin) {
            $ds_chi_tiet = chi_tiet_tin::lay_chi_tiet_cua_tin($tin->id);
            $result = tin::CapNhatKetQuaTin($tin, $ds_chi_tiet);
        }

    }

    public static function LayTinChuaCoKetQua(string $ten_tai_khoan, string $loai_tai_khoan): array
    {
        if ($loai_tai_khoan === "god")
            return array();
        if ($loai_tai_khoan === "admin")
            $sql = "SELECT * FROM tin WHERE trang_thai = -1 AND (tai_khoan_danh = '$ten_tai_khoan' OR tai_khoan_danh IN (
                SELECT ten_tai_khoan FROM tai_khoan WHERE tai_khoan_quan_ly = '$ten_tai_khoan') )";
        else
            $sql = $sql = "SELECT * FROM tin WHERE trang_thai = -1 AND tai_khoan_danh = '$ten_tai_khoan'";
        return tin::doc_tin_tu_db($sql);
    }


    public static function xoa_tat_ca_tin_theo_tai_khoan(string $ten_tai_khoan, sql_connector $sql_connector = null)
    {
        $tin_list = tin::doc_tin_tu_db("SELECT * FROM tin WHERE tai_khoan_danh = '$ten_tai_khoan'");

        $sql_connector = $sql_connector ?? new sql_connector();

        foreach ($tin_list as $tin) {
            $sql_xoa_chitiet = "DELETE FROM chi_tiet_tin 
                     WHERE id_tin = '$tin->id_tin'";
            $sql_connector->get_query_result($sql_xoa_chitiet);
        }
        $sql_xoa_tin = "DELETE FROM tin 
                            WHERE tai_khoan_danh = '$ten_tai_khoan'";
        $sql_connector->get_query_result($sql_xoa_tin);
    }

    public static function CapNhatThongKeChoTin(tin $tin, array $ds_chi_tiet): array
    {

        $result = array();
        $da_co_ket_qua = tin::DaCoKetQua($tin);

        //Lấy cấu hình
        $cau_hinh = cau_hinh::LayCauHinh($tin->tai_khoan_danh);
        //Lấy kết quả theo ngày đánh
        $day_of_week = date('w', strtotime($tin->thoi_gian_danh));
        if ($da_co_ket_qua) {
            $ket_qua_mien_nam = ket_qua_ngay::LayKetQuaMienNam($day_of_week);
            $ket_qua_mien_bac = ket_qua_ngay::LayKetQuaMienBac($day_of_week);
        }

        $html_chi_tiet = '<style>table {width: 100%;} th,td {text-align: right;} td {vertical-align: top;} th:nth-child(1),td:nth-child(1) {text-align: left;}</style>
                        <table> 
                        <thead> <tr><th >Đài</th><th >Số</th><th >Kiểu</th><th >Điểm</th><th >Tiền</th></tr> </thead> 
                    <tbody> ';
        //Cập nhật các giá trị
        //Biến thống kê
        $thong_ke = array(
            '2c-dd' => new tin_thongke('2c-dd'),
            '2c-b' => new tin_thongke('2c-b'),
            '3c' => new tin_thongke('3c'),
            '4c' => new tin_thongke('4c'),
            'dat' => new tin_thongke('dat'),
            'dax' => new tin_thongke('dax'),
        );

        //Kiểm tra từng chi tiết tin
        foreach ($ds_chi_tiet as $chi_tiet_tin) {

            $so_arr = explode(' ', $chi_tiet_tin->so);
            $so_luong_so = count($so_arr);

            $vung_mien = ($chi_tiet_tin->dai === 'mb') ? 'Miền Bắc' : 'Miền Nam'; //Lấy vùng miền và lấy kết quả đài của từng chi tiết theo vùng miền
            if ($da_co_ket_qua)
                $ket_qua_dai = ($chi_tiet_tin->dai === 'mb') ?
                    $ket_qua_mien_bac->ket_qua_cac_dai[0] :
                    $ket_qua_mien_nam->layKetQuaDai($chi_tiet_tin->dai);
            //--------Dựa theo kiểu đánh, nếu kiểu đánh là đầu hoặc đuôi ---------------
            if ($chi_tiet_tin->kieu === "dau" || $chi_tiet_tin->kieu === "duoi") {

                //Lấy cò trúng tương ứng với kiểu đánh đầu hay đuôi
                $chi_tiet_cau_hinh = ($chi_tiet_tin->kieu == "dau") ?
                    $cau_hinh->lay_chi_tiet_2d_dau($vung_mien) : $cau_hinh->lay_chi_tiet_2d_duoi($vung_mien);
                $co = $chi_tiet_cau_hinh->co;
                $trung = $chi_tiet_cau_hinh->trung;

                $chi_tiet_tin->xac = $so_luong_so * $chi_tiet_tin->diem; //Xác
                if ($chi_tiet_tin->dai === 'mb' && $chi_tiet_tin->kieu === 'dau')
                    $chi_tiet_tin->xac = $so_luong_so * $chi_tiet_tin->diem * 4; //Xác
                $chi_tiet_tin->tien = $chi_tiet_tin->xac * $co * 10; //Tiền
                $chi_tiet_tin->thuc_thu = $chi_tiet_tin->xac * ($co / 100); //Thực thu

                //Kiểm tra trúng trật
                if ($da_co_ket_qua)
                    $chi_tiet_tin = ($chi_tiet_tin->kieu == "dau") ? $ket_qua_dai->HaiConDau($chi_tiet_tin, $trung) :
                        $ket_qua_dai->HaiConDuoi($chi_tiet_tin, $trung);

                $thong_ke['2c-dd']->xac += $chi_tiet_tin->xac; //Cập nhật thống kê xác
                $thong_ke['2c-dd']->thuc_thu += $chi_tiet_tin->thuc_thu; //Cập nhật thực thu
                //Cập nhật trúng trật
                if ($chi_tiet_tin->tien_trung > 0) {
                    $thong_ke['2c-dd']->tien_trung += $chi_tiet_tin->tien_trung;
                    $thong_ke['2c-dd']->so_trung .= $chi_tiet_tin->so_trung . '</br>';
                }
                $html_chi_tiet .= $chi_tiet_tin->toHTML();
            }
            //Xỉu đầu xỉu đuôi
            if ($chi_tiet_tin->kieu === "xdau" || $chi_tiet_tin->kieu === "xduoi") {


                //Lấy cò trúng tương ứng với kiểu đánh đầu hay đuôi
                $chi_tiet_cau_hinh = ($chi_tiet_tin->kieu == "xdau") ?
                    $cau_hinh->lay_chi_tiet_xiu_dau($vung_mien) : $cau_hinh->lay_chi_tiet_xiu_duoi($vung_mien);
                $co = $chi_tiet_cau_hinh->co;
                $trung = $chi_tiet_cau_hinh->trung;

                if ($chi_tiet_tin->kieu === 'xdau' && $chi_tiet_tin->dai === 'mb')
                    $chi_tiet_tin->xac = $so_luong_so * $chi_tiet_tin->diem * 3; //Xác
                else
                    $chi_tiet_tin->xac = $so_luong_so * $chi_tiet_tin->diem; //Xác

                $chi_tiet_tin->tien = $chi_tiet_tin->xac * $co * 10; //Tiền
                $chi_tiet_tin->thuc_thu = $chi_tiet_tin->xac * ($co / 100); //Thực thu

                //Kiểm tra trúng trật
                if ($da_co_ket_qua)
                    $chi_tiet_tin = ($chi_tiet_tin->kieu == "xdau") ? $ket_qua_dai->XiuDau($chi_tiet_tin, $trung) :
                        $ket_qua_dai->XiuDuoi($chi_tiet_tin, $trung);

                $thong_ke['3c']->xac += $chi_tiet_tin->xac; //Cập nhật thống kê xác
                $thong_ke['3c']->thuc_thu += $chi_tiet_tin->thuc_thu; //Cập nhật thực thu
                //Cập nhật trúng trật
                if ($chi_tiet_tin->tien_trung > 0) {
                    $thong_ke['3c']->tien_trung += $chi_tiet_tin->tien_trung;
                    $thong_ke['3c']->so_trung .= $chi_tiet_tin->so_trung . '</br>';
                }
                $html_chi_tiet .= $chi_tiet_tin->toHTML();
            }
            //------------------Bao lô-------------------------------
            if ($chi_tiet_tin->kieu === "blo") {
                $so_lo_mien_bac = array(2 => 27, 3 => 23, 4 => 20); //Tính số lô để phục vụ cho kiểu Bao 2c, 3c, 4c
                //Với bao lô, phải duyệt theo từng số, vì một chi tiết có thể có số 2c, 3c, 4c
                $chi_tiet_tin->xac = $chi_tiet_tin->tien = $chi_tiet_tin->thuc_thu = 0.0;

                $con = strlen($so_arr[0]); //con, số ký tự số, 2 con, 3 con, sử dụng để lấy cấu hình và lưu thống kê
                $so_lo = ($vung_mien === "Miền Bắc") ?
                    $so_lo_mien_bac[$con] : 20 - $con; //Tính số lô dựa vào con (số ký tự)

                $chi_tiet_tin->xac += $so_lo * $chi_tiet_tin->diem * $so_luong_so; //Xác = số_lô * điểm * số lượng số. số lô miền nam là 18,17,16, mb 27 23 20 
                $chi_tiet_cau_hinh = $cau_hinh->lay_chi_tiet_bao_lo($vung_mien, $con); //Lấy chi tiết cấu hình theo số con
                $co = $chi_tiet_cau_hinh->co; //cò
                $trung = $chi_tiet_cau_hinh->trung; //trúng
                $chi_tiet_tin->tien = $chi_tiet_tin->xac * $co * 10; //Tiền
                $chi_tiet_tin->thuc_thu = $chi_tiet_tin->xac * ($co / 100); //Thực thu
                //Kiểm tra trúng trật
                if ($da_co_ket_qua)
                    $chi_tiet_tin = $ket_qua_dai->Bao($chi_tiet_tin, $trung);
                //Cập nhật trúng trật
                if ($con == 2) {
                    $thong_ke['2c-b']->xac += $chi_tiet_tin->xac; //Cập nhật thống kê xác
                    $thong_ke['2c-b']->thuc_thu += $chi_tiet_tin->thuc_thu;
                    if ($chi_tiet_tin->tien_trung > 0) {
                        $thong_ke['2c-b']->tien_trung += $chi_tiet_tin->tien_trung;
                        $thong_ke['2c-b']->so_trung .= $chi_tiet_tin->so_trung . '</br>';
                    }
                }
                if ($con == 3) {
                    $thong_ke['3c']->xac += $chi_tiet_tin->xac; //Cập nhật thống kê xác
                    $thong_ke['3c']->thuc_thu += $chi_tiet_tin->thuc_thu;
                    if ($chi_tiet_tin->tien_trung > 0) {
                        $thong_ke['3c']->tien_trung += $chi_tiet_tin->tien_trung;
                        $thong_ke['3c']->so_trung .= $chi_tiet_tin->so_trung . '</br>';
                    }
                }
                if ($con == 4) {
                    $thong_ke['4c']->xac += $chi_tiet_tin->xac; //Cập nhật thống kê xác
                    $thong_ke['4c']->thuc_thu += $chi_tiet_tin->thuc_thu;
                    if ($chi_tiet_tin->tien_trung > 0) {
                        $thong_ke['4c']->tien_trung += $chi_tiet_tin->tien_trung;
                        $thong_ke['4c']->so_trung .= $chi_tiet_tin->so_trung . '</br>';
                    }
                }
                $html_chi_tiet .= $chi_tiet_tin->toHTML();
            }

            //------------------Bảy lô-------------------------------
            if ($chi_tiet_tin->kieu === "baylo") {
                $chi_tiet_tin->xac = $chi_tiet_tin->tien = $chi_tiet_tin->thuc_thu = 0.0;

                $con = strlen($so_arr[0]); //con, số ký tự số, 2 con, 3 con, sử dụng để lấy cấu hình và lưu thống kê

                $chi_tiet_tin->xac = 7 * $chi_tiet_tin->diem * $so_luong_so; //Xác = số_lô * điểm * số lượng số. số lô miền nam là 18,17,16, mb 27 23 20 
                $chi_tiet_cau_hinh = ($con == 2)? $cau_hinh->lay_chi_tiet_7lo_2con() : $cau_hinh->lay_chi_tiet_7lo_3con(); //Lấy chi tiết cấu hình theo số con
                $co = $chi_tiet_cau_hinh->co; //cò
                $trung = $chi_tiet_cau_hinh->trung; //trúng
                $chi_tiet_tin->tien = $chi_tiet_tin->xac * $co * 10; //Tiền
                $chi_tiet_tin->thuc_thu = $chi_tiet_tin->xac * ($co / 100); //Thực thu
                //Kiểm tra trúng trật
                if ($da_co_ket_qua)
                    $chi_tiet_tin = ($con == 2)? $ket_qua_dai->BayLo2con($chi_tiet_tin, $trung) : $ket_qua_dai->BayLo3con($chi_tiet_tin, $trung);
                //Cập nhật trúng trật
                if ($con == 2) {
                    $thong_ke['2c-b']->xac += $chi_tiet_tin->xac; //Cập nhật thống kê xác
                    $thong_ke['2c-b']->thuc_thu += $chi_tiet_tin->thuc_thu;
                    if ($chi_tiet_tin->tien_trung > 0) {
                        $thong_ke['2c-b']->tien_trung += $chi_tiet_tin->tien_trung;
                        $thong_ke['2c-b']->so_trung .= $chi_tiet_tin->so_trung . '</br>';
                    }
                }
                if ($con == 3) {
                    $thong_ke['3c']->xac += $chi_tiet_tin->xac; //Cập nhật thống kê xác
                    $thong_ke['3c']->thuc_thu += $chi_tiet_tin->thuc_thu;
                    if ($chi_tiet_tin->tien_trung > 0) {
                        $thong_ke['3c']->tien_trung += $chi_tiet_tin->tien_trung;
                        $thong_ke['3c']->so_trung .= $chi_tiet_tin->so_trung . '</br>';
                    }
                }
                $html_chi_tiet .= $chi_tiet_tin->toHTML();
            }

            //------------------ da -------------------------------
            if ($chi_tiet_tin->kieu === "da") {
                //Cập nhật xác, tiền, thực thu

                $chi_tiet_cau_hinh = $cau_hinh->lay_chi_tiet_da($vung_mien); //Lấy cấu hình, cò, trúng
                $co = $chi_tiet_cau_hinh->co; //cò
                $trung = $chi_tiet_cau_hinh->trung;

                $chi_tiet_tin->xac = $chi_tiet_tin->diem * 36 * $so_luong_so; //Xác của tin
                if ($chi_tiet_tin->dai === 'mb')
                    $chi_tiet_tin->xac = $chi_tiet_tin->diem * 54 * $so_luong_so; //Xác của tin
                $chi_tiet_tin->tien = $chi_tiet_tin->xac * $co * 10; //Tiền
                $chi_tiet_tin->thuc_thu = $chi_tiet_tin->xac * ($co / 100); //Thực thu

                if ($da_co_ket_qua) //Cập nhật kết quả
                    $chi_tiet_tin = $ket_qua_dai->Da($chi_tiet_tin, $trung);

                $thong_ke['dat']->xac += $chi_tiet_tin->xac; //Cập nhật thống kê xác
                $thong_ke['dat']->thuc_thu += $chi_tiet_tin->thuc_thu;
                if ($chi_tiet_tin->tien_trung > 0) {
                    $thong_ke['dat']->tien_trung += $chi_tiet_tin->tien_trung;
                    $thong_ke['dat']->so_trung .= $chi_tiet_tin->so_trung . '</br>';
                }
                $html_chi_tiet .= $chi_tiet_tin->toHTML();
            }
            //------------------ da xiên -------------------------------
            if ($chi_tiet_tin->kieu === "dx") {
                //Cập nhật xác, tiền, thực thu

                $chi_tiet_cau_hinh = $cau_hinh->lay_chi_tiet_da_xien(); //Lấy cấu hình, cò, trúng
                $co = $chi_tiet_cau_hinh->co; //cò
                $trung = $chi_tiet_cau_hinh->trung;

                $chi_tiet_tin->xac = $chi_tiet_tin->diem * 72 * $so_luong_so; //Xác của tin
                $chi_tiet_tin->tien = $chi_tiet_tin->xac * $co * 10; //Tiền
                $chi_tiet_tin->thuc_thu = $chi_tiet_tin->xac * ($co / 100); //Thực thu

                if ($da_co_ket_qua) //Cập nhật kết quả
                    $chi_tiet_tin = $ket_qua_mien_nam->DaXien($chi_tiet_tin, $trung);

                $thong_ke['dax']->xac += $chi_tiet_tin->xac; //Cập nhật thống kê xác
                $thong_ke['dax']->thuc_thu += $chi_tiet_tin->thuc_thu;
                if ($chi_tiet_tin->tien_trung > 0) {
                    $thong_ke['dax']->tien_trung += $chi_tiet_tin->tien_trung;
                    $thong_ke['dax']->so_trung .= $chi_tiet_tin->so_trung . '</br>';
                }
                $html_chi_tiet .= $chi_tiet_tin->toHTML();
            }
        }



        $html_thong_ke = tin_thongke::toHTMLFormArray($thong_ke);

        $tin = tin::CapNhatThongKeVaoTin($thong_ke, $tin);

        if ($da_co_ket_qua) {
            if ($tin->tien_trung <= 0)
                $tin->trang_thai = TrangThaiTin::KHONG_TRUNG;
            else
                $tin->trang_thai = TrangThaiTin::TRUNG;
        } else
            $tin->trang_thai = -1;

        //Xuất ra
        $html_chi_tiet .= '<tr> 
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Tổng tiền: </td>
                            <td>' . number_format($tin->thuc_thu * 1000, 0, '.', ',') . '</td>
                        </tr>';
        $html_chi_tiet .= '</tbody></table>';
        $result['html_kq_kiem_tra'] = $html_thong_ke . $html_chi_tiet;
        $result['tin'] = $tin;
        $result['ds_chi_tiet'] = $ds_chi_tiet;
        $result['ds_thong_ke'] = $thong_ke;
        $result['success'] = 1;
        return $result;
    }

    public static function CapNhatKetQuaTin(tin $tin, array $ds_chi_tiet): array
    {
        $result = array();
        $da_co_ket_qua = tin::DaCoKetQua($tin);
        if ($da_co_ket_qua == false) { //Nếu chưa có kết quả thì ko làm gì cả
            $result['tin'] = $tin;
            $result['ds_chi_tiet'] = $ds_chi_tiet;
            return $result;
        }

        $cau_hinh = cau_hinh::LayCauHinh($tin->tai_khoan_danh); //Lấy cấu hình
        //Lấy kết quả theo ngày đánh
        $day_of_week = date('w', strtotime($tin->thoi_gian_danh));
        $ket_qua_mien_nam = ket_qua_ngay::LayKetQuaMienNam($day_of_week);
        $ket_qua_mien_bac = ket_qua_ngay::LayKetQuaMienBac($day_of_week);

        $tin->tien_trung = 0;
        //Kiểm tra từng chi tiết tin
        foreach ($ds_chi_tiet as $chi_tiet_tin) {
            $so_arr = explode(' ', $chi_tiet_tin->so);
            $vung_mien = ($chi_tiet_tin->dai === 'mb') ? 'Miền Bắc' : 'Miền Nam'; //Lấy vùng miền và lấy kết quả đài theo vùng miền

            $ket_qua_dai = ($chi_tiet_tin->dai === 'mb') ? $ket_qua_mien_bac->ket_qua_cac_dai[0] :
                $ket_qua_mien_nam->layKetQuaDai($chi_tiet_tin->dai);
            //Dựa theo kiểu đánh, nếu kiểu đánh là đầu hoặc đuôi
            if ($chi_tiet_tin->kieu === "dau" || $chi_tiet_tin->kieu === "duoi") {
                //Lấy trúng tương ứng với kiểu đánh đầu hay đuôi
                $chi_tiet_cau_hinh = ($chi_tiet_tin->kieu == "dau") ?
                    $cau_hinh->lay_chi_tiet_2d_dau($vung_mien) : $cau_hinh->lay_chi_tiet_2d_duoi($vung_mien);
                $trung = $chi_tiet_cau_hinh->trung;
                //Kiểm tra trúng trật
                $chi_tiet_tin = ($chi_tiet_tin->kieu == "dau") ? $ket_qua_dai->HaiConDau($chi_tiet_tin, $trung) :
                    $ket_qua_dai->HaiConDuoi($chi_tiet_tin, $trung);
            }
            //Xỉu đầu xỉu đuôi
            if ($chi_tiet_tin->kieu === "xdau" || $chi_tiet_tin->kieu === "xduoi") {
                //Lấytrúng tương ứng với kiểu đánh đầu hay đuôi
                $chi_tiet_cau_hinh = ($chi_tiet_tin->kieu == "xdau") ?
                    $cau_hinh->lay_chi_tiet_xiu_dau($vung_mien) : $cau_hinh->lay_chi_tiet_xiu_duoi($vung_mien);
                $trung = $chi_tiet_cau_hinh->trung;
                //Kiểm tra trúng trật
                $chi_tiet_tin = ($chi_tiet_tin->kieu == "xdau") ? $ket_qua_dai->XiuDau($chi_tiet_tin, $trung) :
                    $ket_qua_dai->XiuDuoi($chi_tiet_tin, $trung);
            }
            //------------------Bao lô-------------------------------
            if ($chi_tiet_tin->kieu === "blo") {
                //Với bao lô, phải duyệt theo từng số, vì một chi tiết có thể có số 2c, 3c, 4c
                foreach ($so_arr as $so) { //Với mỗi số
                    $con = strlen($so); //con, số ký tự số, 2 con, 3 con, sử dụng để lấy cấu hình và lưu thống kê
                    $chi_tiet_cau_hinh = $cau_hinh->lay_chi_tiet_bao_lo($vung_mien, $con); //Lấy chi tiết cấu hình theo số con
                    $trung = $chi_tiet_cau_hinh->trung; //trúng
                    //Kiểm tra trúng trật
                    $chi_tiet_tin = $ket_qua_dai->Bao($chi_tiet_tin, $trung);
                }
            }
              //------------------Bảy lô-------------------------------
              if ($chi_tiet_tin->kieu === "baylo") {    
                $con = strlen($so_arr[0]); //con, số ký tự số, 2 con, 3 con, sử dụng để lấy cấu hình và lưu thống kê
                $chi_tiet_cau_hinh = ($con == 2)? $cau_hinh->lay_chi_tiet_7lo_2con() : $cau_hinh->lay_chi_tiet_7lo_3con(); //Lấy chi tiết cấu hình theo số con
                $trung = $chi_tiet_cau_hinh->trung; //trúng
                $chi_tiet_tin = ($con == 2)? $ket_qua_dai->BayLo2con($chi_tiet_tin, $trung) : $ket_qua_dai->BayLo3con($chi_tiet_tin, $trung);
            }
            //------------------ da -------------------------------
            if ($chi_tiet_tin->kieu === "da") {
                $chi_tiet_cau_hinh = $cau_hinh->lay_chi_tiet_da($vung_mien); //Lấy cấu hình, cò, trúng
                $trung = $chi_tiet_cau_hinh->trung;
                //Cập nhật kết quả
                $chi_tiet_tin = $ket_qua_dai->Da($chi_tiet_tin, $trung);
            }
            //------------------ da xiên -------------------------------
            if ($chi_tiet_tin->kieu === "dx") {
                $chi_tiet_cau_hinh = $cau_hinh->lay_chi_tiet_da_xien(); //Lấy cấu hình, cò, trúng
                $trung = $chi_tiet_cau_hinh->trung;
                //Cập nhật kết quả
                $chi_tiet_tin = $ket_qua_mien_nam->DaXien($chi_tiet_tin, $trung);
            }
            //Cập nhật tiền trúng
            if ($chi_tiet_tin->tien_trung > 0) {
                $tin->tien_trung += $chi_tiet_tin->tien_trung;
                $tin->so_trung .= $chi_tiet_tin->so_trung;
            }
        }
        if ($da_co_ket_qua) {
            if ($tin->tien_trung <= 0)
                $tin->trang_thai = TrangThaiTin::KHONG_TRUNG;
            else
                $tin->trang_thai = TrangThaiTin::TRUNG;
        }
        $result['tin'] = $tin;
        $result['ds_chi_tiet'] = $ds_chi_tiet;
        $tin->cap_nhat_xuong_db();
        return $result;
    }

    public static function GhiTinVaChiTiet(tin $tin, array $ds_chi_tiet)
    {
        $conn = new sql_connector();
        //$success = false;
        if (!$conn->get_connect_error()) {
            $sql = "INSERT INTO tin (ma_tin, tai_khoan_tao, tai_khoan_danh, thoi_gian_tao, thoi_gian_danh, noi_dung, ghi_chu,
        hai_c, ba_c, bon_c, da_daxien, xac, thuc_thu, tien_trung, so_trung, trang_thai)
        VALUES ('$tin->ma_tin','$tin->tai_khoan_tao','$tin->tai_khoan_danh', '$tin->thoi_gian_tao', '$tin->thoi_gian_danh', '$tin->noi_dung','$tin->ghi_chu',
        $tin->hai_c,$tin->ba_c, $tin->bon_c, $tin->da_daxien, $tin->xac, $tin->thuc_thu, $tin->tien_trung, '$tin->so_trung', $tin->trang_thai)";
            //echo "sql1: " . $sql . "</br>";
            //echo $sql . "<br/>";
            if ($conn->get_query_result($sql)) {
                $id_tin = $conn->get_insert_id(); //Lấy id tin vừa ghi vào csdl
                foreach ($ds_chi_tiet as $chi_tiet) {
                    $sql2 = "INSERT INTO chi_tiet_tin (id_tin, dai, so, kieu, diem, tien, ghi_chu,
                                    hai_c, ba_c, bon_c, da_daxien, xac, thuc_thu, tien_trung, so_trung )
                            VALUES ($id_tin,'$chi_tiet->dai', '$chi_tiet->so', '$chi_tiet->kieu',$chi_tiet->diem, $chi_tiet->tien,'$chi_tiet->ghi_chu',
                                        $chi_tiet->hai_c,$chi_tiet->ba_c, $chi_tiet->bon_c, $chi_tiet->da_daxien, $chi_tiet->xac, $chi_tiet->thuc_thu, $chi_tiet->tien_trung, '$chi_tiet->so_trung')";
                    //echo "sql2: " . $sql2 . "</br>";
                    $conn->get_query_result($sql2);
                }
                return $sql;
            }
        }
        return false;

    }


    public static function DaCoKetQua(tin $tin): bool
    {
        $ngay_tao = date('d', strtotime($tin->thoi_gian_tao));
        $ngay_danh = date('d', strtotime($tin->thoi_gian_danh));
        $day_of_month_current = date('d', time());
        if ($ngay_danh !== $ngay_tao) { //Nếu ngày đánh khác ngày tạo thì chắc chắn đã có kết quả
            //Vì phía client đã check để đảm bảo ngày đánh phải nhỏ hơn hoặc bằng ngày tạo
            //Hoặc ngày đánh khác ngày hiện tại thì chắc chắn đã có kq
            return true;
        }

        $current_time = time();
        $check_time = strtotime(date('Y-m-d') . '18:55:00');
        if ($current_time > $check_time) { //Nếu ngày đánh == ngày tạo (đánh ngày mới nhất) 
            //&& thời gian hiện tại đã qua thời điểm công bố kết quả thì ... 
            return true;
        }
        return false; //Nếu ngày đánh bằng ngày tạo thì chưa có kết quả.
    }

    public static function CapNhatThongKeVaoTin(array $thong_ke, tin $tin): tin
    {
        $tin->hai_c = $thong_ke['2c-b']->xac + $thong_ke['2c-dd']->xac;
        $tin->ba_c = $thong_ke['3c']->xac;
        $tin->bon_c = $thong_ke['4c']->xac;
        $tin->da_daxien = $thong_ke['dat']->xac + $thong_ke['dax']->xac;
        $tin->xac = $tin->hai_c + $tin->ba_c + $tin->bon_c + $tin->da_daxien;

        $tin->thuc_thu = $thong_ke['2c-b']->thuc_thu + $thong_ke['2c-dd']->thuc_thu
            + $thong_ke['3c']->thuc_thu + $thong_ke['4c']->thuc_thu
            + $thong_ke['dat']->thuc_thu + $thong_ke['dax']->thuc_thu;

        $tin->tien_trung = $thong_ke['2c-b']->tien_trung + $thong_ke['2c-dd']->tien_trung
            + $thong_ke['3c']->tien_trung + $thong_ke['4c']->tien_trung
            + $thong_ke['dat']->tien_trung + $thong_ke['dax']->tien_trung;

        $tin->so_trung = $thong_ke['2c-b']->so_trung . $thong_ke['2c-dd']->so_trung
            . $thong_ke['3c']->so_trung . $thong_ke['4c']->so_trung
            . $thong_ke['dat']->so_trung . $thong_ke['dax']->so_trung;

        return $tin;
    }

}

//=========================================Class Chi Tiet Tin ========================================
class chi_tiet_tin
{
    public $id, $id_tin, $dai, $so, $kieu, $diem, $tien, $ghi_chu,
    $hai_c, $ba_c, $bon_c, $da_daxien, $xac, $thuc_thu, $tien_trung, $so_trung;


    public function __construct()
    {
        $this->dai = $this->so = $this->kieu = $this->ghi_chu = $this->so_trung = '';
        $this->id_tin = 0;
        $this->diem = $this->tien = $this->hai_c = $this->ba_c = $this->bon_c =
            $this->da_daxien = $this->xac = $this->thuc_thu = $this->tien_trung = 0.0;
    }
    public static function doc_chi_tiet_tin_tu_db(string $sql, sql_connector $sql_connector = null)
    {
        $ds_chi_tiet = array();

        if ($sql_connector === null)
            $sql_connector = new sql_connector();

        if ($result = $sql_connector->get_query_result($sql)) {
            while ($row = $result->fetch_assoc()) {
                $chi_tiet = new chi_tiet_tin();
                $chi_tiet->lay_du_lieu($row);
                $ds_chi_tiet[] = $chi_tiet;
            }
            return $ds_chi_tiet;
        }
        return null;
    }
    public static function lay_chi_tiet_cua_tin(int $id_tin, sql_connector $sql_connector = null): array
    {
        $ds_chi_tiet = array();

        if ($sql_connector === null)
            $sql_connector = new sql_connector();

        $sql = "SELECT * FROM chi_tiet_tin WHERE id_tin = $id_tin";
        if ($result = $sql_connector->get_query_result($sql)) {
            while ($row = $result->fetch_assoc()) {
                $chi_tiet = new chi_tiet_tin();
                $chi_tiet->lay_du_lieu($row);
                $ds_chi_tiet[] = $chi_tiet;
            }
            return $ds_chi_tiet;
        }
        return $ds_chi_tiet;
    }

    public function ghi_xuong_db(sql_connector $sql_connector)
    {
        $sql = "INSERT INTO chi_tiet_tin (id_tin, dai, so, kieu, diem, tien, ghi_chu,
        hai_c, ba_c, bon_c, da_daxien, xac, thuc_thu, tien_trung, so_trung )
                VALUES ('$this->id_tin','$this->dai', '$this->so', '$this->kieu','$this->diem', '$this->tien','$this->ghi_chu',
                '$this->hai_c','$this->ba_c', '$this->bon_c', '$this->da_daxien', ,'$this->xac', '$this->thuc_thu', '$this->tien_trung', '$this->so_trung')";

        if ($sql_connector === null)
            $sql_connector = new sql_connector();
        //echo $sql;
        return $sql_connector->get_query_result($sql);
    }

    //Update data in to database
    public function cap_nhat_xuong_db(sql_connector $sql_connector)
    {
        $sql = "UPDATE chi_tiet_tin 
                SET  ghi_chu = '$this->ghi_chu',
                    hai_c = '$this->hai_c', 
                    ba_c = '$this->ba_c', 
                    bon_c = '$this->bon_c', 
                    da_daxien = '$this->da_daxien', 
                    xac = '$this->xac', 
                    thuc_thu = '$this->thuc_thu', 
                    tien_trung = '$this->tien_trung',
                    so_trung = '$this->so_trung'
                WHERE id = '$this->id' ";

        if ($sql_connector === null)
            $sql_connector = new sql_connector();

        return $sql_connector->get_query_result($sql);
    }

    // public function xoa_khoi_db()
    // {
    //     $sql = "DELETE FROM chi_tiet_tin 
    //             WHERE id = '$this->id' ";
    //     $sql_connector = new sql_connector();
    //     //echo $sql . '<br/>';
    //     return $sql_connector->get_query_result($sql);
    // }


    public function toString()
    {
        return "Chi tiet To String";
    }

    public function toHTML(): string
    {

        return '<tr> 
                    <td>' . $this->dai . '</td>
				    <td>' . chi_tiet_tin::ChuanHoaSo($this->so) . '</td>
				    <td>' . $this->kieu . '</td>
				    <td>' . $this->diem . '</td>
				    <td>' . number_format($this->tien, 0, '.', ',') . '</td>
				</tr>';
    }

    public function toHTML_web(): string
    {
        return ' <tr role="row" class="">
                    <td aria-colindex="1" role="cell" class="">' . $this->dai . '</td>
                    <td aria-colindex="2" role="cell" class="">' . chi_tiet_tin::ChuanHoaSo($this->so) . '</td>
                    <td aria-colindex="3" role="cell" class="">' . $this->kieu . '</td>
                    <td aria-colindex="4" role="cell" class="">' . $this->diem . '</td>
                    <td aria-colindex="5" role="cell" class="">' . number_format($this->tien, 0, '.', ',') . '</td>
                </tr>';
    }

    //Chuyển từ object sang chi_tiet_tin
    public function lay_du_lieu($row)
    {
        foreach ($row as $key => $value)

            $this->{$key} = $value;
    }
    //Convert from array of objects to array of chi_tiet_tin
    static public function lay_du_lieu_tu_mang($arr_of_row)
    {
        $result = array();
        foreach ($arr_of_row as $row) {
            $chi_tiet = new chi_tiet_tin();
            $chi_tiet->lay_du_lieu($row);
            $result[] = $chi_tiet;
        }
        return $result;
    }
    static public function xoa_chi_tiet_theo_id_tin($id_tin, sql_connector $sql_connector)
    {
        $sql = "DELETE FROM chi_tiet_tin 
                    WHERE id_tin = '$id_tin' ";
        if ($sql_connector === null)
            $sql_connector = new sql_connector();
        return $sql_connector->get_query_result($sql);
    }
    /**
     * Hàm chuẩn hoá chuỗi số nếu quá dài, dùng để xuất
     * Hàm sẽ tìm các dãy số liên tục quá dài và chuyển về dạng \d k \d
     */
    public static function ChuanHoaSo(string $chuoi_so): string
    {
        if (strlen($chuoi_so) < 32)
            return $chuoi_so;

        $mang_cac_so = explode(' ', $chuoi_so);
        $ket_qua = array();
        $size_of_so = count($mang_cac_so);
        for ($i = 0; $i < $size_of_so; $i++) { //Với mỗi phần tử (số)
            if (strpos($mang_cac_so[$i], ',')) { //Nếu có dấu phẩy (số kiểu đá) thì bỏ qua
                $ket_qua[] = $mang_cac_so[$i];
                continue;
            }
            $j = $i + 1;
            $start = $end = $mang_cac_so[$i];
            while ($j < $size_of_so && ($end == ($mang_cac_so[$j] - 1))) {
                $end = $mang_cac_so[$j];
                $j++;
            }
            if ($start == $end) {
                $ket_qua[] = $start;
            } else {
                if (abs($end - $start) > 2) //Khoảng cách từ $end tới start từ 3 số thì dùng kiểu viết tắt 
                    $ket_qua[] = $start . 'k' . $end;
                else //Nếu không thì xuất đầy đủ từng số, lười suy nghĩ nên viết vậy
                    if (abs($end - $start) > 1) { //khoảng cách chỉ 2 đơn vị ( 3 số)
                        $ket_qua[] = $start;
                        $ket_qua[] = $start + 1;
                        $ket_qua[] = $start + 2;
                    } else { //Khoảng cách chỉ 1 đơn vị (2 số)
                        $ket_qua[] = $start;
                        $ket_qua[] = $end;
                    }
            }
            $i = $j - 1;
        }
        return join(' ', $ket_qua);
    }
}


class tin_thongke
{
    public $kieu, $xac, $thuc_thu, $tien_trung, $so_trung;

    public function __construct(string $kieu)
    {
        $this->kieu = $kieu;
        $this->xac = $this->thuc_thu = $this->tien_trung = 0.0;
        $this->so_trung = '';
    }

    public function toHTML(): string
    {
        return '<tr> 
                    <td>' . $this->kieu . '</td>
				    <td>' . number_format($this->xac, 1) . '</td>
				    <td>' . number_format($this->thuc_thu, 1) . '</td>
				    <td>' . number_format($this->tien_trung, 1) . '</td>
				</tr>';
    }
    public function toHTML_web(): string
    {
        return '<tr role="row" class="">
                    <td role="cell" class="type">' . $this->kieu . '</td>
                    <td role="cell" class="info">' . number_format($this->xac, 1) . '<!----></td>
                    <td role="cell" class="info">' . number_format($this->thuc_thu, 1) . '</td>
                    <td role="cell" class="info">' . number_format($this->tien_trung, 1) . '</td>
                </tr>';
    }
    /**
     * Hàm tạo một html để hiển thị trong trang kiểm tra tin, phần Kiểu, Xác, Thực Thu
     * @param mixed $cac_thong_ke Gồm 2c, 3c, 4c, da...
     */
    public static function toHTMLFormArray(array $cac_thong_ke): string
    {
        $result = '<table> 
                        <thead> <tr><th >Kiểu</th><th >Xác</th><th >Thực thu</th><th >Trúng</th></tr> </thead> 
                        <tbody> ';
        $tong = new tin_thongke(""); //Biến tổng để lưu tổng các thống kê, giúp xuất tổng
        foreach ($cac_thong_ke as $item) {
            //$thong_ke = new tin_thongke('');
            //$thong_ke->sao_chep($item);
            $result .= $item->toHTML(); //xuất các dòng 2c,3c...
            //Lưu vào 
            $tong->xac += $item->xac;
            $tong->thuc_thu += $item->thuc_thu;
            $tong->tien_trung += $item->tien_trung;
        }

        $result .= '<tr> 
                    <td> </td>
				    <td>' . number_format($tong->xac, 1) . '</td>
				    <td>' . number_format($tong->thuc_thu, 1) . '</td>
				    <td>' . number_format($tong->tien_trung, 1) . '</td>
				</tr>';
        $result .= '<tr> 
                <td> </td>
                <td></td>
                <td>Thắng|Thua</td>
                <td>' . number_format($tong->tien_trung - $tong->thuc_thu, 1) . '</td>
            </tr>';
        $result .= '</tbody></table>';

        return $result;
    }
}

?>