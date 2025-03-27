<?php
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

  $database = new Database();
  $db = $database->connect();
  $quote = new Quote($db);

  $data = json_decode(file_get_contents("php://input"));
  
  $quote = $data->quote ?? null;
  $author_id = $data->author_id ?? null;
  $category_id = $data->category_id ?? null;
  
  if ($quote === null || $author_id === null || $category_id === null) {
      echo json_encode(['message' => 'Missing Required Parameters']);
      exit();
  }
  
  $quote_obj = new Quote($db);
  $quote_obj->quote = $quote;
  $quote_obj->author = $author_id;
  $quote_obj->category = $category_id;

    echo json_encode(
        array('id' => $quote_obj->create(), 'quote' => $quote_obj->quote, 'author_id' => $quote_obj->author, 'category_id' => $quote_obj->category)
    );
