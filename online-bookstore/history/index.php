<?php
if (!isset($_COOKIE['id'])) {
    header("Location: /login/");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

$user_id = $mysqli->real_escape_string($_COOKIE['id']);

$history_query = "SELECT user_order.id, book_id, title, order_date, quantity, rating IS NOT NULL AS reviewed FROM (SELECT id, book_id, quantity, rating FROM 'order' WHERE buyer_id = '$user_id') AS 'user_order' JOIN 'book' ON book_id = book.id ORDER BY order_date DESC";

if (!$history = $mysqli->query($history_query)) {
    echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>History</title>
</head>

<body>
    <main>
        <h1>History</h1>
        <ol>
            <?php while ($order = $history->fetch_assoc()) { ?>
            <li>
                <div class="book-cover"><img src="/book-detail/cover/<?= $order['book_id'] ?>.png" alt="cover of <?= $order['title'] ?>" /></div>
                <div class="book-title"><?= $order['title'] ?></div>
                <div class="order-quantity">Quantity: <?= $order['quantity'] ?></div>
                <div class="order-reviewed"><?= $order['reviewed'] ? 'Reviewed' : 'Not reviewed' ?></div>
                <div class="order-date"><?= $order['order_date'] ?></div>
                <div class="order-id">Order Number: #<?= $order['user_order.id'] ?></div>
                <?php if ($order['reviewed']) { ?>
                <div class="review-buton"><a href="/review/?id=<?= $order['user_order.id'] ?>">Review</a></div>
                <?php } ?>
            </li>
            <?php } ?>
        </ol>
    </main>
</body>

</html>