<?php
if (!class_exists('Recipe')) {
    class Recipe
    {
        private $ID;
        private $Title;
        private $Description;
        private $Date;
        private $NumberOfPersons;
        private $TimeNecessary;
        private $CategoryID;
        private $ingredients = array();

        function __construct(int $ID = 0, string $Title = "", string $Description = "", DateTime $Date = null, int $NumberOfPersons = 0, string $TimeNecessary = "", int $CategoryID = -1)
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
            if (!$this->Date) {
                $this->Date = $Date;
            }
            if (!$this->NumberOfPersons) {
                $this->NumberOfPersons = $NumberOfPersons;
            } else if (!is_int($this->NumberOfPersons)) {
                $this->NumberOfPersons = intval($this->NumberOfPersons);
            }
            if (!$this->TimeNecessary) {
                $this->TimeNecessary = $TimeNecessary;
            }
            if (!$this->CategoryID) {
                $this->CategoryID = $CategoryID;
            }
        }

        public function __get(String $property)
        {
            if (property_exists($this, $property)) {
                return $this->$property;
            }
        }

        public function __set(String $property, $value)
        {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        public function getID()
        {
            return $this->ID;
        }

        public function getTitle()
        {
            return $this->Title;
        }

        public function getDescription()
        {
            return $this->Description;
        }

        public function getDate()
        {
            return $this->Date;
        }

        public function getNumberOfPersons()
        {
            if ($this->NumberOfPersons && $this->NumberOfPersons > 0) {
                return $this->NumberOfPersons;
            } else {
                return "";
            }
        }

        public function getTimeNecessary()
        {
            return $this->TimeNecessary;
        }

        /**
         * Returns the additional info for the Front-end
         *
         * @return false|string
         */
        public function getAdditionalInfo()
        {
            ob_start();
            if (is_int($this->NumberOfPersons) && intval($this->NumberOfPersons) > 0) {
                ?>
                <p><?php echo $this->NumberOfPersons . " ";
                    echo ($this->NumberOfPersons > 1) ? "personen" : "persoon"; ?></p>
                <?php
            }
            if (!empty($this->TimeNecessary)) {
                ?>
                <p><?php echo $this->TimeNecessary; ?></p>
                <?php
            }

            return ob_get_clean();
        }

        public function getCategoryID()
        {
            return $this->CategoryID;
        }

        public function getCategory()
        {
            $controller = new Controller();
            $category = "";
            if ($this->CategoryID !== -1) {
                $category = $controller->getCategoryById($this->CategoryID);
            }
            return $category;
        }

        public function addIngredient(Ingredient $ingredient)
        {
            if ($ingredient instanceof Ingredient) {
                if (!$this->ingredientInArray($ingredient)) {
                    $this->ingredients[] = $ingredient;
                }
            }
        }

        public function addIngredients(array $ingredients)
        {
            foreach ($ingredients as $ingredient) {
                if ($ingredient instanceof Ingredient) {
                    $this->addIngredient($ingredient);
                }
            }
        }

        /**
         * Check if Ingredient is already in Ingredients array
         *
         * @param Ingredient $checkIngredient
         * @return bool
         */
        public function ingredientInArray(Ingredient $checkIngredient): bool
        {
            $inArray = false;
            if ($this->ingredients && is_array($this->ingredients)) {
                foreach ($this->ingredients as $ingredient) {
                    if ($ingredient->Name === $checkIngredient->Name) {
                        $inArray = true;
                    }
                }
            }

            return $inArray;
        }

        public function getIngredients(): array
        {
            if ($this->ingredients && !empty($this->ingredients)) {
                return $this->ingredients;
            }

            return array();
        }

        public function getIngredientCount(Ingredient $checkIngredient): int
        {
            $count = 0;

            if ($this->ingredients && is_array($this->ingredients)) {
                foreach ($this->ingredients as $ingredient) {
                    if ($ingredient instanceof Ingredient && $ingredient->Name === $checkIngredient->Name) {
                        $count = $ingredient->getCount();
                    }
                }
            }

            return $count;
        }

        public function getIngredientType(Ingredient $checkIngredient): string
        {
            $type = "";

            if ($this->ingredients && is_array($this->ingredients)) {
                foreach ($this->ingredients as $ingredient) {
                    if ($ingredient instanceof Ingredient && $ingredient->Name === $checkIngredient->Name) {
                        $type = $ingredient->getType();
                    }
                }
            }

            return $type;
        }

        public function getPermalink()
        {
            return "recipe.php?id=" . $this->ID;
        }
    }
}