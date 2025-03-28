<?php
include_once '../../config/Database.php';
include_once '../../models/Author.php';

  $database = new Database();
  $db = $database->connect();
  $author = new Author($db);

  $data = json_decode(file_get_contents("php://input"));

if (!isset($data->author_id) || empty($data->author_id)) {
    die(json_encode(["id" => "ID is required"]));
}

    $author->id = $data->author_id;
        if ($author->delete()) {
            echo json_encode(array('id' => 'Author deleted'));
        }
        else {
            echo json_encode(array('message' => 'Author not deleted'));
        }
