<?php
// File class kết quả của đài. Dùng để chứa dữ liệu đọc được từ web 'https://www.minhngoc.com.vn/ket-qua-xo-so/mien-nam.html'

$dir_name = dirname(__FILE__);
include_once(dirname($dir_name) . '/tin/class_tin.php');
include_once(dirname($dir_name) . '/cau_hinh/class_cau_hinh.php');
include_once(dirname($dir_name) . '/tin/class_ds_dai_kieu.php');




class ket_qua_ngay
{
    public $ngay_xo, $ket_qua_cac_dai;
    public function __construct()
    {
        $ket_qua_cac_dai = array();
    }

    public static function LayHTMLKetQua(string $url): string
    {
        $dir_name = dirname(__FILE__);
        $arr_url = explode('/', $url);
        $file_path = dirname($dir_name) . '/ket_qua/' . $arr_url[count($arr_url) - 2] . '/' . $arr_url[count($arr_url) - 1];

        //Kiểm tra quá hạn, nếu quá hạn thì xoá
        if (file_exists($file_path)) {
            //Kiểm tra tập tin đã quá hạn chưa, nếu quá hạn thì xoá.
            $file_modified_time = filemtime($file_path);
            $khoang_thoi_gian_qua_han = time() - (6 * 24 * 60 * 60); // 6 ngày trước
            if ($file_modified_time < $khoang_thoi_gian_qua_han) { //Nếu đã quá hạn
                unlink($file_path);
            }
        }

        // Kiểm tra xem tệp HTML đã tồn tại hay chưa bị xoá thì đọc
        if (file_exists($file_path)) {
            $html = file_get_contents($file_path);
        } else {
            // Nếu không đọc được từ tệp thì đọc từ url và ghi xuống
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url); //Đặt url
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //Đặt ko in ra
            $html = curl_exec($curl);
            if (curl_errno($curl)) {
                $error_message = curl_error($curl);
                // Xử lý lỗi
            }
            curl_close($curl);
            file_put_contents($file_path, $html);
        }

