<?php
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

$result = $quote->read_single($quote->id);
if (empty($result)) {
    echo json_encode(['message' => 'No Quotes Found']);
    exit();
}

echo json_encode($result);