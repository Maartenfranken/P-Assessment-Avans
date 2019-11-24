<?php
require_once(__DIR__ . "/Database.php");

if (!class_exists('UserLogin')) {
    class UserLogin
    {
        private $allowedRoles = array("admin");

        /**
         * Check login
         *
         * @return string
         */
        public function checkLogin(): string
        {
            if (
                $_SERVER['REQUEST_METHOD'] === 'POST'
                && isset($_POST['inputUsername'])
                && isset($_POST['inputPassword'])
            ) {
                $username = filter_var($_POST['inputUsername'], FILTER_SANITIZE_STRING);
                $password = hash('sha256', $_POST['inputPassword']);

                if ($this->checkUserExists($username)) {
                    if ($password === $this->getPassword($username)) {
                        $user = new User($username);
                        $_SESSION['user'] = $user; //Save User object in Session

                        if (in_array($user->getRole(), $this->allowedRoles)) {
                            header("Location: " . ADMIN_URL);
                            die();
                        } else {
                            return "Not correct role";
                        }
                    } else {
                        return "Wrong password";
                    }
                } else {
                    return "Username doesn't exist";
                }
            } else {
                return "Fill in all fields";
            }
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
            $user = $db->select("SELECT Username AS 'username' FROM account WHERE Username = :username",
                User::class,
                array(
                    ':username' => $username
                ));

            if ($user && is_array($user) && isset($user[0])) {
                return true;
            } else {
                return false;
            }
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
            $password = $db->select("SELECT Password FROM account WHERE Username = :username", "",
                array(
                    ':username' => $username
                ));

            if ($password && is_array($password) && isset($password[0]) && isset($password[0]->Password)) {
                return $password[0]->Password;
            } else {
                return "";
            }
        }

        /**
         * Check if the current user in Session exists and has the correct role
         *
         * @return bool
         */
        public function isUserLoggedIn(): bool
        {
            if (isset($_SESSION) && isset($_SESSION["user"])) {
                $user = $_SESSION["user"];
                if ($user instanceof User && in_array($user->getRole(), $this->allowedRoles)) {
                    return true;
                }
            }

            return false;
        }

        /**
         * Removes the current user from Session
         */
        public function logout(): void
        {
            if (isset($_SESSION) && isset($_SESSION["user"])) {
                unset($_SESSION["user"]);
                header("Location: " . LOGIN_URL);
                die();
            }
        }
    }
}