        // Sử dụng nội dung HTML
        return $html;

    }

    public static function LayKetQuaMienNam($day_of_week): ket_qua_ngay
    {
        //==============Chuẩn bị dữ liệu===================
        //Lấy toàn bộ dữ liệu từ web xuống
        $url = ket_qua_ngay::layUrlMienNam($day_of_week);
        $dom_full = new DOMDocument();
        libxml_use_internal_errors(true); //Bao cao cac loi neu co



        //Đọc kết quả sử dụng curl
        $html = ket_qua_ngay::LayHTMLKetQua($url);

        @$dom_full->loadHTML($html);


        $x = new DOMXPath($dom_full);
        //echo $dom_full->saveHTML();
        //Chỉ cắt lấy phần kết quả xổ số cho nhẹ
        $tam = $x->query('//table[@class = "bkqmiennam"]')->item(0);
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $dom_full->saveHTML($tam)); //Lấy phần cần dùng
        $x = new DOMXPath($dom); //Cập nhật lại xpath 

        //Bỏ phần thừa
        unset($dom_full);

        //========== Bóc tách =========

        $ket_qua_ngay = new ket_qua_ngay();

        $ket_qua_ngay->ngay_xo = $x->query('//td[@class = "ngay"]')->item(0)->textContent;

        $cac_cot_ket_qua = $x->query('//table[@class = "rightcl"]'); //Lấy các cột lưu kết quả từng đài trong bảng

        //Với mỗi kết quả của từng đài 
        //echo var_dump($cac_cot_ket_qua);
        foreach ($cac_cot_ket_qua as $cot) {
            //Chuẩn bị dữ liệu ==========
            $dom_sub = new DOMDocument();
            $dom_sub->loadHTML('<?xml encoding="utf-8" ?>' . $dom->saveHTML($cot)); //Chỉ lấy phần cần xử lý
            $x_sub = new DOMXPath($dom_sub);
            //echo $dom_sub->saveHTML();
            //Bóc tách từng đài ==============
            //Lấy tên đài
            $ket_qua_dai = new ket_qua_dai();
            $ket_qua_dai->ten_dai = $x_sub->query("//td[@class = 'tinh']")->item(0)->textContent;
            $ket_qua_dai->ten_dai = trim($ket_qua_dai->ten_dai); //Loại bỏ ký tự thừa
            //echo var_dump($ket_qua_dai);
            $class_name = "";
            for ($i = 0; $i <= 8; $i++) {
                $class_name = ($i == 0) ? "giaidb" : "giai" . $i;
                //echo "class name" . $class_name . "<br/>";
                $query_command = "//td[@class = '" . $class_name . "']/div";
                //echo "query_command: " . $query_command . "<br/>";

                $cac_so_cua_giai = $x_sub->query($query_command);
                //echo "cac_so_cua_giai_lenght" . $cac_so_cua_giai->length . "<br/>";
                for ($j = 0; $j < $cac_so_cua_giai->length; $j++) {
                    if ($j == 0) {
                        $ket_qua_dai->cac_giai[$i] = $cac_so_cua_giai[$j]->textContent;
                    } else {
                        $ket_qua_dai->cac_giai[$i] .= ';' . $cac_so_cua_giai[$j]->textContent;
                    }
                }
            }
            $ket_qua_ngay->ket_qua_cac_dai[] = $ket_qua_dai;
            //echo "<br/>-----------<br/>";

        }
        unset($dom_sub);
        unset($dom);
        unset($x_sub);
        unset($x);

        //echo var_dump($ket_qua_ngay);
        return $ket_qua_ngay;
    }

    //=============================================Lấy kết quả miền Bắc =========================================
    public static function LayKetQuaMienBac(int $day_of_week): ket_qua_ngay
    {
        //==============Chuẩn bị dữ liệu===================
        //Lấy toàn bộ dữ liệu từ web xuống
        $url = ket_qua_ngay::layUrlMienBac($day_of_week);
        $dom_full = new DOMDocument();
        libxml_use_internal_errors(true); //Bao cao cac loi neu co
        //Đọc kết quả sử dụng curl
        $html = ket_qua_ngay::LayHTMLKetQua($url);

        @$dom_full->loadHTML($html);


        $x = new DOMXPath($dom_full);
        //echo $dom_full->saveHTML();
        //Chỉ cắt lấy phần kết quả xổ số cho nhẹ
        $tam = $x->query('//table[@class = "bkqtinhmienbac"]')->item(0);
        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $dom_full->saveHTML($tam)); //Lấy phần cần dùng
        $x = new DOMXPath($dom); //Cập nhật lại xpath 

        //Bỏ phần thừa
        unset($dom_full);
        //echo $dom->saveHTML();

        //========== Bóc tách =========

        $ket_qua_ngay = new ket_qua_ngay();

        $ket_qua_ngay->ngay_xo = $x->query('//div[@class = "ngay"]/a')->item(0)->textContent;
        //echo $ket_qua_ngay->ngay_xo;



        //Chuẩn bị dữ liệu ==========

        //Lấy tên đài
        $ket_qua_dai = new ket_qua_dai();
        $ket_qua_dai->ten_dai = "Miền Bắc";
        //echo var_dump($ket_qua_dai);
        $class_name = ""; //Biến chứa tên class để truy vấn XPath
        for ($i = 0; $i < 8; $i++) { //Chạy từ giải đb đến giải 7
            $class_name = ($i == 0) ? "giaidb" : "giai" . $i; //tạo class name tương ứng để truy vấn
            //echo "class name" . $class_name . "<br/>";
            $query_command = "//td[@class = '" . $class_name . "']/div"; //Tạo chuỗi truy vấn XPath
            //echo "query_command: " . $query_command . "<br/>";

            $cac_so_cua_giai = $x->query($query_command);
            //echo "cac_so_cua_giai_lenght" . $cac_so_cua_giai->length . "<br/>";
            //Tạo một chuỗi các số kết quả cách nhau bởi dấu chấm phẩy ;
            for ($j = 0; $j < $cac_so_cua_giai->length; $j++) {
                if ($j == 0) {
                    $ket_qua_dai->cac_giai[$i] = $cac_so_cua_giai[$j]->textContent;
                } else {
                    $ket_qua_dai->cac_giai[$i] .= ';' . $cac_so_cua_giai[$j]->textContent;
                }
            }
        }
        $ket_qua_ngay->ket_qua_cac_dai[] = $ket_qua_dai;

        unset($dom);
        unset($x);

        //echo var_dump($ket_qua_ngay);
        return $ket_qua_ngay;
    }

    //=====================Lấy url miền nam theo day_of_weed ====================
    private static function layUrlMienNam(int $day_of_week): string
    {
        $url_arr = array(
            0 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-nam/chu-nhat.html",
            1 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-nam/thu-hai.html",
            2 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-nam/thu-ba.html",
            3 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-nam/thu-tu.html",
            4 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-nam/thu-nam.html",
            5 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-nam/thu-sau.html",
            6 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-nam/thu-bay.html"
        );
        return $url_arr[$day_of_week];
    }
    //=====================Lấy url miền nam theo day_of_weed ====================
    private static function layUrlMienBac(int $day_of_week): string
    {
        $url_arr = array(
            0 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-bac/chu-nhat.html",
            1 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-bac/thu-hai.html",
            2 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-bac/thu-ba.html",
            3 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-bac/thu-tu.html",
            4 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-bac/thu-nam.html",
            5 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-bac/thu-sau.html",
            6 => "https://www.minhngoc.com.vn/ket-qua-xo-so/mien-bac/thu-bay.html"
        );
        return $url_arr[$day_of_week];
    }
    //=====================Lấy ngày xổ Miền Mam =================================
    public static function LayNgayXoMienNam(): string
    {
        //==============Chuẩn bị dữ liệu===================
        //Lấy toàn bộ dữ liệu từ web xuống
        $url = 'https://www.minhngoc.com.vn/ket-qua-xo-so/mien-nam.html';
        $dom = new DOMDocument();
        libxml_use_internal_errors(true); //Bao cao cac loi neu co
        $dom->loadHTMLFile($url);
        $x = new DOMXPath($dom);
        $kq = $x->query('//td[@class = "ngay"]')->item(0)->textContent;
        unset($x);
        unset($dom);
        //echo $kq;
        return $kq;
    }


    //================================
    //Trả về một mảng là các ket_qua_ngay sắp theo cấu hình
    function LayMangSapThuTuKetQuaDai(cau_hinh $cau_hinh): array
    {
        //Lấy thứ tự trong tuần của ngày xổ, từ 0 - 6
        $date = str_replace('/', '-', $this->ngay_xo);
        $ngay_trong_tuan = date('w', strtotime($date));
        //Tạo mảng lưu kết quả, 
        $kq_dai_theo_thu_tu = array();
        //$so_dai = (int)sizeof($this->ket_qua_cac_dai); //Lấy số đài xổ ngày hôm đó

        //Lấy số kq theo số đài xổ ngày hôm đó
        $ten_dai_theo_thu_tu = $cau_hinh->getTenDaiTheoNgay($ngay_trong_tuan);
        $arr_ten_dai = explode(";", $ten_dai_theo_thu_tu);
        for ($i = 0; $i < sizeof($arr_ten_dai); $i++) {

            foreach ($this->ket_qua_cac_dai as $ketqua) {
                if ($ketqua->ten_dai === $arr_ten_dai[$i])
                    $kq_dai_theo_thu_tu[] = $ketqua;
            }

        }
        //echo json_encode( $thu_tu_dai);
        return $kq_dai_theo_thu_tu;
    }
    /**
     * Hàm lấy kết quả đài theo tên đài
     * @param string $tendai tên đài ở dạng viết tắt.
     * 
     */
    public function layKetQuaDai(string $tendai): ket_qua_dai
    {
        if ($tendai === "mb" || $tendai === "Miền Bắc")
            return $this->ket_qua_cac_dai[0];


        $ngay_xo = str_replace('/', '-', $this->ngay_xo); //Chuyển dạng dd/mm/yyyy sang dd-mm-yyyy để php nhận dạng đúng
        $day_of_week = date('w', strtotime($ngay_xo));
        $ds_dai = new DanhSachDai();
        $ten_dai_day_du = $ds_dai->LayTenTheoVietTat($tendai, $day_of_week);
        foreach ($this->ket_qua_cac_dai as $ketqua) {

            if ($ketqua->ten_dai === $ten_dai_day_du)
                return $ketqua;
        }
        return new ket_qua_dai();
    }

    function DaXien(chi_tiet_tin $chi_tiet, float $trung): chi_tiet_tin
    {
        $cac_so = explode(' ', $chi_tiet->so); //Tách dãy các số thành mảng

        $mang_cac_dai = explode(',', $chi_tiet->dai);

        $ket_qua1 = $this->layKetQuaDai($mang_cac_dai[0]);
        $ket_qua2 = $this->layKetQuaDai($mang_cac_dai[1]);
        foreach ($cac_so as $so) { //Với mỗi số
            $so1 = substr($so, 0, 2);
            $so2 = substr($so, -2);
            $so_lan_so1_xuat_hien = $so_lan_so2_xuat_hien = 0;
            $so_lan_so1_xuat_hien += $ket_qua1->SoLanXuatHienBaoLo($so1);
            $so_lan_so1_xuat_hien += $ket_qua2->SoLanXuatHienBaoLo($so1);
            $so_lan_so2_xuat_hien += $ket_qua1->SoLanXuatHienBaoLo($so2);
            $so_lan_so2_xuat_hien += $ket_qua2->SoLanXuatHienBaoLo($so2);
            $so_lan_xuat_hien_cua_ca_2_so = min($so_lan_so1_xuat_hien, $so_lan_so2_xuat_hien);
            if ($so_lan_xuat_hien_cua_ca_2_so > 0) { //Nếu cả hai số đều xuất hiện ít nhất 1 lần
                //Cập nhật kết quả
                $chi_tiet->tien_trung = ($chi_tiet->tien_trung == -1) ?
                    $chi_tiet->diem * $trung * $so_lan_xuat_hien_cua_ca_2_so :
                    $chi_tiet->tien_trung + ($chi_tiet->diem * $trung * $so_lan_xuat_hien_cua_ca_2_so);
                $chi_tiet->so_trung .= 'da_' . $so . '_' . ($chi_tiet->diem * $so_lan_xuat_hien_cua_ca_2_so) . 'n;';
            }
        }
        return $chi_tiet;
    }

}

