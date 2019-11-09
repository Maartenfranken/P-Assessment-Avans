<?php
if (!class_exists('Controller')) {
    class Controller {
        const template_path = "../templates/";

        function __construct() {
            $this->setPaths();

            //Autoload classes with extension .php (PHP 5 >= 5.1.0, PHP 7)
            spl_autoload_extensions(".php");
            spl_autoload_register();
        }

        private function setPaths()
        {
            if (!defined("BASE_URL")) {
                define('BASE_URL', 'http://localhost/Avans/P_Assessment/');
            }
            if (!defined("IMAGE_PATH")) {
                define('IMAGE_PATH', 'images/');
            }
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
            $categories = array(
                new Category("Pasta", 14),
                new Category("Ontbijt"),
                new Category("Avondeten"),
                new Category("Mexicaans"),
                new Category("Italiaans"),
                new Category("Rijst"),
                new Category("Hollands"),
                new Category("Grieks"),
                new Category("Chinees"),
                new Category("Feestdagen")
            );
        
            return $categories;
        }
    }
}