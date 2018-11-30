<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/at-config.php';

if (!isset($_COOKIE['access_token'])) {
    header("Location: /login/");
    exit;
}

$access_token = $_COOKIE['access_token'];
if (getAccessToken($access_token, $mysqli)->num_rows == 0) {
    header("Location: /login/");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit;
}

$user_id = $mysqli->query("SELECT * FROM access_info WHERE token = '$access_token'");
$user_id = $user_id->fetch_assoc();
$user_id = $user_id['user_id'];

$url = "http://localhost:9000/HelloWorld?wsdl";
$client = new SoapClient($url);        

$history_query = "SELECT id, book_id, order_date, quantity, rating IS NOT NULL AS reviewed FROM `order` WHERE buyer_id = '$user_id' ORDER BY order_date DESC";

if (!$history = $mysqli->query($history_query)) {
    echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>History</title>
    <link rel="stylesheet" href ="/header.css" type="text/css"/>
    <link rel="stylesheet" href ="history.css" type="text/css"/>
</head>

<body class="history">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php' ?>
    <main>
        <h1>History</h1>
        <ol>
            <?php while ($order = $history->fetch_assoc()) { ?>
            <li>
                <?php 
                    $result = (array)$client->searchBookByID($order['book_id']); 
                    $order['cover'] = $result['cover'];
                    $order['book_title'] = $result['title'];                
                ?>
                <div class="book-cover"><img src="<?= $order['cover'] ?>" alt="cover of <?= $order['book_title'] ?>" /></div>
                <div class= "middle">
                    <div class="book-title"><?= $order['book_title'] ?></div>
                    <div class="order-quantity">Quantity: <?= $order['quantity'] ?></div>
                    <div class="order-reviewed"><?= $order['reviewed'] ? 'Reviewed' : 'Not reviewed' ?></div>
                </div>
                <div class="right">
                    <div class="order-date"><?= $order['order_date'] ?></div>
                    <div class="order-id">Order Number: #<?= $order['id'] ?></div>
                    <?php if (!$order['reviewed']) { ?>
                    <div class="review-button"><a href="/review/?id=<?= $order['id'] ?>">Review</a></div>
                    <?php } ?>
                </div>
            </li>
            <?php } ?>
        </ol>
    </main>
</body>

</html>