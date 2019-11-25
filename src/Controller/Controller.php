<?php
if (!class_exists('Controller')) {
    class Controller
    {
        const template_path = "../templates/";

        function __construct()
        {
            $this->setPaths();

            //Start session if there is none
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }

        /**
         * Set paths for autoloading classes
         */
        private function setPaths()
        {
            if (!defined("BASE_URL")) {
                define('BASE_URL', 'http://localhost/Avans/P_Assessment/'); //TODO GET BASE PATH OF DIRECTORY ANOTHER WAY
            }
            if (!defined("LOGIN_URL") && defined("BASE_URL")) {
                define('LOGIN_URL', BASE_URL . "login.php");
            }
            if (!defined("ADMIN_URL") && defined("BASE_URL")) {
                define('ADMIN_URL', BASE_URL . "admin.php");
            }
            if (!defined("IMAGE_PATH")) {
                define('IMAGE_PATH', 'images/');
            }

            //Autoload classes with extension .php (PHP 5 >= 5.1.0, PHP 7)
            set_include_path(__DIR__ . "/Model/");
            spl_autoload_extensions(".php");
            spl_autoload_register();
        }

        /**
         * Gets the template from /templates with additional data as variables
         *
         * @param String $file
         * @param array $data
         */
        public function getTemplate(String $file, Array $data = array())
        {
            $filepath = self::template_path . $file;
            if (file_exists(stream_resolve_include_path($filepath))) {
                if (!empty($data)) {
                    extract($data);
                }
                include($filepath);
            }
        }

        /**
         * Check login, returns error message if error
         *
         * @return string|void
         */
        public function checkLogin()
        {
            $userLogin = new UserLogin();
            $error = $userLogin->checkLogin();

            return $error ? $error : "";
        }

        /**
         * Returns a list of Category objects
         *
         * @return array
         */
        public function getCategories()
        {
            $db = Database::getInstance();
            return $db->select("SELECT * FROM category", Category::class);
        }

        /**
         * Returns the Category object or empty string if no Category was found by ID
         *
         * @param int $CategoryID
         * @return Category|string
         */
        public function getCategoryById(int $CategoryID)
        {
            $db = Database::getInstance();
            $category = $db->select("SELECT * FROM category WHERE ID = :categoryId",
                Category::class,
                array(
                    ':categoryId' => $CategoryID
                ));
            if ($category && count($category) === 1 && isset($category[0])) {
                return $category[0];
            } else {
                return "";
            }
        }

        /**
     * Returns the Recipe object or empty string if no Recipe was found by ID
     *
     * @param int $RecipeID
     * @return Recipe|string
     */
        public function getRecipeById(int $RecipeID)
        {
            $db = Database::getInstance();
            $recipe = $db->select("SELECT * FROM recipe WHERE ID = :recipeId",
                Recipe::class,
                array(
                    ':recipeId' => $RecipeID
                ));
            if ($recipe && count($recipe) === 1 && isset($recipe[0])) {
                $recipe = $recipe[0];
                if ($recipe instanceof Recipe) {
                    $ingredients = $this->getIngredients($recipe->getID());

                    if ($ingredients) {
                        $recipe->addIngredients($ingredients);
                    }

                    return $recipe;
                }
            }
            return "";
        }

        /**
         * Returns the Ingredient object or empty string if no Ingredient was found by ID
         *
         * @param int $IngredientID
         * @return Ingredient|string
         */
        public function getIngredientById(int $IngredientID)
        {
            $db = Database::getInstance();
            $ingredient = $db->select("SELECT * FROM ingredient WHERE ID = :ingredientID",
                Ingredient::class,
                array(
                    ':ingredientID' => $IngredientID
                ));
            if ($ingredient && count($ingredient) === 1 && isset($ingredient[0])) {
                $ingredient = $ingredient[0];
                if ($ingredient instanceof Ingredient) {
                    return $ingredient;
                }
            }
            return "";
        }

        /**
         * Returns a list of Recipe objects
         *
         * @param int $CategoryID
         * @param int $count
         * @return array
         */
        public function getRecipes(int $CategoryID = -1, int $count = 10)
        {
            $db = Database::getInstance();

            if (!is_int($count) || $count < 0) {
                $count = 10;
            }

            if ($CategoryID !== -1) {
                $recipes = $db->select("SELECT * FROM recipe WHERE CategoryID = :categoryId LIMIT :count",
                    Recipe::class,
                    array(
                        ':categoryId' => $CategoryID,
                        ':count' => $count
                    ));
            } else {
                $recipes = $db->select("SELECT * FROM recipe LIMIT :count",
                    Recipe::class,
                    array(
                        ':count' => $count
                    ));
            }

            if ($recipes) {
                foreach ($recipes as $recipe) {
                    if ($recipe instanceof Recipe) {
                        $ingredients = $this->getIngredients($recipe->getID());

                        if ($ingredients) {
                            $recipe->addIngredients($ingredients);
                        }
                    }
                }
            }

            return $recipes;
        }

        /**
         * Get list of Ingredient objects by RecipeID
         *
         * @param int $RecipeID
         * @return array
         */
        public function getIngredients(int $RecipeID = -1)
        {
            $db = Database::getInstance();
            if ($RecipeID !== -1) {
                return $db->select("SELECT ri.IngredientID, i.Name, ri.Count, ri.Type 
                     FROM recipe_ingredients ri 
                     INNER JOIN ingredient i 
                     ON ri.IngredientID = i.ID 
                     WHERE ri.RecipeID = :recipeId",
                    Ingredient::class,
                    array(
                        ':recipeId' => $RecipeID
                    ));
            } else {
                return $db->select("SELECT * FROM ingredient", Ingredient::class);
            }
        }

        /**
         * Inserts the necessary rows to the database
         *
         * @param string $type
         */
        private function insert(string $type): void
        {
            $db = Database::getInstance();

            switch($type) {
                case "Recipes":
                    $data = array();

                    $data['Title'] = isset($_POST['title']) ? filter_var($_POST['title'], FILTER_SANITIZE_STRING) : "";
                    $data['Description'] = isset($_POST['description']) ? filter_var($_POST['description'], FILTER_SANITIZE_STRING) : NULL;
                    $data['Date'] = (isset($_POST['date']) && !DateTime::createFromFormat('d/m/Y', $_POST['date'])) ? $_POST['date'] : date("Y-m-d H:i:s");
                    $data['NumberOfPersons'] = isset($_POST['numberOfPersons']) ? filter_var($_POST['numberOfPersons'], FILTER_SANITIZE_STRING) : NULL;
                    $data['TimeNecessary'] = isset($_POST['timeNecessary']) ? filter_var($_POST['timeNecessary'], FILTER_SANITIZE_STRING) : NULL;
                    $data['CategoryID'] = isset($_POST['categoryID']) ? filter_var($_POST['categoryID'], FILTER_SANITIZE_NUMBER_INT) : NULL;

                    $success = $db->prepareExecute("INSERT INTO recipe 
                                            (Title, Description, Date, NumberOfPersons, TimeNecessary, CategoryID) 
                                            VALUES (:Title, :Description, :Date, :NumberOfPersons, :TimeNecessary, :CategoryID)",
                                            $data);

                    if ($success) {
                        $recipeId = $db->getLastId();

                        if (isset($_POST['ingredients']) && is_array($_POST['ingredients'])) {
                            foreach ($_POST['ingredients'] as $ingredientID => $ingredient) {
                                if (isset($ingredient['checked'])) { //Check if included
                                    $data = array();

                                    $data['IngredientID'] = $ingredientID;
                                    $data['RecipeID'] = $recipeId;
                                    $data['Count'] = isset($ingredient['count']) ? filter_var($ingredient['count'], FILTER_SANITIZE_NUMBER_INT) : 0;
                                    $data['Type'] = isset($ingredient['type']) ? filter_var($ingredient['type'], FILTER_SANITIZE_STRING) : "";

                                    $db->prepareExecute("INSERT INTO recipe_ingredients 
                                            (IngredientID, RecipeID, Count, Type) 
                                            VALUES (:IngredientID, :RecipeID, :Count, :Type)",
                                            $data);
                                }
                            }
                        }
                    }

                    break;
                case "Ingredients":
                    $data = array();

                    $data['Name'] = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : "";

                    $db->prepareExecute("INSERT INTO ingredient 
                                            (Name) 
                                            VALUES (:Name)",
                                            $data);
                    break;
                case "Categories":
                    $data = array();

                    $data['Title'] = isset($_POST['title']) ? filter_var($_POST['title'], FILTER_SANITIZE_STRING) : "";
                    $data['Description'] = isset($_POST['description']) ? filter_var($_POST['description'], FILTER_SANITIZE_STRING) : NULL;

                    $db->prepareExecute("INSERT INTO category 
                                            (Title, Description) 
                                            VALUES (:Title, :Description)",
                                            $data);
                    break;
            }
        }

        /**
         * Updates the necessary rows to the database
         *
         * @param string $type
         */
        private function update(string $type): void
        {
            $db = Database::getInstance();

            switch($type) {
                case "Recipes":
                    $data = array();

                    $recipeId = isset($_POST['recipeID']) ? filter_var($_POST['recipeID'], FILTER_SANITIZE_NUMBER_INT) : -1;

                    $data['Title'] = isset($_POST['title']) ? filter_var($_POST['title'], FILTER_SANITIZE_STRING) : "";
                    $data['Description'] = isset($_POST['description']) ? filter_var($_POST['description'], FILTER_SANITIZE_STRING) : NULL;
                    $data['Date'] = (isset($_POST['date']) && !DateTime::createFromFormat('d/m/Y', $_POST['date'])) ? $_POST['date'] : date("Y-m-d H:i:s");
                    $data['NumberOfPersons'] = isset($_POST['numberOfPersons']) ? filter_var($_POST['numberOfPersons'], FILTER_SANITIZE_STRING) : NULL;
                    $data['TimeNecessary'] = isset($_POST['timeNecessary']) ? filter_var($_POST['timeNecessary'], FILTER_SANITIZE_STRING) : NULL;
                    $data['CategoryID'] = isset($_POST['categoryID']) ? filter_var($_POST['categoryID'], FILTER_SANITIZE_NUMBER_INT) : NULL;

                    $data['RecipeID'] = $recipeId;

                    if ($data['RecipeID'] >= 0) {
                        $success = $db->prepareExecute("UPDATE recipe 
                                                            SET Title = :Title, Description = :Description, Date = :Date, NumberOfPersons = :NumberOfPersons, TimeNecessary = :TimeNecessary, CategoryID = :CategoryID 
                                                            WHERE ID = :RecipeID",
                            $data);

                        if ($success) {
                            if (isset($_POST['ingredients']) && is_array($_POST['ingredients'])) {
                                foreach ($_POST['ingredients'] as $ingredientID => $ingredient) {
                                    if (isset($ingredient['checked'])) { //Check if included
                                        $data = array();

                                        $data['IngredientID'] = $ingredientID;
                                        $data['RecipeID'] = $recipeId;
                                        $data['Count'] = isset($ingredient['count']) ? filter_var($ingredient['count'], FILTER_SANITIZE_NUMBER_INT) : 0;
                                        $data['Type'] = isset($ingredient['type']) ? filter_var($ingredient['type'], FILTER_SANITIZE_STRING) : "";

                                        //TODO: Update ingredient row
                                        $db->prepareExecute("INSERT INTO recipe_ingredients 
                                                (IngredientID, RecipeID, Count, Type) 
                                                VALUES (:IngredientID, :RecipeID, :Count, :Type)",
                                            $data);
                                    } else {
                                        //TODO: Remove ingredient from recipe
                                    }
                                }
                            }
                        }
                    }

                    break;
                case "Ingredients":
                    $data = array();

                    $data['Name'] = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : "";

                    $db->prepareExecute("INSERT INTO ingredient 
                                            (Name) 
                                            VALUES (:Name)",
                        $data);
                    break;
                case "Categories":
                    $data = array();

                    $data['Title'] = isset($_POST['title']) ? filter_var($_POST['title'], FILTER_SANITIZE_STRING) : "";
                    $data['Description'] = isset($_POST['description']) ? filter_var($_POST['description'], FILTER_SANITIZE_STRING) : NULL;

                    $db->prepareExecute("INSERT INTO category 
                                            (Title, Description) 
                                            VALUES (:Title, :Description)",
                        $data);
                    break;
            }
        }

        /**
         * Deletes the necessary rows from the database
         *
         * @param int $ID
         * @param string $type
         */
        private function delete(int $ID, string $type): void
        {
            $db = Database::getInstance();
            switch ($type) {
                case "Recepten":
                    $db->prepareExecute("DELETE FROM recipe_ingredients WHERE RecipeID = :recipeID", array(
                        ':recipeID' => $ID
                    ));
                    break;
                case "Ingrediënten":
                    $db->prepareExecute("DELETE FROM recipe_ingredients WHERE IngredientID = :ingredientID", array(
                        ':ingredientID' => $ID
                    ));
                    break;
            }

            switch($type) {
                case "Recepten":
                    $type = "recipe";
                    break;
                case "Ingrediënten":
                    $type = "ingredient";
                    break;
                case "Categorieën":
                    $type = "category";
                    break;
            }

            $db->prepareExecute("DELETE FROM " . $type . " WHERE ID = :id", array(
                ':id' => $ID
            ));
        }

        /**
         * Trim string based on length
         * https://stackoverflow.com/a/3161830
         *
         * @param string $string
         * @param int $length
         * @param string $append
         * @return array|string
         */
        public function truncate(string $string, int $length = -1, $append = "&hellip;")
        {
            if ($length !== -1) {
                $string = trim($string);

                if (strlen($string) > $length) {
                    $string = wordwrap($string, $length);
                    $string = explode("\n", $string, 2);
                    $string = $string[0] . $append;
                }
            }

            return $string;
        }

        /**
         * Executes admin actions
         *
         * @param string $action
         * @param string $type
         */
        public function executeAdminAction(string $action, string $type = "")
        {
            $userLogin = new UserLogin();
            switch ($action) {
                case "logout":
                    $userLogin->logout();
                    break;
                case "new":
                    if (!empty($type) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                        $this->insert($type);
                    }
                    break;
                case "edit":
                    if (!empty($type) && $_SERVER['REQUEST_METHOD'] === 'POST') {
                        $this->update($type);
                    }
                    break;
                case "delete":
                    if (isset($_GET['id']) && isset($_GET['type'])) {
                        $ID = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
                        $type = filter_var($_GET['type'], FILTER_SANITIZE_STRING);
                        $this->delete($ID, $type);
                    }
                    break;
            }
        }
    }
}