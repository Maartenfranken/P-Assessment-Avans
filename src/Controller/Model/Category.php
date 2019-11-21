<?php
if (!class_exists('Category')) {
    class Category
    {
        private $ID;
        private $Title;
        private $Description;
        private $count;

        function __construct(int $ID = 0, String $Title = "", String $Description = "", int $count = 0)
        {
            if (!$this->ID) {
                $this->ID = $ID;
            }
            if (!$this->Title) {
                $this->Title = $Title;
            }
            if (!$this->Description) {
                $this->Description = $Description;
            }
            if (!$this->count) {
                $this->count = $count;
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

        public function getTitle()
        {
            if ($this->Title) {
                return $this->Title;
            } else {
                return "";
            }
        }

        public function getDescription()
        {
            return $this->Description;
        }

        public function getCount()
        {
            return $this->count;
        }

        public function getPermalink()
        {
            return "category.php?id=" . $this->ID;
        }
    }
}