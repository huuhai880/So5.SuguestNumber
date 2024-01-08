<?php
$dir_name = dirname(__FILE__);
include_once($dir_name . '/class_ds_dai_kieu.php');
include_once($dir_name . '/class_tin.php');
include_once(dirname($dir_name) . '/cau_hinh/class_cau_hinh.php');

class ChiTietBocTach
{
    public $dai, $so = array(), $kieu, $diem;
    public function XuatHTML()
    {
        $html = "<p>" . $this->dai . implode('.', $this->so) . $this->kieu . $this->diem . '</p>';
        echo $html;
    }
    /**
     * Hàm kiểm tra hai chi tiết liên tục có nằm trong một chuỗi viết tắt kiểu bao hay không
     */
    public static function CungSoBaoLo(ChiTietBocTach $chi_tiet_truoc, ChiTietBocTach $chi_tiet_hien_tai) : bool{
        if($chi_tiet_truoc->kieu !== $chi_tiet_hien_tai->kieu)
            return false;
        if($chi_tiet_truoc->dai !== $chi_tiet_hien_tai->dai)
            return false;
        if(count($chi_tiet_truoc->so) != count($chi_tiet_hien_tai->so))
            return false;
        for ($i=0; $i < count($chi_tiet_truoc->so); $i++) { 
            if($chi_tiet_truoc->so[$i] != $chi_tiet_hien_tai->so[$i])
                return false;
        }

        for ($i=0; $i < count($chi_tiet_truoc->so); $i++) { 
            $so_truoc = $chi_tiet_truoc->so[$i];
            $so_hien_tai = substr($chi_tiet_hien_tai->so[$i], strlen($chi_tiet_hien_tai->so[$i]) - strlen($so_truoc) );
            if($so_truoc != $so_hien_tai)
                return false;
        }
        return true;
    }
}
class NoiDungTin
{
    public static $thu_dais = array(
        0 => array('tg', 'kg', 'dl'),
        1 => array('tp', 'dt', 'cm'),
        2 => array('bt', 'vt', 'blieu'),
        3 => array('dn', 'ct', 'st'),
        4 => array('tn', 'ag', 'bt'),
        5 => array('vl', 'sbe', 'tv'),
        6 => array('tp', 'la', 'bp', 'hg')
    );
    private $noi_dung_arr = array();
    private $day_of_week;
    public $noi_dung_str;
    private $tai_khoan_danh;
    function __construct(string $noi_dung, int $day_of_week, string $tai_khoan_danh)
    {
        $this->tai_khoan_danh = $tai_khoan_danh;
        $this->day_of_week = $day_of_week;
        $noi_dung_chuan_hoa = $this->ChuanHoa($noi_dung);
        $this->noi_dung_str = $noi_dung_chuan_hoa;
        $tin_tach_theo_khoang_trang = explode(" ", $noi_dung_chuan_hoa);
        $this->noi_dung_arr = $tin_tach_theo_khoang_trang;
        //$this->noi_dung_arr = NoiDungTin::XuLySoKeo($tin_tach_theo_khoang_trang);
    }

