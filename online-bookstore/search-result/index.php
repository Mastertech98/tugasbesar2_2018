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

$title = isset($_GET['title']) ? $mysqli->real_escape_string($_GET['title']) : '';

$search_query = "SELECT * FROM book WHERE title LIKE '%$title%'";

if (!$books = $mysqli->query($search_query)) {
    echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Result</title>
</head>

<body>
    <main>
        <h1>Search Result</h1>
        <div>Found <span id="result-count"><?= $result->num_rows ?></span> result(s)</div>
        <ul>
            <?php while ($book = $books->fetch_assoc()) { ?>
            <li>
                <div class="book-cover"><img src="/book-detail/cover/<?= $book['id'] ?>.png" alt="cover of <?= $book['title'] ?>" /></div>
                <div class="book-title"><?= $book['title'] ?></div>
                <div class="book-author-and-rating"><?= $book['author'] ?> - <?= $book['rating'] ?>/5.0 (<?= $book['votes-count'] ?> votes)</div>
                <div class="book-synopsis"><?= $book['synopsis'] ?></div>
                <div class="book-detail"><a href="/book-detail/?id=<?= $book['id'] ?>">Detail</a></div>
            </li>
            <?php } ?>
        </ul>
    </main>
</body>

</html>