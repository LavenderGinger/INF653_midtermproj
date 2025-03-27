<?php
  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';

  $database = new Database();
  $db = $database->connect();
  $quote = new Quote($db);
    $author = new Author($db);
    $category = new Category($db);

  $data = json_decode(file_get_contents("php://input"));
  $quote->id = $data->id ?? null;
  $quote->quote = $data->quote ?? null;
  $quote->author = $data->author_id ?? null;
  $quote->category = $data->category_id ?? null;

if ($quote->id  === null || $quote->author === null || $quote->category === null) {
    echo json_encode(['message' => 'Missing Required Parameters']);
    exit();
}

$result = $author->read_single($quote->author);

if (empty($result)) {
    echo json_encode(['message' => 'author_id Not Found']);
    exit();
}

$result = null;

$result = $category->read_single($quote->category);

if (empty($result)) {
    echo json_encode(['message' => 'category_id Not Found']);
    exit();
}

  if ($quote->update()) {
      echo json_encode(array('id' => $quote->id  , 'quote' =>   $data->quote, 'author_id' => $quote->author, 'category_id' => $quote->category));
  }
  else {
      echo json_encode(array('id' => 'Quote not updated'));
  }