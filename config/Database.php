<?php 
  class Database {
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $conn;
    private $port;
    private $db_name;

    public function __construct() {
      $this->username = getenv('USERNAME');
      $this->password = getenv('PASSWORD');
      $this->dbname = getenv('DBNAME');
      $this->host = getenv('HOST');
    }

    public function connect() {
      if ($this->conn) {
        return $this->conn;
      }
      else {
        $dsn = "pgsql:host={$this->host};dbname={$this->dbname}";
        try { 
          $this->conn = new PDO($dsn, $this->username, $this->password);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          return $this->conn;
        }
        catch(PDOException $e) {
          echo 'Connection Error: ' . $e->getMessage();
          die();
        }
      }
    }
  }