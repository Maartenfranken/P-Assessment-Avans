<form class="form-signin" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8"); ?>">
    <h1 class="h3 mb-3 font-weight-normal">Login</h1>
    <?php echo (isset($errorMessage) && !empty($errorMessage)) ? "<div class='alert alert-danger' role='alert'>" . $errorMessage . "</div>" : ""; ?>
    <label for="inputUsername" class="sr-only">Gebruikersnaam</label>
    <input autofocus="" class="form-control mb-3" id="inputUsername" name="inputUsername" placeholder="Gebruikersnaam" required="" type="text">
    <label for="inputPassword" class="sr-only">Wachtwoord</label>
    <input class="form-control mb-3" id="inputPassword" name="inputPassword" placeholder="Wachtwoord" required="" type="password">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Inloggen</button>
</form>