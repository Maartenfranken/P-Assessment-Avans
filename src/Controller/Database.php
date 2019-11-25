<?php
if (!class_exists('Database')) {
    class Database
    {
        private $connection;
        private static $instance;
        private $server = "mysql:host=localhost;dbname=p_assessment";
        private $username = "root";
        private $password = "";

        private function __construct()
        {
            try {
                $this->connection = new PDO($this->server, $this->username, $this->password);
                $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE); //Fix for an issue I had with int parameters.
            } catch (PDOException $e) {
                error_log($e->getMessage());
                exit("Error connecting to database");
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

        public function closeConnection()
        {
            $this->connection = null;
        }

        /**
         * Executes the SQL Query after preparing and adding possible values
         * Returns an array of objects of specified class if given
         *
         * @param string $sql
         * @param string $class
         * @param array $values
         * @return array
         */
        public function select(string $sql, string $class = "", array $values = array()): array
        {
            if ($this->connection) {
                $stmt = $this->connection->prepare($sql);

                try {
                    if (empty($values)) {
                        $stmt->execute();
                    } else {
                        $stmt->execute($values);
                    }

                    return $this->fetchObjects($stmt, $class);
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    return array();
                }
            }
        }

        /**
         * Prepare the SQL query and execute with values
         *
         * @param string $sql
         * @param array $values
         * @return bool
         */
        public function prepareExecute(string $sql, array $values = array()): bool
        {
            if ($this->connection) {
                $stmt = $this->connection->prepare($sql);

                try {
                    if (empty($values)) {
                        $stmt->execute();
                    } else {
                        $stmt->execute($values);
                    }

                    return true;
                } catch (PDOException $e) {
                    error_log($e->getMessage());
                    return false;
                }
            }
        }

        /**
         * Get the last id inserted into database
         *
         * @return bool|int
         */
        public function getLastId()
        {
            if ($this->connection) {
                return $this->connection->lastInsertId();
            }

            return false;
        }

        private function fetchObjects(PDOStatement $stmt, string $class): array
        {
            $array = array();

            if (!empty($class)) {
                while ($obj = $stmt->fetchObject($class)) {
                    $array[] = $obj;
                }
            } else {
                while ($obj = $stmt->fetchObject()) {
                    $array[] = $obj;
                }
            }

            return $array;
        }
    }
}