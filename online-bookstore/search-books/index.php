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

?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Books</title>
    <link rel="stylesheet" href ="/header.css" type="text/css"/>
    <link rel="stylesheet" href ="search-books.css" type="text/css"/>
    <link rel="stylesheet" href ="search-result.css" type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
</head>

<body class="browse">
    <?php include_once '../header.php' ?>
    <main>
        <h1>Search Books</h1> 
        <div ng-app="myapp" ng-controller="mycontroller">
            <div class="input">
                <input id="search" type="search" name="title" placeholder="Input search terms..." ng-model="title"/>
                <span id="search-error"></span>
            </div>
            <div class="button">
                <button ng-click="search()">Search</button>
            </div>
            <div class="loadingcontainer" ng-show="showloading"><img class="loading" src="loading.gif"/></div>
            <div class="found-result" ng-show="showresultcount">Found <span id="result-count"><input ng-model="showresultcount" readonly></span> result(s)</div>
            <div ng-show="error">Sorry no books Found :(</div>
            <ul ng-repeat="x in results" ng-show="showresult">
                <li>
                    <div class="book-cover"><img ng-src="{{x.cover}}" alt="No Cover" /></div>
                    <div class="book-title">{{x.title}}</div>
                    <div class="book-author-and-rating" ng-show="!(isArray(x.authors))">{{x.authors}} - {{x.rating | number: 1}}/5.0 ({{x.votes_count}} votes)</div>
                    <div class="book-author-and-rating" ng-show="isArray(x.authors)">{{x.authors.join(", ")}} - {{x.rating | number: 1}}/5.0 ({{x.votes_count}} votes)</div>
                    <div class="book-synopsis">{{x.desc}}</div>
                    <div class="book-detail"><a ng-href="/book-detail/?id={{x.id}}">Detail</a></div>
                </li>
            </ul>
        </div>
    </main>
    <script src="angular.js" type="module"></script>
</body>

</html>