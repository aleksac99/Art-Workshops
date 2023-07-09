<?php require_once "./views/map_imports.php"; ?>
<script src="<?php echo Router::createURI("bootstrap/js/bootstrap.js"); ?>"></script>
<script src="<?php echo Router::createURI("js/workshop.js"); ?>"></script>
<div class="container">
    <div class="row p-4">
        <h1 class=" text-center text-primary"> <?php echo $w->getName(); ?> </h1>
    </div>
    <?php
    if ($organizerOrAdmin) { ?>
        <div class="row bg-light border rounded p-4">
            <h3 class="text-center">Prijave za ovu radionicu</h3>
            <div class="container border rounded w-75">
                <?php foreach ($applications as $application) { ?>
                    <div class="row bg-light border rounded text-center">
                        <div class="col-4  p-4"><?php echo $application["username"]; ?></div>
                        <?php if ($application["status"]==0) { ?>
                            <div class="col-8 text-success p-4">Prihvaćen</div>
                        <?php }
                        else if ($application["status"]==1) { ?>
                            <div class="col-8 text-danger p-4">Odbijen</div>
                        <?php }
                        else { ?>
                            <div class="col-8 p-4">
                                <form action="" method="post">
                                    <input type="hidden" name="uID" value="<?php echo $application["user_id"]; ?>">
                                    <input class="btn btn-success" name="acceptApplication" type="submit" value="Prihvati">
                                    <input class="btn btn-danger" name="denyApplication" type="submit" value="Odbij">
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                <?php }
                ?>
            </div>
        </div>
    <?php }
    ?>
    <div class="row bg-light border rounded p-4">
        <div class="col-8">
            <p> <?php echo $w->getLongDescription(); ?> </p>
        </div>
        <div class="col-4">
            <?php
                $imgDir = implode("/", ["res", $w->getUserId(), "workshops", $w->getName(), "main"]);
                // $imgDir = Router::createURI(implode("/", ["res", $w["user_id"], "workshops", $w["name"], "main"]));
                $tmp = scandir($imgDir);
                $imgName = end($tmp);
            ?>
            <img width=500 height=600 class="img-thumbnail" src="<?php echo Router::createURI(implode("/", [$imgDir, $imgName])); ?>">
        </div>
    </div>
    <div class="row bg-light border rounded p-4">
        <div class="col-8">
            <h5> <?php echo $w->getAddress(); ?> </h5>
            <h5> <?php echo $w->getDate(); ?> </h5>
            <h5>Trenutno prijavljeno: <?php echo $a->getNumberOfApplications($w->getId(), [0, 2]); ?> </h5>
            <h5>Maksimalni broj učesnika: <?php echo $w->getMaxNumberOfApplications(); ?> </h5>
            <hr>
            <?php
            if ($w->getDate()<date("Y-m-d H:i:s")) {
                if ($organizerOrAdmin) {
                    $cls = "";
                    $msg = "Radionica se završila";
                }
                else if ($applied) {
                    if ($a->getStatus()==0) {
                        $msg = "Prisustvovali ste ovoj radionici";
                        $cls = "text-success";
                    }
                    else if ($a->getStatus()==1) {
                        $msg = "Administrator je odbio Vaš zahtev za ovu radionicu";
                        $cls = "text-danger";
                    }
                    else {
                        $msg = "Administrator nije razmotrio Vaš zahtev za ovu radionicu";
                        $cls = "text-info";
                    }
                }
                else {
                    $msg = "Niste se prijavili za ovu radionicu";
                    $cls = "text-info";
                } ?>
                <p class="<?php echo $cls; ?>"><?php echo $msg; ?></p>
            <?php }
            else if ($organizerOrAdmin) { // If organizer of this WS or admin
                echo "<a class='btn btn-info' role='button' href=".Router::createURI(implode("/", ["workshops", "edit", $w->getId()])).">Izmeni</a>";
                echo " <a class='btn btn-danger' role='danger' href=".Router::createURI(implode("/", ["workshops", "delete", $w->getId()])).">Obrisi</a>";
            }
            else {
                if($applied) { ?>
                <?php if ($a->getStatus()==0) { ?>
                    <p class="text-success">Organizator je odobrio prijavu</p>
                    <a class="btn btn-danger <?php echo $disallowCancel?" disabled":"";?>" role="button" href="<?php echo Router::createURI("workshops/quit/".$w->getId()); ?>">Odjavi se</a>
                <?php } else if ($a->getStatus()==2) { ?>
                    <p class="text-info">Prijava poslata organizatoru</p>
                    <a class="btn btn-danger <?php echo $disallowCancel?" disabled":"";?>" role="button" href="<?php echo Router::createURI("workshops/quit/".$w->getId()); ?>">Odjavi se</a>
                <?php } else {?>
                    <p class="text-danger">Organizator nije odobrio prijavu</p>
                <?php } ?>
                <?php }
                else if ($a->getNumberOfApplications($w->getId(), [0, 2])<$w->getMaxNumberOfApplications()) {?>
                    <a class="btn btn-success" role="button" href="<?php echo Router::createURI("workshops/apply/".$w->getId()); ?>">Prijavi se</a>
                    <?php
                }
                else {
                // TODO: Notify me if workshop becomes available
                echo "Obavesti me ako se mesto bude oslobodilo";
                }
            }
            ?>
        </div>
        <div class="col-4">
            <div id="map" style="height: 415.467px; width: 415.467px; border:solid"></div>
        </div>
    </div>
    <?php
        $imgDir = implode("/", ["res", $w->getUserId(), "workshops", $w->getName(), "optional"]);
        if (is_dir($imgDir)) { ?>
        <div class="row justify-content-center p-4">
            <div id="carouselExampleControls" class="carousel slide w-75" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                        $active=" active";
                        $tmp = array_diff(scandir($imgDir), [".", ".."]);
                        foreach($tmp as $imgName) { ?>
                            <div class="carousel-item<?php echo $active; ?>">
                                <?php $active=""; ?>
                                <img src="<?php echo Router::createURI(implode("/", [$imgDir, $imgName])); ?>" class="d-block w-100">
                            </div>
                        <?php } ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    <?php } ?>
    <div class="row bg-light border rounded p-4">
        <h3 class="text-center">Sviđanja i komentari</h3>
        <div class="container border rounded w-50">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-2 d-flex justify-content-center">
                    <?php if ($a->checkIfAttended($_SESSION["user"]->getID(), $w->getName())) { ?>
                        <form action="" method="post" class="form">
                            <button class="btn" name="toggleLike" type="submit">
                                <?php } ?>
                                    <img width=80 height=80 src="<?php
                                    if ($a->checkIfAttended($_SESSION["user"]->getID(), $w->getName())) {
                                        if ($l->checkIfLiked($_SESSION["user"]->getID(), $w->getName())) {
                                            echo Router::createURI("res/default/red_heart.png");
                                        }
                                        else {
                                            echo Router::createURI("res/default/black_heart.png");
                                        }
                                    }
                                    else {
                                        echo Router::createURI("res/default/gray_heart.png");
                                    }
                                ?>">
                            </button>
                        </form>
                    <?php if ($a->checkIfAttended($_SESSION["user"]->getID(), $w->getName())) { ?> </a> <?php } ?>
                    </div>
                    <div class="col-2">
                        <img class="img-fluid" src="<?php echo Router::createURI("res/default/comment.png"); ?>" onclick="focusComment()">
                    </div>
                </div>
                <div class="row d-flex justify-content-between">
                    <div class="col-2 text-center">
                        <h4><?php echo count($likes); ?></h4>
                    </div>
                    <div class="col-2 text-center">
                        <h4><?php echo count($comments); ?></h4>
                    </div>
                </div>
            </div>
        <?php
            foreach ($comments as $cc) { ?>
                <div class="row border rounded p-2">
                    <div class="col-2">
                        
                        <?php
                            $imgDir = implode("/", ["res", $cc["user_id"], "profile"]);
                            if (is_dir($imgDir)) {
                                $tmp = scandir($imgDir);
                                $imgName = end($tmp);
                            }
                            else {
                                $imgDir = "res/default";
                                $imgName = "default_profile.jpg";
                            }
                        ?>
                        <img width=200 height=200 class="img-thumbnail" src="<?php echo Router::createURI(implode("/", [$imgDir, $imgName])); ?>">
                    </div>
                    <div class="col-10">
                        <p>
                            <?php echo $cc["username"].", ".$cc["datetime"]; ?>
                        </p>
                        <div id="comment-text-div-<?php echo $cc["id"] ?>">
                            <span id="comment-text-span"><?php echo $cc["text"];?></span>
                            <?php
                            if ($cc["user_id"]==$_SESSION["user"]->getID()) { ?>
                                <br>
                                <input class="btn btn-link" type="button" value="Izmeni" onclick="editComment(<?php echo $cc['id'];?>)">
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="row border rounded p-2">
                    <form action="" class="form" method="post">
                        <div class="form-group d-flex flex-row justify-content-between align-items-center">
                            Komentar:
                            <input id="addComment" name="comment" type="text" class="form-control w-50"  <?php echo $a->checkIfAttended($_SESSION["user"]->getID(), $w->getName())?"":"disabled"; ?>>
                            <input name="sendComment" class="btn btn-warning <?php echo $a->checkIfAttended($_SESSION["user"]->getID(), $w->getName())?"":"disabled"; ?>" type="submit" value="Pošalji">
                        </div>
                    </form>
                </div>
                <?php if ($a->checkIfAttended($_SESSION["user"]->getID(), $w->getName())) { ?>
                    <div class="row border rounded p-2">
                        <h3 class="text-center">Osobe kojima se ova radionica sviđa</h3>
                    </div>
                    <?php foreach($likes as $like) {?>
                        <div class="row"><p class="text-center"><?php echo $like["username"]; ?></p></div>
                        <?php } ?>
                <?php } ?>
        </div>
    </div>
</div>
<script>
var coordinates = [<?php echo ($w??false) ? $w->getAddressLong(): 0.;?>, <?php echo ($w??false) ? $w->getAddressLat() : 0.;?>];
var showSearchBar = false;
</script>
<script src="<?php echo Router::createURI("js/render_map.js"); ?>"></script>