<script src="<?php echo Router::createURI("js/workshop.js"); ?>"></script>
<h1 class="text-center">Moja sviđanja</h1>
<div class="container bg-light border rounded w-75 mb-4">
    <?php
        foreach($likes as $l) { ?>
        <div class="row bg-light border rounded-p-4 d-flex align-items-center">
            <div class="col-2">
                <img widht=100 height=100 class="img" src="<?php echo Router::createURI("res/default/red_heart.png"); ?>">
            </div>
            <div class="col-8">
                <h5>
                    <?php echo $l["workshop_name"]; ?>
                </h5>
            </div>
            <div class="col-2">
                <form action="" method="post">
                    <input type="hidden" name="workshopName" value="<?php echo $l["workshop_name"]; ?>">
                    <input class="btn btn-danger" name="unlike" type="submit" value="Ne sviđa mi se">
                </form>
            </div>
        </div>
        <?php }
    ?>
</div>
<h1 class="text-center">Moji komentari</h1>
<div class="container bg-light border rounded w-75 mb-4">
    <?php
        foreach($comments as $c) { ?>
            <div class="row bg-light border rounded-p-4 d-flex align-items-center">
                <div class="col-2">
                <img widht=100 height=100 class="img" src="<?php echo Router::createURI("res/default/comment.png"); ?>">
                </div>
                <div class="col-2">
                    <h5>
                        <?php echo $c["workshop_name"]; ?>
                    </h5>
                </div>
                <div class="col-6">
                    <div id="comment-text-div-<?php echo $c["id"]; ?>">
                        <?php echo $c["text"]; ?>
                    </div>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <input class="btn btn-info" type="button" value="Izmeni" onclick="editComment(<?php echo $c['id'];?>)">
                </div>
            </div>
        <?php }
    ?>
</div>
<script src=></script>