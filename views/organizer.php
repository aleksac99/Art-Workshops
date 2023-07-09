<?php require_once "./views/map_imports.php"; ?>
<div class="container pt-4">
    <div class="row text-center">
        <h1> <?php echo $title; ?></h1>
    </div>
    <?php if ($action=="insert") { ?>
        <div class="row">
            <div class="container w-25 p-3 d-flex flex-column align-items-center">
                <div class="row">
                    <h5 class="">Uvezi šablon</h5>                
                </div>
                <div class="row">
                    <form name="pattern" class="form-control" action="" method="post">
                        <select name="workshopPattern" onchange="this.form.submit()">
                            <option value="" selected>Bez šablona</option>
                            <?php
                                foreach ($workshops as $ws) { ?>
                                    <option value="<?php echo $ws["id"]; ?>" <?php echo ($ws["id"]==$w->getId()) ? "selected" : ""; ?>><?php echo $ws["name"]; ?> | <?php echo $ws["date"]; ?></option>
                                <?php }
                            ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <form class="form" action="" method="post" name="addWorkshop" enctype="multipart/form-data">
            <div class="form-floating">
                <input required id="floatingWorkshopName" class="form-control" type="text" placeholder="Naziv radionice" name="name" value="<?php echo ($w ?? false) ? $w->getName() : '';?>" <?php echo ($action=="update")? "disabled" : ""; ?>>
                <label for="floatingWorkshopName">Naziv radionice</label>
            </div>
            <div class="form-floating">
                <input required id="floatingDatetime" class="form-control" type="datetime-local" name="datetime" value="<?php echo ($w ?? false) ? $w->getDate() : '';?>">
                <label for="floatingDatetime">Datum i vreme</label>
            </div>
            <div class="form-group">
                <textarea required id="floatingShortDescription" class="form-control" name="shortDescription" rows="3" placeholder="Kratak opis"><?php echo ($w ?? false) ? $w->getShortDescription() : '';?></textarea>
            </div>
            <div class="form-group">
                <textarea required id="floatingLongDescription" class="form-control" name="longDescription" rows="10" placeholder="Duzi opis"><?php echo ($w ?? false) ? $w->getLongDescription() : '';?></textarea>
            </div>
            <div class="form-floating">
                <input required id="floatingMaxNumberOfApplications" class="form-control" type="number" name="maxNumberOfApplications"  value="<?php echo ($w ?? false) ? $w->getMaxNumberOfApplications() : '';?>">
                <label for="floatingMaxNumberOfApplications">Maksimalni broj učesnika</label>
            </div>
            <div class="form-group">
                <label for="mainImage">Glavna slika</label>
                <input <?php echo ($action!="update")?"required":""; ?> id="mainImage" class="form-control-file" type="file" name="mainImage">
            </div>
            <div class="form-group">
                <label for="imageGallery">Galerija slika (najvise 5)</label>
                <input id="imageGallery" class="form-control-file" type="file" name="optionalImages[]" multiple onchange="checkNumFiles()">
            </div>
            <div class="form-group">
                <input required type="hidden" name="address" value="<?php echo ($w ?? false) ? $w->getAddress() : '';?>">
                <input required type="hidden" name="addressLat" value="<?php echo ($w ?? false) ? $w->getAddressLat() : '';?>">
                <input required type="hidden" name="addressLong" value="<?php echo ($w ?? false) ? $w->getAddressLong() : '';?>">
            </div>
            <div class="form-group">
                <label for="map">Izaberi mesto održavanja</label>
                <div id="map" style="height: 500px; width: 500px; border:solid">
            </div>
            <div class="form-group pt-4">
                <?php 
                if ($action=="update") {
                    echo '<input class="btn btn-primary w-100" type="submit" value="Ažuriraj informacije">';
                }
                else {
                    echo '<input class="btn btn-primary w-100" name="addWorkshop" type="submit" value="Predloži radionicu">';
                }
                ?>
            </div>
        </form>
    </div>
</div>
<script src="<?php echo Router::createURI("js/organizer.js"); ?>"></script>
<script>
    var coordinates = [<?php echo ($w->getId()) ? $w->getAddressLong(): 0.;?>, <?php echo ($w->getId()) ? $w->getAddressLat() : 0.;?>];
    var showSearchBar = true;
</script>
<script src="<?php echo Router::createURI("js/render_map.js"); ?>"></script>