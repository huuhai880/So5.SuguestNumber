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
        $this->dais[] = new Ten('TP. HCM', 'tp', array("thanh pho", "thanhpho", "thanh.pho", "thpho", "hcm", "tph", "t.ph", "tp", "tphcm", "t.pho", "tpho"));
        $this->dais[] = new Ten('Đồng Tháp', 'dt', array("dong thap", "dong.thap", "dongthap", "dt", "dth", "dai dong thap", "d.thap", "dthap", "d thap", "d.thap"));
        $this->dais[] = new Ten('Cà Mau', 'cm', array("ca mau", "ca. mau", "camau", "ca.mau", "cm", "cmau", "c mau", "c.mau", "dai ca mau"));
        $this->dais[] = new Ten('Bến Tre', 'bt', array("ben tre", "bentre", "bt", "btr", "btre", "b tre", "b.tre", "dai ben tre"));
        $this->dais[] = new Ten('Vũng Tàu', 'vt', array("vung tau", "vung. tau", "dung tau", "vungtau", "dungtau", "vug tau", "vt", "vtau", "v tau", "v.tau", "dai vung tau"));
        $this->dais[] = new Ten('Bạc Liêu', 'blieu', array("bac lieu", "bac. lieu", "baclieu", "bac.lieu", "bli", "blie", "bliu", "bl", "b lieu", "blieu", "b.lieu", "dai bac lieu"));
        $this->dais[] = new Ten('Đồng Nai', 'dn', array("dong nai", "dong.nai", "dongnai", "dog nai", "dognai", "dn", "dnai", "d.nai", "dai dong nai"));
        $this->dais[] = new Ten('Cần Thơ', 'ct', array("can tho", "cantho", "ct", "cth", "dai can tho", "ctho", "c.tho"));
        $this->dais[] = new Ten('Sóc Trăng', 'st', array("soc trang", "soctrang", "soc.trang", "soc. trang", "st", "str", "dai soc trang", "strang", "s.trang", "s trang"));
        $this->dais[] = new Ten('Tây Ninh', 'tn', array("tay ninh", "tay.ninh", "tayninh", "tninh", "t.ninh", "t.n", "tn", "dai tay ninh"));
        $this->dais[] = new Ten('An Giang', 'ag', array("an giang", "angiang", "agiang", "agian", "ag", "a.g", "agiag", "a.giang", "dai an giang"));
        $this->dais[] = new Ten('Bình Thuận', 'bt', array("binh thuan", "binh. thuan", "binh.thuan", "binhthuan", "bthuan", "b.thuan", "b thuan", "bth", "bt", "dai binh thuan"));
        $this->dais[] = new Ten('Vĩnh Long', 'vl', array("vinh long", "vinhlong", "vlong", "vlog", "v.long", "v long", "v.l", "vl", "dai vinh long"));
        $this->dais[] = new Ten('Bình Dương', 'sbe', array("binh duong", "binhduong", "bduong", "bduog", "b.duong", "b duong", "b duog", "bdu", "song be", "sbe", "s.be", "sb", "bd", "bdg", "dai binh duong"));
        $this->dais[] = new Ten('Trà Vinh', 'tv', array("tra vinh", "tra. vinh", "tra.vinh", "travinh", "trvinh", "trav", "tvinh", "t.vinh", "t vinh", "tv", "t.v", "trv", "dai tra vinh"));
        $this->dais[] = new Ten('Long An', 'la', array("long an", "log an", "longan", "logan", "long.an", "log.an", "lg.an", "l.an", "lan", "la", "l.a", "dai long an"));
        $this->dais[] = new Ten('Hậu Giang', 'hg', array("hau giang", "haugiang", "hau.giang", "hau. giang", "hgiang", "h.giang", "hg", "dai hau giang"));
        $this->dais[] = new Ten('Tiền Giang', 'tg', array("tien giang", "tien.giang", "tiengiang", "tienggiang", "tgiang", "t giang", "t.giang", "tg", "tgi", "tgiag", "dai tien giang","TG"));
        $this->dais[] = new Ten('Kiên Giang', 'kg', array("kien giang", "kieng giang", "kiengiang", "kgiang", "k.giang", "kg", "k.g", "kgi", "dai kien giang"));
        $this->dais[] = new Ten('Đà Lạt', 'dl', array("da lat", "da. lat", "da lac", "dalat", "da.lat", "dalac", "da.lac", "dalt", "dal", "dl", "dlat", "d.lat", "dai da lat",'Đl'));
        $this->dais[] = new Ten('Bình Phước', 'bp', array("binh phuoc", "binhphuoc", "binh.phuoc", "binh. phuoc", "bphuoc", "phuoc", "b.phuoc", "bp", "dai binh phuoc"));
        $this->dais[] = new Ten('Phú Yên', 'py', array( "phu yen", "phuyen", "phu.yen", "pyen", "py", "p.y", "p yen", "p.yen","Py"));
        $this->dais[] = new Ten('Thừa T.Huế', 'hue', array("thua thien hue", "thu thien hue", "thua t hue", "tth", "th", "tthue", "tt hue", "t.t.hue", "hue"));
        $this->dais[] = new Ten('Đắk Lắk', 'dl', array("dak lak", "daklak", "daclak", "dac lak", "dac.lak", "dak.lak", "daklac", "dak lac", "dlak", "dlac", "dlat", "dl", "daclac", "dac lac", "dac lat", "dat lac", "dat lak", "d.lak","dlk"));
        $this->dais[] = new Ten('Quảng Nam', 'qn', array("quang nam", "quan nam", "quangnam", "quang.nam", "qnam", "q.nam", "qn",'qnm'));
        $this->dais[] = new Ten('Đà Nẵng', 'dn', array("da nang", "da.nang", "danang", "da nag", "da.nag", "danag", "dnang", "dnag", "dna", "d nang", "d.nang", "dng", "dn"));
        $this->dais[] = new Ten('Khánh Hòa', 'kh', array("khanh hoa", "khanh.hoa", "khanhhoa", "khahhoa", "khoa", "kha", "kh,hoa", "k.hoa", "k,hoa", "k hoa", "kh hoa", "kh"));
        $this->dais[] = new Ten('Bình Định', 'bd', array("binh dinh", "binh. dinh", "binh.dinh", "binhdinh", "bdinh", "b dinh", "b.dinh", "bdi", "bd"));
        $this->dais[] = new Ten('Quảng Trị', 'qt', array("quang tri", "quang. tri", "quan tri", "quangtri", "quang.tri", "qt", "qtri", "q.tri", "qtr"));
        $this->dais[] = new Ten('Quảng Bình', 'qb', array("quang binh", "quan binh", "quangbinh", "quang.binh", "qb", "qbinh", "q binh", "q.binh", "qbi"));
        $this->dais[] = new Ten('Gia Lai', 'gl', array("gja laj", "gia lai", "gia.lai", "gialai", "gjalaj", "gl", "glai", "g.lai", "gla"));
        $this->dais[] = new Ten('Ninh Thuận', 'nth', array("ninh thuan", "ninh.thuan", "ninhthuan", "nt", "nthuan", "n.thuan", "nth",'Nth','Nt','nT','NT','NTH','nTH','ntH'));
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
            'xduoidao',
            'xduidao',
            'xddui',
            'xdduoi',
            'daoxdui',
            'daoxduoi',
            'xcduidao',
            'xcduoidao',
            'daoxcdui',
            'daoxcduoi',
            'tlduoidao',
            'daotldui',
            'daotlduoi',
            'tloduidao',
            'tloduoidao',
            'daotlodui',
            'daotloduoi'
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


?>