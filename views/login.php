<?php require_once './config/config.php'; ?>
<div class="container w-25 p-5 text-center">
    <div class="row m-2"><a class="link" href="<?php echo Router::createURI(""); ?>"><h1 class="text-center">Moje Radionice</h1></a></div>
    <?php
    if ($adminLogin) {
        echo "<div class='row m-2'><h1>Login za Administratore</h1></div>";
    }
    ?>
    <div class="row m-2">
        <form action="" method="post" name="login">
            <div class="form-floating m-2">
                <input type="text" id="floatingUsername" class="form-control" name="username" placeholder>
                <label for="floatingUsername">Korisničko ime</label>
            </div>
            <div class="form-floating m-2">
                <input class="form-control" type="password" id="floatingPassword" name="password" placeholder>
                <label for="floatingPassword">Lozinka</label>
            </div>
                <input class="btn btn-primary m-2" type="submit" value="Prijavi se">
        </form>
    </div>
    <div class="row m-2">
        Zaboravljena lozinka? <a href="<?php echo Router::createURI("login/forgot"); ?>">Klikni ovde</a>
    </div>
    <div class="row m-2">
        Nemaš nalog? <a href="<?php echo Router::createURI("register"); ?>">Registruj se</a>
    </div>
</div>