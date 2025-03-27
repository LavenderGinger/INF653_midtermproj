<?php
  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';

  $database = new Database();
  $db = $database->connect();
  $quote = new Quote($db);

  $data = json_decode(file_get_contents("php://input"));
  $quote->id = $data->id;
  $quote->quote = $data->quote;
  $quote->author = $data->author_id;
  $quote->category = $data->category_id;
  if ($quote->update()) {
      echo json_encode(array('id' => $quote->id  , 'quote' =>   $data->quote, 'author_id' => $quote->author, 'category_id' => $quote->category));
  }
  else {
      echo json_encode(array('id' => 'Quote not updated'));
  }