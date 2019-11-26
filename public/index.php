<?php include 'header.php'; ?>
<?php $controller->getTemplate('banner.php', array('title' => 'Homepage', 'bgImage' => IMAGE_PATH . 'banner-home.jpg')); ?>
    <section class="container">
        <div class="row">
            <div class="col-md mb-4 mb-md-0">
                <?php $controller->getTemplate('categories.php'); ?>
            </div>
            <div class="col-md">
                <h2>Recepten</h2>
                <?php $controller->getTemplate('recipes.php', array('count' => 3)); ?>
            </div>
        </div>
    </section>
<?php include 'footer.php'; ?>