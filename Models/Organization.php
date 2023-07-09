<?php

require_once './Models/Database.php';

class Organization extends Database {

    private $id;
    private $userId;
    private $name;
    private $address;
    private $organizationNumber;


    public function insert($data) {
        
        $query = "INSERT INTO organization (user_id, name, address, organization_number) VALUES (
            ".$data["userId"].", '".$data["name"]."', '".$data["address"]."', '".$data["organizationNumber"]."');";

        $res = $this->executeQuery($query);
        return !$res==null;
        
    }

}

?>