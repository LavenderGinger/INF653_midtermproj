<?php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

  $database = new Database();
  $db = $database->connect();
  $category = new Category($db);

  $category->id = isset($_GET['id']) ? $_GET['id'] : die();

$category->read_single($category->id);

$category_arr = array (
      'id' => $category->id,
      'author' => $category->category
  );
if (empty($author_arr)) {
    echo json_encode(['message' => 'category_id Not Found']);
    exit();
}

echo json_encode($author_arr);