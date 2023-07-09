<h1 class="text-center p-4">Novi zahtevi za registraciju</h1>
<div class="container bg-light w-75 border rounded p-4 d-flex flex-column align-items-center">
    <?php foreach($users as $user) { ?>
        <div class="row border rounded w-75 text-center p-1">
            <div class="col-4"><a class="link" href="<?php echo Router::createURI("user/u/".$user["username"]); ?>"><?php echo $user["username"] ?></a></div>
                <div class="col-4">
                    <form action="" method="post">
                        <input class="btn btn-success" type="submit" name="accept" value="Prihvati">
                        <input type="hidden" name="username" value="<?php echo $user["username"]; ?>">
                    </form>
                </div>
                <div class="col-4">
                    <form action="" method="post">
                        <input type="hidden" name="username" value="<?php echo $user["username"]; ?>">
                        <input class="btn btn-danger" type="submit" name="deny" value="Odbij">
                    </form>
                </div>
        </div>
    <?php } ?>
</div>