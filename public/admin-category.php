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
            $controller->executeAdminAction($action, "Categories");
        }
    }

    if ($action && $action === "edit" && isset($_GET['id'])) {
        $categoryID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $category = $controller->getCategoryById($categoryID);
    }
?>
<section class="container mt-4">
    <div class="row">
        <div class="col-md col-lg-3">
            <div class="nav flex-column nav-pills nav-pills-dark" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active show" id="v-pills-categories-tab" data-toggle="pill" href="#v-pills-categories" role="tab" aria-controls="v-pills-categories" aria-selected="true">Categorieën</a>
            </div>
        </div>
        <div class="col-md col-lg-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade active show" id="v-pills-categories" role="tabpanel" aria-labelledby="v-pills-categories-tab">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8"); ?>" method="post">
                        <input type="hidden" name="action" value="<?php echo $action; ?>"/>
                        <input type="hidden" name="categoryID" value="<?php echo isset($categoryID) ? $categoryID : -1; ?>"/>
                        <div class="form-group">
                            <label for="title">Titel</label>
                            <input type="text" class="form-control" id="title" name="title" aria-describedby="Title" placeholder="Vul hier een titel in" required="required" value="<?php echo (isset($category) && $category instanceof Category) ? $category->getTitle() : ""; ?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Beschrijving</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?php echo (isset($category) && $category instanceof Category) ? $category->getDescription() : ""; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark"><?php echo ($action && $action === 'edit') ? "Opslaan" : "Toevoegen"; ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
