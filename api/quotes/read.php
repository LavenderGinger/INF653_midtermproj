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

if (isset($_GET['id'])) {
    $quote->id = $_GET['id'];
    $quote->read_single();

    if ($quote->quote !== null) {
        echo json_encode([
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author,
            'category' => $quote->category,
        ]);
    }
    else {
        echo json_encode(['message' => 'No Quotes Found']);
    }
}
elseif (isset($_GET['author_id']) || isset($_GET['category_id'])) {
    $author_id = $_GET['author_id'] ?? null;
    $category_id = $_GET['category_id'] ?? null;
    $result = $quote->read_filtered($author_id, $category_id);

    if ($result->rowCount() > 0) {
        $quotes_arr = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            array_push($quotes_arr, [
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category,
            ]);
        }
        echo json_encode($quotes_arr);
    }
    else {
        echo json_encode([]);
    }
}
else {
    $result = $quote->read();
    if ($result->rowCount() > 0) {
        $quotes_arr = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            array_push($quotes_arr, [
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category,
            ]);
        }
        echo json_encode($quotes_arr);
    } 
    else {
        echo json_encode([]);
    }
}
