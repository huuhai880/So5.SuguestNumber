<?php 
    class db_info{
        public const MAY_CHU = "127.0.0.1";
        //public const MAY_CHU = '213.136.93.171'; //contabo
        public const TAI_KHOAN = "admin_sql";
        public const MAT_KHAU = "root@123";
        public const TEN_CSDL = "db_so";
        public const PORT_CSDL = "3306";
        //ki11996499_
    }
    class TrangThaiTaiKhoan{
        public const CHUA_KICH_HOAT = 0;
        public const DANG_HOAT_DONG = 1;
        public const BI_CANH_BAO = -1;
        public const BI_KHOA = -2;
    }
    class TrangThaiTin{
        public const CHUA_SOI = -1;
        public const KHONG_TRUNG = 0;
        public const TRUNG = 1;
        //public const BI_KHOA = -2;
    }
    define("LOAI_KHONG_XAC_DINH", 0);
    define("LOAI_DAI", 1);
    define("LOAI_SO", 2);
    define("LOAI_KIEU", 3);
    define("LOAI_DIEM", 4);
    define("LOAI_CHU_CAI", 5);
    define("LOAI_CHU_SO", 6);
    define("LOAI_CHU_KEO", 7);
    define("LOAI_CHU_DAI", 8);
    define("CO_LOI", 1);
    const MAT_KHAU_MAC_DINH = "123";
?>