<?php
$dir_name = dirname(__FILE__);
//include_once(dirname($dir_name) . '/ket_qua/class_ket_qua.php');
//include_once(dirname($dir_name) . '/cau_hinh/class_cau_hinh.php');
include_once(dirname($dir_name) . '/tin/class_boc_tach_tin.php');






class ChiTietBocTach
{
    public $dai, $so = array(), $kieu, $diem;
    public function XuatHTML()
    {
        $html = "<p>" . $this->dai . implode('.', $this->so) . $this->kieu . $this->diem . '</p>';
        echo $html;
    }
    /**
     * Hàm kiểm tra hai chi tiết có cùng kiểu bao và cùng số hay không
     */
    public static function CungSoBaoLo(ChiTietBocTach $chi_tiet_truoc, ChiTietBocTach $chi_tiet_hien_tai) : bool{
        if($chi_tiet_truoc->kieu !== $chi_tiet_hien_tai->kieu)
            return false;
        if($chi_tiet_truoc->dai !== $chi_tiet_hien_tai->dai)
            return false;
        if(count($chi_tiet_truoc->so) != count($chi_tiet_hien_tai->so))
            return false;
        for ($i=0; $i < count($chi_tiet_truoc->so); $i++) { 
            $so_truoc = $chi_tiet_truoc->so[$i];
            $so_hien_tai = substr($chi_tiet_hien_tai->so[$i], strlen($chi_tiet_hien_tai->so[$i]) - strlen($so_truoc) );
            if($so_truoc != $so_hien_tai)
                return false;
        }
        return true;
    }
}
class XuLyTin
{
    public static $thu_dais = array(
        0 => array('1d', '2d', '3d', '4d', '1dai', '2dai', '3dai', '4dai', 'mb'),
        1 => array('1d', '2d', '3d', '4d', '1dai', '2dai', '3dai', '4dai', 'mb'),
        2 => array('1d', '2d', '3d', '4d', '1dai', '2dai', '3dai', '4dai', 'mb'),
        3 => array('1d', '2d', '3d', '4d', '1dai', '2dai', '3dai', '4dai', 'mb'),
        4 => array('1d', '2d', '3d', '4d', '1dai', '2dai', '3dai', '4dai', 'mb'),
        5 => array('1d', '2d', '3d', '4d', '1dai', '2dai', '3dai', '4dai', 'mb'),
        6 => array('1d', '2d', '3d', '4d', '1dai', '2dai', '3dai', '4dai', 'mb')
    );
    private $noi_dung_arr = array();
    private $day_of_week;
    public $noi_dung_str;
    private $tai_khoan_danh;
    function __construct(string $noi_dung, int $day_of_week = null, string $tai_khoan_danh = null)
    {
        $this->tai_khoan_danh = $tai_khoan_danh;
        $this->day_of_week = $day_of_week;
        $noi_dung_chuan_hoa = $this->ChuanHoa($noi_dung);
        // $this->noi_dung_str = $noi_dung_chuan_hoa;
        // $tin_tach_theo_khoang_trang = explode(" ", $noi_dung_chuan_hoa);
        // $this->noi_dung_arr = $tin_tach_theo_khoang_trang;
        //$this->noi_dung_arr = NoiDungTin::XuLySoKeo($tin_tach_theo_khoang_trang);
    }

    public static function ChuanHoa(string $tin): string
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

        // //Thay dấu chấm nhằm ở điểm bằng dấu phẩy. Đặc thù của điểm là sau dấu phẩy chỉ có một chữ số.
        // $tin = preg_replace('/(\D\d+)(\.)(\d\D|\d$)/', '$1,$3', $tin);
        // //Thay dấu chấm giữa hai đài bằng dấu phẩy
        // $tin = preg_replace('/(^|\s)(hn|mb|hanoi|tp|hcm|dt|cm|camau|bt|btr|btre|vt|blieu|baclieu|dn|ct|st|soctrang|tn|ag|bt|binhthuan|vl|sbe|bd|sb|tv|travinh|la|hg|haugiang|tg|kg|dl|dalat|bp|binhphuoc)(\s*)(.)(\s*)(hn|mb|hanoi|tp|hcm|dt|cm|camau|bt|btr|btre|vt|blieu|baclieu|dn|ct|st|soctrang|tn|ag|bt|binhthuan|vl|sbe|bd|sb|tv|travinh|la|hg|haugiang|tg|kg|dl|dalat|bp|binhphuoc)(\s)/', '$1$2$3,$5$6$7', $tin);
         $tin = str_replace(array('_','-', ';', ':', '\'', '\"'), ' ', $tin); //Thay các ký tự phân cách bằng khoảng trắng

