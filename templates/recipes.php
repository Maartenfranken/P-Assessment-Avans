<div class="recipes">
    <?php 
        $controller = new Controller();
        $CategoryId = isset($CategoryId) ? $CategoryId : -1;
        $count = isset($count) ? $count : -1;
        $recipes = $controller->getRecipes($CategoryId, $count);

        if ($recipes) {
            foreach ($recipes as $recipe) {
                $controller->getTemplate('recipe.php', array('recipe' => $recipe));
            }
        }
    ?>
</div>