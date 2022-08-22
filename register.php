<?php

    session_start(); //Стартиране на сесия

    require_once 'db.php';

    if (isset($_SESSION['logged'])) { //Проверка дали съществува сесия

        if($_SESSION['logged'] == 'client') { //Проверка дали има логнат клиент
            header('Location: clients.php'); //Ако да, пренасочване към страницата на клиентите
        } elseif ($_SESSION['logged'] == 'broker') { //Проверка дали има логнат брокер
            header('Location: brokers.php'); //Ако да, пренасочване към страницата на брокерите       
        }

    }

    if(isset($_POST['first_name'])) { //Проверка дали е изпратена заявка за регистрация

        $fName = $_POST['first_name'];
        $lName = $_POST['last_name'];
        $tel = $_POST['phone'];
        $email = $_POST['email'];
        
        if (strlen($tel) < 10 || strlen($tel) > 10) {
            die ('Моля въведете правилен тел. номер!');
        }
        

        $pas1 = $_POST['password'];
        $pas2 = $_POST['password1'];
 
        $password = md5($pas1); //Криптиране на парола
        $testPass = md5($pas2); //Криптиране на парола

        if($password !== $testPass) { //Ако не съвпадат паролите
            die ('Паролите не съвпадат, моля опитате отново!');
        }

    if (isset($_POST['type']) and $_POST['type'] === 'on') { //Проверка дали се регистрира като клиент
        
        $broker = $_POST['ID_broker'];
        $city = $_POST['ID_city'];
        $sqlRegisterQuery = "INSERT INTO client (first_name, last_name, telephone, email, password, ID_broker, ID_city) VALUES ('$fName', '$lName', '$tel', '$email', '$password', '$broker', '$city')"; //Заявка за въвеждане на данните в БД за клиент

            if (mysqli_query($con, $sqlRegisterQuery)) { //Проверка за успешна заявка
                $_SESSION['logged'] = 'client';
                header('Location: clients.php'); //Пренасочване към страница на клиенти
            } else {        
                die('Грешка при регистрация, моля опитай отново!'); //Умиране
            }

        } else { //Регистрация като брокер
        
        $area = $_POST['area'];
        $sqlRegisterQuery = "INSERT INTO broker (first_name, last_name, telephone, email, password, ID_area) VALUES ('$fName', '$lName', '$tel', '$email', '$password', '$area')"; //Заявка за въвеждане на данните в БД за брокер

                if (mysqli_query($con, $sqlRegisterQuery)) {
                    $_SESSION['logged'] = 'broker';
                    header('Location: brokers.php'); //Пренасочване към страница "брокери"
                } else {
                    die('Грешка при регистрация, моля опитайте отново!'); //Умиране    
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
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="src/style.css">

    <title>Регистрация</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                <h2 class="text-center">Регистрация</h2>
                <form method="POST" action="register.php">
                    <label for="type" >Регистрирай се като</label>
                    <input type="checkbox" data-toggle="toggle" data-on="Клиент" data-off="Брокер" data-onstyle="success" data-offstyle="info" id="type" name="type" checked>
                    <div class="form-group mt-2">
                        <label for="exampleInputFirstName">Име</label>
                        <input type="text" class="form-control" id="exampleInputFirstName" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputLastName">Фамилия</label>
                        <input type="text" class="form-control" id="exampleInputLastName" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPhone">Телефон</label>
                        <input type="tel" class="form-control" id="exampleInputPhone" name="phone" required>
                        <small id="telephoneHelper" class="form-text text-muted">Пример: 08XXXXXXXX</a></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Електронна поща</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                        <small id="emailHelper" class="form-text text-muted">Пример: example@mail.com</a></small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Парола</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword2">Повторете паролата</label>
                        <input type="password" class="form-control" id="exampleInputPassword2" name="password1" required>
                    </div>
                    <div id="client">
                        <div class="form-group">
                            <label>Брокер</label>
                            <select name="ID_broker" class="form-control" required>
                                <?php

                                    $query = "SELECT ID_broker, first_name, last_name FROM broker"; //Заявка за получаване на всички брокери
                                    $resultBroker = mysqli_query($con, $query);//Изпълняване на заявката
                                    mysqli_fetch_all($resultBroker); //Обработване на заявката

                                    foreach ($resultBroker as $resBr) { //За всеки запис от резултата се добавя нов <option> таг
                                        echo "<option value='" . $resBr['ID_broker'] . "'>" . $resBr['first_name'] . ' ' . $resBr['last_name'] . "</option>";
                                    }

                                ?>

                            </select>
                        </div>
                        
        <div class="form-group">
            <label>Град</label>
            <select name="ID_city" class="form-control" required>
                <?php
                                        
                    $query = "SELECT ID_city, name_city FROM city";//Заявка за получаване на всички градове
                    $resultCity = mysqli_query($con, $query);//Изпълняване на заявката
                    mysqli_fetch_all($resultCity); //Обработване на заявката

                    foreach ($resultCity as $resCi) { //За всеки запис от резултата се добавя нов <option> таг
                        echo "<option value='" . $resCi['ID_city'] . "'>" . $resCi['name_city'] . "</option>";
                    }
                ?>
            </select>
         </div>
     </div>

<div id="broker">
    <div class="form-group">
        <label>Район</label>
        <select name="area" class="form-control" required>                    
            <?php

                $query = "SELECT ID_area, name FROM area";//Заявка за получаване на всички райони
                $result = mysqli_query($con, $query);//Изпълняване на заявката
                mysqli_fetch_all($result); //Обработване на заявката

                foreach ($result as $res) { //За всеки запис от резултата се добавя нов <option> таг
                    echo "<option value='" . $res['ID_area'] . "'>" . $res['name'] . "</option>";
                }
            ?>
        </select>
    </div>
</div>

<button type="submit" class="btn btn-primary">Регистрация</button>
                </form>
            <small id="alreadyMember" class="form-text text-muted text-left">Вече си потребител?<a href="login.php"> Влез в системата!</a></small>
            </div>
            <div class="col"></div>
        </div>
    </div>
    <script>
    let checkbox = $("#type");
    let clientInputs = $("#client");
    let brokerInputs = $("#broker");
    checkbox.change(function() {
        if (checkbox.prop("checked") == false) { //Показване на полетата за регистрация на брокер
            
			clientInputs.hide();
        	brokerInputs.show();
        
		} else if (checkbox.prop("checked") == true) { //Показване на полетата за регистрация на клиент
            
			brokerInputs.hide();
            clientInputs.show();

        }
    })
    </script>
</body>

</html>