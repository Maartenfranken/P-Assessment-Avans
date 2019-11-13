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

        //Dummy data (use database later)
        //Current default count = 10
        public function getRecipes($count = 10) {
            $recipes = array();
            $category = new Category(0, "Pasta", "", 10);

            for ($i = 0; $i < $count; $i++) {
                $recipes[] = new Recipe($i, "Title", date_create("now"), "Lorem ipsum here", 4, "20 minuten", $category);
            }

            return $recipes;
        }
    }
}