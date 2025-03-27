<?php
include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();
$author = new Author($db);

$author->id = isset($_GET['id']) ? $_GET['id'] : die();

$result = $author->read_single($author->id);

$author_arr = array (
    'id' => $author->id,
    'author' => $author->author
);
if (empty($result)) {
    echo json_encode(['message' => 'author_id Not Found']);
    exit();
}
else {
    echo json_encode($author_arr);
}