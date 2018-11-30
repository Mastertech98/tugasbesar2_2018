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

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (!isset($_GET['id'])) {
            http_response_code(400);
            exit;
        }

        $order_id = $mysqli->real_escape_string($_GET['id']);

        $book_query = "SELECT book_id FROM `order` WHERE id = '$order_id'";
        
        if (!$books = $mysqli->query($book_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }
        
        $book = $books->fetch_assoc();
        
        $url = "http://localhost:9000/HelloWorld?wsdl";
        $client = new SoapClient($url);
        $result = (array)$client->searchBookByID($book['book_id']);
        $book['book_title'] = $result['title'];
        $book['author'] = "";
        if (!is_array($result['authors'])){
            $book['author'] = $result['authors'];
        }
        else{
            $last = count($result['authors']) - 1;
            for($i = 0; $i <= $last ; $i++){
                if ($i == 0){
                    $book['author'] = $result['authors'][$i];
                }
                $book['author'] = $book['author'] . ', ' . $result['authors'][$i];
            }
        }
        $book['cover'] = $result['cover'];

        break;
    case 'POST':
        $id = $mysqli->real_escape_string($_POST['id']);
        $rating = $mysqli->real_escape_string($_POST['rating']);
        $comments = $mysqli->real_escape_string($_POST['comments']);

        $review_query = "UPDATE `order` SET rating = '$rating', comments = '$comments' WHERE id = '$id'";

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
    <link rel="stylesheet" href ="/header.css" type="text/css"/>
    <link rel="stylesheet" href ="/review/review.css" type="text/css"/>
</head>

<body class="history">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php' ?>
    <main>
        <section>
            <div class="book-cover"><img src="<?= $book['cover'] ?>" alt="cover of <?= $book['book_title'] ?>" /></div>
            <h1 class="book-title"><?= $book['book_title'] ?></h1>
            <div class="book-author"><?= $book['author'] ?></div>
        </section>
        <form method="post">
            <input type="hidden" name="id" id="id" value="<?= $order_id ?>" />
            <section>
                <h2>Add Rating</h2>
                <div class="rating">
                    <input name="rating" type="radio" id="5-star" value="5" />
                    <label for="5-star" class="star"><img /></label>
                    <input name="rating" type="radio" id="4-star" value="4" />
                    <label for="4-star" class="star"><img /></label>
                    <input name="rating" type="radio" id="3-star" value="3" checked="checked" />
                    <label for="3-star" class="star"><img /></label>
                    <input name="rating" type="radio" id="2-star" value="2" />
                    <label for="2-star" class="star"><img /></label>
                    <input name="rating" type="radio" id="1-star" value="1"  />
                    <label for="1-star" class="star"><img /></label>
                </div>
            </section>
            <section>
                <h2>Add Comment</h2>
                <textarea id="comments" name="comments" rows="6"></textarea><br />
                <span id="comments-error"></span>
            </section>
            <div class="button">
                <button class="secondary" type="button" onclick="window.history.back()">Back</button>
                <button class="primary">Submit</button>
            </div>
        </form>
    </main>
    <script src="validation.js" type="module"></script>
</body>

</html>