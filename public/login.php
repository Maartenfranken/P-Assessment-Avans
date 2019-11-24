<?php
    include 'header.php';
    $controller = new Controller();
    $error = "";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $error = $controller->checkLogin();
    }
?>
    <section class="container">
        <div class="row">
            <div class="col-md col-lg-6 mx-auto">
                <?php $controller->getTemplate('login.php', array('errorMessage' => $error)); ?>
            </div>
        </div>
    </section>
<?php include 'footer.php'; ?>