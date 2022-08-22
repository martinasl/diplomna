<?php

    session_start(); //Стартиране на сесия

    if (isset($_SESSION['logged'])) { //

        if($_SESSION['logged'] == 'client') { //Проверка дали има логнат клиент

            header('Location: clients.php'); //Ако да пренасочване към страницата на клиентите

        } elseif ($_SESSION['logged'] == 'broker') { //Проверка дали има логнат брокер
            header('Location: brokers.php'); //Ако да пренасочване към страницата на брокерите
        }

    }
   //<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

?>

<!doctype html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="https://bootswatch.com/5/cyborg/bootstrap.min.css" integrity="sha384-ho+E1p63iQjWbfmVdB2r7jaYXGIB0m8tw+WfjOLvq6V65Y6iGeCebznFSl0CGSRY" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="src/style.css">

    <title>Начало</title>
</head>


<body>
    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col"><h2 class="text-center mb-4">Добре дошли!</h2></div>
            <div class="col"></div>
        </div>
        <div class="row">
            <div class="col"></div>
            <div class="col text-center">
                <a href="login.php" class="btn btn-outline-primary mr-5">Вход</a> 
                <a href="register.php" class="btn btn-outline-primary ml-5">Регистрация</a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</body>

</html>