<?php
if (!class_exists('Controller')) {
    class Controller {
        const template_path = "../templates/";

        function __construct() {
            $this->setPaths();
        }

        private function setPaths()
        {
            if (!defined("BASE_URL")) {
                define('BASE_URL', 'http://localhost/Avans/P_Assessment/');
            }
            if (!defined("IMAGE_PATH")) {
                define('IMAGE_PATH', 'images/');
            }

            //Autoload classes with extension .php (PHP 5 >= 5.1.0, PHP 7)
            set_include_path(__DIR__."/Model/");
            spl_autoload_extensions(".php");
            spl_autoload_register();
        }

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

        public function getCategories() {
            $db = Database::getInstance();
            $categories = $db->query("SELECT * FROM category", Category::class);
            return $categories;
        }

        public function getCategoryById(int $CategoryID) {
            $db = Database::getInstance();
            $category = $db->query("SELECT * FROM category WHERE ID = " . $CategoryID, Category::class);
            if ($category && count($category) === 1) {
                return $category[0];
            } else {
                return "";
            }
        }

        public function getRecipes(int $CategoryID = -1, int $count = 10) {
            $db = Database::getInstance();

            if (!is_int($count) || $count < 0) {
                $count = 10;
            }

            if ($CategoryID !== -1) {
                $recipes = $db->query("SELECT * FROM recipe WHERE CategoryID = " . $CategoryID . " LIMIT " . $count, Recipe::class);
            } else {
                $recipes = $db->query("SELECT * FROM recipe LIMIT " . $count, Recipe::class);
            }

            if ($recipes) {
                foreach ($recipes as $recipe) {
                    $ingredients = $this->getIngredients($recipe->getID());
                     
                    if ($ingredients) {
                        foreach ($ingredients as $ingredient) {
                            $recipe->addIngredient($ingredient);
                        }
                    }
                }
            }

            return $recipes;
        }

        public function getIngredients(int $RecipeID) {
            $db = Database::getInstance();
            $ingredients = $db->query("SELECT ri.IngredientID, i.Name, ri.Count, ri.Type FROM recipe_ingredients ri INNER JOIN ingredient i ON ri.IngredientID = i.ID WHERE ri.RecipeID = " . $RecipeID, Ingredient::class);
            return $ingredients;
        }

        //https://stackoverflow.com/a/3161830
        public function truncate(string $string, int $length = -1, $append="&hellip;") {
            if ($length !== -1) {
                $string = trim($string);

                if(strlen($string) > $length) {
                    $string = wordwrap($string, $length);
                    $string = explode("\n", $string, 2);
                    $string = $string[0] . $append;
                }
            }

            return $string;
        }
    }
}