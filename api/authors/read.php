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

$result = $author->read();
$num = $result->rowCount();

if($num>0){
    $authors_arr = array();

    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        print_r($row);
        extract($row);
        $author_item = array(
            'id'=>$id,
            'author'=>$author
        );
        array_push($authors_arr, $author_item);
    }
    echo json_encode($authors_arr);
} 
else {
    echo json_encode(array('message' => 'No Authors Found')
    );
}