<?php
if (!class_exists('Recipe')) {
    class Recipe {
        protected $id;
        protected $title;
        protected $description;
        protected $date;
        protected $numberOfPersons;
        protected $timeNecessary;
        protected $category;
        protected $ingredients = array();

        function __construct(int $id, String $title, DateTime $date, String $description, int $numberOfPersons, String $timeNecessary, Category $category) {
            $this->id = $id;
            $this->title = $title;
            $this->description = $description;
            $this->date = $date;
            $this->numberOfPersons = $numberOfPersons;
            $this->timeNecessary = $timeNecessary;
            $this->category = $category;
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

        public function addIngredient(Ingredient $ingredient, int $count, String $type) {
            if ($ingredient instanceof Ingredient) {
                //TODO Check if ingredient is not already in array
                $this->ingredients[] = $ingredient;
            }
        }
    }
}