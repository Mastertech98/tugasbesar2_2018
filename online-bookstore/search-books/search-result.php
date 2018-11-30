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
        $n_items = 1;
        if (is_array($result['item'])){
            foreach($result['item'] as $x){
                if(isset($x->id)){
                    $search_query = "SELECT AVG(rating) as rating, COUNT(rating) as votes_count FROM `order` WHERE book_id ='". $x->id ."'";
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
        }
        else{
            if(isset($result['item']->id)){ 
                $search_query = "SELECT AVG(rating) as rating, COUNT(rating) as votes_count FROM `order` WHERE book_id = '" . $result['item']->id . "'";
                $books = $mysqli->query($search_query);
                if (!$books) {
                    $result['item']->rating = '0';
                    $result['item']->votes_count = '0';
                } else {
                    $row = $books->fetch_assoc();
                    $result['item']->rating = $row['rating'];
                    $result['item']->votes_count = $row['votes_count'];
                }
                $result['item'] = array($result['item']);
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
