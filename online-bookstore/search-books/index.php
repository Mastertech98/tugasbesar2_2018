<?php
if (!isset($_COOKIE['access_token'])) {
    header("Location: /login/");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Books</title>
    <link rel="stylesheet" href ="/header.css" type="text/css"/>
    <link rel="stylesheet" href ="search-books.css" type="text/css"/>
</head>

<body class="browse">
    <?php include '../header.php' ?>
    <main>
        <h1>Search Books</h1>
        <form action="/search-result/" method="get" >
            <div class="input">
                <input id="search" type="search" name="title" placeholder="Input search terms..." />
                <span id="search-error"></span>
            </div>
            <div class="button">
                <button>Search</button>
            </div>
        </form>
    </main>
    <script src="validation.js" type="module"></script>
</body>

</html>