    public static function ChuanHoa($tin): string
    {
        //Chữ thường
        $tin = mb_strtolower($tin, 'UTF-8');
        //Bỏ unicode
        $tin = str_replace('đ', 'd', $tin);
        $tin = str_replace(array('â', 'á', 'ă'), 'a', $tin);
        $tin = str_replace('ô', 'o', $tin);
        $tin = str_replace('ơ', 'o', $tin);
        $tin = str_replace('ư', 'u', $tin);


        //Thêm khoảng trắng
        
        
        
        $tin = str_replace(array("\r", "\n", "\r\n"), ' ', $tin); //Thay ký tự xống dòng bằng khoảng trắng
        $tin = preg_replace('/(\d+)([a-zA-Z]+)/', '$1 $2', $tin); //Thêm khoảng trắng vào số và chữ
        $tin = preg_replace('/([a-zA-Z]+)(\d+)/', '$1 $2', $tin); //Thêm khoảng trắng vào chữ và số
        $tin = preg_replace('/(\s)([n])([^a-z]*)/', '$1 $3', $tin); //Xoá chữ n thay bằng khoảng trắng

        //Thay dấu chấm nhằm ở điểm bằng dấu phẩy. Đặc thù của điểm là sau dấu phẩy chỉ có một chữ số.
        $tin = preg_replace('/(\D\d+)(\.)(\d\D|\d$)/', '$1,$3', $tin);
        //Thay dấu chấm giữa hai đài bằng dấu phẩy
        $tin = preg_replace('/(^|\s)(hn|mb|hanoi|tp|hcm|dt|cm|camau|bt|btr|btre|vt|blieu|baclieu|dn|ct|st|soctrang|tn|ag|bt|binhthuan|vl|sbe|bd|sb|tv|travinh|la|hg|haugiang|tg|kg|dl|dalat|bp|binhphuoc)(\s*)(.)(\s*)(hn|mb|hanoi|tp|hcm|dt|cm|camau|bt|btr|btre|vt|blieu|baclieu|dn|ct|st|soctrang|tn|ag|bt|binhthuan|vl|sbe|bd|sb|tv|travinh|la|hg|haugiang|tg|kg|dl|dalat|bp|binhphuoc)(\s)/', '$1$2$3,$5$6$7', $tin);
        $tin = str_replace(array('.','-', ';', ':', '\'', '\"'), ' ', $tin); //Thay các ký tự phân cách bằng khoảng trắng

        //Thay dấu phẩy nằm giữa mà hai bên đều có ít nhất 2 chữ số (và có thể có khoảng trắng)bằng khoảng trắng
        $tin = preg_replace('/(?<=\d{2})\s*,\s*(?=\d{2})/', ' ', $tin);
        $tin = preg_replace('/[,|.]$/', ' ', $tin);
        //Thay dấu phẩy nằm giữa mà hai bên có một bên là số và một bên là chữ (và có thể có khoảng trắng)bằng khoảng trắng
        $tin = preg_replace('/(?<=[a-z])\s*,\s*(?=\d)|(?<=\d)\s*,\s*(?=[a-z])/', ' ', $tin);


        //Bỏ khoảng trắng
        $tin = preg_replace('/\s{2,}/', ' ', $tin); //Tìm trên 2 khoảng trắng liên tục thay bằng 1 khoảng trắng
        $tin = trim($tin); //Xoá khoảng trắng thừa đầu cuối
        $tin = preg_replace('/(^|\s)([1-9])(\s)(d)(\s)/', '$1$2$4$5', $tin); //Khôi phục khoảng trắng giữa số và d
        $tin = preg_replace('/(\s)(,)/', '$2', $tin); //Bỏ khoảng trắng trước dấu phẩy
        $tin = preg_replace('/(,)(\s)/', '$2', $tin); //Bỏ khoảng trắng sau dấu phẩy
        $tin = preg_replace('/(\s)(k|keo)(\s)/', '$2', $tin); //Bỏ khoảng trắng trước và sau k|keo
        $tin = preg_replace('/(1|2|3|4)(\s)(dai)/', '$1$3', $tin); //Bỏ khoảng trắng giữ 1,2,3,4 vài dai
        $tin = preg_replace('/(\s)(dau|a|duoi|dui|d|dd|dauduoi|daudui|ab|b|bao|bl|blo|lo|doc|baodao|daolo|dlo|bld|bdao|dbao|db|bd|blodao|dbl|bldao)(\s)(0)(1|2|3|4|5|6|7|8|9)(\s|$)/', ' $2 0,$5 $6',$tin);
        $tin = preg_replace('/(\s)(xc|x|tl|tlo|sc|siu|xdau|xcdau|tldau|tlodau|xduoi|xcdui|xcduoi|xdui|tldui|tlduoi|tlodui|tloduoi)(\s)(0)(1|2|3|4|5|6|7|8|9)(\s|$)/', ' $2 0,$5 $6',$tin);
        $tin = preg_replace('/(\s)(xd|xcd|dxc|daox|daoxc|xdao|xcdao|tld|dtl|daotl|tldao|tlod|dtlo|daotlo|tlodao|suidao)(\s)(0)(1|2|3|4|5|6|7|8|9)(\s|$)/', ' $2 0,$5 $6',$tin);
        $tin = preg_replace('/(\s)(xdaudao|xddau|daoxdau|xcdaudao|daoxcdau|tldaudao|daotldau|tlduidao|tlodaudao|daotlodau)(\s)(0)(1|2|3|4|5|6|7|8|9)(\s|$)/', ' $2 0,$5 $6',$tin);
        $tin = preg_replace('/(\s)(xduoidao|xduidao|xddui|xdduoi|daoxdui|daoxduoi|xcduidao|xcduoidao|daoxcdui|daoxcduoi|tlduoidao)(\s)(0)(1|2|3|4|5|6|7|8|9)(\s|$)/', ' $2 0,$5 $6',$tin);
        $tin = preg_replace('/(\s)(daotldui|daotlduoi|tloduidao|tloduoidao|daotlodui|daotloduoi|da|dat|dv|dav|dx|dax|dxien|daxien|cheo|dxv|daxv|dvx)(\s)(0)(1|2|3|4|5|6|7|8|9)(\s|$)/', ' $2 0,$5 $6',$tin);
        $tin = preg_replace('/\s{2,}/', ' ', $tin); //Tìm trên 2 khoảng trắng liên tục thay bằng 1 khoảng trắng
        $tin = trim($tin); //Xoá khoảng trắng thừa đầu cuối
        return $tin;

    }
    public static function XuLySoKeo(array $tin_kieu_array): array
    {
        $ket_qua = array();
        foreach ($tin_kieu_array as $item) {
            if(NoiDungTin::LaSoKeo($item)){
                $so_ben_trai = $so_ben_phai = 0;
                NoiDungTin::LaySoCuaSoKeo($item, $so_ben_trai, $so_ben_phai);
                $step_length = 0;
                $so_ky_tu = strlen($so_ben_phai);
                //if(strlen($so_ben_trai) == 2){ //Trường hợp số kéo 2 chữ số
                    if(preg_match('/^(\d)\1*$/', $so_ben_trai) && preg_match('/^(\d)\1*$/', $so_ben_phai)) //Nếu dạng 11,22...
                        $step_length = 11;
                    else if (($so_ben_phai - $so_ben_trai) % 1000 == 0)
                        $step_length = 1000;
                        else if(($so_ben_phai - $so_ben_trai) % 100 == 0)
                            $step_length = 100;
                            else if(($so_ben_phai - $so_ben_trai) % 10 == 0)
                                $step_length = 10;
                            else
                                $step_length = 1;
                // 
                for ($i=$so_ben_trai; $i <= $so_ben_phai ; $i += $step_length) 
                    $ket_qua[] = str_pad($i, $so_ky_tu, "0", STR_PAD_LEFT);        
            }
            else
                $ket_qua[] = $item;   
            }
        return $ket_qua;
    }
    public function LayDsTenDaiVietTat(): array
    {
        $result = array();

        $cau_hinh = cau_hinh::LayCauHinh($this->tai_khoan_danh);
        $ten_cac_dai_day_du_theo_thu_tu = $cau_hinh->lay_ten_dai_theo_thu_tu($this->day_of_week);
        $mang_ten_day_du = explode(';', $ten_cac_dai_day_du_theo_thu_tu);
        $ds_dai = new DanhSachDai();
        foreach ($mang_ten_day_du as $ten_day_du) {
            $result[] = $ds_dai->LayVietTatTheoTen($ten_day_du);
        }
        return $result;
    }
    /**
     * Hàm bóc tách Đài Số Kiểu
     * @return array:chi_tiet_tin
     */
    public function BocTachDaiSoKieu(): array
    {
        $ket_qua = array();
        $this->noi_dung_arr = $this::XuLySoKeo($this->noi_dung_arr);
        $ds_dai = new DanhSachDai();
        $ds_kieu = new DanhSachKieu();
        $ds_dai_viettat_theothutu = $this->LayDsTenDaiVietTat();
        $size = count($this->noi_dung_arr);
        for ($i = 2; $i < $size; $i++) { //Chỉ tìm kiểu nên bắt đầu bằng 2 vì 0 đài 1 số
            if ($this->laKieu($i)) {

                $chi_tiet_boc_tach = new ChiTietBocTach();
                //Kiểu, chuẩn hoá về viết tắt
                $kieu_viet_tat = $ds_kieu->LayVietTatTheoCode($this->noi_dung_arr[$i]);
                $chi_tiet_boc_tach->kieu = $kieu_viet_tat;
                //Đài, chuẩn hoá về viết tắt
                $vi_tri_dai_cua_kieu = $this->LayViTriDaiCuaKieu($i); //Đài
                
                if (preg_match("/1d|2d|3d|4d|1dai|2dai|3dai|4dai/", $this->noi_dung_arr[$vi_tri_dai_cua_kieu]))
                    $chi_tiet_boc_tach->dai = $this->noi_dung_arr[$vi_tri_dai_cua_kieu];
                else
                    $chi_tiet_boc_tach->dai = $ds_dai->LayVietTatTheoCode($this->noi_dung_arr[$vi_tri_dai_cua_kieu]);

                //Số
                $chi_tiet_boc_tach->so = $this->LaySoCuaKieu($i); //Số

                //Điểm, chuẩn hoá về dấu . thay cho dấu, để đúng định dạng kiểu số thực
                $vi_tri_diem_cua_kieu = $this->LayViTriDiemCuaKieu($i); //Điểm

            
                if(isset($this->noi_dung_arr[$vi_tri_diem_cua_kieu])){
                    $chi_tiet_boc_tach->diem = str_replace(',', '.', $this->noi_dung_arr[$vi_tri_diem_cua_kieu]);
                }
                
                $ket_qua[] = $chi_tiet_boc_tach;
            }
        }

        // $ket_qua = NoiDungTin::TachTinTheoSoCon($ket_qua);

        // $ket_qua = NoiDungTin::ChuanHoaSoTheoKieu($ket_qua);

        $ket_qua = NoiDungTin::Doi2D3DThanhTenDai($ket_qua, $ds_dai_viettat_theothutu);
        $ket_qua = NoiDungTin::DoiChanhPhuThanhTenDai($ket_qua, $ds_dai_viettat_theothutu);
        $ket_qua = NoiDungTin::TachTinTheoSoLuongDai($ket_qua);
        $ket_qua = NoiDungTin::TachTinTheoKieuCoBan($ket_qua);
        $ket_qua_ChiTietTin = NoiDungTin::ChiTietBocTach_to_ChiTietTin($ket_qua);
        return $ket_qua_ChiTietTin;
    }


