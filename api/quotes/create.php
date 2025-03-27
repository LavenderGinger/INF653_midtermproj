<?php
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

  $database = new Database();
  $db = $database->connect();
  $quote = new Quote($db);
  $author = new Author($db);
  $category = new Category($db);

  $data = json_decode(file_get_contents("php://input"));
  
  $quote = $data->quote ?? null;
  $author_id = $data->author_id ?? null;
  $category_id = $data->category_id ?? null;
  
  if ($quote === null || $author_id === null || $category_id === null) {
      echo json_encode(['message' => 'Missing Required Parameters']);
      exit();
  }

    $result = $author->read_single($author_id);

    if (empty($result)) {
        echo json_encode(['message' => 'author_id Not Found']);
        exit();
    }

    $result = null;

    $result = $category->read_single($category_id);

    if (empty($result)) {
        echo json_encode(['message' => 'category_id Not Found']);
        exit();
    }

  $quote_obj = new Quote($db);
  $quote_obj->quote = $quote;
  $quote_obj->author = $author_id;
  $quote_obj->category = $category_id;

    echo json_encode(
        array('id' => $quote_obj->create(), 'quote' => $quote_obj->quote, 'author_id' => $quote_obj->author, 'category_id' => $quote_obj->category)
    );
