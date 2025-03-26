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

$result = $quote->read();
$num = $result->rowCount();

if ($num > 0) {
    $quotes = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $quotes[] = [
            'id' => $row['id'],
            'quote' => $row['quote'],
            'author' => $row['author'] ?? null,
            'category' => $row['category'] ?? null,
        ];
    }
    echo json_encode($quotes);
} else {
    echo json_encode([]);
}
?>