<h1 class="text-center pt-4 pb-4">Najbolje ocenjene radionice</h1>
<div class="container">
    <?php foreach($mostLiked as $w) {?>
        <div class="container border rounded border-primary bg-dark text-light p-2">
            <div class="row p-2">
                <div class="col-4">
                    <?php
                    $imgDir = implode("/", ["res", $w["user_id"], "workshops", $w["name"], "main"]);
                    $tmp = scandir($imgDir);
                    $imgName = end($tmp);
                    ?>
                    <img width=500 height=600 class="img-thumbnail" src="<?php echo Router::createURI(implode("/", [$imgDir, $imgName])); ?>">
                </div>
                <div class="col-8">
                    <h3 class="mt-1 text-info">  <?php echo $w["name"]; ?> </h3>
                    <h6 class="mt-1 text-success">Broj sviđanja: <?php echo $w["c"]; ?></h6>
                    <h6 class="mt-1">  <?php echo $w["date"]; ?> </h6>
                    <h6 class="mt-1">  <?php echo $w["address"]; ?> </h6>
                    <p> <?php echo $w["short_description"]; ?> </p>
                    <?php if (isset($_SESSION["user"])){ ?> <a class="btn btn-primary" href="<?php echo Router::createURI("workshops/w/".$w["id"]); ?>">Detalji</a>
                    <?php }?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>