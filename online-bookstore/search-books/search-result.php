<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";
$data = json_decode(file_get_contents("php://input"));
$title = $mysqli->real_escape_string($data->title);
$output = array();

$search_query = "SELECT *, (SELECT AVG(rating) FROM `order` WHERE book_id = book.id) AS rating, (SELECT COUNT(*) FROM `order` WHERE book_id = book.id AND rating IS NOT NULL) AS votes_count FROM book WHERE title LIKE '%$title%' ";

$books = $mysqli->query($search_query);
$output['length'] = $books->num_rows;
sleep(3);
if ($books->num_rows > 0) {
    while($row = $books->fetch_array()){
        $output[]= $row;
    }
    echo json_encode($output);
}
?>
