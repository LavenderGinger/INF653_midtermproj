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

  $data = json_decode(file_get_contents("php://input"));

    $quote->id = $data->id;
        if ($quote->delete()) {
            echo json_encode(array('message' => 'Quote deleted'));
        }
        else {
            echo json_encode(array('message' => 'Quote not deleted'));
        }