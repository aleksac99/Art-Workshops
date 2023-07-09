<?php
require_once './config/dbconfig.php';

abstract class Database {

    private $conn;

    public function __construct() {

        $this->conn = mysqli_connect(
            constant('DB_HOST'),
            constant('DB_USER'),
            constant('DB_PASS'),
            constant('DB_NAME'),
        );
        mysqli_set_charset($this->conn, "utf8");

        if (!$this->conn) {
            die(mysqli_connect_error());
        }
    }

    protected function executeQuery($query) {
        $r = mysqli_query($this->conn, $query);
        if(!$r) {
            throw new Exception("Query execution Error");
        }
        return $r;
    }

    protected function fetchOne($query) {

        $res = $this->executeQuery($query);

        if (mysqli_num_rows($res)>0) {
            return mysqli_fetch_assoc($res);
        }
        else return null;
    }

    function _destruct() {
        mysqli_close($conn);
    }

}

?>