<?php

require_once "UrlShortener.php";

$urlShortener = new UrlShortener();

if (isset($_GET['QUERY_STRING'])) {
    $uniqueCode = $_GET['QUERY_STRING'];
    $originalUrl = $urlShortener->getOriginalURL();
}

header("Location: index.php");
exit();