    public function laDai(int $index): bool
    {
        if ($index < 0 || $index >= count($this->noi_dung_arr))
            return false;

        $item = $this->noi_dung_arr[$index];
        if (preg_match('/[a-z]/', $item) == false) //Nếu không có chữ cái nào thì sai
            return false;
        if(preg_match("/1d|2d|3d|4d|1dai|2dai|3dai|4dai|dc|dp|chinh|chanh|phu/", $item)) //Nếu là 1 từ 2d, 3d... thì đúng
            return true;
        $item_arr = explode(',', $item);
        if(count($item_arr) > 4)
            return false;
        $ds_dai = new DanhSachDai();
        foreach ($item_arr as $code) {
            if(preg_match("/1d|2d|3d|4d|1dai|2dai|3dai|4dai/", $code))
                return false;
            if ($ds_dai->LaCodeDai($code, $this->day_of_week) == false)
                return false;
        }
        return true;
    }


    public function laKieu(int $index): bool
    {
        if ($index <= 1 || $index >= count($this->noi_dung_arr))
            return false;
        $item = $this->noi_dung_arr[$index];
        if (preg_match('/[0-9]/', $item)) //Kiểu ko đc chứa số
            return false;

        $ds_kieu = new DanhSachKieu();
        return $ds_kieu->LaCodeKieu($item, $this->day_of_week);
    }
    public function laSo(int $index): bool
    {
        if ($index < 1 || $index >= count($this->noi_dung_arr))
            return false;
        //Kiểm tra bản thân đúng định dạng số không?
        $item = $this->noi_dung_arr[$index];
        $chi_chua_ky_tu_so = preg_match('/^[0-9]+$/', $item); //Chỉ chứa ký tự số
        $la_k_hoac_keo = preg_match('/^(\d{2,4})(k|keo)(\d{2,4})$/', $item); //dạng \d k \d hoặc\d keo \d
        $la_so = $chi_chua_ky_tu_so || $la_k_hoac_keo;

        //Bên trái của vị trí đang xét phải là đài hoặc một phần tử chỉ chứa số
        $ben_trai_la_dai = $this->laDai($index - 1);
        $ben_trai_la_so = preg_match('/^[0-9]+([,][0-9]+)?$/', $this->noi_dung_arr[$index - 1]); //Chứa số và dấu phẩy
        $ben_trai_hop_le = $ben_trai_la_dai || $ben_trai_la_so;

        if ($la_so && $ben_trai_hop_le)
            return true;

        return false;
    }

    public function laDiem(int $index): bool
    {
        if ($index <= 1 || $index >= count($this->noi_dung_arr))
            return false;
        if($this->noi_dung_arr[$index] === "05")
            return false;

        //Kiểm tra bản thân đúng định dạng số không?
        $chi_so_hoac_dau_phay = preg_match('/^[0-9]+([,][0-9])?$/', $this->noi_dung_arr[$index]); //chỉ số hoac dấu phẩy

        //Bên trái là kiểu
        $ben_trai_la_kieu = $this->laKieu($index - 1);

        if ($chi_so_hoac_dau_phay && $ben_trai_la_kieu)
            return true;
        return false;
    }
    public function LayViTriDaiCuaKieu(int $index_of_kieu): int
    {
        if ($index_of_kieu < 0 || $index_of_kieu >= count($this->noi_dung_arr))
            return -1; //Không hợp lệ

        $vi_tri_dai = $index_of_kieu - 1;
        while ($vi_tri_dai >= 0) {
            if ($this->laDai($vi_tri_dai))
                return $vi_tri_dai;

            $vi_tri_dai--;
        }
        return -1;
    }

    public function LaySoCuaKieu(int $index_of_kieu): array
    {
        $result = array();
        if ($index_of_kieu <= 0 || $index_of_kieu >= count($this->noi_dung_arr))
            return $result; //Không hợp lệ, return empty array

        $i = $index_of_kieu-1;

        while ($i > 0) {
            
            if ($this->laSo($i)) {

                $result[] = $this->noi_dung_arr[$i];

            } else {
                if (count($result) > 0)
                    return array_reverse($result);
            }
            $i--;
        }
        return array_reverse($result);
    }
    public function LayViTriSoCuaKieu(int $index_of_kieu, int &$start, int &$end)
    {
        $result = array();
        if ($index_of_kieu <= 0 || $index_of_kieu >= count($this->noi_dung_arr))
            return $result; //Không hợp lệ, return empty array
        $i = $index_of_kieu - 1;
        $flag_had_found = false;
        while ($i > 0) {
            if ($this->laSo($i)) {
                if ($flag_had_found == false) { //Nếu là số và chưa tìm thấy trước đó thì đây là vị trí cuối dãy số
                    $start = $end = $i;
                    $flag_had_found = true;
                } else
                    $start = $i; //Ngược lại thì là vị trí đầu dãy số
            } else {
                if ($flag_had_found)
                    return; //Nếu tìm thấy một vị trí ko phải số nhưng trước đó đã tìm thấy thì kết thúc tìm
            }
            $i--;
        }
    }
    public function LayViTriDiemCuaKieu(int $index_of_kieu): int
    {
        if ($index_of_kieu < 2 || $index_of_kieu >= count($this->noi_dung_arr) - 1)
            return -1; //Không hợp lệ
        
        for ($i = $index_of_kieu; $i < count($this->noi_dung_arr); $i++) {
            
            if (preg_match('/^[0-9]+([,][0-9]+)?$/', $this->noi_dung_arr[$i])){
                return $i;
            }
            
        }
        
        return -1;
    }

