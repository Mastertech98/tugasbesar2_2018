<?php
if (!isset($_COOKIE['id'])) {
    header("Location: /login/");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Books</title>
</head>

<body>
    <main>
        <h1>Search Books</h1>
        <form action="/search-result/" method="get" >
            <div class="input">
                <input type="search" name="title" placeholder="Input search terms..." />
            </div>
            <div class="button">
                <button>Search</button>
            </div>
        </form>
    </main>
</body>

</html>