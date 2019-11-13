<div class="recipes">
    <?php 
        $controller = new Controller();
        $recipes = isset($count) ? $controller->getRecipes($count) : $controller->getRecipes();

        foreach ($recipes as $recipe) {
            $controller->getTemplate('recipe.php', array('recipe' => $recipe));
        }
    ?>
</div>