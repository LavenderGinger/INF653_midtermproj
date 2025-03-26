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
include_once '../../models/Quote.php';

  $database = new Database();
  $db = $database->connect();
  $quote = new Quote($db);

  php
  $data = json_decode(file_get_contents("php://input"));
  
  $quote = $data->quote ?? null;
  $author_id = $data->author_id ?? null;
  $category_id = $data->category_id ?? null;
  
  if ($quote === null || $author_id === null || $category_id === null) {
      echo json_encode(['message' => 'Missing required fields']);
      exit();
  }
  
  $quote_obj = new Quote($db);
  $quote_obj->quote = $quote;
  $quote_obj->author_id = $author_id;
  $quote_obj->category_id = $category_id;
  
  if ($quote_obj->create()) {
      echo json_encode(['message' => 'Quote created successfully']);
  } else {
      echo json_encode(['message' => 'Failed to create quote']);
  }  