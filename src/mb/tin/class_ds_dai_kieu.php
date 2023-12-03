<?php

class Ten
{
    public $ten, $viet_tat, $codes = array();
    function __construct(string $ten, string $viet_tat, array $codes)
    {
        $this->ten = $ten;
        $this->viet_tat = $viet_tat;
        $this->codes = $codes;
    }
}
class DanhSachDai
{
    public $dais = array();
    function __construct()
    {
        $this->dais = array();
        $this->dais[] = new Ten('Miền Bắc', 'mb', array('hn', 'mb', 'hanoi','HN','Hn','hN'));
        $this->dais[] = new Ten('TP. HCM', 'tp', array( 'tp', 'hcm'));
        $this->dais[] = new Ten('Đồng Tháp', 'dt', array('dt'));
        $this->dais[] = new Ten('Cà Mau', 'cm', array('cm', 'camau'));
        $this->dais[] = new Ten('Bến Tre', 'bt', array('bt', 'btr', 'btre'));
        $this->dais[] = new Ten('Vũng Tàu', 'vt', array('vt'));
        $this->dais[] = new Ten('Bạc Liêu', 'blieu', array('blieu', 'baclieu'));
        $this->dais[] = new Ten('Đồng Nai', 'dn', array('dn'));
        $this->dais[] = new Ten('Cần Thơ', 'ct', array('ct'));
        $this->dais[] = new Ten('Sóc Trăng', 'st', array('st', 'soctrang'));
        $this->dais[] = new Ten('Tây Ninh', 'tn', array('tn'));
        $this->dais[] = new Ten('An Giang', 'ag', array('ag'));
        $this->dais[] = new Ten('Bình Thuận', 'bt', array('bt', 'binhthuan'));
        $this->dais[] = new Ten('Vĩnh Long', 'vl', array('vl'));
        $this->dais[] = new Ten('Bình Dương', 'sbe', array('sbe', 'bd', 'sb'));
        $this->dais[] = new Ten('Trà Vinh', 'tv', array('tv', 'travinh'));
        $this->dais[] = new Ten('Long An', 'la', array('la'));
        $this->dais[] = new Ten('Hậu Giang', 'hg', array('hg', 'haugiang'));
        $this->dais[] = new Ten('Tiền Giang', 'tg', array('tg'));
        $this->dais[] = new Ten('Kiên Giang', 'kg', array('kg'));
        $this->dais[] = new Ten('Đà Lạt', 'dl', array('dl', 'dalat'));
        $this->dais[] = new Ten('Bình Phước', 'bp', array('bp', 'binhphuoc'));
    }
    private function LaCode(string $code, int $day_of_week) : bool
    {
        if($code === 'bd' && $day_of_week != 5) //Neu la bd nhung ko phai thu 6 thì ko phai dai
            return false;
        foreach ($this->dais as $dai) {
            if(in_array($code, $dai->codes))
                return true;
        }
        return false;
    }
    public function LaCodeDai(string $code, int $day_of_week) : bool
    {
        $code_s = explode(',',$code);
        foreach ($code_s as $code) {
            if($this->LaCode($code, $day_of_week) == false)
                return false;
        }
        return true;
    }

