<?php
if (!class_exists('Ingredient')) {
    class Ingredient
    {
        private $ID;
        private $Name;
        private $Count;
        private $Type;

        function __construct(int $ID = 0, string $Name = "", int $Count = 0, string $Type = "")
        {
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

        public function __get($property)
        {
            if (property_exists($this, $property)) {
                return $this->$property;
            }
        }

        public function __set($property, $value)
        {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        public function getName()
        {
            return $this->Name;
        }

        public function getCount()
        {
            return $this->Count;
        }

        public function getType()
        {
            return $this->Type;
        }

        /**
         * Helpful toString method for showing ingredient info on Front-end
         *
         * @return string
         */
        public function __toString()
        {
            if (!empty($this->Name) && $this->Count > 0 && $this->Type) {
                return $this->Name . ": " . $this->Count . " " . $this->Type;
            } else if (!empty($this->Name)) {
                return $this->Name;
            } else {
                return "";
            }
        }
    }
}