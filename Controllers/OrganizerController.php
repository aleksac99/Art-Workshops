<?php

class OrganizerController {

    public static function index() {

        require_once "./Models/Workshop.php";
        $w = new Workshop();
        $workshops = $w->fetchByUserId($_SESSION["user"]->getID());

        $title = "Predloži radionicu";
        $action = "insert";

        if ($_SERVER["REQUEST_METHOD"]=="POST") {

            if (isset($_POST["addWorkshop"])) {

                $u = $_SESSION["user"];
                $approved = $w->checkIfAlreadyApproved($_POST["name"], $u->getID()) || ($_SESSION["admin"]??false);
                
                $w->insert([
                    "userId" => $u->getID(),
                    "name" => $_POST["name"],
                    "date" => $_POST["datetime"],
                    "address" => $_POST["address"],
                    "addressLat" => $_POST["addressLat"],
                    "addressLong" => $_POST["addressLong"],
                    "shortDescription" => $_POST["shortDescription"],
                    "longDescription" => $_POST["longDescription"],
                    "maxNumberOfApplications" => $_POST["maxNumberOfApplications"],
                    "status" => ($approved ? 0 : 2)
                ]);

                $_SESSION["message"] = "Zahtev za radionicu uspesno poslat.";
                $_SESSION["message"] .= ($approved) ? " Radionica je automatski odobrena." : " Čeka se odobrenje od strane Administratora." ;
                $_SESSION["alert_class"] = "info";
                Router::redirect("organizer");
            }
            else if (isset($_POST["workshopPattern"])) {
                
                if ($_POST["workshopPattern"]!="") {
                    
                    $w->fetchById($_POST["workshopPattern"]);
                }
            }
        }
        
        require_once "./views/header.php";
        require_once "./views/navbar.php";
        require_once "./views/organizer.php";
        require_once "./views/footer.php";
    }
}

?>