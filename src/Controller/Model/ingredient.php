<?php
if (!class_exists('Ingredient')) {
    class Ingredient {
        private $ID;
        private $Name;
        private $Count;
        private $Type;

        function __construct(int $ID = 0, String $Name = "", int $Count = 0, string $Type = "") {
            if (!$this->ID) {
                $this->ID = $ID;
            }
            if (!$this->Name) {
                $this->Name = $Name;
            }
            if (!$this->Count) {
                $this->Count = $Count;
            }
            if (!$this->Type) {
                $this->Type = $Type;
            }
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

        public function getName() {
            return $this->Name;
        }

        public function getCount() {
            return $this->Count;
        }

        public function getType() {
            return $this->Type;
        }

        public function __toString() {
            return $this->Name . ": " . $this->Count . " " . $this->Type;
        }
    }
}