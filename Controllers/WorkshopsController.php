<?php

    class WorkshopsController {

        public static function index() {
            
            require_once 'views/header.php';
            if ($_SESSION["user"] ?? false) require_once 'views/navbar.php';

            require_once "./Models/Workshop.php";

            $w = new Workshop();
            $sortType = isset($_POST["sort"]) ? $_POST["sort"] : "0";
            $searchName = $_POST["searchName"] ?? "%";
            $searchAddress = $_POST["searchAddress"] ?? "%";
            
            $workshops = $w->fetchFromApplications($_SESSION["user"]->getID(), $sortType, $searchName, $searchAddress, false);
            
            $workshopTitle = "Radionice na kojima sam trenutno prijavljen/a";
            require_once 'views/workshops.php';
            require_once 'views/footer.php';

        }

        public static function apply($wID) {
            
            require_once "./Models/Application.php";
            require_once "./Models/Workshop.php";

            $a = new Application();
            $res = $a->insert([
                "userId" => $_SESSION["user"]->getID(),
                "workshopId" => $wID,
            ]);

            $w = new Workshop();
            $w->fetchById($wID);

            $_SESSION["message"] = "Uspešna prijava na radionicu.";
            $_SESSION["alert_class"] = "success";
            Router::redirect("workshops/w/".$wID);


        }

        public static function quit($wID) {
            
            require_once "./Models/Application.php";
            require_once "./Models/Workshop.php";
            $a = new Application();
            $res = $a->delete($_SESSION["user"]->getID(), $wID);
            $w = new Workshop();
            $w->fetchById($wID);
            
            Router::redirect("workshops/w/".$wID);
        }

        public static function accept($wID) {
            
            require_once "./Models/Workshop.php";
            $w = new Workshop();
            $res = $w->accept($wID);
            if ($res) {
                $u = new User();
                $w->fetchById($wID);
                $u->upgradePrivileges($w->getUserId());
            }
            
            Router::redirect("workshops/new");
        }

        public static function deny($wID) {
            
            require_once "./Models/Workshop.php";
            $w = new Workshop();
            $res = $w->deny($wID);
            
            Router::redirect("workshops/new");
        }

        public static function w($wID) {
            
            if (!$wID) Router::redirect("workshops");

            require_once "./Models/Workshop.php";
            require_once "./Models/Application.php";
            require_once "./Models/WorkshopLike.php";
            require_once "./Models/Comment.php";

            $w = new Workshop();
            $w->fetchById($wID);
            $l = new WorkshopLike();
            $c = new Comment();
            $a = new Application();

            if($_SERVER["REQUEST_METHOD"]=="POST") {

                if (isset($_POST["sendComment"])) {

                    $c->insert([
                        "userId" => $_SESSION["user"]->getID(),
                        "workshopName" => $w->getName(),
                        "text" =>$_POST["comment"]
                    ]);
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
                else if (isset($_POST["toggleLike"])) {
                    
                    if ($l->checkIfLiked($_SESSION["user"]->getID(), $w->getName())) {

                        $l->delete([
                            "userId" => $_SESSION["user"]->getID(),
                            "workshopName" => $w->getName()
                        ]);
                    }
                    else {
            
                        $l->insert([
                            "userId" => $_SESSION["user"]->getID(),
                            "workshopName" => $w->getName()
                        ]);
                    }
                }
                else if (isset($_POST["acceptApplication"])) {
                    $a->accept($_POST["uID"], $w->getId());
                }
                else if (isset($_POST["denyApplication"])) {
                    $a->deny($_POST["uID"], $w->getId());
                }
            }

            $a->getNumberOfApplications($w->getId(), [0, 2]);

            $organizerOrAdmin = ($w->getUserId()==$_SESSION["user"]->getID()) || ($_SESSION["admin"]??false);
            
            $a->fetchApplication($_SESSION["user"]->getID(), $wID);
            $applied = ($a->getStatus()!=null);
            
            if ($organizerOrAdmin) {
                $applications = $a->fetchByWorkshopId($w->getId());
            }

            $likes = $l->fetchByWorkshopName($w->getName());
            $comments = $c->fetchByWorkshopName($w->getName());

            // Calculate time left
            $d1= new DateTime($w->getDate());
            $d2= new DateTime();
            $interval= $d1->diff($d2);
            $disallowCancel =  (($interval->days * 24) + $interval->h)<12;


            require_once "./views/header.php";
            require_once "./views/navbar.php";
            require_once "./views/workshop.php";
            require_once "./views/footer.php";
        }

        public static function my() {

            require_once "./Models/Workshop.php";
            $w = new Workshop();

            $sortType = isset($_POST["sort"]) ? $_POST["sort"] : "0";
            $searchName = $_POST["searchName"] ?? "%";
            $searchAddress = $_POST["searchAddress"] ?? "%";

            $workshops = $w->fetchByUserId($_SESSION["user"]->getID(), $sortType, $searchName, $searchAddress);

            $workshopTitle = "Radionice čiji sam organizator";
            
            require_once "./views/header.php";
            require_once "./views/navbar.php";
            require_once "./views/workshops.php";
            require_once "./views/footer.php";

        }

        public static function new() {
            
            require_once "./Models/Workshop.php";
            $w = new Workshop();
            $workshops = $w->fetchNew();

            require_once "./views/header.php";
            require_once "./views/navbar.php";
            require_once "./views/workshops_new.php";
            require_once "./views/footer.php";
        }

        public static function delete($wID) {

            require_once "./Models/Workshop.php";

            $w = new Workshop();
            $w->delete($wID);
            Router::redirect("workshops");            
        }

        public static function edit($wID) {

            require_once "./Models/Workshop.php";

            $w = new Workshop();
            $w->fetchById($wID);
            $title = "Ažuriraj informacije o radionici";
            $action="update";

            if ($_SERVER["REQUEST_METHOD"]=="GET") {

                require_once "./views/header.php";
                require_once "./views/navbar.php";
                require_once "./views/organizer.php";
                require_once "./views/footer.php";
            }
            else { // POST
                $res = $w->update([
                "id" => $w->getId(),
                "datetime" => $_POST["datetime"],
                "shortDescription" => $_POST["shortDescription"],
                "longDescription" => $_POST["longDescription"],
                "maxNumberOfApplications" => $_POST["maxNumberOfApplications"],
                "address" => $_POST["address"],
                "addressLat" => $_POST["addressLat"],
                "addressLong" => $_POST["addressLong"]
                ]);

                // Update Main Image
                if ($_FILES["mainImage"]["tmp_name"]!="") {
                    $w->deleteImage("main");
                    $w->saveImage($_FILES["mainImage"], $w->getName(), "main", $w->getUserId());
                }

                //Update Gallery
                if ($_FILES["optionalImages"]["tmp_name"][0]!="") {
                    $w->deleteImage("optional");
                    for ($i=0; $i<count($_FILES["optionalImages"]["name"]); $i++) {
                        $w->saveImage([
                            "type" => $_FILES["optionalImages"]["type"][$i],
                            "tmp_name" => $_FILES["optionalImages"]["tmp_name"][$i],
                            "name" => $_FILES["optionalImages"]["name"][$i]],
                            $w->getName(), "optional", $w->getUserId());
                    }
                }

                $_SESSION["message"] = $res ? "Informacije o radionici uspesno ažurirane." : "Neuspešno ažuriranje informacija o radionici.";
                $_SESSION["alert_class"] = $res ? "success" : "danger";

                Router::redirect("workshops/edit/".$w->getId()); // Refresh
            }
        }

    }


?>