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

$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

$quote->read_single();

if($quote->quote != null) {
    $quote_arr = array(
        'id' => $quote->id,
        'quote' => $quote->quote,
        'author' => $quote->author,
        'category' => $quote->category
    );
    echo json_encode($quote_arr);
} else {
    echo json_encode(array('message' => 'No Quote Found'));
}
