<?php
if (!class_exists('Category')) {
    class Category {
        private $name = '';

        private $count = 0;

        function __construct(String $name, int $count = 0) {
           $this->name = $name;
           $this->count = $count;
        }

        public function getName() {
            return $this->name;
        }

        public function getCount() {
            return $this->count;
        }

        public function setCount(int $count) {
            $this->count = $count;
        }
    }
}