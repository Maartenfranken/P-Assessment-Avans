<?php
$controller = new Controller();
if (isset($recipe)) { ?>
    <div class="col-12">
        <a class="card" href="<?php echo $recipe->getPermalink(); ?>">
            <div class="d-flex">
                <div class="img-square-wrapper">
                    <img class="" src="http://via.placeholder.com/150x150" alt="Card image cap">
                </div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $recipe->getTitle(); ?></h4>
                    <p class="card-text"><?php echo $controller->truncate($recipe->getDescription(), 100); ?></p>
                </div>
            </div>
        </a>
    </div>
<?php } ?>