//======================================Class Ket Qua Dai ==========================
class ket_qua_dai
{
    public $ten_dai, $cac_giai = array();
    public function __construct()
    {
        $ten_dai = '';
        $cac_giai = array();
    }

    function HaiConDau(chi_tiet_tin $chi_tiet, float $trung): chi_tiet_tin
    {
        $giai_can_lay = (sizeof($this->cac_giai) == 9) ? 8 : 7; //Nam lấy 8, bắc lấy 7
        $cac_so = explode(' ', $chi_tiet->so);
        $size_of_cac_so = sizeof($cac_so);
        foreach ($cac_so as $so) {
            $giai = $this->cac_giai[$giai_can_lay];
            if (strpos($giai, $so) !== false) {
                $chi_tiet->tien_trung += ($chi_tiet->xac / $size_of_cac_so) * $trung;
                $chi_tiet->so_trung .= "2c-dau_" . $so . "_" . ($chi_tiet->xac / $size_of_cac_so) . "n;";
            }
        }

        return $chi_tiet;
    }

    //Hàm so sánh 2 con đuôi, 2 số cuối giải ĐB
    function HaiConDuoi(chi_tiet_tin $chi_tiet, float $trung): chi_tiet_tin
    {
        $cac_so = explode(' ', $chi_tiet->so);
        $size_of_cac_so = sizeof($cac_so);

        $hai_so_cuoi_db = substr($this->cac_giai[0], -2); //lay 2 so cuoi giai dac biet


        foreach ($cac_so as $so) {

            if ($so == $hai_so_cuoi_db) { //So mỗi số với 2 số cuối giải đặc biệt
                $chi_tiet->tien_trung += ($chi_tiet->xac / $size_of_cac_so) * $trung;
                $chi_tiet->so_trung .= "2c-duoi_" . $so . "_" . ($chi_tiet->xac / $size_of_cac_so) . "n;";
            }
        }

        return $chi_tiet;
    }

