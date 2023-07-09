<?php

require_once './Models/Database.php';

class User extends Database {

    private $id;
    private $username;
    private $password;
    private $email;
    private $firstName;
    private $lastName;
    private $phoneNumber;
    private $status;
    private $userType;

    public $i2type = [
        0 => "Učesnik",
        1 => "Organizator",
        2 => "Administrator"
    ];
    public $i2status = [
        0 => "Aktivan",
        1 => "Neaktivan",
        2 => "Na cekanju"
    ];

    public function checkPassword($uid, $pw, $newPW) {
        $query = "SELECT id, password FROM user WHERE id=".$uid." AND password='".$pw."';";
        $res = $this->fetchOne($query);
        if ($res==null) return -1;
        else if ($res["password"]==$newPW) return -2;
        else return 1;
    }

    public function login($username, $password, $isAdmin) {
        
        $query = "SELECT status, password FROM user WHERE username='".$username."' AND user_type".
        ($isAdmin ? "=" : "!=")."2;";
        $res = $this->fetchOne($query);

        // 0 - Approved
        // 1 - Denied
        // 2 - Pending
        // 3 - Wrong username
        // 4 - Wrong password
        return $res ? ($password==$res["password"]? $res["status"] : 4 ) : 3;

    }

    public function fetchByUsername($username) {
        
        $query = "SELECT * FROM user WHERE username='".$username."';";
        $res = $this->fetchOne($query);

        $this->id = $res['id'];
        $this->username = $res['username'];
        $this->password = $res['password'];
        $this->email = $res['email'];
        $this->firstName = $res['first_name'];
        $this->lastName = $res['last_name'];
        $this->phoneNumber = $res['phone_number'];
        $this->status = $res['status'];
        $this->userType = $res['user_type'];
    }

    public function checkIfInDB($username, $email) {
        
        $query = "SELECT id FROM user WHERE username='".$username."' OR email='".$email."';";
        $res = $this->fetchOne($query);
        return $res!=null;
    }

    public function insert($data) {
        
        $query = "INSERT INTO user (username, password, email, first_name, last_name, phone_number, user_type, status) VALUES (
            '".$data["username"]."', '".$data["password"]."', '".$data["email"]."', '".$data["firstName"].
            "', '".$data["lastName"]."', '".$data["phoneNumber"]."', ".$data["userType"].", ".$data["status"].");";

        $res = $this->executeQuery($query);
        return $res;
        return !$res==null;
        
    }

    public function fetchAll() {

        $query = "SELECT username FROM user WHERE user_type!=2;";
        $res = $this->executeQuery($query);
        $users = [];
        if ($res->num_rows > 0) {
            while ($u = $res->fetch_assoc()) {
                $users[] = $u;
            }
        }

        return $users;
    }

    public function update($data) {
        $query = "UPDATE user SET first_name='".$data["firstName"]."', last_name='".$data["lastName"].
        "', phone_number='".$data["phoneNumber"]."' WHERE username='".$data["username"]."';";

        $res = $this->executeQuery($query);
        return $res!=null;
    }

    public function changePassword($data) {
        $query = "UPDATE user SET password='".$data["password"]."' WHERE username='".$data["username"]."';";
        $res = $this->executeQuery($query);
        return $res!=null;
    }

    public function delete($username) {
        $query = "DELETE FROM user WHERE username='".$username."'";
        $res = $this->executeQuery($query);
        return $res!=null;
    }
    public function fetchNew() {
        
        $query = "SELECT username FROM user WHERE status=2;";
        $res = $this->executeQuery($query);
        $users = [];
        if ($res->num_rows > 0) {
            while ($u = $res->fetch_assoc()) {
                $users[] = $u;
            }
        }

        return $users;      
    }

    public function processRequest($username, $newStatus) {

        $query = "UPDATE user SET status=".$newStatus." WHERE username='".$username."';";

        $res = $this->executeQuery($query);
        return $res !=null;

    }

    public function upgradePrivileges($uID) {

        $query = "UPDATE user SET user_type= 1 WHERE id=".$uID.";";
        $res = $this->executeQuery($query);
        
        return $res !=null;
    }

    public function getID() {
        return $this->id;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getFirstName() {
        return $this->firstName;
    }
    public function getLastName() {
        return $this->lastName;
    }
    public function getPhoneNumber() {
        return $this->phoneNumber;
    }
    public function getUserType() {
        return $this->i2type[$this->userType];
    }

}

?>