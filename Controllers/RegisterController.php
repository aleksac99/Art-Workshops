<?php

class RegisterController {

    public static function index($byAdmin=false) {
        
        $validation = "validateRegisterParams()";

        if ($_SERVER["REQUEST_METHOD"]=="GET") {

            require_once "./views/register.php";
            require_once "./views/footer.php";
        }
        else if ($_SERVER["REQUEST_METHOD"]=="POST") {
            
            if ($_FILES["profilePicture"]["tmp_name"]!="") {
                
                $size = getimagesize($img = $_FILES["profilePicture"]["tmp_name"]);
                if(($size[0]<100 && $size[1]<100) || ($size[0]>300 && $size[1]>300)) {
                    
                    $_SESSION["message"] = "Neadekvatne dimenzije slike.";
                    $_SESSION["alert_class"] = "danger";
                    $tmp=0;
                }
                else {
                    $tmp=1;
                }
            }
            else {
                $tmp=1;
            }

            if($tmp) {
                $u = self::register($byAdmin);

                if (!$byAdmin) {
    
                    require_once "./Controllers/LoginController.php";
                    LoginController::addSessionLoginInfo(isset($u), false, $u);
                }
                self::addSessionRegisterInfo(isset($u), $byAdmin, $u);
            }

            $loc = ($_SESSION["admin"]??false) ? "user/add": (isset($u) ? "" : "register" );
            Router::redirect($loc);
    }
}
    public static function deleteProfilePicture($user) {

        $imgDir = implode("/", ["res", $user->getID(), "profile"]);
        if (is_dir($imgDir)) {
            $tmp = scandir($imgDir);
            $imgName = end($tmp);
            unlink(implode("/", [$imgDir, $imgName]));
        }
    }

    public static function saveProfilePicture($user) {

        $fileType = $_FILES["profilePicture"]["type"];

        if (in_array($fileType, ["image/jpeg", "image/png"])) {

            $img = $_FILES["profilePicture"]["tmp_name"];
            $path = implode("/", ["res", $user->getID(), "profile"]);
            if (!file_exists($path)) mkdir ($path, 0777, true);
            $path = implode("/", [$path, $_FILES["profilePicture"]["name"]]);
            move_uploaded_file($img, $path);

            return $path;
        }

    }

    private static function addSessionRegisterInfo($successful, $byAdmin, $u) {

        if (!$successful) {
            $_SESSION["message"] = "Osoba sa istim korisničkim imenom ili e-mailom već postoji.";
            $_SESSION["alert_class"] = "danger";
        }
        else if ($byAdmin) {
            $_SESSION["message"] = "Uspešno registrovan novi korisnik.";
            $_SESSION["alert_class"] = "success";
        }
        else {
            $_SESSION["message"] = "Zahtev za registraciju uspešno poslat. Čeka se odobrenje od strane Administratora.";
            $_SESSION["alert_class"] = "success";
        }
    }

    private static function register($byAdmin) {

        $u = new User();

        if (!$u->checkIfInDB($_POST["username"], $_POST["email"])) {
            $resInsertUser = $u ->insert([
                "username" => $_POST["username"],
                "password" => $_POST["password"],
                "email" => $_POST["email"],
                "firstName" => $_POST["firstName"],
                "lastName" => $_POST["lastName"],
                "phoneNumber" => $_POST["phoneNumber"],
                "status" => $byAdmin ? 0 : 2,
                "userType" => isset($_POST["asOrganizer"]) ? 1 : 0
            ]);

            $u->fetchByUsername($_POST["username"]);

            self::saveProfilePicture($u);

            if (isset($_POST["asOrganizer"])) {

                require_once './Models/Organization.php';

                $o = new Organization();
                $resInsertOrganization = $o->insert([
                    "userId" => $u->getID(),
                    "name" =>$_POST["organizationName"],
                    "address" => $_POST["organizationAddress"],
                    "organizationNumber" => $_POST["organizationNumber"]
                ]);
            }
        }
        return $u;
    }
}

?>