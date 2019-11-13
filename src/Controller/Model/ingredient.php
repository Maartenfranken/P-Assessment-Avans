<?php
if (!class_exists('Ingredient')) {
    class Ingredient {
        private $ID;
        private $name;

        function __construct(int $ID, String $name) {
            $this->ID = $ID;
            $this->name = $name;
        }
        
        public function __get($property) {
            if (property_exists($this, $property)) {
                return $this->$property;
            }
        }

        public function __set($property, $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }
}