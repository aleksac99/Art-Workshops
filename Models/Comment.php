<?php

require_once './Models/Database.php';

class Comment extends Database {

    private $id;
    private $userId;
    private $workshopName;
    private $text;


    public function insert($data) {
        
        $query = "INSERT INTO comment (user_id, workshop_name, text) VALUES (
            ".$data["userId"].", '".$data["workshopName"]."', '".$data["text"]."');";

        $res = $this->executeQuery($query);
        return !$res==null;
    }

    public function edit($data) {
        
        $query = "UPDATE comment SET text='".$data["text"]."' WHERE id=".$data["commentID"].";";

        $res = $this->executeQuery($query);
        return !$res==null;
    }

    public function delete($data) {
        
        $query = "DELETE FROM comment WHERE id=".$data["commentID"].";";

        $res = $this->executeQuery($query);
        return !$res==null;
    }

    public function fetchByUserId($userID) {

        $query = "SELECT * FROM comment WHERE user_id=".$userID.";";
        $res = $this->executeQuery($query);
        
        $comments = [];
        if ($res->num_rows > 0) {
            while ($c = $res->fetch_assoc()) {
                $comments[] = $c;
            }
        }
        return $comments;
    }

    public function fetchByWorkshopName($wName) {

        $query = "SELECT c.*, u.username FROM comment c JOIN user u ON c.user_id=u.id WHERE c.workshop_name='".$wName."';";
        $res = $this->executeQuery($query);

        $comments = [];
        if ($res->num_rows > 0) {
            while ($c = $res->fetch_assoc()) {
                $comments[] = $c;
            }
        }
        
        return $comments;
    }
}

?>