    private function LayVietTatCuaCode(string $code) : string
    {
        if(preg_match('/1d|2d|3d|4d|1dai|2dai|3dai|4dai|dc|dp|chanh|phu/', $code))
            return $code;
        foreach ($this->dais as $dai) {
            if(in_array($code, $dai->codes))
                return $dai->viet_tat;
        }
        return '';
    }
    public function LayVietTatTheoCode(string $code) : string
    {
        $code_s = explode(',',$code);
        $size = count($code_s);
        $result = '';
        for ($i=0; $i < $size; $i++) { 
            $viet_tat = $this->LayVietTatCuaCode($code_s[$i]);
            if($i==0)
                $result = $viet_tat;
            else
                $result = $result . ',' . $viet_tat; 
        }
        
        return $result;
    }
    public function LayVietTatTheoTen(string $ten) : string
    {
        //if($code === 'bd' && $day_of_week == 5) 
            //return '';
        foreach ($this->dais as $dai) {
            if($dai->ten === $ten)
                return $dai->viet_tat;
        }
        return '';
    }
    public function LayTenTheoVietTat(string $ten_viet_tat, int $day_of_week) : string
    {
        if ($ten_viet_tat === "bt" && $day_of_week == 2) //Thứ 
                $tendai = 'Bến Tre'; //Nếu là thứ 3 thì bt là bến tre, còn lại là bình thuận
        if ($ten_viet_tat === "bt" && $day_of_week == 4) //Thứ 
                $tendai = 'Bình Thuận'; //Nếu là thứ 3 thì bt là bến tre, còn lại là bình thuận
        foreach ($this->dais as $dai) {
            if($dai->viet_tat === $ten_viet_tat)
                return $dai->ten;
        }
        return '';
    }

}

class DanhSachKieu
{
    /*
     'dau'|'a'|'duoi'|'dui'|'d'|'dd'|'dauduoi'|'daudui'|'ab'|
    'b'|'bao'|'bl'|'blo'|'lo'|'doc'|'baodao'|'daolo'|'dlo'|'bld'|'bdao'|'dbao'|'db'|'bd'|'blodao'|'dbl'|'bldao'|
    'xc'|'x'|'tl'|'tlo'|'sc'|'siu'|'xdau'|'xcdau'|'tldau'|'tlodau'|
    'xduoi'|'xcdui'|'xcduoi'|'xdui'|'tldui'|'tlduoi'|'tlodui'|'tloduoi'|
    'xd'|'xcd'|'dxc'|'daox'|'daoxc'|'xdao'|'xcdao'|'tld'|'dtl'|'daotl'|'tldao'|'tlod'|'dtlo'|'daotlo'|'tlodao'|'suidao'|
    'xdaudao'|'xddau'|'daoxdau'|'xcdaudao'|'daoxcdau'|'tldaudao'|'daotldau'|'tlduidao'|'tlodaudao'|'daotlodau'|
    'xduoidao'|'xduidao'|'xddui'|'xdduoi'|'daoxdui'|'daoxduoi'|'xcduidao'|'xcduoidao'|'daoxcdui'|'daoxcduoi'|'tlduoidao'|
    'daotldui'|'daotlduoi'|'tloduidao'|'tloduoidao'|'daotlodui'|'daotloduoi'|'da'|'dat'|'dv'|'dav'|
    'dx'|'dax'|'dxien'|'daxien'|'cheo'|'dxv'|'daxv'|'dvx'|
     */
    public $kieus = array();
    function __construct()
    {
        $this->kieus = array();
        $this->kieus[] = new Ten('Đầu', 'dau', array('dau', 'a'));
        $this->kieus[] = new Ten('Đuôi', 'duoi', array('duoi', 'dui', 'd'));
        $this->kieus[] = new Ten('Đầu đuôi', 'dauduoi', array('dd', 'dauduoi', 'daudui', 'ab'));
        $this->kieus[] = new Ten('Bao lô', 'blo', array('b', 'bao', 'bl', 'blo', 'lo', 'doc'));
        $this->kieus[] = new Ten('Bao lô đảo', 'blodao', array('baodao', 'daolo', 'dlo', 'bld', 'bdao', 'dbao', 'db', 'bd', 'blodao', 'dbl', 'bldao'));
        $this->kieus[] = new Ten('Bảy lô', 'baylo', array('slo', 'baylo'));
        $this->kieus[] = new Ten('Xỉu chủ', 'xc', array('xc', 'x', 'tl', 'tlo', 'sc', 'siu'));
        $this->kieus[] = new Ten('Xỉu chủ đầu', 'xdau', array('xdau', 'xcdau', 'tldau', 'tlodau'));
        $this->kieus[] = new Ten('Xỉu chủ đuôi', 'xduoi', array('xduoi', 'xcdui', 'xcduoi', 'xdui', 'tldui', 'tlduoi', 'tlodui', 'tloduoi'));
        $this->kieus[] = new Ten('Xỉu chủ đảo', 'xdao', array('xd', 'xcd', 'dxc', 'daox', 'daoxc', 'xdao', 'xcdao', 'tld', 'dtl', 'daotl', 'tldao', 'tlod', 'dtlo', 'daotlo', 'tlodao', 'suidao'));
        $this->kieus[] = new Ten('Xỉu chủ đảo đầu', 'xddau', array('xdaudao', 'xddau', 'daoxdau', 'xcdaudao', 'daoxcdau', 'tldaudao', 'daotldau', 'tlduidao', 'tlodaudao', 'daotlodau'));
        $this->kieus[] = new Ten('Xỉu chủ đảo đuôi', 'xdduoi', array(
            // 'xduoidao',
            // 'xduidao',
            // 'xddui',
            // 'xdduoi',
            // 'daoxdui',
            // 'daoxduoi',
            // 'xcduidao',
            // 'xcduoidao',
            // 'daoxcdui',
            // 'daoxcduoi',
            // 'tlduoidao',
            // 'daotldui',
            // 'daotlduoi',
            // 'tloduidao',
            // 'tloduoidao',
            // 'daotlodui',
            // 'daotloduoi'
            "daoxduoi", "daoxiuduoi", "daoxcduoi", "daoxchuduoi", "daoxiuchuduoi", "daoxdui", "daoxiudui", "daoxcdui", "daoxchudui", "daoxiuchdui", "daoxchdui", "daoxiuchudui", "dxcduoi", "dxcdui", "xduidao", "xcduoidao", "xcduidao", "xcdaodui", "xcdaoduoi", "xdaoduoi", "xdaodui", "xduoidao", "tlduoidao", "tlduidao"
        )
        );
        $this->kieus[] = new Ten('Đá', 'da', array('da'));
        $this->kieus[] = new Ten('Đá thẳng', 'dat', array('dat'));
        $this->kieus[] = new Ten('Đá vòng', 'dav', array('dv', 'dav'));
        $this->kieus[] = new Ten('Đá xiên', 'dx', array('dx', 'dax', 'dxien', 'daxien', 'cheo'));
        $this->kieus[] = new Ten('Đá xiên vòng', 'dxv', array('dxv', 'daxv', 'dvx'));
    }
    public function LaCodeKieu(string $code, int $day_of_week) : bool
    {
        if($code === 'bd' && $day_of_week != 5) //Neu la bd va thu 6 thi ko phai kieu ma la dai
            return true;
        foreach ($this->kieus as $ten) {
            if(in_array($code, $ten->codes))
                return true;
        }
        return false;
    }

