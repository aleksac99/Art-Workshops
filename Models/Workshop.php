<?php

require_once './Models/Database.php';

class Workshop extends Database {

    private $id;
    private $userId;
    private $name;
    private $date;
    private $address;
    private $addressLat;
    private $addressLong;
    private $shortDescription;
    private $longDescription;
    private $numberOfApplications;
    private $maxNumberOfApplications;
    private $status;

    public function getId() {
        return $this->id;
    }
    public function getUserId() {
        return $this->userId;
    }
    public function getName() {
        return $this->name;
    }
    public function getDate() {
        return $this->date;
    }
    public function getAddress() {
        return $this->address;
    }
    public function getAddressLat() {
        return $this->addressLat;
    }
    public function getAddressLong() {
        return $this->addressLong;
    }
    public function getShortDescription() {
        return $this->shortDescription;
    }
    public function getLongDescription() {
        return $this->longDescription;
    }
    public function getNumberOfApplications() {
        return $this->numberOfApplications;
    }
    public function getMaxNumberOfApplications() {
        return $this->maxNumberOfApplications;
    }

    public function update($data) {
        
        $query = "UPDATE workshop SET date='".$data["datetime"].
        "', short_description='".$data["shortDescription"]."', long_description='".$data["longDescription"].
        "', address='".$data["address"]."', max_no_applications=".$data["maxNumberOfApplications"].", address_lat=".$data["addressLat"].", address_long=".$data["addressLong"].
        " WHERE id=".$data["id"].";";
        $res = $this->executeQuery($query);
        return $res != null;
    }


    public function insert($data) {
        // Insert text data
        $query = "INSERT INTO workshop (user_id, name, date, address, address_lat, address_long, short_description, long_description, max_no_applications, status) VALUES (
            ".$data["userId"].", '".$data["name"]."', '".$data["date"]."', '".$data["address"]."', ".$data["addressLat"].", ".$data["addressLong"].
            ", '".$data["shortDescription"]."', '".$data["longDescription"]."', ".$data["maxNumberOfApplications"].
            ", ".$data["status"].");";

        $res = $this->executeQuery($query);

        // Insert Main image
        $this->saveImage($_FILES["mainImage"], $_POST["name"], "main", $data["userId"]);

        // Insert optional images
        for ($i=0; $i<count($_FILES["optionalImages"]["name"]); $i++) {
            $this->saveImage([
                "type" => $_FILES["optionalImages"]["type"][$i],
                "tmp_name" => $_FILES["optionalImages"]["tmp_name"][$i],
                "name" => $_FILES["optionalImages"]["name"][$i]],
                $_POST["name"], "optional", $data["userId"]);
        }
        return !$res==null;
    }
    

    public function saveImage($imgData, $name, $subfolder, $userID) {

        $fileType = $imgData["type"]; //$_FILES["mainImage"]

        if (in_array($fileType, ["image/jpeg", "image/png"])) { // OK Type

            $img = $imgData["tmp_name"];    
            $path = implode("/", ["res",$userID, "workshops", $name, $subfolder]);
            if (!file_exists($path)) mkdir ($path, 0777, true);
            move_uploaded_file($img, implode("/", [$path, $imgData["name"]]));

            return $path;
        }

    }

    public function deleteImage($subfolder) {

        $imgDir = implode("/", ["res", $this->getUserId(), "workshops", $this->getName(), $subfolder]);
        if (is_dir($imgDir)) {
            $tmp = array_diff(scandir($imgDir), [".", ".."]);
            foreach($tmp as $imgName) {
                unlink(implode("/", [$imgDir, $imgName]));
            }
        }
    }

    public function accept($wID) {

        $query = "UPDATE workshop SET status=0 WHERE id=".$wID.";";
        $res = $this->executeQuery($query);
        return $res!=null;
    }

    public function deny($wID) {

        $query = "UPDATE workshop SET status=1 WHERE id=".$wID.";";
        $res = $this->executeQuery($query);
        return $res!=null;
    }

    public function fetchNew() {

        $query = "SELECT w.id, w.name, x.cnt FROM workshop w LEFT JOIN (SELECT a.user_id, COUNT(a.id) AS cnt FROM application a JOIN workshop w ON a.workshop_id=w.id WHERE w.date>=NOW() AND a.status!=1 GROUP BY a.user_id) x ON w.user_id=x.user_id WHERE status=2;";
        $res = $this->executeQuery($query);

        $workshops = [];
        if ($res->num_rows > 0) {
            while ($w = $res->fetch_assoc()) {
                $workshops[] = $w;
            }
        }

        return $workshops;      
    }

