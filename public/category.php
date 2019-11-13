<?php include 'header.php'; ?>
<?php $controller->getTemplate('banner.php', array('title' => 'Categorie', 'bgImage' => IMAGE_PATH . 'banner-home.jpg')); ?>
<section class="container">
    <div class="row">
        <div class="col-md">
            <h2>Recepten</h2>
            <?php $controller->getTemplate('recipes.php', array('count' => 10)); ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>