<?php
include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->connect();
$quote = new Quote($db);

$id = isset($_GET['id']) ? $_GET['id'] : null;
$author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

$result = $quote->read();
$num = $result->rowCount();

if($num>0){
    $quotes_arr = array();

    while($row=$result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $quote_item = array(
            'id'=>$id,
            'quote'=>$quote,
            'author'=>$author_name,
            'category'=>$category_name
        );
        array_push($quotes_arr, $quote_item);
    }
    echo json_encode($quotes_arr);
}
else {
    echo json_encode(array('message' => 'No Quotes Found'));
}