<?php 
    include 'header.php'; 
    $controller = new Controller();
    $recipeId = isset($_GET['id']) ? intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT)) : '';
    $recipe = !empty($recipeId) || $recipeId === 0 ? $controller->getRecipeById($recipeId): '';
    if (empty($recipe) || !$recipe || !$recipe instanceof Recipe) {
        header("Location: http://localhost/Avans/P_Assessment");
        die();
    }
?>
<?php $controller->getTemplate('banner.php', array('title' => $recipe->getTitle(), 'bgImage' => IMAGE_PATH . 'banner-home.jpg')); ?>
<section class="container">
    <div class="row">
        <div class="col-md order-md-1 order-2">
            <p><?php echo $recipe->getDescription(); ?></p>
        </div>
        <div class="col-md-4 order-md-2 order-1">
            <?php 
                $ingredients = $recipe->getIngredients();
                if ($ingredients && is_array($ingredients)) {
            ?>
                <h2>Ingredienten</h2>
                <ul>
                    <?php foreach ($ingredients as $ingredient) { ?>
                        <li><?php echo $ingredient; ?></li>
                    <?php } ?>
                </ul>
            <?php } 
            
                echo $recipe->getAdditionalInfo();
            ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>