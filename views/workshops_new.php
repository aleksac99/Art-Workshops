<h1 class="text-center p-4">Zahtevi za nove radionice</h1>
<div class="container bg-light w-75 border rounded p-4 d-flex flex-column align-items-center">
    <?php foreach($workshops as $w) { ?>
        <div class="row border rounded w-75 text-center p-1">
            <div class="col-3"><?php echo $w["name"] ?></div>
            <div class="col-3"><a class="btn btn-info" href="<?php echo Router::createURI("workshops/w/".$w["id"]); ?> ">Detalji</a></div>
            <div class="col-3"><a class="btn btn-success<?php echo $w["cnt"]?" disabled":""; ?>" href="<?php echo Router::createURI("workshops/accept/".$w["id"]); ?> ">Prihvati</a></div>
            <div class="col-3"><a class="btn btn-danger" href="<?php echo Router::createURI("workshops/deny/".$w["id"]); ?> ">Odbij</a></div>
        </div>
    <?php } ?>
</div>