    //So sánh 2 con bao, tất cả giải
    function Bao(chi_tiet_tin $chi_tiet, float $trung): chi_tiet_tin
    {
        $cac_so = explode(' ', $chi_tiet->so);
        $con = strlen($cac_so[0]);
        $giai_bat_dau_soi = (sizeof($this->cac_giai) + 1) - $con; //Lấy vị trí giải bắt đầu soi trở về 0
        foreach ($cac_so as $so) {
            for ($i = $giai_bat_dau_soi; $i >= 0; $i--) { //Soi từng giải
                $giai = $this->cac_giai[$i];
                $mang_cac_so_cua_giai = explode(';', $giai); //Phân tách các số của giải
                foreach ($mang_cac_so_cua_giai as $so_cua_giai) { //Với mỗi số của giải, lấy só cuối, có thể là 2, 3, 4 số cuối
                    $so_cuoi = substr($so_cua_giai, (-1 * $con));
                    if ($so == $so_cuoi) { //So sánh số cuối, nếu bằng thì cập nhật 

                        $chi_tiet->tien_trung += $chi_tiet->diem * $trung;
                        $chi_tiet->so_trung .= $con . 'c-bao_' . $so . '_' . $chi_tiet->diem . 'n;';
                    }
                }
            }
        }
        return $chi_tiet;
    }
    //So sánh 2 con bao, tất cả giải
    function BayLo2con(chi_tiet_tin $chi_tiet, float $trung): chi_tiet_tin
    {
        $cac_so = explode(' ', $chi_tiet->so);
        foreach ($cac_so as $so) {
            for ($i = 8; $i >= 5; $i--) { //Soi từ giải 8 đến giải 5
                $giai = $this->cac_giai[$i];
                $mang_cac_so_cua_giai = explode(';', $giai); //Phân tách các số của giải
                foreach ($mang_cac_so_cua_giai as $so_cua_giai) { //Với mỗi số của giải, lấy 2 số cuối
                    $so_cuoi = substr($so_cua_giai, -2); 
                    if ($so == $so_cuoi) { //So sánh hai số cuối, nếu bằng thì cập nhật 

                        $chi_tiet->tien_trung += $chi_tiet->diem * $trung;
                        $chi_tiet->so_trung .= '2c-baylo_' . $so . '_' . $chi_tiet->diem . 'n;';
                    }
                }
            }
            //Giải đặc biệt
            $so_cuoi = substr($this->cac_giai[0], -2); //Lấy 2 số cuối db
            if ($so == $so_cuoi) { //So sánh hai số cuối, nếu bằng thì cập nhật 

                $chi_tiet->tien_trung += $chi_tiet->diem * $trung;
                $chi_tiet->so_trung .= '2c-baylo_' . $so . '_' . $chi_tiet->diem . 'n;';
            } 
        }
        return $chi_tiet;
    }

