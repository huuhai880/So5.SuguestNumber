<?php
$dir_name = dirname(__FILE__);
require_once($dir_name . '/config.php');
class sql_connector
{
    public $conn;
    function __construct()
    {
        $this->conn = mysqli_connect(db_info::MAY_CHU, db_info::TAI_KHOAN, db_info::MAT_KHAU, db_info::TEN_CSDL);
        if(!$this->conn->connect_errno)
            $this->conn->set_charset('utf8');
    }
    public function get_connect_error()
    {
        return $this->conn->connect_error;
    }
    public function get_query_result($sql)
    {
        return $this->conn->query($sql);
    }
    public function get_insert_id(){
        return $this->conn->insert_id;
    }
    function __destruct()
    {
        $this->conn->close();
    }
}

?>