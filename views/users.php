<h1 class="text-center p-4">Lista svih korisnika</h1>
<div class="container bg-light w-75 border rounded p-4 d-flex flex-column align-items-center">
    <?php foreach($users as $user) { ?>
        <div class="row border rounded w-75 text-center p-1">
            <div class="col-6"><a class="link" href="<?php echo Router::createURI("user/u/".$user["username"]); ?>"><?php echo $user["username"] ?></a></div>
            <div class="col-6"><a class="btn btn-danger" href="<?php echo Router::createURI("user/delete/".$user["username"]); ?>">Obriši</a></div>
        </div>
    <?php } ?>
</div>