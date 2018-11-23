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

$title = isset($_GET['title']) ? $mysqli->real_escape_string($_GET['title']) : '';

$search_query = "SELECT *, (SELECT AVG(rating) FROM `order` WHERE book_id = book.id) AS rating, (SELECT COUNT(*) FROM `order` WHERE book_id = book.id AND rating IS NOT NULL) AS votes_count FROM book WHERE title LIKE '%$title%' ";

if (!$books = $mysqli->query($search_query)) {
    echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Result</title>
    <link rel="stylesheet" href ="/header.css" type="text/css"/>
    <link rel="stylesheet" href ="./search-result.css" type="text/css"/>
</head>

<body class="browse">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php' ?>
    <main>
        <div class="search-result">
            <h1>Search Result</h1>
            <div class="found-result">Found <span id="result-count"><?= $books->num_rows ?></span> result(s)</div>
        </div>
        <ul>
            <?php while ($book = $books->fetch_assoc()) { ?>
            <li>
                <?php 
                    $book_cover = glob($_SERVER['DOCUMENT_ROOT'] . "/book-detail/cover/". $book['id'] .".*");
                    $book_cover = $book_cover ? basename($book_cover[0]) : "0.jpg";                 
                ?>
                <div class="book-cover"><img src="/book-detail/cover/<?= $book_cover ?>" alt="cover of <?= $book['title'] ?>" /></div>
                <div class="book-title"><?= $book['title'] ?></div>
                <div class="book-author-and-rating"><?= $book['author'] ?> - <?= number_format((float)$book['rating'], 1)?>/5.0 (<?= $book['votes_count'] ?> votes)</div>
                <div class="book-synopsis"><?= $book['synopsis'] ?></div>
                <div class="book-detail"><a href="/book-detail/?id=<?= $book['id'] ?>">Detail</a></div>
            </li>
            <?php } ?>
        </ul>
    </main>
</body>

</html>