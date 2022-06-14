<?php

session_start();

require_once(__DIR__ . "/../config.php");
require_once(__DIR__ . "/UrlShortener.php");

$errors = false;

$urlShortener = new UrlShortener();
if (isset($_POST['url']) && !$errors) {
    $originalURL = $_POST['url'];
    if ($uniqueCode = $urlShortener->validateUrlAndReturnCode($originalURL)) {
        $_SESSION['success'] = $urlShortener->generateLinkForShortURL($uniqueCode, $originalURL);
    } else
        {
        $_SESSION['error'] = "Данные урл уже есть в бд ";
    }
}

header("Location: ../index.php");
exit();

