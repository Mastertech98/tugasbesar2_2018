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
        $book_id = $mysqli->real_escape_string($_GET['id']);

        $url = "http://localhost:9000/HelloWorld?wsdl";
        $client = new SoapClient($url);
        $result = (array)$client->searchBookByID($book_id);
        
        //title, author, synopsis
        $book_query = "SELECT AVG(rating) AS rating FROM `order` WHERE book_id = '$book_id'";
        $review_query = "SELECT buyer_id, username, comments, rating FROM (SELECT buyer_id, comments, rating FROM `order` WHERE book_id = '$book_id' AND rating IS NOT NULL) AS `review` JOIN `user` ON user.id = buyer_id";

        $books = $mysqli->query($book_query);
        $reviews = $mysqli->query($review_query);
        if (!$books || !$reviews) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        $book = $books->fetch_assoc();
        $book['title'] = $result['title'];
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
        $book['synopsis'] = $result['desc'];
        $book['cover'] = $result['cover'];
        $book['categories'] = $result['categories'];
        $book['price'] = $result['harga'] < 0 ? "NOT FOR SALE" : $result['harga'];

        if (!is_array($book['categories'])){
            $rec = (array)$client->getRecommendation(array($book['categories']));
        }
        else{
            $rec = (array)$client->getRecommendation($book['categories']);
        }
        break;
    case 'POST':
        // require_once $_SERVER['DOCUMENT_ROOT'] . "/config.php";

        // $access_token = $_COOKIE['access_token'];
        $id = $mysqli->query("SELECT * FROM access_info WHERE token = '$access_token'");
        $id = $id->fetch_assoc();
        $id = $id['user_id'];

        $card_query = "SELECT card FROM user WHERE id = '$id'";
        $card = $mysqli->query($card_query);
        $card = $card->fetch_assoc();
        $card = $card['card'];

        $buyer_id = $mysqli->real_escape_string($id);
        $book_id = $mysqli->real_escape_string($_POST['id']);
        $quantity = $mysqli->real_escape_string($_POST['quantity']);

        $url = "http://localhost:9000/HelloWorld?wsdl";
        $client = new SoapClient($url);
        $result = $client->orderBook($book_id, $quantity, $card);
        var_dump($result);

        $order_query = "INSERT INTO `order`(buyer_id, book_id, quantity, order_date) VALUES ('$buyer_id', '$book_id', '$quantity', CURRENT_DATE())";

        if (!$order = $mysqli->query($order_query)) {
            echo "Failed to run query: (" . $mysqli->errno . ") " . $mysqli->error;
            exit;
        }

        http_response_code(202);
        echo $mysqli->insert_id;
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
    <link rel="stylesheet" href ="/header.css" type="text/css"/>
    <link rel="stylesheet" href ="/book-detail/book-detail.css" type="text/css"/>
</head>

<body class="browse">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/header.php' ?>
    <main>
        <section>
            <span class="right">
                <div class="book-cover"><img src=<?= $book['cover'] ?> alt="cover of <?= $book['title'] ?>" /></div>
                <div class="rating">
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++) { ?><img src="<?= $i <= $book['rating'] ? "full-star" : "empty-star" ?>.png" /><?php } ?>
                    </div>
                    <div class="number">
                        <?= number_format($book['rating'], 1) ?> / 5.0
                    </div>
                </div>
            </span>
            <span class="left">
                <h1 class="book-title"><?= $book['title'] ?></h1>
                <div class="book-author"><?= $book['author'] ?></div>
                <div class="book-synopsis"><?= $book['synopsis'] ?></div>
            </span>
        </section>
        <section>
            <h2>Order</h2>
            <form method="post">
                <input type="hidden" name="id" id="id" value="<?= $book_id ?>" />
                <div class="input">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" id="quantity" list="quantity-option" onclick="this.select()" />
                    <datalist id="quantity-option">
                        <option value="1"></option>
                        <option value="2"></option>
                        <option value="3"></option>
                        <option value="4"></option>
                        <option value="5"></option>
                    </datalist>
                    <span id="quantity-error"></span>
                </div>
                <div class="button">
                    <?php 
                        if(!strcmp($book['price'],"NOT FOR SALE")){
                            echo "<button disabled>". $book['price']. "</button>";
                        }
                        else{
                            echo "<button> Rp ". $book['price']. "<br/> Click to Order</button>";
                        }
                    ?>
                </div>
            </form>
        </section>
        <section>
            <h2>Reviews</h2>
            <ul>
                <?php while ($review = $reviews->fetch_assoc()) {
                    $profile_picture = glob($_SERVER['DOCUMENT_ROOT'] . "/profile/pictures/{$review['buyer_id']}.*");
                    $profile_picture = $profile_picture ? basename($profile_picture[0]) : "0.jpg";
                ?>
                <li>
                    <div class="review-profile-picture"><img src="/profile/pictures/<?= $profile_picture ?>" alt="picture of <?= $review['username'] ?>" /></div>
                    <div class="review-rating">
                        <img src="full-star.png" />
                        <?= number_format($review['rating'], 1) ?> / 5.0
                    </div>
                    <div class="review-username"><?= '@' . $review['username'] ?></div>
                    <div class="review-comments"><?= $review['comments'] ?></div>
                </li>
                <?php } ?>
            </ul>
        </section>
        <section>
            <h2>Recommendation</h2>
            <?php 
                if ($rec['id']){
                    echo "<div class=\"cover-rec\"><img src=\"". $rec['cover'] ."\" alt=\"No Cover\" /></div>
                    <div class=\"detail-rec\"><a href=\"/book-detail/?id=". $rec['id'] ."\">Detail</a></div>";
                }
                else {
                    echo "<div class=\"detail-rec\"><a href=\"/search-books\">Browse</a></div>";
                }
            ?>
            
        </section>
    </main>
    <div class="modal">
        <div class="modal-window">
            <div class="modal-header">
                <button class="modal-close" type="button">✖</button>
            </div>
            <div class="modal-content">
                <img class="check" src="check.png" alt="icon of check" />
                <div class="message">
                    <b>Order Success!</b><br />
                    Transaction Number: <span id="order-id"></span>
                </div>
            </div>
        </div>
    </div>
    <script src="modal.js"></script>
    <script src="order.js" type="module"></script>
    <script src="validation.js" type="module"></script>
</body>

</html>