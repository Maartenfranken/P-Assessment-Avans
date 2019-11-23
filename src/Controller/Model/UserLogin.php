<?php
if (!class_exists('UserLogin')) {
    class UserLogin
    {
        private $allowedRoles = array("admin");

        /**
         * Check login
         */
        public function checkLogin()
        {
            $username =filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password = $_POST['password'];

            if ($this->checkUserExists($username)) {
                if (password_verify($password, $this->getPassword($username))) {
                    $user = new User($username);
                    $_SESSION['user'] = $user; //Save User object in Session

                    if (in_array($user->getRole(), $this->allowedRoles)) {
                        //TODO: Redirect to CRUD Back-end
                    }
                } else {
                    //TODO: Show error message
                }
            }

            //TODO: Redirect to Login
        }

        /**
         * Checks if User exists by Username
         *
         * @param $username
         * @return bool
         */
        public function checkUserExists($username): bool
        {
            $db = Database::getInstance();

            return true;
        }

        /**
         * Get the password by Username
         *
         * @param $username
         * @return string
         */
        private function getPassword($username): string
        {
            $db = Database::getInstance();

            return "";
        }
    }
}