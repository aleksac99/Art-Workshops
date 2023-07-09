<main class="p-4">
<h1 class="text-center"><?php echo $workshopTitle; ?></h1>
<div class="container w-25 p-3">
    <form action="" method="post" name="form">
        <div class="form-group">
            <label for="sort">Sortiraj po:</label>
            <select name="sort" id="sort" class="form-control" onchange="this.form.submit()">
                <option value="0" <?php if($sortType == '0') echo "selected"; ?>>Preporučeno</option>
                <option value="1" <?php if($sortType == '1') echo "selected"; ?>>Po nazivu rastuće</option>
                <option value="2" <?php if($sortType == '2') echo "selected"; ?>>Po nazivu opadajuće</option>
                <option value="3" <?php if($sortType == '3') echo "selected"; ?>>Po datumu rastuće</option>
                <option value="4" <?php if($sortType == '4') echo "selected"; ?>>Po datumu opadajuće</option>
            </select>
        </div>
        <input type="text" class="form-control" name="searchName" placeholder="Pretraga po nazivu" onchange="this.form.submit()" value="<?php echo $_POST["searchName"] ?? "";  ?>">
        <input type="text" class="form-control" name="searchAddress" placeholder="Pretraga po mestu" onchange="this.form.submit()" value="<?php echo $_POST["searchAddress"] ?? "";  ?>">
    </form>
</div>
<?php foreach($workshops as $w) {?>
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
                <h6 class="mt-1">  <?php echo $w["date"]; ?> </h6>
                <h6 class="mt-1">  <?php echo $w["address"]; ?> </h6>
                <p> <?php echo $w["short_description"]; ?> </p>
                <?php if (isset($_SESSION["user"])){
                    if ($w["user_id"]==$_SESSION["user"]->getID()) {
                        if ($w["status"]==0) {
                            $msg = "Administrator je odobrio ovu radionicu";
                            $cls = "text-success";
                        }
                        else if ($w["status"]==1) {
                            $msg = "Administrator nije odobrio ovu radionicu";
                            $cls = "text-danger";
                        }
                        else {
                            $msg = "Čeka se odobrenje od strane Administratora";
                            $cls = "text-info";
                        } ?>
                        <p class="<?php echo $cls; ?>"><?php echo $msg; ?></p>
                    <?php } ?>
                    <a class="btn btn-primary" href="<?php echo Router::createURI("workshops/w/".$w["id"]); ?>">Detalji</a>
                <?php }?>
            </div>
        </div>
    </div>
    <?php } ?>
</main>