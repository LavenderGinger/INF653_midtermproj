<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}
include_once '../../config/Database.php';
include_once '../../models/Category.php';

  $database = new Database();
  $db = $database->connect();
  $category = new Category($db);

  $data = json_decode(file_get_contents("php://input"));
  $category->id = $data->id;
  $category->category = $data->category;
  if ($category->update()) {
      echo json_encode(array('message' => 'Category updated'));
  }
  else {
      echo json_encode(array('message' => 'Category not updated'));
  }