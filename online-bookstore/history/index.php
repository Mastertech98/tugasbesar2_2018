<?php
if (!isset($_COOKIE['access_token'])) {
    header("Location: /login/");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$access_token = $_COOKIE['access_token'];
$user_id = $mysqli->query("SELECT id FROM user WHERE access_token = '$access_token'");
$user_id = $user_id->fetch_assoc();
$user_id = $user_id['id'];

$history_query = "SELECT user_order.id, book_id, title, order_date, quantity, rating IS NOT NULL AS reviewed FROM (SELECT id, book_id, quantity, order_date, rating FROM `order` WHERE buyer_id = '$user_id') AS `user_order` JOIN `book` ON book_id = book.id ORDER BY order_date DESC";

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
                    $book_cover = glob($_SERVER['DOCUMENT_ROOT'] . "/book-detail/cover/". $order['book_id'] .".*");
                    $book_cover = $book_cover ? basename($book_cover[0]) : "0.jpg";                 
                ?>
                <div class="book-cover"><img src="/book-detail/cover/<?= $book_cover ?>" alt="cover of <?= $order['title'] ?>" /></div>
                <div class= "middle">
                    <div class="book-title"><?= $order['title'] ?></div>
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