    /**
     * Hàm chuẩn hoá số theo kiểu
     * Nếu đảo thì xử lý đảo số
     * Nếu đá thì tạo cặp số đá, cách nhau bởi dấu phẩy
     * @param array $ds_chi_tiet mảng ChiTietBocTach, số ở dạng mảng 
     */
    public static function ChuanHoaSoTheoKieu(array $ds_chi_tiet): array
    {
        $result = array();
        $ds_kieu = new DanhSachKieu();
        foreach ($ds_chi_tiet as $chi_tiet) {
            $ten_kieu = $ds_kieu->LayTenTheoCode($chi_tiet->kieu, $chi_tiet->so);
            $ten_kieu = mb_strtolower($ten_kieu, 'UTF-8');
            if (strstr($ten_kieu, "đảo")) { //Xử lý đảo
                $result_hoan_vi = array();
                foreach ($chi_tiet->so as $so) {
                    $result_hoan_vi_tung_so = array();
                    NoiDungTin::layHoanVi($so, $result_hoan_vi_tung_so);
                    $result_hoan_vi = array_merge($result_hoan_vi, $result_hoan_vi_tung_so);
                }
                if($chi_tiet->kieu === 'dx')
                    $chi_tiet->kieu = 'xdao';
                $chi_tiet->so = $result_hoan_vi;
            } else if (strstr($ten_kieu, "đá")) { //Xử lý đá
                //Tách các chuỗi 2,4,6,8 chữ số thành 2 chữ số
                $ket_qua_tach_2_chu_so = array(); //Lưu kết quả tách số thành 2 chữ số
                foreach ($chi_tiet->so as $so) {
                    $ket_qua_tach_2_chu_so = array_merge($ket_qua_tach_2_chu_so, str_split($so, 2));
                }

                $result_so_da = array(); //Lưu kết quả tạo số đá
                $so_length = count($ket_qua_tach_2_chu_so);
                for ($i = 0; $i < $so_length - 1; $i++) {
                    for ($j = $i + 1; $j < $so_length; $j++) {
                        $result_so_da[] = $ket_qua_tach_2_chu_so[$i] . ',' . $ket_qua_tach_2_chu_so[$j];
                    }
                }
                $chi_tiet->so = $result_so_da;
            }
            elseif(strstr($ten_kieu, "bao lô")){ //Tạo số bao lô, 1234,123,12
                if(count($result) != 0){
                    $chi_tiet_truoc = $result[count($result) - 1];
                    if(ChiTietBocTach::CungSoBaoLo($chi_tiet_truoc, $chi_tiet)) //Nếu cùng kiểu bao va cung so
                    {
                        $cac_so_moi = array();
                        foreach ($chi_tiet_truoc->so as $so) {
                            $so_moi = $so;
                            if(strlen($so) > 2){
                                $so_moi = substr($so, 1);//Bỏ đi 1 chữ số bên trái
                            }
                            $cac_so_moi[] = $so_moi;
                        }
                        $chi_tiet->so = $cac_so_moi;
                    }
                }
            }
            $result[] = $chi_tiet;
        }
        return $result;
    }
    /**
     * Đổi đài chánh đài phụ thành tên đài
     */
    public static function DoiChanhPhuThanhTenDai(array $ds_chi_tiet, array $ds_dai){
        $result = array();
        foreach ($ds_chi_tiet as $chi_tiet) {
            if (preg_match("/dc|chanh|chinh/", $chi_tiet->dai)) {   //Đài chính
                $chi_tiet->dai = $ds_dai[0];  
            }
            if (preg_match("/dp|phu/", $chi_tiet->dai)) {  //Đài phụ
                $chi_tiet->dai = $ds_dai[1];  
            }
            $result[] = $chi_tiet;
        }
        return $result;
    }
   /**
     * Đổi 2d, 3d thành tên đài
     */
    public static function Doi2D3DThanhTenDai(array $ds_chi_tiet, array $ds_dai){
        $result = array();
        foreach ($ds_chi_tiet as $chi_tiet) {
            if (preg_match("/1d|2d|3d|4d|1dai|2dai|3dai|4dai/", $chi_tiet->dai)) {  
                $fist_char = substr($chi_tiet->dai, 0, 1);
                if ($fist_char == 1)  //1d
                    $chi_tiet->dai = $ds_dai[0];
                elseif ($fist_char == 2)  //2d
                    $chi_tiet->dai = $ds_dai[0] . ',' . $ds_dai[1];
                elseif ($fist_char == 3)  //3d
                    $chi_tiet->dai = $ds_dai[0] . ',' . $ds_dai[1] . ',' . $ds_dai[2];
                else
                    $chi_tiet->dai = $ds_dai[0] . ',' . $ds_dai[1] . ',' . $ds_dai[2] . ',' . $ds_dai[3] ;
            }
            $result[] = $chi_tiet;
        }
        return $result;
    }

    public static function TachTinTheoSoLuongDai(array $ds_chi_tiet): array
    {
        $result = array();
        foreach ($ds_chi_tiet as $chi_tiet) {
            $chi_tiet->dai = NoiDungTin::ChuanHoaDaiMienBac($chi_tiet->dai);
            if(strpos($chi_tiet->dai,',') != false) { //Nếu có dấu phẩy
                $ds_dai = explode(',', $chi_tiet->dai);
                $so_luong_dai = count($ds_dai);
                if($chi_tiet->kieu === 'dx' || $chi_tiet->kieu === 'dxv'){ //Nếu là đá
                    for ($i=0; $i < $so_luong_dai  - 1; $i++) 
                        for ($j= $i + 1; $j < $so_luong_dai; $j++) {
                            $chi_tiet_moi = clone $chi_tiet;
                            $chi_tiet_moi->dai = $ds_dai[$i]. ',' . $ds_dai[$j];
                            $result[] = $chi_tiet_moi;
                        }
                } 
                else{ //Nếu không phải đá
                    for ($i=0; $i < $so_luong_dai; $i++) {
                        $chi_tiet_moi = clone $chi_tiet;
                        $chi_tiet_moi->dai = $ds_dai[$i];
                        $result[] = $chi_tiet_moi;
                    }
                }
            }
            else
                $result[] = $chi_tiet;
            
        }
        return $result;
    }
    /**
     * Hàm chuẩn hoá đài miền bắc, trường hợp chuỗi dạng mb mb  hay mb hn thì chuẩn hoá về mb
     */
    public static function ChuanHoaDaiMienBac(string $dai_str) : string{
        if(str_contains($dai_str, 'hn') || str_contains($dai_str, 'mb'))
            return 'mb';
        return $dai_str;
    }
    /**
     * Tach tin theo danh 2 con, 3 con, 4 con
     * Trạng thái của số là đã được xử lý số kéo. Chưa xử lý số đá (ko chứa dấu phẩy)
     * ==> Cách xử lý: Đọc từng số. sắp xếp vào danh sách tương ứng
     */
    public static function TachTinTheoSoCon(array $ds_chi_tiet): array
    {
        $result = array();
        foreach ($ds_chi_tiet as $chi_tiet) {
            $cac_so = $chi_tiet->so;
            $hai_con = array();
            $ba_con = array();
            $bon_con = array();
            $sau_con = array();
            $tam_con = array();
            $con_lai = array(); //Còn lại, ko thuộc các trường hợp trước
            foreach ($cac_so as $so) {
                if(strlen($so) == 2)
                    $hai_con[] = $so;
                else if(strlen($so) == 3)
                    $ba_con[] = $so;
                else if(strlen($so) == 4)
                    $bon_con[] = $so;
                else if(strlen($so) == 6)
                    $sau_con[] = $so;
                else if(strlen($so) == 8)
                    $tam_con[] = $so;
                else
                    $con_lai[] = $so;
            }
            if(count($hai_con) > 0){
                $chi_tiet_moi = clone $chi_tiet;
                $chi_tiet_moi->so = $hai_con;
                $result[] = $chi_tiet_moi;
            }
            if(count($ba_con) > 0){
                $chi_tiet_moi = clone $chi_tiet;
                $chi_tiet_moi->so = $ba_con;
                $result[] = $chi_tiet_moi;
            } 
            if(count($bon_con) > 0){
                $chi_tiet_moi = clone $chi_tiet;
                $chi_tiet_moi->so = $bon_con;
                $result[] = $chi_tiet_moi;
            }  
            if(count($sau_con) > 0){
                $chi_tiet_moi = clone $chi_tiet;
                $chi_tiet_moi->so = $sau_con;
                $result[] = $chi_tiet_moi;
            }  
            if(count($tam_con) > 0){
                $chi_tiet_moi = clone $chi_tiet;
                $chi_tiet_moi->so = $tam_con;
                $result[] = $chi_tiet_moi;
            }  
            if(count($con_lai) > 0){
                $chi_tiet_moi = clone $chi_tiet;
                $chi_tiet_moi->so = $con_lai;
                $result[] = $chi_tiet_moi;
            }  
        }
        return $result;
    }



