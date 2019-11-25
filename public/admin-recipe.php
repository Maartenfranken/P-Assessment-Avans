<?php
include 'header.php';
$controller = new Controller();
$userLogin = new UserLogin();
if (!$userLogin->isUserLoggedIn()) {
    header("Location: " . LOGIN_URL);
    die();
}
$action = isset($_GET['action']) ? filter_var($_GET['action'], FILTER_SANITIZE_STRING) : "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = isset($_POST['action']) ? filter_var($_POST['action'], FILTER_SANITIZE_STRING) : "";
    if (!empty($action)) {
        $controller->executeAdminAction($action, "Recipes");
    }
}

if ($action && $action === "edit" && isset($_GET['id'])) {
    $recipeID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $recipe = $controller->getRecipeById($recipeID);
}
?>
<section class="container mt-4">
    <div class="row">
        <div class="col-md col-lg-3">
            <div class="nav flex-column nav-pills nav-pills-dark" id="v-pills-tab" role="tablist"
                 aria-orientation="vertical">
                <a class="nav-link active show" id="v-pills-recipes-tab" data-toggle="pill" href="#v-pills-recipes"
                   role="tab" aria-controls="v-pills-recipes" aria-selected="true">Recepten</a>
            </div>
        </div>
        <div class="col-md col-lg-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade active show" id="v-pills-recipes" role="tabpanel"
                     aria-labelledby="v-pills-recipes-tab">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8"); ?>"
                          method="post">
                        <input type="hidden" name="action" value="<?php echo $action; ?>"/>
                        <input type="hidden" name="recipeID" value="<?php echo isset($recipeID) ? $recipeID : -1; ?>"/>
                        <div class="form-group">
                            <label for="title">Titel</label>
                            <input type="text" class="form-control" id="title" name="title" aria-describedby="title"
                                   placeholder="Vul hier een titel in" required="required"
                                   value="<?php echo (isset($recipe) && $recipe instanceof Recipe) ? $recipe->getTitle() : ""; ?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Beschrijving</label>
                            <textarea class="form-control" id="description" name="description"
                                      rows="4"><?php echo (isset($recipe) && $recipe instanceof Recipe) ? $recipe->getDescription() : ""; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="date">Datum</label>
                            <input type="date" class="form-control" id="date" name="date" aria-describedby="date"
                                   required="required"
                                   value="<?php echo (isset($recipe) && $recipe instanceof Recipe) ? $recipe->getDate() : ""; ?>">
                        </div>
                        <div class="form-group">
                            <label for="numberOfPersons">Aantal personen</label>
                            <input type="text" class="form-control" id="numberOfPersons" name="numberOfPersons"
                                   aria-describedby="numberOfPersons" placeholder="4"
                                   value="<?php echo (isset($recipe) && $recipe instanceof Recipe) ? $recipe->getNumberOfPersons() : ""; ?>">
                        </div>
                        <div class="form-group">
                            <label for="timeNecessary">Benodigde tijd</label>
                            <input type="text" class="form-control" id="timeNecessary" name="timeNecessary"
                                   aria-describedby="timeNecessary" placeholder="30 minuten"
                                   value="<?php echo (isset($recipe) && $recipe instanceof Recipe) ? $recipe->getTimeNecessary() : ""; ?>">
                        </div>
                        <?php
                        $categories = $controller->getCategories();
                        if ($categories && !empty($categories)) {
                            ?>
                            <div class="form-group">
                                <label for="categories">Categorieën</label>
                                <select class="form-control" id="categories" name="categoryID">
                                    <?php
                                    foreach ($categories as $category) {
                                        if ($category instanceof Category) {
                                            ?>
                                            <option value="<?php echo $category->ID; ?>"<?php echo (isset($recipe) && $recipe instanceof Recipe && $recipe->getCategoryID() === $category->ID) ? " selected" : ""; ?>><?php echo $category->getTitle(); ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } ?>

                        <?php
                        $ingredients = $controller->getIngredients();
                        if ($ingredients && !empty($ingredients)) {
                            ?>
                            <h3>Ingrediënten</h3>
                            <div class="form-group">
                                <?php
                                foreach ($ingredients as $ingredient) {
                                    if ($ingredient instanceof Ingredient) {
                                        ?>
                                        <div class="form-check clearfix">
                                            <input class="form-check-input" type="checkbox"
                                                   value="1"
                                                   id="ingredient<?php echo $ingredient->ID; ?>"
                                                   name="ingredients[<?php echo $ingredient->ID; ?>][checked]"
                                                <?php echo (isset($recipe) && $recipe instanceof Recipe && $recipe->ingredientInArray($ingredient)) ? " checked='true'" : ""; ?>>
                                            <label class="form-check-label"
                                                   for="ingredient<?php echo $ingredient->ID; ?>">
                                                <?php echo $ingredient->getName(); ?>
                                            </label>
                                            <div class="form-row float-right">
                                                <div class="form-group mr-4">
                                                    <label for="count<?php echo $ingredient->ID; ?>">Hoeveelheid</label>
                                                    <input type="text" class="form-control"
                                                           id="count<?php echo $ingredient->ID; ?>"
                                                           name="ingredients[<?php echo $ingredient->ID; ?>][count]"
                                                           aria-describedby="count<?php echo $ingredient->ID; ?>"
                                                           placeholder="50"
                                                           value="<?php echo (isset($recipe) && $recipe instanceof Recipe && $recipe->ingredientInArray($ingredient)) ? $recipe->getIngredientCount($ingredient) : ""; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="type<?php echo $ingredient->ID; ?>">Type</label>
                                                    <input type="text" class="form-control"
                                                           id="type<?php echo $ingredient->ID; ?>"
                                                           name="ingredients[<?php echo $ingredient->ID; ?>][type]"
                                                           aria-describedby="type<?php echo $ingredient->ID; ?>"
                                                           placeholder="Gram"
                                                           value="<?php echo (isset($recipe) && $recipe instanceof Recipe && $recipe->ingredientInArray($ingredient)) ? $recipe->getIngredientType($ingredient) : ""; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        <?php } ?>
                        <button type="submit"
                                class="btn btn-dark"><?php echo ($action && $action === 'edit') ? "Opslaan" : "Toevoegen"; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
