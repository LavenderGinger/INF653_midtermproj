<?php
class Quote {
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $author;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT a.author as author_name, c.category as category_name, q.id, q.author_id, q.category_id, q.quote 
        FROM ' . $this->table . ' q
        LEFT JOIN
           authors a on q.author_id = a.id 
        LEFT JOIN
            categories c on q.category_id = c.id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single($id) {
        $query = 'SELECT a.author as author_name, c.category as category_name, q.id, q.author_id, q.category_id, q.quote
      FROM ' . $this->table . ' q
      LEFT JOIN
        authors a ON q.author_id = a.id
      LEFT JOIN
        categories c ON q.category_id = c.id
      WHERE q.id = :id;
      ';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author_name'];
            $this->category = $row['category_name'];
            return $this;
        }
        return null;
    }

    public function create() {
        $query = 'INSERT INTO quotes (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)';
        $stmt = $this->conn->prepare($query);
        
        if (!$this->quote || !$this->author || !$this->category) {
            return false;
        }
        
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author);
        $stmt->bindParam(':category_id', $this->category);
        
        return $stmt->execute();
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET quote = :quote, author_id = :author_id, category_id = :category_id WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author);
        $stmt->bindParam(':category_id', $this->category);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $result = $stmt->execute();
        $num = $result->rowCount();
        if($num == 1) {
            return true;
        }
        return false;
    }
}