    public static function TachTinTheoKieuCoBan(array $ds_chi_tiet): array
    {
        $result = array();
        foreach ($ds_chi_tiet as $chi_tiet) {
            if ($chi_tiet->kieu === "dauduoi") {
                $chi_tiet_dau = clone $chi_tiet;
                $chi_tiet_dau->kieu = "dau";
                $result[] = $chi_tiet_dau;

                $chi_tiet_duoi = clone $chi_tiet;
                $chi_tiet_duoi->kieu = "duoi";
                $result[] = $chi_tiet_duoi;
            } else if ($chi_tiet->kieu === "blodao") {
                $chi_tiet->kieu = "blo";
                $result[] = $chi_tiet;
            } else if ($chi_tiet->kieu === "xc" || $chi_tiet->kieu === "xdao") {
                $chi_tiet_dau = clone $chi_tiet;
                $chi_tiet_dau->kieu = "xdau";
                $result[] = $chi_tiet_dau;

                $chi_tiet_duoi = clone $chi_tiet;
                $chi_tiet_duoi->kieu = "xduoi";
                $result[] = $chi_tiet_duoi;
            } else if ($chi_tiet->kieu === "xddau") {
                $chi_tiet->kieu = "xdau";
                $result[] = $chi_tiet;
            } else if ($chi_tiet->kieu === "xdduoi") {
                $chi_tiet->kieu = "xduoi";
                $result[] = $chi_tiet;
            } else if ($chi_tiet->kieu === "dat" || $chi_tiet->kieu === "dv") {
                $chi_tiet->kieu = "da";
                $result[] = $chi_tiet;
            } else
                $result[] = $chi_tiet;
        }

        return $result;
    }

    public static function ChiTietBocTach_to_ChiTietTin(array $ds_chi_tiet): array
    {
        $result = array();
        foreach ($ds_chi_tiet as $chi_tiet) {
            $chi_tiet_tin = new chi_tiet_tin();
            $chi_tiet_tin->dai = $chi_tiet->dai;
            $chi_tiet_tin->so = join(' ', $chi_tiet->so);
            $chi_tiet_tin->kieu = $chi_tiet->kieu;
            $chi_tiet_tin->diem = $chi_tiet->diem;
            $result[] = $chi_tiet_tin;
        }

        return $result;
    }

    public static function layHoanVi($string, &$result, $prefix = '')
    {
        $length = strlen($string);

        if ($length == 0) {
            if (in_array($prefix, $result) == false)
                $result[] = $prefix;
        } else {
            for ($i = 0; $i < $length; $i++) {
                $new_string = substr($string, 0, $i) . substr($string, $i + 1);
                NoiDungTin::layHoanVi($new_string, $result, $prefix . $string[$i]);
            }
        }
    }
    //================================== PHẦN CÁC HÀM KIỂM TRA TIN ===================================

    public function KiemTraNoiDung()
    {
        $ket_qua_kiem_tra = '';
        if (strlen($this->noi_dung_str) < 6) { //Nếu tin quá ngắng
            return '<p>Tin quá ngắn </p>';
        }

        if (($ket_qua_kiem_tra = $this->TinBatDauBangDai()) != '') {

            return $ket_qua_kiem_tra;
        }
        if (($ket_qua_kiem_tra = $this->KiemTraTuHopLe()) != '') {

            return $ket_qua_kiem_tra;
        }
        if (($ket_qua_kiem_tra = $this->KiemTra4d4dai()) != '') {

            return $ket_qua_kiem_tra;
        }

        if (($ket_qua_kiem_tra = $this->KiemTraDaiTheoNgayDanh()) != '') {

            return $ket_qua_kiem_tra;
        }
        if (($ket_qua_kiem_tra = $this->KiemTraDinhDangSoKeo()) != '') {

            return $ket_qua_kiem_tra;
        }
        if (($ket_qua_kiem_tra = $this->KiemTraSoCuaKieu()) != '') {

            return $ket_qua_kiem_tra;
        }
        if (($ket_qua_kiem_tra = $this->KiemTraDiemCuaKieu()) != '') {

            return $ket_qua_kiem_tra;
        }
        return '';
    }

    /**
     * Hàm kiểm tra: Kiểu không có số
     * Số hợp lệ của các kiểu đánh
     */
    public function KiemTraSoCuaKieu()
    {
        $dsKieu = new DanhSachKieu();
        $html_tin = '<p>';
        $tu_ko_hop_le = '';
        //Duyệt các từ
        for ($i = 0; $i < count($this->noi_dung_arr); $i++) {
            $item = $this->noi_dung_arr[$i];
            if ($dsKieu->LaCodeKieu($item, $this->day_of_week)) { //Là kieu
                $start = $end = -1;
                $this->LayViTriSoCuaKieu($i, $start, $end);

                if ($start == -1) //Kiem tra kieu khong co so
                {
                    $tu_ko_hop_le .= $this->noi_dung_arr[$i] . ', ';
                    $html_tin .= ' <mark> ' . $this->noi_dung_arr[$i] . ' </mark> ';
                } else {
                    $html_tin .= $this->noi_dung_arr[$i] . ' ';
                }


                $vietTatKieu = $dsKieu->LayVietTatTheoCode($item);
                $ket_qua = '';
                switch ($vietTatKieu) { //Goi ham kiem tra so theo kieu
                    case "dau":
                    case "duoi":
                    case "dauduoi":
                        $ket_qua = $this->KiemTraSoDauDuoi($i, $start, $end);
                        if (empty($ket_qua) == false)
                            return $ket_qua;
                        break;
                    case "xc":
                    case "xdau":
                    case "xiudui":
                    case "xiudao":
                    case "xddau":
                    case "xddui":
                        $ket_qua = $this->KiemTraSoXiu($i, $start, $end);
                        if (empty($ket_qua) == false)
                            return $ket_qua;
                        break;
                    case "da":
                    case "dat":
                    case "dav":
                    case "dx":
                    case "dxv":
                        $ket_qua = $this->KiemTraSoDa_SoLuong_SoChuSo($i, $start, $end);
                        if (empty($ket_qua) == false)
                            return $ket_qua;
                        $ket_qua = $this->KiemTraSoDa_CungSoChuSo($i, $start, $end);
                        if (empty($ket_qua) == false)
                            return $ket_qua;
                        $ket_qua = $this->KiemTraSoDa_KhongTrungNhau($i, $start, $end);
                        if (empty($ket_qua) == false)
                            return $ket_qua;
                        break;
                    case "blo":
                        $ket_qua = $this->KiemTraSoBao($i, $start, $end);
                        if (empty($ket_qua) == false)
                            return $ket_qua;
                        break;
                }
            }
        }
        $html_tin .= '</p>';
        if (strlen($tu_ko_hop_le) > 0) {
            $tu_ko_hop_le = '<p>Lỗi cú pháp, không nhận diện được số đánh cảu kiểu : ' . $tu_ko_hop_le . '</p>';
            return $html_tin . $tu_ko_hop_le;
        }
        return '';
    }

