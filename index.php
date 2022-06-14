<?php
session_start();
require_once("./config.php");
//require_once('./classes/shorten.php')
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <div class="row pt-5">
        <div class="w-50 mx-auto">
            <form method="POST" action="classes/shorten.php">
                <div class="section group">
                    <div class="col span_3_of_3">
                        <input type="text" id="url" name="url" class="form-control" placeholder="Введите URL адрес">
                    </div>
                </div>
                <input type="submit" value="Отправить" class="btn btn-outline-primary mt-2" style="">
            </form>
        </div>
    </div>
    <div class="row">
        <?php
        //Проверяем существует ли этот запрос и есть ли ошибки
        if (isset($_SESSION['success'])) {
            echo "<div class='alert alert-success' role='alert'>
        Сокращенная ссылка: <a href='{$_SESSION['success']}' class='alert-link' target='_blank'>" . $_SESSION['success'] . "</a></div>";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger' role='alert'>
            <a href='{$_SESSION['error']}' class='alert-link' target='_blank'>" . $_SESSION['error'] . "</a></div>";
            unset($_SESSION['error']);
        }
        if (isset($_GET['error']) && $_GET['error'] == 'db') {
            echo "<div class='alert alert-danger' role='alert'>Ошибка подключения к базе !<a href='#' class='alert-link'></a>.
            </div>";
        }
        if (isset($_GET['error']) && $_GET['error'] == 'nourl') {
            echo "<div class='alert alert-danger' role='alert'>Неверный URL !<a href='#' class='alert-link'></a>.
            </div>";
        }

        ?>
    </div>
</div>
</body>
</html>