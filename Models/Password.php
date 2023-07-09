<?php

require_once './Models/Database.php';

class Password extends Database {

    private $id;
    private $userId;
    private $datetime;
    private $tempPassword;

    public function getId() {
        return $this->id;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function getDatetime() {
        return $this->datetime;
    }
    public function getTempPassword() {
        return $this->tempPassword;
    }

    public function insert($data) {

        $query = "INSERT INTO password (user_id, temp_password) VALUES (".$data["userId"].", '".$data["tempPassword"]."');";
        $res = $this->executeQuery($query);
        return $res!=null;
    }

    public function delete($uID) {
        
        $query = "DELETE FROM password WHERE user_id=".$uID.";";
        $res = $this->executeQuery($query);
        return $res->num_rows == 1;
    }

    public function fetchByUsername($username) {

        $query = "SELECT p.* FROM password p JOIN user u ON p.user_id=u.id WHERE DATE_ADD(datetime, INTERVAL 30 MINUTE)>NOW() AND username='".$username."' AND status=0 ORDER BY datetime DESC LIMIT 1;";
        $res = $this->fetchOne($query);
        return $res ? $res["temp_password"] : null;
    }

}

?>