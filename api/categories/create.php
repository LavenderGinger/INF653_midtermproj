<?php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

  $database = new Database();
  $db = $database->connect();
  $category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

        $category->category = $data->category ?? null;

    if ($category->category  === null) {
        echo json_encode(['message' => 'Missing Required Parameters']);
        exit();
    }

echo json_encode(
    array('id' => $category->create(), 'category' => $category->category)
);
