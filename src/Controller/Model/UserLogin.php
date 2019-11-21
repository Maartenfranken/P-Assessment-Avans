<?php
if (!class_exists('UserLogin')) {
    class UserLogin
    {
        /**
         * Check login
         */
        public function checkLogin()
        {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (password_verify($password, $this->getPassword($username))) {
                $_SESSION['user'] = new User($username); //Save User object in Session

                //TODO: Redirect to CRUD Back-end
            } else {
                //Show error message
            }
        }

        /**
         * Checks if User exists by Username
         *
         * @param $username
         */
        public function checkUserExists($username)
        {
            $db = Database::getInstance();
        }

        /**
         * Get the password by Username
         *
         * @param $username
         * @return bool
         */
        private function getPassword($username): bool
        {
            $db = Database::getInstance();

            return true;
        }
    }
}