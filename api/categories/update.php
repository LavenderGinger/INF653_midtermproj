<?php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

  $database = new Database();
  $db = $database->connect();
  $category = new Category($db);

  $data = json_decode(file_get_contents("php://input"));
  $category->id = $data->id ?? null;
  $category->category = $data->category ?? null;

if ($category->id  === null || $category->category) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

  if ($category->update()) {
      echo json_encode(array('id' => $category->id  , 'category' => $category->category));
  }
  else {
      echo json_encode(array('id' => 'Category not updated'));
  }