    public function LayVietTatTheoCode(string $code) : string
    {
        //if($code === 'bd' && $day_of_week == 5) //Neu la bd va thu 6 thi ko phai code
            //return '';
        foreach ($this->kieus as $kieu) {
            if(in_array($code, $kieu->codes))
                return $kieu->viet_tat;
        }
        return "";
    }
    public function LayTenTheoCode(string $code, array $so = null) : string
    {
        //if($code === 'bd' && $day_of_week == 5) //Neu la bd va thu 6 thi ko phai code
            //return '';
        if($code === 'dx'){
            if($so != null){
                $la_so_xiu_dao = true;
                foreach ($so as $item) {
                    if(strlen($item) != 3)
                        $la_so_xiu_dao = false;
                }
                if($la_so_xiu_dao)
                    return 'đảo';
            }
        }
        foreach ($this->kieus as $kieu) {
            if(in_array($code, $kieu->codes))
                return $kieu->ten;
        }
        return "";
    }

}


class DanhSachDaiMB
{
    public $dais = array();
    function __construct()
    {
        $this->dais = array();
        $this->dais[] = new Ten('Miền Bắc', 'mb', array('hn', 'mb', 'hanoi', 'HN'));
    }
    
    private function LaCode(string $code, int $day_of_week) : bool
    {
        if($code === 'bd' && $day_of_week != 5) //Neu la bd nhung ko phai thu 6 thì ko phai dai
            return false;
        foreach ($this->dais as $dai) {
            if(in_array($code, $dai->codes))
                return true;
        }
        return false;
    }
    public function LaCodeDai(string $code, int $day_of_week) : bool
    {
        $code_s = explode(',',$code);
        foreach ($code_s as $code) {
            if($this->LaCode($code, $day_of_week) == false)
                return false;
        }
        return true;
    }

