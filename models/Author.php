<?php
class Author {
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function read($id = null, $author = null) {
        $query = 'SELECT id, author FROM ' . $this->table . ' ORDER BY id';

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single($id) {
        $query = 'SELECT id, author FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->id = $row['id'];
            $this->author = $row['author'];
            return $this;
        }
        else {
            return null;
        }
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (author) VALUES (:author)';

        $stmt = $this->conn->prepare($query);

        $this->author = htmlspecialchars(strip_tags($this->author));

        $stmt->bindParam(':author', $this->author);

        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s. \n", $stmt->error);

        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . '
        SET author = :author
        WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }

        printf("Error : %s. \n", $stmt->error);

        return false;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }

        printf("Error: %s. \n", $stmt->error);

        return false;
    }
}