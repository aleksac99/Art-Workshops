<?php
class LogoutController {
    
    public static function index() {

        session_destroy();
        Router::redirect("");
    }
    public static function change() {

        session_destroy();
        Router::redirect("login");
    }
}
?>