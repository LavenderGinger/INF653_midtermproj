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
include_once '../../models/Author.php';

  $database = new Database();
  $db = $database->connect();
  $author = new Author($db);

  $data = json_decode(file_get_contents("php://input"));

    $author->id = $author_id;
        if ($author->delete()) {
            echo json_encode(array('message' => 'Author deleted'));
        }
        else {
            echo json_encode(array('message' => 'Author not deleted'));
        }
    else {
        echo json_encode(array('message' => 'Missing author ID'));
    }