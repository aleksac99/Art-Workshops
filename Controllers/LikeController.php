<?php
class LikeController {

    public static function toggle($wID) {

        require_once "Models/WorkshopLike.php";
        require_once "Models/Workshop.php";
        $l = new WorkshopLike();
        $w = new Workshop();
        $w->fetchById($wID);

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

        Router::redirect(implode("/", ["workshops", "w", $wID]));
    }
}
?>