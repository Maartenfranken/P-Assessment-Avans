<?php
//https://www.php.net/manual/en/mysqli-result.fetch-object.php
if (!class_exists('Database')) {
    class Database
    {
        private $connection;
        private static $instance;
        private $host = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "p_assessment";

        //TODO: Fix with try catch?
        private function __construct()
        {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

            if (mysqli_connect_error()) {
                trigger_error("Failed to connect to MySQL: " . mysql_connect_error(), E_USER_ERROR);
            }
        }

        public static function getInstance()
        {
            if (!self::$instance) { // If no instance, make one
                self::$instance = new self();
            }

            return self::$instance;
        }

        // Magic method clone is empty to prevent duplication of connection
        private function __clone()
        {
        }

        public function query(String $sql, String $class = '')
        {
            if ($this->connection) {
                //TODO: SQL NEEDS TO BE PREPARED
                if ($result = $this->connection->query($sql)) {
                    $array = $this->fetchObjects($result, $class);

                    mysqli_free_result($result);

                    return $array;
                }
            }
        }

        private function fetchObjects($result, $class)
        {
            $array = array();

            if (!empty($class)) {
                while ($obj = $result->fetch_object($class)) {
                    $array[] = $obj;
                }
            } else {
                while ($obj = $result->fetch_object()) {
                    $array[] = $obj;
                }
            }

            return $array;
        }
    }
}