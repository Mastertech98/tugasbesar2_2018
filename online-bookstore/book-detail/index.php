<?php
if (!isset($_COOKIE['id'])) {
    header("Location: /login/");
    exit;
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

        if (!isset($_GET['id'])) {
            http_response_code(400);
            exit;
        }

        $book_id = $mysqli->real_escape_string($_GET['id']);

        $book_query = "SELECT title, author, synopsis, AVG(rating) FROM (SELECT * FROM book WHERE id = '$book_id') AS 'book' LEFT OUTER JOIN 'order' ON book.id = book_id";
        $review_query = "SELECT buyer_id, username, comments, rating FROM (SELECT buyer_id, comments, rating FROM 'order' WHERE book_id = '1' AND rating IS NOT NULL) AS 'review' JOIN 'user' ON user.id = buyer_id";

        if (!$books = $mysqli->query($book_query) || !$reviews = $mysqli->query($review_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        $book = $books->fetch_assoc();

        break;
    case 'POST':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

        $user_id = $mysqli->real_escape_string($_COOKIE['id']);
        $book_id = $mysqli->real_escape_string($_POST['id']);
        $quantity = $mysqli->real_escape_string($_POST['quantity']);

        $order_query = "INSERT INTO order(user_id, book_id, quantity, order_date) VALUES ('$user_id', '$book_id', '$quantity', CURRENT_DATE())";

        if (!$order = $mysqli->query($order_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        http_response_code(202);
        echo $mysqli->$insert_id;
        exit;
    default:
        http_response_code(405);
        exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title><?= $book['title'] ?></title>
</head>

<body>
    <article>
        <section>
            <h1 class="book-title"><?= $book['title'] ?></h1>
            <div class="book-author"><?= $book['author'] ?></div>
            <div class="book-synopsis"><?= $book['synopsis'] ?></div>
            <div class="book-cover"><img src="/book-detail/cover/<?= $book_id ?>.png" alt="cover of <?= $book['title'] ?>" /></div>
            <div class="rating">
                <div class="stars">
                    <?php for ($i = 0; $i < 5; $i++) { ?>
                    <img src="<?= $i < $book['rating'] ? "full-star" : "empty-star" ?>.png" />
                    <?php } ?>
                </div>
                <div class="number">
                    <?= $book['rating'] ?> / 5.0
                </div>
            </div>
        </section>
        <section>
            <h2>Order</h2>
            <form method="post">
                <input type="hidden" name="id" id="id" value="<?= $book_id ?>" />
                <div class="input">
                    <label for="quantity">Quantity:</label>
                    <select id="quantity">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                <div class="button">
                    <button>Order</button>
                </div>
            </form>
        </section>
        <section>
            <h2>Review</h2>
            <ul>
                <?php while ($review = $reviews->fetch_assoc()) { ?>
                <li>
                    <div class="review-profile-picture"><img src="/profile/picture/<?= $review['buyer_id'] ?>.png" alt="picture of <?= $review['username'] ?>" /></div>
                    <div class="review-username"><?= $review['username'] ?></div>
                    <div class="review-comments"><?= $review['comments'] ?></div>
                    <div class="review-rating">
                        <img src="big-star.png" />
                        <?= $review['rating'] ?> / 5.0
                    </div>
                </li>
                <?php } ?>
            </ul>
        </section>
    </article>
    <script src="order.js"></script>
</body>

</html>