    function BayLo3con(chi_tiet_tin $chi_tiet, float $trung): chi_tiet_tin
    {
        $cac_so = explode(' ', $chi_tiet->so);
        foreach ($cac_so as $so) {
            for ($i = 7; $i >= 5; $i--) { //Soi từ giải 7 đến giải 5
                $giai = $this->cac_giai[$i];
                $mang_cac_so_cua_giai = explode(';', $giai); //Phân tách các số của giải
                foreach ($mang_cac_so_cua_giai as $so_cua_giai) { //Với mỗi số của giải, lấy 3 số cuối
                    $so_cuoi = substr($so_cua_giai, -3); 
                    if ($so == $so_cuoi) { //So sánh, nếu bằng thì cập nhật 

                        $chi_tiet->tien_trung += $chi_tiet->diem * $trung;
                        $chi_tiet->so_trung .= '3c-baylo_' . $so . '_' . $chi_tiet->diem . 'n;';
                    }
                }
            }
            //Số đầu tiên giải 4
             $giai_tu  = explode(';', $this->cac_giai[4]);
             $so_dau_giai_tu = $giai_tu[0];
             $so_cuoi = substr($so_dau_giai_tu, -3); //Lấy 3 chữ số cuối
             if ($so == $so_cuoi) { //So sánh, nếu bằng thì cập nhật 
 
                 $chi_tiet->tien_trung += $chi_tiet->diem * $trung;
                 $chi_tiet->so_trung .= '3c-baylo_' . $so . '_' . $chi_tiet->diem . 'n;';
             } 
            //Giải đặc biệt
            $so_cuoi = substr($this->cac_giai[0], -3); //Lấy 3 số cuối db
            if ($so == $so_cuoi) { //So sánh, nếu bằng thì cập nhật 

                $chi_tiet->tien_trung += $chi_tiet->diem * $trung;
                $chi_tiet->so_trung .= '3c-baylo_' . $so . '_' . $chi_tiet->diem . 'n;';
            } 
        }
        return $chi_tiet;
    }
    //Hàm soi đánh 3 con đầu. Miền Nam giải 7, miền bắc Giải 6
    function XiuDau(chi_tiet_tin $chi_tiet, float $trung): chi_tiet_tin
    {
        $vi_tri_giai_can_lay = (sizeof($this->cac_giai) == 9) ? 7 : 6; //Nam lấy 7, bắc lấy 6
        $giai_can_lay = $this->cac_giai[$vi_tri_giai_can_lay];
        $mang_cac_so_cua_giai = explode(';', $giai_can_lay); //Tách các số của giải thành mảng

        $cac_so = explode(' ', $chi_tiet->so); //Tách dãy các cần soi  thành mảng
        //$size_of_cac_so = sizeof($cac_so); //Số lượng số cần soi

        foreach ($cac_so as $so) {
            foreach ($mang_cac_so_cua_giai as $so_cua_giai) { //Với mỗi số, lấy 3 só cuối
                $ba_so_cuoi = substr($so_cua_giai, -3);
                if ($so === $ba_so_cuoi) { //So sánh ba số cuối, nếu bằng thì cập nhật 

                    //$xac_cua_so = $chi_tiet->xac / $size_of_cac_so;
                    $chi_tiet->tien_trung += $chi_tiet->diem * $trung;
                    $chi_tiet->so_trung .= '3c_' . $so . '_' . $chi_tiet->diem . 'n;';
                }
            }
        }
        return $chi_tiet;
    }

