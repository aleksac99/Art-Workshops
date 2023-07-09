<?php

class LoginController {

    public static function index($adminLogin=false) {

        if ($_SERVER["REQUEST_METHOD"]=="GET") {

            require_once "./views/login.php";
            require_once "./views/footer.php";
        }
        else if ($_SERVER["REQUEST_METHOD"]=="POST") {

            self::login($adminLogin);
        }

    }
    
    public static function addSessionLoginInfo($res, $adminLogin, $u) {

        if ($res==0) { // Account approved
            $_SESSION["admin"] = $adminLogin;
            $_SESSION["user"] = $u;
            $_SESSION["message"] = "Uspešna prijava.";
            $_SESSION["alert_class"] = "success";
        }
        else if ($res==1) { // Account denied
            $_SESSION["message"] = "Administrator je odbio Vaš zahtev za registraciju.";
            $_SESSION["alert_class"] = "danger";
        }
        else if ($res==2) { // Pending approval
            $_SESSION["message"] = "Čeka se odobrenje registracije od strane Administratora.";
            $_SESSION["alert_class"] = "info";
        }
        else if ($res==3) { // Wrong username
            $_SESSION["message"] = "Pogrešno korisničko ime.";
            $_SESSION["alert_class"] = "danger";
        }
        else if ($res==4) { // Wrong password
            $_SESSION["message"] = "Pogrešna lozinka.";
            $_SESSION["alert_class"] = "danger";
            $un = $_POST["username"];
        }
        else if ($res==5) { // Temp password used
            $_SESSION["admin"] = $adminLogin;
            $_SESSION["user"] = $u;
            $_SESSION["message"] = "Uspešno prijavljivanje privremenom lozinkom. Promenite je što pre.";
            $_SESSION["alert_class"] = "info";
        }
        else if ($res==6) { // Temp password wrong
            $_SESSION["message"] = "Neuspešno prijavljivanje privremenom lozinkom.";
            $_SESSION["alert_class"] = "danger";
        }
    }

    public static function temp() {
        echo "asd";
        require_once "views/set_new_password.php";
    }

    private static function login($adminLogin) {

        $u = new User();

        require_once "Models/Password.php";
        $p = new Password();
        $pw = $p->fetchByUsername($_POST["username"]);
        if ($pw) {
            $res = ($pw==$_POST["password"])?5:6;
        }
        else {
            $res = $u->login($_POST["username"], $_POST["password"], $adminLogin);
        }

        if ($res == 0 || $res == 5) $u->fetchByUsername($_POST["username"]);
        
        self::addSessionLoginInfo($res, $adminLogin, $u);
        

        $loc = ($res<3 || $res==5) ? "" : ($adminLogin ? "login/admin": "login");
        Router::redirect($loc);
    }

    public static function admin() {

        self::index(true);
    }

    public static function forgot() {
        
        if ($_SERVER["REQUEST_METHOD"]=="POST") {
            //TODO: Send email

            require_once "Models/Password.php";
            $p = new Password();

            $numbersRange = range('0', '9');
            $lowercaseRange = range('a', 'z');
            $uppercaseRange = range('A', 'Z');
            $specialChars = array_merge(range('(', '/'), range(':', '@'), range('[', '-'));
            $merged = array_merge($numbersRange, $lowercaseRange, $uppercaseRange, $specialChars);

            $tempPassword = $lowercaseRange[array_rand($lowercaseRange)].$numbersRange[array_rand($numbersRange)].$specialChars[array_rand($specialChars)];
            for ($tmp=0; $tmp<13; $tmp++) {
                $tempPassword .= $merged[array_rand($merged)];
            }

            $p->insert([
                "userId" => 58,
                "tempPassword" => $tempPassword
            ]);

            // phpinfo();
            // mail("aleksahet@gmail.com", "TEST", "TESTEST");
            $_SESSION["message"] = "Mejl poslat na datu adresu. Privremena lozinka važi u narednih 30 minuta.";
            $_SESSION["alert_class"] = "info";
            Router::redirect("");
        }

        require_once "views/forgot_password.php";
        require_once "views/footer.php";
    }
}

?>