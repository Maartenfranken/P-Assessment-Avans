<?php
if (!class_exists('Controller')) {
    class Controller {
        const template_path = "../templates/";

        function __construct() {
            
        }

        public function getTemplate(String $file) {
            $filepath = self::template_path . $file;
            if (file_exists(stream_resolve_include_path($filepath))) {
                include($filepath);
            }
        }
    }
}