<?php
include_once '../../config/Database.php';
include_once '../../models/Author.php';

  $database = new Database();
  $db = $database->connect();
  $author = new Author($db);

$data = json_decode(file_get_contents("php://input"));

        $author->author = $data->author ?? null;

if ($author->author === null) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

echo json_encode(
    array('id' => $author->create(), 'author' => $author->author)
);
