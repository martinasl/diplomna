<?php

	session_start(); //Стартиране на сесия

    require_once 'db.php';

	if (isset($_SESSION['logged'])) { //

		if($_SESSION['logged'] == 'client') { //Проверка дали има логнат клиент

			header('Location: clients.php'); //Ако да пренасочване към страницата на клиентите

		} elseif ($_SESSION['logged'] == 'broker') { //Проверка дали има логнат брокер
			
			header('Location: brokers.php'); //Ако да пренасочване към страницата на брокерите

		}

	}

	if (isset($_POST['email'])) { //Проверка дали е изпратена заявка за логване
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		$getPassQueryClient = "SELECT password FROM client WHERE email = '$email'"; //Заявка за получаване на парола на клиент от БД
		$getPassQueryBroker = "SELECT password FROM broker WHERE email = '$email'"; //Заявка за получаване на парола на брокер от БД

		$result = mysqli_query($con, $getPassQueryClient); //Изпълняване на заявка за парола на клиент


		if (mysqli_num_rows($result) === 1) { //Проверка дали е клиент

			$passwordDB = mysqli_fetch_row($result)[0]; //Съхраняване на получената (криптирана) от БД парола в $passwordDB
				if ($passwordDB === md5($password)) { //Сравняване на криптираната парола от базата с паролата (криптира се на момента), която е въвел потребителя
					
					$_SESSION['logged'] = 'client';
					header('Location: clients.php'); //При съвпадение пренасочване към страницата на клиентите
					
					} else {

							die('Грешна парола!'); //Умиране
					
							}
	} else { //Брокер

		$passwordDB = mysqli_fetch_row(mysqli_query($con, $getPassQueryBroker))[0]; //Съхраняване на получената (криптирана) от БД парола в $passwordDB

			if ($passwordDB === md5($password)) { //Сравняване на криптираната парола от базата с паролата (криптира се на момента), която е въвел потребителя
			
				$_SESSION['logged'] = 'broker';
				header('Location: brokers.php'); //При съвпадение пренасочване към страницата на брокери

			} else {

					die('Грешна парола!'); //Умиране

					}
			
			}
	}
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
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384- OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="src/style.css">

    <title>Вход</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <h2 class="text-center">Вход</h2>
                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Електронна поща</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            name="email" required>
                        <small id="emailHelper" class="form-text text-muted">Пример: example@mail.com</a></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Парола</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Вход</button>
                </form>
                <small id="alreadyMember" class="form-text text-muted text-left">Нямаш регистрация?<a href="register.php"> Регистрирай се!</a></small>
            </div>
            <div class="col"></div>
        </div>
    </div>
</body>

</html>