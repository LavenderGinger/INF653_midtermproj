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

if(isset($_GET['id'])) {
    $quote->id = $_GET['id'];
    $quote->read_single();

    if($quote->quote !== null) {
        $quote_arr = array(
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author,
            'category' => $quote->category
        );
        echo json_encode($quote_arr);
    } else {
        echo json_encode(array('message' => 'No Quotes Found'));
    }
} else {
    $result = $quote->read();
    $num = $result->rowCount();

    if($num > 0) {
        $quotes_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            
            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );

            array_push($quotes_arr, $quote_item);
        }

        echo json_encode($quotes_arr);
    } else {
        echo json_encode(array());
    }
    if(isset($_GET['id'])) {
    $quote->id = $_GET['id'];
    $quote->read_single();

    if($quote->quote !== null) {
        $quote_arr = array(
            'id' => $quote->id,
            'quote' => $quote->quote,
            'author' => $quote->author,
            'category' => $quote->category
        );
        echo json_encode($quote_arr);
    } else {
        echo json_encode(array('message' => 'No Quotes Found'));
    }
} else {
    $result = $quote->read();
    $num = $result->rowCount();

    if($num > 0) {
        $quotes_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            
            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );

            array_push($quotes_arr, $quote_item);
        }

        echo json_encode($quotes_arr);
    }
    else {
        echo json_encode(array());
    }
    $author->name = $data->name;

if($author->create()) {
    echo json_encode(array('message' => 'Author Created'));
}
else {
    echo json_encode(array('message' => 'Author Not Created'));
}
}
}