    public function KiemTraTuHopLe(): string
    {
        $size = count($this->noi_dung_arr);
        $html_tin = '<p>';
        $tu_ko_hop_le = '';
        $ds_dai = new DanhSachDai();
        $ds_kieu = new DanhSachKieu();
        for ($i = 0; $i < $size; $i++) {
            $item = $this->noi_dung_arr[$i];
            if (preg_match("/^[a-zA-Z]+(,[a-zA-Z]+)*$/", $item)) { //Nếu chỉ chứa các chữ cái và dấu phẩy
                if ($ds_dai->LaCodeDai($item, $this->day_of_week) || $ds_kieu->LaCodeKieu($item, $this->day_of_week)
                    ||  preg_match('/dc|dp|chinh|chanh|phu/', $item)) {
                    $html_tin .= $this->noi_dung_arr[$i] . ' ';
                } else {
                    $html_tin .= ' <mark> ' . $this->noi_dung_arr[$i] . ' </mark> ';
                    $tu_ko_hop_le .= $this->noi_dung_arr[$i] . ', ';
                }
            } else { //Nếu có chứa số
                $la_dai = preg_match('/1d|2d|3d|4d|1dai|2dai|3dai|4dai/', $item);
                $la_keo = preg_match('/^(\d{2,4})(k|keo)(\d{2,4})$/', $item);
                $la_so = preg_match('/^[0-9]+([,][0-9]+)?$/', $item);
                if ($la_dai || $la_keo || $la_so)
                    $html_tin .= $this->noi_dung_arr[$i] . ' ';
                else {
                    $html_tin .= ' <mark> ' . $this->noi_dung_arr[$i] . ' </mark> ';
                    $tu_ko_hop_le .= $this->noi_dung_arr[$i] . ', ';
                }
            }
        }
        $html_tin .= '</p>';
        if (strlen($tu_ko_hop_le) > 0) {
            $tu_ko_hop_le = '<p>Lỗi, các từ : ' . $tu_ko_hop_le . ' không nhận diện được</p>';
            return $html_tin . $tu_ko_hop_le;
        }
        return '';
    }
    public function KiemTraDaiTheoNgayDanh(): string
    {
        $size = count($this->noi_dung_arr);
        $ds_dai = new DanhSachDai();
        $html_tin = '<p>';
        $tu_ko_hop_le = '';
        for ($i = 0; $i < $size; $i++) {
            if ($this->laDai($i)) {
                $dai_hop_le = true;
                $dai_s = explode(',', $this->noi_dung_arr[$i]);
                foreach ($dai_s as $dai) {
                    if(in_array($ds_dai->LayVietTatTheoCode($dai), NoiDungTin::$thu_dais[$this->day_of_week]) == false)
                        $dai_hop_le = false;
                    if(preg_match("/1d|2d|3d|4d|1dai|2dai|3dai|4dai|dc|dp|chinh|chanh|phu|mb/", $dai)) //Nếu là 1 từ 2d, 3d... thì đúng
                        $dai_hop_le = true;
                }
                if ($dai_hop_le) {
                    //Hợp lệ theo thứ
                    $html_tin .= $this->noi_dung_arr[$i] . ' ';
                    //if(preg_match('/4d|4dai/', $this->noi_dung_arr[$i]) && $day_of_week != 7)
                } else {
                    $html_tin .= ' <mark> ' . $this->noi_dung_arr[$i] . ' </mark> ';
                    $tu_ko_hop_le .= $this->noi_dung_arr[$i] . ', ';
                }
            } else
                $html_tin .= $this->noi_dung_arr[$i] . ' ';
        }
        $html_tin .= '</p>';
        if (strlen($tu_ko_hop_le) > 0) {
            $thu = ($this->day_of_week == 0) ? 'Chủ nhật' : 'Thứ ' . ($this->day_of_week + 1);
            $tu_ko_hop_le = '<p>' . $thu . ' không nhận đài : ' . $tu_ko_hop_le . '</p>';
            return $html_tin . $tu_ko_hop_le;
        }
        return '';
    }
    public function KiemTra4d4dai(): string
    {
        $size = count($this->noi_dung_arr);
        $html_tin = '<p>';
        $tu_ko_hop_le = '';
        for ($i = 0; $i < $size; $i++) { 
            if ($this->laDai($i)) {
                if (preg_match('/4d|4dai/', $this->noi_dung_arr[$i]) && $this->day_of_week != 6) {
                    //4 dai ma ko phai thu 7 thi ko hop le
                    $html_tin .= ' <mark> ' . $this->noi_dung_arr[$i] . ' </mark> ';
                    $tu_ko_hop_le .= $this->noi_dung_arr[$i] . ', ';
                } else {
                    $so_dai = substr_count($this->noi_dung_arr[$i], ',') + 1;
                    if($so_dai == 4  && $this->day_of_week != 6 ){
                        //4 dai ma ko phai thu 7 thi ko hop le
                        $html_tin .= ' <mark> ' . $this->noi_dung_arr[$i] . ' </mark> ';
                        $tu_ko_hop_le .= $this->noi_dung_arr[$i] . ', ';
                    } else  //hop le
                        $html_tin .= $this->noi_dung_arr[$i] . ' ';
                }
            } else
                $html_tin .= $this->noi_dung_arr[$i] . ' ';
        }
        $html_tin .= '</p>';
        if (strlen($tu_ko_hop_le) > 0) {
            $tu_ko_hop_le = '<p>' . $tu_ko_hop_le . 'chỉ nhận vào thứ 7 </p>';
            $ket_qua = $html_tin . $tu_ko_hop_le;
            return $ket_qua;
        }
        return '';
    }

    public function KiemTraDiemCuaKieu(): string
    {
        $size = count($this->noi_dung_arr);
        $html_tin = '<p>';
        $tu_ko_hop_le = '';
        for ($i = 0; $i < $size; $i++) {
            if ($this->laKieu($i)) {
                if ($this->laDiem($i + 1)) { //hop le
                    $html_tin .= $this->noi_dung_arr[$i] . ' ';
                } else {
                    //4 dai ma ko phai thu 7 thi ko hop le
                    $html_tin .= ' <mark> ' . $this->noi_dung_arr[$i] . ' </mark> ';
                    $tu_ko_hop_le .= $this->noi_dung_arr[$i] . ', ';
                }
            } else
                $html_tin .= $this->noi_dung_arr[$i] . ' ';
        }
        $html_tin .= '</p>';
        if (strlen($tu_ko_hop_le) > 0) {
            $tu_ko_hop_le = '<p> Lỗi cú pháp: Không nhận diện được điểm đánh của kiểu ' . $tu_ko_hop_le . ' có thể điểm đánh không đúng</p>';
            $ket_qua = $html_tin . $tu_ko_hop_le;
            return $ket_qua;
        }
        return '';
    }

    public function TinBatDauBangDai()
    {
        $html_output = "<p>";
        $danh_sach_cac_tu_khong_hop_le = "";
        $dsDai = new DanhSachDai();
        //Duyệt các từ
        for ($i = 0; $i < count($this->noi_dung_arr); $i++) {
            $item = $this->noi_dung_arr[$i];
            if ($i == 0) {
                if ($this->laDai($i)) { //Nếu đầu tin là đài thì thêm bình thường
                    $html_output .= $item . " ";

                } else {
                    $html_output .= "<mark>" . $item . "</mark> "; //thì tô sáng
                    $danh_sach_cac_tu_khong_hop_le .= $item;
                }
            } else { //Nếu không phải chỉ là ký tự thì thêm vào bình thường
                $html_output .= $item . " ";
            }
        }
        $html_output .= "</p>";

        if (empty($danh_sach_cac_tu_khong_hop_le) == false) {
            $danh_sach_cac_tu_khong_hop_le = "<p>Tin phải bắt đầu bằng tên đài</p>";
            return $html_output . $danh_sach_cac_tu_khong_hop_le;
        }
        return "";
    }

