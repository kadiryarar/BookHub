<?php

    class Database {
        private string $host = "localhost";    
        private string $username = "root";    
        private string $password = "";    
        private string $dbName = "bookhub";    

        protected function connect() {
            
            try {
                $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;
                $pdo = new PDO($dsn, $this->username, $this->password);

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

                return $pdo;

            } catch (PDOException $err) {
                echo "Hata: " . $err->getMessage();
            }
        }
    }

?>