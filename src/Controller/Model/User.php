<?php
if (!class_exists('User')) {
    class User {
        private $username;
        private $role = "admin";

        public function __construct(string $username)
        {
            $this->username = $username;
        }

        public function getUsername() {
            return $this->username;
        }

        public function getRole() {
            return $this->role;
        }
    }
}