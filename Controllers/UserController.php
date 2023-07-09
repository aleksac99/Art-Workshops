<?php

class UserController {
    public static function index() {

        if (!$_SESSION["admin"]) {
            Router::redirect("user/u/".$_SESSION["user"]->getUsername());
        }
        require_once "./Models/User.php";
        $u = new User();
        $users = $u->fetchAll();
        
        require_once "./views/header.php";
        require_once "./views/navbar.php";
        require_once "./views/users.php";
        require_once "./views/footer.php";

    }
    public static function u($username=null) {

        if (!($_SESSION["admin"]??false) && $username!=$_SESSION["user"]->getUsername()) {
            Router::redirect("user/u/".$_SESSION["user"]->getUsername());
        }

        
        $validation = "validateUpdateParams()";
        
        require_once "./Models/User.php";
        require_once "./Models/Comment.php";
        require_once "./Models/Workshop.php";
        require_once "./Models/WorkshopLike.php";


        $u = new User();
        $u->fetchByUsername($username);
        $c = new Comment();
        $w = new Workshop();
        $l = new WorkshopLike();
        
        if (isset($_POST["updateProfile"])) {

            $resUpdateUser = $u ->update([
                "username" => $u->getUsername(),
                "firstName" => $_POST["firstName"],
                "lastName" => $_POST["lastName"],
                "phoneNumber" => $_POST["phoneNumber"]
            ]);

            $_SESSION["message"] = "Podaci o korisniku uspešno ažurirani.";
            $_SESSION["alert_class"] = "success";
            
            $u->fetchByUsername($username);

            Router::redirect("user/u/".$u->getUsername());
        }
        else if (isset($_POST["updateProfilePicture"])) {
            
            require_once "./Controllers/RegisterController.php";

            if ($_FILES["profilePicture"]["tmp_name"]!="") {

                $size = getimagesize($img = $_FILES["profilePicture"]["tmp_name"]);
                if(($size[0]<100 && $size[1]<100) || ($size[0]>300 && $size[1]>300)) {
                    
                    $_SESSION["message"] = "Neadekvatne dimenzije slike.";
                    $_SESSION["alert_class"] = "danger";
                }
                else {

                    RegisterController::deleteProfilePicture($u);
                    RegisterController::saveProfilePicture($u);
        
                    $_SESSION["message"] = "Profilna slika uspešno ažurirana.";
                    $_SESSION["alert_class"] = "success";
                }
            }
            else {

                $_SESSION["message"] = "Izaberite novu sliku.";
                $_SESSION["alert_class"] = "danger";
            }

            Router::redirect("user/u/".$u->getUsername());
        }
        else if (isset($_POST["changePassword"])) {

            if ($u->checkPassword($u->getID(), $_POST["oldPassword"], $_POST["newPassword"])==-1) {
                $_SESSION["message"] = "Pogrešna lozinka";
                $_SESSION["alert_class"] = "danger";
                Router::redirect("user/u/".$u->getUsername());
            }
            else if ($u->checkPassword($u->getID(), $_POST["oldPassword"], $_POST["newPassword"])==-2) {

                $_SESSION["message"] = "Stara i nova lozinka ne smeju biti iste";
                $_SESSION["alert_class"] = "danger";
                Router::redirect("user/u/".$u->getUsername());
            }
            else {
                $res = $u->changePassword([
                    "password" => $_POST["newPassword"],
                    "username" => $u->getUsername()
                ]);

                if ($res) {

                    require_once "Models/Password.php";
                    $p = new Password();

                    $p->delete($u->getID());

                    $_SESSION["message"] = "Lozinka uspešno ažurirana.";
                    $_SESSION["alert_class"] = "success";
                    Router::redirect("logout/change");
                }
            }
        }
        else if (isset($_POST["editComment"])) {
            $c->edit([
                "commentID" => $_POST["commentID"],
                "text" => $_POST["commentText"]
            ]);
        }
        else if (isset($_POST["deleteComment"])) {
            $c->delete([
                "commentID" => $_POST["commentID"]
            ]);
        }
        else if (isset($_POST["unlike"])) {
            $l->delete([
                "userId" => $u->getID(),
                "workshopName" => $_POST["workshopName"]
            ]);
        }

        $sortType = isset($_POST["sort"]) ? $_POST["sort"] : "0";
        $searchName = $_POST["searchName"] ?? "%";
        $searchAddress = $_POST["searchAddress"] ?? "%";
        $workshops = $w->fetchFromApplications($u->getID(), $sortType, $searchName, $searchAddress, true);
        $workshopTitle = "Radionice na kojima sam prisustvovao/la";

        // Get user likes
        $likes = $l->fetchByUserId($u->getID());

        // Get user comments
        $comments = $c->fetchByUserId($u->getID());
        
        require_once "./views/header.php";
        require_once "./views/navbar.php";
        require_once "./views/user_profile_photo.php";
        require_once "./views/register.php";
        require_once "./views/workshops.php";
        require_once "./views/actions.php";
        require_once "./views/footer.php";
    }

    public static function delete($username) {
        require_once "./Models/User.php";
        $u = new User();
        $u->delete($username);
        Router::redirect("user");
    }

    public static function new() {

        if ($_SERVER["REQUEST_METHOD"]=="POST") {
            if (isset($_POST["accept"])) {
                self::accept($_POST["username"]);
            }
            else if (isset($_POST["deny"])) {
                self::deny($_POST["username"]);
            }
        }

        $u = new User();
        $users = $u->fetchNew();
        
        require_once "./views/header.php";
        require_once "./views/navbar.php";
        require_once "./views/users_new.php";
        require_once "./views/footer.php";
    }

    public static function add(){

        $validation = "validateRegisterParams()";

        if ($_SERVER["REQUEST_METHOD"]=="GET") {

            require_once "./views/header.php";
            require_once "./views/navbar.php";
            require_once "./views/register.php";
            require_once "./views/footer.php";
        }
        else if ($_SERVER["REQUEST_METHOD"]=="POST") {

            require_once "./Controllers/RegisterController.php";
            RegisterController::index(true);
        }
    }

    private static function processRequest($username, $accept) {
        
        require_once "./Models/User.php";
        $u = new User();
        $users = $u->processRequest($username, $accept);

        Router::redirect("user/new");
    }

    public static function accept($username) {
        self::processRequest($username, 0);
    }

    public static function deny($username) {
        self::processRequest($username, 1);
    }

}
?>