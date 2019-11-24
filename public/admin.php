<?php
    include 'header.php';
    $controller = new Controller();
    $userLogin = new UserLogin();
    if (!$userLogin->isUserLoggedIn()) {
        header("Location: " . LOGIN_URL);
        die();
    }
    if (isset($_GET['action'])) {
        $action = filter_var($_GET['action'], FILTER_SANITIZE_STRING);
        $controller->executeAdminAction($action);
    }
?>
<section class="container mt-4">
    <div class="row">
        <div class="col-md col-lg-3">
            <div class="nav flex-column nav-pills nav-pills-dark" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active show" id="v-pills-recipes-tab" data-toggle="pill" href="#v-pills-recipes" role="tab" aria-controls="v-pills-recipes" aria-selected="true">Recepten</a>
                <a class="nav-link" id="v-pills-ingredients-tab" data-toggle="pill" href="#v-pills-ingredients" role="tab" aria-controls="v-pills-ingredients" aria-selected="false">Ingrediënten</a>
                <a class="nav-link" id="v-pills-categories-tab" data-toggle="pill" href="#v-pills-categories" role="tab" aria-controls="v-pills-categories" aria-selected="false">Categorieën</a>
            </div>
        </div>
        <div class="col-md col-lg-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade active show" id="v-pills-recipes" role="tabpanel" aria-labelledby="v-pills-recipes-tab">
                    <?php $controller->getTemplate('admin.php', array(
                            'type' => 'Recepten',
                            'singular' => 'recept',
                            'tableHeaders' => array(
                                'Titel',
                                'Beschrijving',
                                'Datum',
                                'Aantal personen',
                                'Tijd',
                                'Categorie'
                            ),
                            'url' => 'admin-recipe'
                        )); ?>
                </div>
                <div class="tab-pane fade" id="v-pills-ingredients" role="tabpanel" aria-labelledby="v-pills-ingredients-tab">
                    <?php $controller->getTemplate('admin.php', array(
                        'type' => 'Ingrediënten',
                        'singular' => 'ingredient',
                        'tableHeaders' => array(
                            'Naam',
                        ),
                        'url' => 'admin-ingredient'
                    )); ?>
                </div>
                <div class="tab-pane fade" id="v-pills-categories" role="tabpanel" aria-labelledby="v-pills-categories-tab">
                    <?php $controller->getTemplate('admin.php', array(
                        'type' => 'Categorieën',
                        'singular' => 'categorie',
                        'tableHeaders' => array(
                            'Titel',
                            'Beschrijving'
                        ),
                        'url' => 'admin-category'
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'footer.php'; ?>