    private function LayVietTatCuaCode(string $code) : string
    {
        if(preg_match('/1d|2d|3d|4d|1dai|2dai|3dai|4dai|dc|dp|chanh|phu/', $code))
            return $code;
        foreach ($this->dais as $dai) {
            if(in_array($code, $dai->codes))
                return $dai->viet_tat;
        }
        return '';
    }
    public function LayVietTatTheoCode(string $code) : string
    {
        $code_s = explode(',',$code);
        $size = count($code_s);
        $result = '';
        for ($i=0; $i < $size; $i++) { 
            $viet_tat = $this->LayVietTatCuaCode($code_s[$i]);
            if($i==0)
                $result = $viet_tat;
            else
                $result = $result . ',' . $viet_tat; 
        }
        
        return $result;
    }
    public function LayVietTatTheoTen(string $ten) : string
    {
        //if($code === 'bd' && $day_of_week == 5) 
            //return '';
        foreach ($this->dais as $dai) {
            if($dai->ten === $ten)
                return $dai->viet_tat;
        }
        return '';
    }
    public function LayTenTheoVietTat(string $ten_viet_tat, int $day_of_week) : string
    {
        if ($ten_viet_tat === "bt" && $day_of_week == 2) //Thứ 
                $tendai = 'Bến Tre'; //Nếu là thứ 3 thì bt là bến tre, còn lại là bình thuận
        if ($ten_viet_tat === "bt" && $day_of_week == 4) //Thứ 
                $tendai = 'Bình Thuận'; //Nếu là thứ 3 thì bt là bến tre, còn lại là bình thuận
        foreach ($this->dais as $dai) {
            if($dai->viet_tat === $ten_viet_tat)
                return $dai->ten;
        }
        return '';
    }
    
   

}

class DanhSachDaiMN
{
    public $dais = array();
    function __construct()
    {
        $this->dais = array();
        $this->dais[] = new Ten('TP. HCM', 'tp', array( 'tp', 'hcm'));
        $this->dais[] = new Ten('Đồng Tháp', 'dt', array('dt'));
        $this->dais[] = new Ten('Cà Mau', 'cm', array('cm', 'camau'));
        $this->dais[] = new Ten('Bến Tre', 'bt', array('bt', 'btr', 'btre'));
        $this->dais[] = new Ten('Vũng Tàu', 'vt', array('vt'));
        $this->dais[] = new Ten('Bạc Liêu', 'blieu', array('blieu', 'baclieu'));
        $this->dais[] = new Ten('Đồng Nai', 'dn', array('dn'));
        $this->dais[] = new Ten('Cần Thơ', 'ct', array('ct'));
        $this->dais[] = new Ten('Sóc Trăng', 'st', array('st', 'soctrang'));
        $this->dais[] = new Ten('Tây Ninh', 'tn', array('tn'));
        $this->dais[] = new Ten('An Giang', 'ag', array('ag'));
        $this->dais[] = new Ten('Bình Thuận', 'bt', array('bt', 'binhthuan'));
        $this->dais[] = new Ten('Vĩnh Long', 'vl', array('vl'));
        $this->dais[] = new Ten('Bình Dương', 'sbe', array('sbe', 'bd', 'sb'));
        $this->dais[] = new Ten('Trà Vinh', 'tv', array('tv', 'travinh'));
        $this->dais[] = new Ten('Long An', 'la', array('la'));
        $this->dais[] = new Ten('Hậu Giang', 'hg', array('hg', 'haugiang'));
        $this->dais[] = new Ten('Tiền Giang', 'tg', array('tg'));
        $this->dais[] = new Ten('Kiên Giang', 'kg', array('kg'));
        $this->dais[] = new Ten('Đà Lạt', 'dl', array('dl', 'dalat'));
        $this->dais[] = new Ten('Bình Phước', 'bp', array('bp', 'binhphuoc'));
    }
    private function LaCode(string $code, int $day_of_week) : bool
    {
        if($code === 'bd' && $day_of_week != 5) //Neu la bd nhung ko phai thu 6 thì ko phai dai
            return false;
        foreach ($this->dais as $dai) {
            if(in_array($code, $dai->codes))
                return true;
        }
        return false;
    }
    public function LaCodeDai(string $code, int $day_of_week) : bool
    {
        $code_s = explode(',',$code);
        foreach ($code_s as $code) {
            if($this->LaCode($code, $day_of_week) == false)
                return false;
        }
        return true;
    }

