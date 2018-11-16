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

        $order_id = $mysqli->real_escape_string($_GET['id']);

        $book_query = "SELECT id, title, author FROM (SELECT book_id FROM 'order' WHERE id = '$order_id') AS 'book_order' JOIN 'book' ON book_id = id";
        
        if (!$books = $mysqli->query($book_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        $book = $books->fetch_assoc();

        break;
    case 'POST':
        require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

        $id = $mysqli->real_escape_string($_POST['id']);
        $rating = $mysqli->real_escape_string($_POST['rating']);
        $comments = $mysqli->real_escape_string($_POST['comments']);

        $review_query = "UPDATE 'order' SET rating = '$rating', comments = '$comments' WHERE id = '$id'";

        if (!$result = $mysqli->query($review_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }
        
        header("Location: /history/");
        exit;
    default:
        http_response_code(405);
        exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Review</title>
</head>

<body>
    <article>
        <section>
            <h1 class="book-title"><?= $book['title'] ?></h1>
            <div class="book-author"><?= $book['author'] ?></div>
            <div class="book-cover"><img src="/book-detail/cover/<?= $book['id'] ?>.png" alt="cover of <?= $book['title'] ?>" /></div>
        </section>
        <section>
            <form method="post">
                <input type="hidden" name="id" id="id" value="<?= $order_id ?>" />
                <section>
                    <h2>Add Rating</h2>
                    <div class="rating">
                        <span><input type="radio" name="rating" id="star5" value="5"><label for="star5"></label></span>
                        <span><input type="radio" name="rating" id="star4" value="4"><label for="star4"></label></span>
                        <span><input type="radio" name="rating" id="star3" value="3"><label for="star3"></label></span>
                        <span><input type="radio" name="rating" id="star2" value="2"><label for="star2"></label></span>
                        <span><input type="radio" name="rating" id="star1" value="1"><label for="star1"></label></span>
                    </div>
                </section>
                <section>
                    <h2>Add Comment</h2>
                    <textarea name="comments"></textarea>
                </section>
                <div class="button">
                    <button class="secondary" type="button">Back</button>
                    <button class="primary">Submit</button>
                </div>
            </form>
        </section>
    </article>
    <script src="review.js"></script>
</body>

</html>