<?php
if (!class_exists('Recipe')) {
    class Recipe {
        protected $ID;
        protected $Title;
        protected $Description;
        protected $Date;
        protected $NumberOfPersons;
        protected $TimeNecessary;
        protected $CategoryID;
        protected $ingredients = array();

        function __construct(int $ID = 0, String $Title = "", String $Description = "", DateTime $Date = null, int $NumberOfPersons = 0, String $TimeNecessary = "", int $CategoryID = -1) {
            if (!$this->ID) {
                $this->ID = $ID;
            }
            if (!$this->Title) {
                $this->Title = $Title;
            }
            if (!$this->Description) {
                $this->Description = $Description;
            }
            if (!$this->Date) {
                $this->Date = $Date;
            }
            if (!$this->NumberOfPersons) {
                $this->NumberOfPersons = $NumberOfPersons;
            }
            if (!$this->TimeNecessary) {
                $this->TimeNecessary = $TimeNecessary;
            }
            if (!$this->CategoryID) {
                $this->CategoryID = $CategoryID;
            }
        }

        public function __get(String $property) {
            if (property_exists($this, $property)) {
                return $this->$property;
            }
        }

        public function __set(String $property, $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        public function getID() {
            return $this->ID;
        }

        public function getTitle() {
            return $this->Title;
        }

        public function getDescription() {
            return $this->Description;
        }

        public function getDate() {
            return $this->Date;
        }

        public function getNumberOfPersons() {
            return $this->NumberofPersons;
        }

        public function getTimeNecessary() {
            return $this->TimeNecessary;
        }

        public function getCategoryID() {
            return $this->CategoryID;
        }

        public function getCategory() {
            $controller = new Controller();
            $category = "";
            if ($this->CategoryID !== -1) {
                $category = $controller->getCategoryById($this->CategoryID);
            }
            return $category;
        }

        public function addIngredient(Ingredient $ingredient) {
            if ($ingredient instanceof Ingredient) {
                //TODO Check if ingredient is not already in array
                $this->ingredients[] = $ingredient;
            }
        }

        public function getIngredients() {
            if ($this->ingredients && !empty($this->ingredients)) {
                return $this->ingredients;
            }
        }
    }
}