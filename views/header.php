<div class="container bg-dark">
    <header class="d-flex justify-content-around py-3">
        <div class="logo text-primary">
            <span class="fs-4"> <a href="<?php echo Router::createURI(""); ?>">Moje radionice</a></span>
        </div>

            <?php
                if (isset($_SESSION["user"])) { ?>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <p class="text-light">Zdravo, <?php echo $_SESSION["user"]->getUsername() ?></p>
                        <a href="<?php echo Router::createURI("logout"); ?>" class="nav-link active  color-accent-1 text-center">Odjavi se</a>
                    </li>
                </ul>
                <?php }
                else { ?> 
                    <ul class="nav nav-pills">
                        <li class="nav-item rounded-pill"> <a class="nav-link active" href="./login">Login</a></li>
                        <li class="nav-item rounded-pill"> <a class="nav-link" href="./register">Register</a></li>
                    </ul>
                <?php } ?>
    </header>
</div>