<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse justify-content-md-center">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href=" <?php echo Router::createURI("user"); ?>">Profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=" <?php echo Router::createURI("workshops"); ?>">Radionice</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href=" <?php echo Router::createURI("organizer"); ?>"> Postani organizator</a>
            </li>
            <?php
                if ($_SESSION["user"]->getUserType()=="Organizator" || $_SESSION["admin"]) { ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo Router::createURI("workshops/my"); ?>">Moje radionice</a></li>
                <?php }
            ?>
            <?php if (($_SESSION["admin"]??false)) {?>
                <li class="nav-item"> <a class="nav-link" href=" <?php echo Router::createURI("user/new"); ?>">Zahtevi za registraciju</a></li>
                <li class="nav-item"> <a class="nav-link" href=" <?php echo Router::createURI("workshops/new"); ?>">Zahtevi za nove radionice</a></li>
                <li class="nav-item"> <a class="nav-link" href=" <?php echo Router::createURI("user/add"); ?>">Dodaj novog korisnika</a></li>
            <?php }?>
        </ul>
    </div>
</nav>