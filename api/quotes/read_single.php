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

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $quote->id = intval($_GET['id']);
}
if (isset($_GET['author']) && !empty($_GET['author'])) {
    $quote->author_id = intval($_GET['author']);
}
if (isset($_GET['category']) && !empty($_GET['category'])) {
    $quote->category_id = intval($_GET['category']);
}

$result = $quote->read_single();
if (empty($result)) {
    echo json_encode(['message' => 'No quotes found.']);
    exit();
}

echo json_encode($result);