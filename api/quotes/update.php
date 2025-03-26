<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  $method = $_SERVER ['REQUEST_METHOD'];

  if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
  }

  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';

  $database = new Database();
  $db = $database->connect();
  $quote = new Quote($db);

  $data = json_decode(file_get_contents("php://input"));
  $quote->id = $data->id;
  $quote->quote = $data->author_id;
  $quote->author_id = $data->author_id;
  $quote->category_id = $data->category_id;
  if ($quote->update()) {
      echo json_encode(array('message' => 'Quote updated'));
  }
  else {
      echo json_encode(array('message' => 'Quote not updated'));
  }