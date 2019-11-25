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
            $controller->executeAdminAction($action, "Ingredients");
        }
    }

    if ($action && $action === "edit" && isset($_GET['id'])) {
        $ingredientID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $ingredient = $controller->getIngredientById($ingredientID);
    }
?>
<section class="container mt-4">
    <div class="row">
        <div class="col-md col-lg-3">
            <div class="nav flex-column nav-pills nav-pills-dark" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active show" id="v-pills-ingredients-tab" data-toggle="pill" href="#v-pills-ingredients" role="tab" aria-controls="v-pills-ingredients" aria-selected="true">Ingrediënten</a>
            </div>
        </div>
        <div class="col-md col-lg-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade active show" id="v-pills-ingredients" role="tabpanel" aria-labelledby="v-pills-ingredients-tab">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8"); ?>" method="post">
                        <input type="hidden" name="action" value="<?php echo $action; ?>"/>
                        <div class="form-group">
                            <label for="name">Naam</label>
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="Naam" placeholder="Vul hier een naam in" required="required" value="<?php echo (isset($ingredient) && $ingredient instanceof Ingredient) ? $ingredient->getName() : ""; ?>">
                        </div>
                        <button type="submit" class="btn btn-dark"><?php echo ($action && $action === 'edit') ? "Opslaan" : "Toevoegen"; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
