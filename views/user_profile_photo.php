<div class="container">
    <div class="row d-flex align-items-center">
        <div class="col-4">
            <?php
                $imgDir = implode("/", ["res", $u->getID(), "profile"]);
                if (is_dir($imgDir)) {
                    $tmp = array_diff(scandir($imgDir), [".", ".."]);
                    $imgName = end($tmp);
                }
                else {
                    $imgDir = "res/default";
                    $imgName = "default_profile.jpg";
                }
            ?>
            <img width=500 height=600 class="img-thumbnail" src="<?php echo Router::createURI(implode("/", [$imgDir, $imgName])); ?>">
        </div>
        <div class="col-8 text-center">
            <h3>Izaberi novu profilnu sliku</h3>
            <form class="form" enctype="multipart/form-data" action="" method="post">
                <div class="form-group">
                    <input class="form-control" type="file" id="profile-picture" name="profilePicture">
                </div>
                <input class="btn btn-primary mt-4 w-100" type="submit" value="Promeni profilnu sliku" name="updateProfilePicture">
            </form>
        </div>
    </div>
</div>