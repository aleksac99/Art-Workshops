<?php

require_once './Models/Database.php';

class WorkshopLike extends Database {

    private $id;
    private $userId;
    private $workshopName;


    public function insert($data) {
        
        $query = "INSERT INTO workshop_like (user_id, workshop_name) VALUES (".$data["userId"].", '".$data["workshopName"]."');";

        $res = $this->executeQuery($query);
        return !$res==null;
    }

    public function delete($data) {
        
        $query = "DELETE FROM workshop_like WHERE user_id=".$data["userId"]." AND workshop_name='".$data["workshopName"]."';";
        
        $res = $this->executeQuery($query);
        return !$res==null;
    }

    public function fetchByUserId($userID) {

        $query = "SELECT * FROM workshop_like WHERE user_id=".$userID.";";
        $res = $this->executeQuery($query);
        
        $likes = [];
        if ($res->num_rows > 0) {
            while ($l = $res->fetch_assoc()) {
                $likes[] = $l;
            }
        }
        return $likes;
    }

    public function fetchByWorkshopName($workshopName) {

        $query = "SELECT l.*, u.username FROM workshop_like l JOIN user u ON l.user_id=u.id WHERE l.workshop_name='".$workshopName."';";

        $res = $this->executeQuery($query);
        
        $likes = [];
        if ($res->num_rows > 0) {
            while ($l = $res->fetch_assoc()) {
                $likes[] = $l;
            }
        }
        return $likes;
    }

    public function checkIfLiked($userID, $workshopName) {

        $query = "SELECT * FROM workshop_like WHERE user_id=".$userID." AND workshop_name='".$workshopName."';";

        $res = $this->executeQuery($query);
        return (mysqli_num_rows($res)>0);
    }
}

?>