    public function KiemTraDinhDangSoKeo()
    {
        $html_output = "<p>";
        $danh_sach_cac_tu_khong_hop_le = "";
        $dsDai = new DanhSachDai();
        //Duyệt các từ
        for ($i = 0; $i < count($this->noi_dung_arr); $i++) {
            $item = $this->noi_dung_arr[$i];
            if(preg_match('/^(\d{2,4})(k|keo)(\d{2,4})$/', $item)) //Nếu là kiểu kéo
            {
                if(NoiDungTin::DungDinhDangSoKeo($item)) //Nếu số keo đúng định dạng
                        $html_output .= $item . " ";
                else {
                    $html_output .= "<mark>" . $item . "</mark> "; //thì tô sáng
                    $danh_sach_cac_tu_khong_hop_le .= $item;
                    }
            } 
            else { //Nếu không phải dạng kéo thì thêm bình thường
                $html_output .= $item . " ";
            }
        }
        $html_output .= "</p>";

        if (empty($danh_sach_cac_tu_khong_hop_le) == false) {
            $danh_sach_cac_tu_khong_hop_le = '<p>Số :'. $danh_sach_cac_tu_khong_hop_le. ' không đúng định dạng số kéo</p>';
            return $html_output . $danh_sach_cac_tu_khong_hop_le;
        }
        return "";
    }

    public function KiemTraSoDauDuoi(int $index_of_kieu, int $start, int $end): string
    {
        $html_output = "<p>";
        $tu_khong_hop_le = '';
        $arr_length = count($this->noi_dung_arr);
        for ($i = 0; $i < $arr_length; $i++) {
            if ($i >= $start && $i <= $end) {
                if (NoiDungTin::DemSoKyTuCuaSo($this->noi_dung_arr[$i])==2)
                    $html_output .= $this->noi_dung_arr[$i] . ' '; //Thêm bình thường
                else {
                    $html_output .= '<mark>' . $this->noi_dung_arr[$i] . '</mark> '; //thì tô sáng
                    $tu_khong_hop_le .= $this->noi_dung_arr[$i] . ', ';
                }
            } else
                $html_output .= $this->noi_dung_arr[$i] . ' '; //Thêm bình thường 
        }
        $html_output .= '</p>';
        if (strlen($tu_khong_hop_le) > 0) {
            $tu_khong_hop_le = "<p>Các số " . $tu_khong_hop_le . "không đúng với kiểu " . $this->noi_dung_arr[$index_of_kieu] . ".</p>";
            return $html_output . $tu_khong_hop_le;
        }
        return '';
    }


    public function KiemTraSoXiu(int $index_of_kieu, int $start, int $end): string
    {
        $html_output = "<p>";
        $tu_khong_hop_le = '';
        $arr_length = count($this->noi_dung_arr);
        for ($i = 0; $i < $arr_length; $i++) {
            if ($i >= $start && $i <= $end) {
                if (NoiDungTin::DemSoKyTuCuaSo($this->noi_dung_arr[$i])==3)
                    $html_output .= $this->noi_dung_arr[$i] . ' '; //Thêm bình thường
                else {
                    $html_output .= '<mark>' . $this->noi_dung_arr[$i] . '</mark> '; //thì tô sáng
                    $tu_khong_hop_le .= $this->noi_dung_arr[$i] . ', ';
                }
            } else
                $html_output .= $this->noi_dung_arr[$i] . ' '; //Thêm bình thường 
        }
        $html_output .= '</p>';
        if (strlen($tu_khong_hop_le) > 0) {
            $tu_khong_hop_le = "<p>Các số " . $tu_khong_hop_le . "không đúng với kiểu " . $this->noi_dung_arr[$index_of_kieu] . ".</p>";
            return $html_output . $tu_khong_hop_le;
        }
        return '';
    }
    public function KiemTraSoDa_SoLuong_SoChuSo($index_of_kieu, $start, $end)
    {
        $html_output = "<p>";
        $tu_khong_hop_le = "";
        $err_type = 0;
        // Duyệt các từ
        for ($i = 0; $i < count($this->noi_dung_arr); $i++) {
            $item = $this->noi_dung_arr[$i];
            if ($i >= $start && $i <= $end) { // Nếu nằm trong phạm vi số
                if ($start == $end && strlen($item) < 4) {
                    if($this->noi_dung_arr[$index_of_kieu] ==='dx' && strlen($item) == 3){
                        //Nếu là xỉu đảo chứ không phải đá xiên
                        $html_output .= $item . " "; // Thêm bình thường
                    }
                    else{
                        $html_output .= "<mark>" . $item . "</mark> "; // Thì tô sáng
                        $tu_khong_hop_le .= $item . ", ";
                        $err_type = 1; // Lỗi chỉ có một số
                    }
                    
                } else {
                    if (strlen($item) % 2 == 0) { // Nếu số chữ số chia hết cho 2 thì hợp lệ
                        $html_output .= $item . " "; // Thêm bình thường
                    } else {
                        if($this->noi_dung_arr[$index_of_kieu] ==='dx' && strlen($item) == 3){
                            //Nếu là xỉu đảo chứ không phải đá xiên
                            $html_output .= $item . " "; // Thêm bình thường
                        }
                        else{
                            $html_output .= "<mark>" . $item . "</mark> "; // Thì tô sáng
                            $tu_khong_hop_le .= $item . ", ";
                            $err_type = 2; // Lỗi khác 2,4,6... chữ số
                        }
                    }
                }
            } else { // Nếu không phải là số thì thêm bình thường
                $html_output .= $item . " ";
            }
        }
        $html_output .= "</p>";
        if (empty($tu_khong_hop_le))
            return "";
        if ($err_type == 1) {
            $tu_khong_hop_le =
                "<p>Số " . $tu_khong_hop_le . "phải có nhiều hơn 1 số để có thể " . $this->noi_dung_arr[$index_of_kieu] . ".</p>";
        }
        if ($err_type == 2) {
            $tu_khong_hop_le =
                "<p>Số " . $tu_khong_hop_le . "chỉ có thể có 2,4,6... chữ số để có thể " . $this->noi_dung_arr[$index_of_kieu] . ".</p>";
        }
        return $html_output . $tu_khong_hop_le;
    }
    /**
     * Hàm kiểm tra số đá có cùng số lượng chữ số hay không? Hoặc phải bằng 2, hoặc phải bằng 4
     * Hàm được gọi sau khi gọi hàm kiểm tra Số Đá có nhiều hơn 2 số và chỉ có thể 2 hoặc 4 chữ số
     */
    public function KiemTraSoDa_CungSoChuSo($index_of_kieu, $start, $end)
    {
        //Kiểm tra
        $cung_so_chu_so = true;
        if ($start == $end) //Nếu chỉ có một chữ số
            $cung_so_chu_so = true;
        else {
            $so_chu_so = strlen($this->noi_dung_arr[$start]);
            for ($i = $start; $i <= $end; $i++) {
                if ($so_chu_so != strlen($this->noi_dung_arr[$i])) {
                    $cung_so_chu_so = false;
                    break;
                }

            }
        }

        $html_output = "<p>";

        // Duyệt các từ
        for ($i = 0; $i < count($this->noi_dung_arr); $i++) {
            $item = $this->noi_dung_arr[$i];
            if ($i == $start && $cung_so_chu_so == false) { // Bắt đầu tô sáng dãy số
                $html_output .= "<mark>" . $item . ' '; // Thì tô sáng 
            } else if ($i == $end && $cung_so_chu_so == false) { // Kết thúc tô sáng
                $html_output .= $item . "</mark> ";
            } else
                $html_output .= $item . " "; // Thêm bình thường

        }
        $html_output .= "</p>";
        if ($cung_so_chu_so == false) {
            $tu_khong_hop_le =
                "<p>Phải cùng 2 hoặc 4 chữ số để có thể đá!</p>";
            return $html_output . $tu_khong_hop_le;
        }

        return '';
    }

