<?php
include_once '../../config/Database.php';
include_once '../../models/Category.php';

  $database = new Database();
  $db = $database->connect();
  $category = new Category($db);

  $category->id = isset($_GET['id']) ? $_GET['id'] : die();

$result = $category->read_single($category->id);

if (empty($result)) {
    echo json_encode(['message' => 'category_id Not Found']);
    exit();
}
else {
    $category_arr = array (
        'id' => $category->id,
        'category' => $category->category
    );
    echo json_encode($category_arr);
}