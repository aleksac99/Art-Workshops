<?php

require_once './Models/Database.php';

class Application extends Database {

    private $id;
    private $userId;
    private $workshopId;
    private $status;

    public function getId() {
        return $this->id;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function getWorkshopId() {
        return $this->workshopId;
    }
    public function getStatus() {
        return $this->status;
    }

    public function delete($uID, $wID) {
        
        $query = "DELETE FROM application WHERE user_id=".$uID." AND workshop_id=".$wID.";";
        $res = $this->executeQuery($query);
        return $res->num_rows == 1;
    }

    public function checkIfAttended($uid, $wName) {

        $query = "SELECT a.id from application a JOIN workshop w ON a.workshop_id=w.id WHERE a.status=0 AND w.date<=NOW() AND a.user_id=".$uid." AND w.name='".$wName."';";
        $res = $this->executeQuery($query);

        return $res->num_rows > 0;
    }

    public function checkIfApplied($uID, $wID) {

        $query = "SELECT id FROM application WHERE user_id=".$uID." AND workshop_id=".$wID.";";
        $res = $this->executeQuery($query);
        return $res->num_rows == 1;
    }

    public function insert($data) {

        $query = "INSERT INTO application (user_id, workshop_id, status) VALUES (".$data["userId"].", ".$data["workshopId"].", 2);";

        $res = $this->executeQuery($query);
        return $res!=null;
    }

    public function fetchByWorkshopId($wID) {

        $query = "SELECT a.*, u.username FROM application a JOIN user u ON a.user_id=u.id WHERE a.workshop_id=".$wID.";";
        $res = $this->executeQuery($query);
        
        $applications = [];
        if ($res->num_rows > 0) {
            while ($w = $res->fetch_assoc()) {
                $applications[] = $w;
            }
        }
        return $applications;
    }

    public function fetchApplication($uID, $wID) {
        
        $query = "SELECT * FROM application WHERE user_id=".$uID." AND workshop_id=".$wID.";";

        $res = $this->fetchOne($query);

        if ($res) {
            $this->id = $res["id"];
            $this->workshopId = $res["workshop_id"];
            $this->userId = $res["user_id"];
            $this->status = $res["status"];
        }
    }

    public function accept($uID, $wID) {

        $query = "UPDATE application SET status=0 WHERE user_id=".$uID." AND workshop_id=".$wID.";";
        
        $res = $this->executeQuery($query);
        return $res!=null;
    }

    public function deny($uID, $wID) {

        $query = "UPDATE application SET status=1 WHERE user_id=".$uID." AND workshop_id=".$wID.";";
        
        $res = $this->executeQuery($query);
        return $res!=null;
    }

    public function getNumberOfApplications($wID, $status=null) {

        $query = "SELECT COUNT(a.id) as N FROM application a WHERE workshop_id=".$wID;
        if ($status) {
            $kw = " AND (";
            foreach($status as $s) {
                $query .= $kw." status=".$s;
                $kw = " OR";
            }
            $query .= ")";
        }
            $query .= ";";

            $res = $this->fetchOne($query);
            return $res["N"];
    }

    public function checkOngoingApplications($uID) {

        $query = "SELECT w.id, w.name, x.cnt FROM workshop w LEFT JOIN (SELECT a.user_id, COUNT(a.id) AS cnt FROM application a JOIN workshop w ON a.workshop_id=w.id WHERE w.date>=NOW() GROUP BY a.user_id) x ON w.user_id=x.user_id WHERE status=2;";
        $res = $this->fetchOne($query);

        return $res;

    }

}

?>