    public function KiemTraSoDa_KhongTrungNhau($index_of_kieu, $start, $end)
    {
        //Kiểm tra
        $trung_nhau = false;
        if ($start == $end) //Nếu chỉ có một chữ số thì mặc định là ko trùng
            $trung_nhau = false;
        else {
            if (strlen($this->noi_dung_arr[$start]) == 2) { //Xử lý 2 chữ số, kiểm tra các trường hợp trùng nhau
                for ($i = $start; $i < $end; $i++) {
                    for ($j = $i + 1; $j <= $end; $j++) {
                        if ($this->noi_dung_arr[$i] == $this->noi_dung_arr[$j])
                            $trung_nhau = true;
                    }
                }
            } else { //4Chữ số
                for ($i = $start; $i <= $end; $i++) {
                    $so1 = substr($this->noi_dung_arr[$i], 0, 2);
                    $so2 = substr($this->noi_dung_arr[$i], -2);
                    if ($so1 == $so2)
                        $trung_nhau = true;
                }
            }

        }

        $html_output = "<p>";

        // Duyệt các từ
        for ($i = 0; $i < count($this->noi_dung_arr); $i++) {
            $item = $this->noi_dung_arr[$i];
            if ($i == $start && $trung_nhau == true) { // Bắt đầu tô sáng dãy số
                $html_output .= "<mark>" . $item . ' '; // Thì tô sáng 
            } else if ($i == $end && $trung_nhau == true) { // Kết thúc tô sáng
                $html_output .= $item . "</mark> ";
            } else
                $html_output .= $item . " "; // Thêm bình thường

        }
        $html_output .= "</p>";
        if ($trung_nhau == true) {
            $tu_khong_hop_le =
                "<p>Các số phải không trùng nhau để có thể đá!</p>";
            return $html_output . $tu_khong_hop_le;
        }

        return '';
    }

    public function KiemTraSoBao(int $index_of_kieu, int $start, int $end): string
    {
        $html_output = "<p>";
        $tu_khong_hop_le = '';
        $arr_length = count($this->noi_dung_arr);
        for ($i = 0; $i < $arr_length; $i++) {
            if ($i >= $start && $i <= $end) {
                $count_of_digit = NoiDungTin::DemSoKyTuCuaSo($this->noi_dung_arr[$i]);
                if (1 < $count_of_digit && $count_of_digit < 5) //Neu co 2 - 4 so
                    $html_output .= $this->noi_dung_arr[$i] . ' '; //Thêm bình thường
                else {
                    $html_output .= '<mark>' . $this->noi_dung_arr[$i] . '</mark> '; //thì tô sáng
                    $tu_khong_hop_le .= $this->noi_dung_arr[$i] . ', ';
                }
            } else
                $html_output .= $this->noi_dung_arr[$i] . ' '; //Thêm bình thường 
        }
        $html_output .= '</p>';
        if (strlen($tu_khong_hop_le) > 0) {
            $tu_khong_hop_le = "<p>Kieu 'blo' chi cho phep 2, 3 hoac 4 chu so </p>";
            return $html_output . $tu_khong_hop_le;
        }
        return '';
    }

    static function DungDinhDangSoKeo(string $so){
        $so_ben_phai = $so_ben_phai = 0;
        NoiDungTin::LaySoCuaSoKeo($so, $so_ben_trai, $so_ben_phai);
        if($so_ben_trai >= $so_ben_phai) //Số trái lớn hơn phải thì sai
            return false;
        if(strlen($so_ben_trai) != strlen($so_ben_phai)) //Kích thước số 2 bên khác nhau => sai
            return false;
        if(strlen($so_ben_trai) == 2) //Nếu số ký tự = 2 thì đúng
            return true;

        $so_ben_trai_bo_so_cuoi = substr($so_ben_trai, 0, -1);
        $so_ben_phai_bo_so_cuoi = substr($so_ben_phai, 0, -1);
        if($so_ben_trai_bo_so_cuoi == $so_ben_phai_bo_so_cuoi) //Nếu 2 số bỏ đi số cuối mà bằng nhau thì đúng
            return true;

        $tao_thanh_tu_ky_tu_giong_nhau_ben_trai = preg_match('/^(\d)\1*$/', $so_ben_trai);
        $tao_thanh_tu_ky_tu_giong_nhau_ben_phai = preg_match('/^(\d)\1*$/', $so_ben_phai);
        if( $tao_thanh_tu_ky_tu_giong_nhau_ben_trai && $tao_thanh_tu_ky_tu_giong_nhau_ben_phai) //Nếu 2 số cùng dạng 111,2222 thì đúng
            return true;

        //Nếu hiệu của 2 số chia hết cho 10, 100, 1000 (theo số ký tự) thì đúng
        $so_ky_tu =strlen($so_ben_trai);
        $hieu_chia_het_cho_10_100_1000 = ($so_ben_phai - $so_ben_trai) % pow(10, $so_ky_tu)  == 0; 
        if($hieu_chia_het_cho_10_100_1000)
            return true;

        //Nếu hiệu chia hết cho 10 và không lớn hơn 99 thì đúng
        $hieu_chi_het_cho_10_va_khong_lon_hon_99 = ($so_ben_phai - $so_ben_trai) % 10 == 0 && ($so_ben_phai - $so_ben_trai) < 100;
        if($hieu_chi_het_cho_10_va_khong_lon_hon_99)
            return true;
        //Nếu hiệu chia hết cho 100 và không lớn hơn 999 thì đúng
        $hieu_chi_het_cho_100_va_khong_lon_hon_990 = ($so_ben_phai - $so_ben_trai) % 100 == 0 && ($so_ben_phai - $so_ben_trai) < 1000;
        if($hieu_chi_het_cho_100_va_khong_lon_hon_990)
            return true;

        $hieu_chi_het_cho_1000 = ($so_ben_phai - $so_ben_trai) % 1000 == 0;
        if($hieu_chi_het_cho_1000)
            return true;
        return false;
    }
    static function DemSoKyTuCuaSo(string $so) : int{
        $vitri =  strpos($so, 'k');
        if($vitri !==false ) //Là kéo
            return NoiDungTin::DemSoKyTuSoCuaSoKeo($so);
        return strlen($so);
    }
    static function DemSoKyTuSoCuaSoKeo(string $so): int
    {
        $so = str_replace('keo', 'k', $so);
        $sos = explode('k', $so);
        $num1 = $sos[0];
        return strlen($num1);
    }
    static function LaSoKeo(string $so): bool {
        $dung_dinh_dang = preg_match('/^(\d{2,4})(k|keo)(\d{2,4})$/', $so);
        if($dung_dinh_dang == false)
            return false;
        // NoiDungTin::LaySoCuaSoKeo($so, $num_left, $num_right);
        // if(strlen($num_left) != strlen($num_right))
        //     return false;
        return true;
    }
    static function LaySoCuaSoKeo(string $so, &$so_ben_trai = null, &$so_ben_phai = null){
        $so = str_replace('keo', 'k', $so);
        $sos = explode('k', $so);
        $so_ben_trai = $sos[0];
        $so_ben_phai = $sos[1];
    } 
}

?>