    public function delete($wID) {
        
        $query = "DELETE FROM workshop WHERE id=".$wID.";";
        $res = $this->executeQuery($query);
        return $res!=null;
    }
    
    public function fetchFromApplications($uid, $sortType=null, $searchName="", $searchAddress="", $attended=true) {

        $query = "SELECT w.* FROM workshop w INNER JOIN application a on w.id=a.workshop_id WHERE a.status!=1 AND a.user_id=".$uid;
        $query .= $attended? " AND date<=NOW()" : " AND date>=NOW()";
        $query .= " AND (LOWER(name) LIKE LOWER('%".$searchName."%') AND LOWER(address) LIKE LOWER('%".$searchAddress."%'))";
        
        if ($sortType) {
            $sortQuery = [
                "",
                " ORDER BY name ASC",
                " ORDER BY name DESC",
                " ORDER BY date ASC",
                " ORDER BY date DESC"
            ];
            $query .= $sortQuery[$sortType];
        }

        $query .= ";";
        $res = $this->executeQuery($query);

        $workshops = [];
        if ($res->num_rows > 0) {
            while ($u = $res->fetch_assoc()) {
                $workshops[] = $u;
            }
        }

        return $workshops;
    }

    public function fetchAll($sortType=null, $searchName="", $searchAddress="") {

        $query = "SELECT * FROM workshop WHERE status=0 AND date>=NOW()";

        $query .= " AND (LOWER(name) LIKE LOWER('%".$searchName."%') AND LOWER(address) LIKE LOWER('%".$searchAddress."%'))";

        if ($sortType) {
            $sortQuery = [
                "",
                " ORDER BY name ASC",
                " ORDER BY name DESC",
                " ORDER BY date ASC",
                " ORDER BY date DESC"
            ];
            $query .= $sortQuery[$sortType];
        }

        $query .= ";";

        $res = $this->executeQuery($query);
        $workshops = [];
        if ($res->num_rows > 0) {
            while ($u = $res->fetch_assoc()) {
                $workshops[] = $u;
            }
        }

        return $workshops;
    }

    public function fetchByUserId($uID, $sortType=null, $searchName="", $searchAddress="") {

        $query = "SELECT * FROM workshop WHERE user_id=".$uID;
        $query .= " AND (LOWER(name) LIKE LOWER('%".$searchName."%') AND LOWER(address) LIKE LOWER('%".$searchAddress."%'))";

        if ($sortType) {
            $sortQuery = [
                "",
                " ORDER BY name ASC",
                " ORDER BY name DESC",
                " ORDER BY date ASC",
                " ORDER BY date DESC"
            ];
            $query .= $sortQuery[$sortType];
        }

        $query .= ";";
        $res = $this->executeQuery($query);

        $workshops = [];
        if ($res->num_rows > 0) {
            while ($u = $res->fetch_assoc()) {
                $workshops[] = $u;
            }
        }

        return $workshops;
    }

    public function fetchById($wID) {

        $query = "SELECT * FROM workshop WHERE id=".$wID.";";

        $res = $this->executeQuery($query);
        if ($res->num_rows > 0) {
            $res = mysqli_fetch_assoc($res);

            $this->id = $res["id"];
            $this->userId = $res["user_id"];
            $this->name = $res["name"];
            $this->date = $res["date"];
            $this->address = $res["address"];
            $this->addressLat = $res["address_lat"];
            $this->addressLong = $res["address_long"];
            $this->shortDescription = $res["short_description"];
            $this->longDescription = $res["long_description"];
            $this->maxNumberOfApplications = $res["max_no_applications"];
            $this->status = $res["status"];
        }
    }

    public function fetchMostLiked() {


        $query = "SELECT w.*, COUNT(l.workshop_name) as c FROM workshop w LEFT JOIN workshop_like l ON w.name=l.workshop_name  WHERE w.status=0 AND w.date>=NOW() GROUP BY w.id ORDER BY c DESC LIMIT 5;";
        $res = $this->executeQuery($query);

        $workshops = [];
        if ($res->num_rows > 0) {
            while ($w = $res->fetch_assoc()) {
                $workshops[] = $w;
            }
        }
        return $workshops;
    }

    public function checkIfAlreadyApproved($wName, $uID) {

        $query = "SELECT * FROM workshop WHERE name='".$wName."' AND user_id=".$uID." AND status=0;";
        $res = $this->fetchOne($query);
        return $res;
    }

}

?>