    private function LayVietTatCuaCode(string $code) : string
    {
        if(preg_match('/1d|2d|3d|4d|1dai|2dai|3dai|4dai|dc|dp|chanh|phu/', $code))
            return $code;
        foreach ($this->dais as $dai) {
            if(in_array($code, $dai->codes))
                return $dai->viet_tat;
        }
        return '';
    }
    public function LayVietTatTheoCode(string $code) : string
    {
        $code_s = explode(',',$code);
        $size = count($code_s);
        $result = '';
        for ($i=0; $i < $size; $i++) { 
            $viet_tat = $this->LayVietTatCuaCode($code_s[$i]);
            if($i==0)
                $result = $viet_tat;
            else
                $result = $result . ',' . $viet_tat; 
        }
        
        return $result;
    }
    public function LayVietTatTheoTen(string $ten) : string
    {
        //if($code === 'bd' && $day_of_week == 5) 
            //return '';
        foreach ($this->dais as $dai) {
            if($dai->ten === $ten)
                return $dai->viet_tat;
        }
        return '';
    }
    public function LayTenTheoVietTat(string $ten_viet_tat, int $day_of_week) : string
    {
        if ($ten_viet_tat === "bt" && $day_of_week == 2) //Thứ 
                $tendai = 'Bến Tre'; //Nếu là thứ 3 thì bt là bến tre, còn lại là bình thuận
        if ($ten_viet_tat === "bt" && $day_of_week == 4) //Thứ 
                $tendai = 'Bình Thuận'; //Nếu là thứ 3 thì bt là bến tre, còn lại là bình thuận
        foreach ($this->dais as $dai) {
            if($dai->viet_tat === $ten_viet_tat)
                return $dai->ten;
        }
        return '';
    }

}

