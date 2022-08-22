<?php
session_start(); //Стартиране на сесия

require_once 'db.php';

if($_SESSION['logged'] !== 'broker') { //Проверка дали е логнат брокер

    header('Location: login.php'); //Ако не е брокер пренасочване към логин страницата

}

if(isset($_POST['ID_client'])) { //Проверка дали е подадена заявка за добавяне на посещение

    $date = date( "Y-m-d", strtotime($_POST['date'])); //Преобразуване на датата в такава валидна за БД
    $inputQuery = "INSERT INTO visit (ID_client, ID_broker, ID_property, date, comment) VALUES ({$_POST['ID_client']}, {$_POST['ID_broker']}, {$_POST['ID_property']}, '$date', '{$_POST['comment']}')"; //Заявка за въвеждане на данните в БД
    $input = mysqli_query($con, $inputQuery); //Изпълняване на заявката

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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384- OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="src/style.css">

    <title>Добавяне на Оглед</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <?php
                    if (isset($_SESSION['logged'])) {

                        echo "<a class='btn btn-outline-danger' href='logout.php'>Изход</a>";

                    }

                    if (isset($_SESSION['logged']) && ($_SESSION['logged'] == 'broker')){

                        echo "<a class='btn btn-outline-success' href='brokers.php'>Назад</a>";

                    }
                ?>
            </div>

            <div class="col-4 text-center">
                <h2>Огледи</h2>
                <br>
            </div>

            <div class="col-4"></div>
        </div>

        <?php

            $strSQL = "SELECT ID_client, ID_broker, ID_property, date, comment FROM visit"; //Заявка за получаване на посещения
            $rs = mysqli_query($con,$strSQL); //Изпълняване на заявката

        ?>

        <table cellpadding='5' cellspacing='0' class='table'>
            <tr>
                <td width=100>Клиент</td>
                <td width=100>Брокер</td>
                <td width=100>Имот</td>
                <td width=100>Дата</td>
                <td width=100>Коментар</td>
            </tr>

            <?php
                while($row = mysqli_fetch_array($rs))
                {
                echo "<tr>
                <td>" . mysqli_fetch_row(mysqli_query($con, "SELECT first_name FROM client WHERE ID_client = {$row['ID_client']}"))[0] . "</td>
                <td>" . mysqli_fetch_row(mysqli_query($con, "SELECT first_name FROM broker WHERE ID_broker = {$row['ID_broker']}"))[0] . "</td>
                <td>" . mysqli_fetch_row(mysqli_query($con, "SELECT name_property FROM property WHERE ID_property = {$row['ID_property']}"))[0] . "</td>
                <td>" . $row['date'] . "</td>
                <td>" . $row['comment'] . "</td>
                </tr>";
                }
            ?>

            <tr>
                <form action='addVisit.php' method='POST'>
                    <td>
                        <select name="ID_client" class="form-control" required>
                            <?php
                                $query = "SELECT ID_client, first_name, last_name FROM client"; //Заявка за получаване на всички клиенти
                                $resultClients = mysqli_query($con, $query); //Изпълняване на заявката
                                mysqli_fetch_all($resultClients); //Обработване на заявката
                                foreach ($resultClients as $resCl) { //За всеки запис от резултата се добавя нов <option> таг

                                    echo "<option value='" . $resCl['ID_client'] . "'>" . $resCl['first_name'] . ' ' . $resCl['last_name'] . "</option>";

                                }
                            ?>
                        </select>
                    </td>

                    <td>
                        <select name="ID_broker" class="form-control" required>
                            <?php
                                $query = "SELECT ID_broker, first_name, last_name FROM broker"; //Заявка за получаване на всички брокери
                                $resultBroker = mysqli_query($con, $query); //Изпълняване на заявката
                                mysqli_fetch_all($resultBroker); //Обработване на заявката
                                foreach ($resultBroker as $resBr) { //За всеки запис от резултата се добавя нов <option> таг

                                    echo "<option value='" . $resBr['ID_broker'] . "'>" . $resBr['first_name'] . ' ' . $resBr['last_name'] . "</option>";

                                }
                            ?>
                        </select>
                    </td>

                    <td>
                        <select name="ID_property" class="form-control" required>
                            <?php
                                $query = "SELECT ID_property, name_property FROM property"; //Заявка за получаване на всички имоти
                                $resultProperties = mysqli_query($con, $query); //Изпълняване на заявката
                                mysqli_fetch_all($resultProperties); //Обработване на заявката
                                foreach ($resultProperties as $resPr) { //За всеки запис от резултата се добавя нов <option> таг

                                    echo "<option value='" . $resPr['ID_property'] . "'>" . $resPr['name_property'] . "</option>";

                                }
                            ?>
                        </select>
                    </td>

                    <td><input type='date' name='date' class="form-control" required></td>
                    <td><input type='text' name='comment' class="form-control" placeholder='Коментар'></td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">Добавяне</button>
        </form>
    </div>
</body>

</html>