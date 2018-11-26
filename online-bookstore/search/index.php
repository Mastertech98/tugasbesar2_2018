<?php
// if (!isset($_COOKIE['access_token'])) {
//     header("Location: /login/");
//     exit;
// }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search</title>
    <link rel="stylesheet" href ="/header.css" type="text/css"/>
    <link rel="stylesheet" href ="search.css" type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular.js"></script>
    <script src="./search.js"></script>
</head>

<body ng-app="probook">
    <?php
    // include $_SERVER['DOCUMENT_ROOT'] . '/header.php'
    ?>
    
    <div ng-controller="probook-ctrl">
        
        <h1>Search Books</h1>
        <form ng-submit="searchBooks()">
            <!-- <div class="input"> -->
                <input ng-model="searchInput" type="search" placeholder="Input search terms..." />
                <span id="search-error"></span>
            <!-- </div> -->
            <div class="button">
                <button>Search</button>
            </div>
        </form>

        <div class="search-result">
            <div class="subtitle">Search Result</div>
            <div class="found-result">Found <span id="result-count">{{ $books.num_rows }}</span> result(s)</div>
        </div>
        <ul>
            <?php // while ($book = $books->fetch_assoc()) { ?>
                <!-- <li>
                    <?php 
                    // $book_cover = glob($_SERVER['DOCUMENT_ROOT'] . "/book-detail/cover/". $book['id'] .".*");
                    // $book_cover = $book_cover ? basename($book_cover[0]) : "0.jpg";                 
                    ?>
                <div class="book-cover"><img src="/book-detail/cover/{{$book_cover}}" alt="cover of {{$book['title']}}" /></div>
                <div class="book-title">{{$book['title']}}</div>
                <div class="book-author-and-rating">{{$book['author']}} - {{number_format((float)$book['rating'], 1)}}/5.0 ({{$book['votes_count']}} votes)</div>
                <div class="book-synopsis">{{$book['synopsis']}}</div>
                <div class="book-detail"><a href="/book-detail/?id={{$book['id']}}">Detail</a></div>
            </li> -->
            <?php //} ?>
        </ul>

    </div>

</body>

</html>