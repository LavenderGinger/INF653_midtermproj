<?php
include_once '../../config/Database.php';
include_once '../../models/Author.php';

  $database = new Database();
  $db = $database->connect();
  $author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

        $author->author = $data->author;
        if ($author->create()) {
            echo json_encode(array('message' => 'Author created'));
        }
        else {
            echo json_encode(array('message' => 'Author not created'));
        }