<?php
class Database {
    private $host = "db4free.net";
    private $db_name = "ticketsphp";
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->username = getenv('Database_UserName');  // en Replit 'Secrets'
        $this->password = getenv('Database_Password');  // en Replit 'Secrets'
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>