        // //Thay dấu phẩy nằm giữa mà hai bên đều có ít nhất 2 chữ số (và có thể có khoảng trắng)bằng khoảng trắng
        // $tin = preg_replace('/(?<=\d{2})\s*,\s*(?=\d{2})/', ' ', $tin);
        // //Thay dấu phẩy nằm giữa mà hai bên có một bên là số và một bên là chữ (và có thể có khoảng trắng)bằng khoảng trắng
        // $tin = preg_replace('/(?<=[a-z])\s*,\s*(?=\d)|(?<=\d)\s*,\s*(?=[a-z])/', ' ', $tin);


        // //Bỏ khoảng trắng
        // $tin = preg_replace('/\s{2,}/', ' ', $tin); //Tìm trên 2 khoảng trắng liên tục thay bằng 1 khoảng trắng
        // $tin = trim($tin); //Xoá khoảng trắng thừa đầu cuối
        // $tin = preg_replace('/(^|\s)([1-9])(\s)(d)(\s)/', '$1$2$4$5', $tin); //Khôi phục khoảng trắng giữa số và d
        // $tin = preg_replace('/(\s)(,)/', '$2', $tin); //Bỏ khoảng trắng trước dấu phẩy
        // $tin = preg_replace('/(,)(\s)/', '$2', $tin); //Bỏ khoảng trắng sau dấu phẩy
        // $tin = preg_replace('/(\s)(k|keo)(\s)/', '$2', $tin); //Bỏ khoảng trắng trước và sau k|keo
        // $tin = preg_replace('/(1|2|3|4)(\s)(dai)/', '$1$3', $tin); //Bỏ khoảng trắng giữ 1,2,3,4 vài dai
        // $tin = preg_replace('/(\s)(dau|a|duoi|dui|d|dd|dauduoi|daudui|ab|b|bao|bl|blo|lo|doc|baodao|daolo|dlo|bld|bdao|dbao|db|bd|blodao|dbl|bldao)(\s)(05)(\s|$)/', ' $2 $4,$5$6',$tin);
        // $tin = preg_replace('/(\s)(xc|x|tl|tlo|sc|siu|xdau|xcdau|tldau|tlodau|xduoi|xcdui|xcduoi|xdui|tldui|tlduoi|tlodui|tloduoi)(\s)(05)(\s|$)/', ' $2 $4,$5$6',$tin);
        // $tin = preg_replace('/(\s)(xd|xcd|dxc|daox|daoxc|xdao|xcdao|tld|dtl|daotl|tldao|tlod|dtlo|daotlo|tlodao|suidao)(\s)(05)(\s|$)/', ' $2 $4,$5$6',$tin);
        // $tin = preg_replace('/(\s)(xdaudao|xddau|daoxdau|xcdaudao|daoxcdau|tldaudao|daotldau|tlduidao|tlodaudao|daotlodau)(\s)(05)(\s|$)/', ' $2 $4,$5$6',$tin);
        // $tin = preg_replace('/(\s)(xduoidao|xduidao|xddui|xdduoi|daoxdui|daoxduoi|xcduidao|xcduoidao|daoxcdui|daoxcduoi|tlduoidao)(\s)(05)(\s|$)/', ' $2 $4,$5$6',$tin);
        // $tin = preg_replace('/(\s)(daotldui|daotlduoi|tloduidao|tloduoidao|daotlodui|daotloduoi|da|dat|dv|dav|dx|dax|dxien|daxien|cheo|dxv|daxv|dvx)(\s)(05)(\s|$)/', ' $2 $4,$5$6',$tin);
        // $tin = trim($tin); //Xoá khoảng trắng thừa đầu cuối

        $tin_moi = '';
        $i = 0;
        while($i < strlen($tin)){
            $tin_moi.= '<p>' . 'a' . '</p>';
        }

        echo $tin_moi;

        return $tin;
    }


     
}

?>