class DanhSachDaiMT
{
    public $dais = array();
    function __construct()
    {
        $this->dais = array();
        $this->dais[] = new Ten('Phú Yên', 'py', array( "phu yen", "phuyen", "phu.yen", "pyen", "py", "p.y", "p yen", "p.yen"));
        $this->dais[] = new Ten('Thừa Thiên Huế', 'hue', array('"thua thien hue", "thu thien hue", "thua t hue", "tth", "th", "tthue", "tt hue", "t.t.hue", "hue"'));
        $this->dais[] = new Ten('Đắk Lắk', 'dl', array("dak lak", "daklak", "daclak", "dac lak", "dac.lak", "dak.lak", "daklac", "dak lac", "dlak", "dlac", "dlat", "dl", "daclac", "dac lac", "dac lat", "dat lac", "dat lak", "d.lak"));
        $this->dais[] = new Ten('Quảng Nam', 'qn', array("quang nam", "quan nam", "quangnam", "quang.nam", "qnam", "q.nam", "qn"));
        $this->dais[] = new Ten('Đà Nẵng', 'dn', array('"da nang", "da.nang", "danang", "da nag", "da.nag", "danag", "dnang", "dnag", "dna", "d nang", "d.nang", "dng", "dn"'));
        $this->dais[] = new Ten('Khánh Hòa', 'kh', array("khanh hoa", "khanh.hoa", "khanhhoa", "khahhoa", "khoa", "kha", "kh,hoa", "k.hoa", "k,hoa", "k hoa", "kh hoa", "kh"));
        $this->dais[] = new Ten('Bình Định', 'bd', array("binh dinh", "binh. dinh", "binh.dinh", "binhdinh", "bdinh", "b dinh", "b.dinh", "bdi", "bd"));
        $this->dais[] = new Ten('Quảng Trị', 'qt', array("quang tri", "quang. tri", "quan tri", "quangtri", "quang.tri", "qt", "qtri", "q.tri", "qtr"));
        $this->dais[] = new Ten('Quảng Bình', 'qb', array("quang binh", "quan binh", "quangbinh", "quang.binh", "qb", "qbinh", "q binh", "q.binh", "qbi"));
        $this->dais[] = new Ten('Gia Lai', 'gl', array("gja laj", "gia lai", "gia.lai", "gialai", "gjalaj", "gl", "glai", "g.lai", "gla"));
        $this->dais[] = new Ten('Ninh Thuận', 'nth', array("ninh thuan", "ninh.thuan", "ninhthuan", "nt", "nthuan", "n.thuan", "nth"));
        $this->dais[] = new Ten('Quảng Ngãi', 'qn', array("quang ngai", "quang.ngai", "quangngai", "quan ngai", "quan.ngai", "quanngai", "qngai", "q ngai", "q.ngai", "qng", "qn"));
        $this->dais[] = new Ten('Đắk Nông', 'dno', array("dak nong", "dac nong", "daknong", "dacnong", "dkn", "dnong", "dno", "d.nong"));
        $this->dais[] = new Ten('Kon Tum', 'kt', array("ktum", "kontum", "kontom", "komtum", "kumtum", "kuntum", "kon", "ktun", "ktu", "kt"));
    }
    private function LaCode(string $code, int $day_of_week) : bool
    {
        if($code === 'bd' && $day_of_week != 5) //Neu la bd nhung ko phai thu 6 thì ko phai dai
            return false;
        foreach ($this->dais as $dai) {
            if(in_array($code, $dai->codes))
                return true;
        }
        return false;
    }
    public function LaCodeDai(string $code, int $day_of_week) : bool
    {
        $code_s = explode(',',$code);
        foreach ($code_s as $code) {
            if($this->LaCode($code, $day_of_week) == false)
                return false;
        }
        return true;
    }

    private function LayVietTatCuaCode(string $code) : string
    {
        if(preg_match('/1d|2d|3d|4d|1dai|2dai|3dai|4dai|dc|dp|chanh|phu/', $code))
            return $code;
        foreach ($this->dais as $dai) {
            if(in_array($code, $dai->codes))
                return $dai->viet_tat;
        }
        return '';
    }
    public function LayVietTatTheoCode(string $code) : string
    {
        $code_s = explode(',',$code);
        $size = count($code_s);
        $result = '';
        for ($i=0; $i < $size; $i++) { 
            $viet_tat = $this->LayVietTatCuaCode($code_s[$i]);
            if($i==0)
                $result = $viet_tat;
            else
                $result = $result . ',' . $viet_tat; 
        }
        
        return $result;
    }
    public function LayVietTatTheoTen(string $ten) : string
    {
        //if($code === 'bd' && $day_of_week == 5) 
            //return '';
        foreach ($this->dais as $dai) {
            if($dai->ten === $ten)
                return $dai->viet_tat;
        }
        return '';
    }
    public function LayTenTheoVietTat(string $ten_viet_tat, int $day_of_week) : string
    {
        if ($ten_viet_tat === "bt" && $day_of_week == 2) //Thứ 
                $tendai = 'Bến Tre'; //Nếu là thứ 3 thì bt là bến tre, còn lại là bình thuận
        if ($ten_viet_tat === "bt" && $day_of_week == 4) //Thứ 
                $tendai = 'Bình Thuận'; //Nếu là thứ 3 thì bt là bến tre, còn lại là bình thuận
        foreach ($this->dais as $dai) {
            if($dai->viet_tat === $ten_viet_tat)
                return $dai->ten;
        }
        return '';
    }

}


?>