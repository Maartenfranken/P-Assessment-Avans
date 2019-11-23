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
        public function getIngredients(int $RecipeID)
        {
            $db = Database::getInstance();
            $ingredients = $db->select("SELECT ri.IngredientID, i.Name, ri.Count, ri.Type 
                     FROM recipe_ingredients ri 
                     INNER JOIN ingredient i 
                     ON ri.IngredientID = i.ID 
                     WHERE ri.RecipeID = :recipeId",
                Ingredient::class,
                array(
                    ':recipeId' => $RecipeID
                ));
            return $ingredients;
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
    }
}