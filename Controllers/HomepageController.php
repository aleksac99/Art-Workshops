<?php

    class HomepageController {

        public static function index() {
            
            require_once 'views/header.php';
            if (isset($_SESSION["user"])) require_once 'views/navbar.php';

            require_once "./Models/Workshop.php";

            $w = new Workshop();
            $sortType = isset($_POST["sort"]) ? $_POST["sort"] : "0";
            $searchName = $_POST["searchName"] ?? "%";
            $searchAddress = $_POST["searchAddress"] ?? "%";
            $workshops = $w->fetchAll($sortType, $searchName, $searchAddress);
            $mostLiked = $w->fetchMostLiked();

            
            $workshopTitle = "Trenutno dostupne radionice";

            require_once "views/top_workshops.php";
            require_once "views/workshops.php";

        }
    }


?>