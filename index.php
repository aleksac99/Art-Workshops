<?php
    require_once 'config/config.php';
    require_once 'Router.php';
?>
<!DOCTYPE html>
<head>
    <title><?php echo constant("SITE_NAME"); ?></title>
    <link rel="stylesheet" href="<?php echo Router::createURI("bootstrap/css/bootstrap.css"); ?>">
</head>
<body>
    <?php
        require_once "./Models/User.php";

        session_start();

        if (isset($_SESSION["message"])) { ?>
        <div class="alert alert-<?php echo $_SESSION["alert_class"]; ?>" role="alert">
        <?php echo $_SESSION["message"]; ?>
        </div>
            <?php unset($_SESSION["message"]);
            unset($_SESSION["alert_class"]);
        }
        
        try {

            Router::callController($_SESSION["user"]??null);
        }
        catch(Exception $e) {
            $_SESSION["message"] = "GRESKA: ".$e->getMessage().$e->getTraceAsString();
            $_SESSION["alert_class"] = "danger";
            Router::redirect("");
        }
        require_once "views/footer.php";
    ?>
</body>
</html>