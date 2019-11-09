<?php 
  require "../src/Controller/controller.php";
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
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="out/js/main.min.js"></script>
</head>
<body>

<header>
  <div class="site-header sticky-top py-1">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center p-3 px-md-4 bg-white border-bottom box-shadow">
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="<?php echo BASE_URL; ?>">Home</a>
        <a class="p-2 text-dark" href="<?php echo BASE_URL; ?>recepten.php">Recepten</a>
      </nav>
      <a class="btn btn-outline-primary" href="<?php echo BASE_URL; ?>login.php">Login</a>
    </div>
  </div>
</header>