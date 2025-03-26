<?php 
  class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $conn;
    private $port;

    public function __construct() {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $this->username = $_ENV['USERNAME'];
        $this->password = $_ENV['PASSWORD'];
        $this->dbname = $_ENV['DBNAME'];
        $this->host = $_ENV['HOST'];
        $this->port = $_ENV['PORT'];
    }

    public function connect() {
        if ($this->conn) {
            return $this->conn;
        } else {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};";
            try {
                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $this->conn;
            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
                die();
            }
        }
    }
}