<?php
require "../src/Controller/Controller.php";
$controller = new Controller();
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>P-Assessment</title>
    <meta name="description" content="A website made for P-Assessment on Avans">
    <meta name="author" content="Maarten Franken">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="out/css/main.min.css?v=1.0">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
            integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="out/js/main.min.js"></script>
</head>
<body>

<header>
    <div class="site-header sticky-top py-1">
        <div class="container d-flex flex-row justify-content-between align-items-center py-3 bg-white box-shadow">
            <nav class="my-2 my-md-0 mr-md-3">
                <a class="p-2 text-dark" href="<?php echo BASE_URL; ?>">Home</a>
            </nav>
            <!-- TODO: WHEN LOGGED IN SHOW CRUD LINK INSTEAD -->
            <a class="btn btn-outline-primary" href="<?php echo BASE_URL; ?>login.php">Login</a>
        </div>
    </div>
</header>