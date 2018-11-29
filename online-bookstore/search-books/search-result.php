<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
$data = json_decode(file_get_contents("php://input"));
$title = $data->title;

$url = "http://localhost:9000/HelloWorld?wsdl";
$client = new SoapClient($url);
$result = (array)$client->searchBooksByTitle($title);
$n_items = 0;

try {
    if (isset($result['item'])){
        $n_items = sizeof($result['item']);
        foreach($result['item'] as $x){
            $search_query = "SELECT AVG(rating) as rating, count(*) as votes_count FROM `order` WHERE book_id = $x->id ";
            $books = $mysqli->query($search_query);
            if (!$books) {
                $x->rating = '0';
                $x->votes_count = '0';
            } else {
                $row = $books->fetch_assoc();
                $x->rating = $row['rating'];
                $x->votes_count = $row['votes_count'];
            }
        }
    }
} catch (Exception $e) {
    $n_items = 0;
}

if ($n_items > 0) {
    echo json_encode($result);
}
else {
    $temp = array("item" => array());
    echo json_encode($temp);
}
?>
