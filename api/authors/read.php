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

if (isset($_GET['id'])) {
    $author->id = $_GET['id'];
    $author->read_single();

    if ($author->name !== null) {
        echo json_encode([
            'id' => $author->id,
            'author' => $author->name,
        ]);
    }
    else {
        echo json_encode(['message' => 'Author Not Found']);
    }
}
else {
    $result = $author->read();
    if ($result->rowCount() > 0) {
        $authors_arr = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            array_push($authors_arr, [
                'id' => $id,
                'author' => $name,
            ]);
        }
        echo json_encode($authors_arr);
    }
    else {
        echo json_encode([]);
    }
}