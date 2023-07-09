<?php
class Router {

    private static $guestRoutes = ["login", "login/admin", "login/forgot", "register", ""];
    private static $userRoutes = ["logout", "homepage", "user", "user/u/", "workshops", "workshops/w/", "workshops/apply/", "workshops/quit/", "organizer", "like/toggle/", ""];
    private static $organizerRoutes = ["workshops/accept/", "workshops/deny/", "workshops/my", "workshops/edit/", "workshops/delete/"];
    private static $adminRoutes = ["user/delete/", "user/new", "workshops/new", "workshops/accept/", "workshops/deny/", "user/add"];

    private static function checkPrivileges($u, $uri) {

        $t = ($u??false)?$u->getUserType():"Gost";

        $c = "";
        if($uri["controller"]=="Homepage") {
            return Router::checkArray($t, $c);
        }
        $c = lcfirst($uri["controller"]);
        if ($uri["method"]=="index") {
            return Router::checkArray($t, $c);
        }
        $c .= "/".$uri["method"];
        if ($uri["arg"]=="") {
            return Router::checkArray($t, $c);
        }
        $c .= "/";
        return Router::checkArray($t, $c);
    }

    private static function checkArray($t, $uri) {

        if ($t=="Gost") {
            return in_array($uri, Router::$guestRoutes);
        }
        else if ($t=="Učesnik") {
            return in_array($uri, Router::$userRoutes);
        }
        else if ($t=="Organizator") {
            return in_array($uri, array_merge(Router::$userRoutes, Router::$organizerRoutes));
        }
        else if ($t=="Administrator") {
            return in_array($uri, array_merge(Router::$userRoutes, Router::$organizerRoutes, Router::$adminRoutes));
        }
    }
    
    public static function getURI() {
        
        $path_info = trim($_SERVER['REQUEST_URI'], "/");
        return explode('/', $path_info);

    }

    private static function processURI() {

        $controllerPart = self::getURI()[1] ?? '';
        $methodPart = self::getURI()[2] ?? '';
        $argPart = self::getURI()[3] ?? '';

        return [
            "controller" => !empty($controllerPart) ? ucfirst($controllerPart) : "Homepage", // Uppercase first
            "method" => (!empty($methodPart) ? $methodPart : "index"),
            "arg" => $argPart
        ];

    }

    public static function callController($u) {
        
        $uri = self::processURI();
        if (!Router::checkPrivileges($u, $uri)) {
            $_SESSION["message"] = "Nemate pristup traženoj stranici!";
            $_SESSION["alert_class"] = "danger";
            Router::redirect("");
        }

        $controller = $uri["controller"]."Controller";
        
        $path = implode("/", ["Controllers", $controller.".php"]);
                
        require_once $path;

        isset($uri["arg"]) ? $controller::{$uri["method"]}($uri["arg"]) : $controller::{$uri["method"]}();

    }

    public static function redirect($location) {

        $h = self::createURI($location);
        header("Location: ".$h);
    }

    public static function createURI($location) {
        
        return implode("/", [
            "http:/",
            constant("URL_ROOT"),
            constant("URL_SUBFOLDER"),
            $location
        ]);
    }

}

?>