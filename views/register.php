<script src="<?php echo Router::createURI("js/register.js"); ?>"></script>
<?php
require_once "./views/map_imports.php";
?>
<div class="container">
    <div class="row text-center p-4">
        <?php $title = ($u ?? false) ? "Moje informacije": "Registruj se"; ?>
        <h1><?php echo $title; ?></h1>
    </div>
    <div class="row">
        <?php require_once "./views/register_form.php"; ?>
    </div>
    <?php if ((!($u ?? false)) && !(isset($_SESSION["admin"])??false)) { ?>
        <div class="row">
        <p class="text-center">Imaš nalog? <a href="<?php echo Router::createURI("login"); ?>">Prijavi se</a></p>
        </div>
    <?php } else if (($u ?? false)) { ?>
        <div class="row text-center p-4">
            <h1>Promeni lozinku</h1>
        </div>
        <div class="row">
            <?php require_once "./views/change_password_form.php"; ?>
        </div>
    <?php }?>
</div>

<script src="<?php echo Router::createURI("js/address_search.js"); ?>"></script>