    //Hàm soi đánh 3 con đuôi, 3 số cuối giải ĐB
    function XiuDuoi(chi_tiet_tin $chi_tiet, float $trung): chi_tiet_tin
    {


        $cac_so = explode(' ', $chi_tiet->so); //Tách dãy các cần soi  thành mảng
        $size_of_cac_so = sizeof($cac_so); //Số lượng số cần soi

        $giai_db = $this->cac_giai[0];
        $ba_so_cuoi = substr($giai_db, -3);

        foreach ($cac_so as $so) {
            if ($so === $ba_so_cuoi) { //So sánh ba số cuối, nếu bằng thì cập nhật 

                //$xac_cua_so = $chi_tiet->xac / $size_of_cac_so;
                $chi_tiet->tien_trung += $chi_tiet->diem * $trung;
                $chi_tiet->so_trung .= '3c_' . $so . '_' . $chi_tiet->diem . 'n;';
            }

        }
        return $chi_tiet;
    }



    /**
     * Hàm soi kiểu Đá Thẳng
     */
    function Da(chi_tiet_tin $chi_tiet, float $trung): chi_tiet_tin
    {
        $cac_so = explode(' ', $chi_tiet->so); //Tách dãy các số thành mảng
        foreach ($cac_so as $so) { //Với mỗi số
            $so1 = substr($so, 0, 2);
            $so2 = substr($so, -2);
            $so_lan_so1_xuat_hien = $so_lan_so2_xuat_hien = 0;
            $so_lan_so1_xuat_hien += $this->SoLanXuatHienBaoLo($so1);
            $so_lan_so2_xuat_hien += $this->SoLanXuatHienBaoLo($so2);
            $so_lan_xuat_hien_cua_ca_2_so = min($so_lan_so1_xuat_hien, $so_lan_so2_xuat_hien);
            if ($so_lan_xuat_hien_cua_ca_2_so > 0) { //Nếu cả hai số đều xuất hiện ít nhất 1 lần
                //Cập nhật kết quả
                $chi_tiet->tien_trung += $chi_tiet->diem * $trung * $so_lan_xuat_hien_cua_ca_2_so;
                $chi_tiet->so_trung .= 'da_' . $so . '_' . ($chi_tiet->diem * $so_lan_xuat_hien_cua_ca_2_so) . 'n;';
            }
        }
        return $chi_tiet;
    }

    /**
     * Hàm đếm số lần xuất hiện của số trong kết quả (Soi đuôi)
     */
    function SoLanXuatHienBaoLo(string $so): int
    {
        $so_lan_xuat_hien = 0;
        $con = strlen($so);
        $giai_bat_dau_soi = (count($this->cac_giai) + 1) - $con; //Lấy vị trí giải bắt đầu soi trở về 0
        for ($i = $giai_bat_dau_soi; $i >= 0; $i--) { //Soi từng giải
            $giai = $this->cac_giai[$i];
            $mang_cac_so_cua_giai = explode(';', $giai); //Phân tách các số của giải
            foreach ($mang_cac_so_cua_giai as $so_cua_giai) { //Với mỗi số của giải, lấy só cuối, có thể là 2, 3, 4 số cuối
                $so_cuoi = substr($so_cua_giai, (-1 * $con));
                if ($so == $so_cuoi) //So sánh số cuối, nếu bằng thì cập nhật 
                    $so_lan_xuat_hien++;
            }
        }
        return $so_lan_xuat_hien;
    }

}



?>