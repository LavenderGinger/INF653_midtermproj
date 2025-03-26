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
      $this->db_name = getenv('DBNAME');
      $this->host = getenv('HOST');
      $this->port = getenv('PORT');
    }

    public function connect() {
      if ($this->conn) {
        return $this->conn;
      }
      else {
        $dsn = "postgresql://quotesdb_ykmh_user:8cAZMRJdgq9jyYLUOtyi70O39pLfP9Lj@dpg-cv89lud2ng1s73duh81g-a.oregon-postgres.render.com/quotesdb_ykmh;port={$this->port};dbname={$this->db_name};";
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