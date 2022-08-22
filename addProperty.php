<?php
session_start(); //Стартиране на сесия

require_once 'db.php';

if($_SESSION['logged'] !== 'broker') { //Проверка дали е логнат брокер

    header('Location: login.php');

}

if(isset($_POST['name_property']) and isset($_FILES['img'])){ //Проверка за подадена заявка за добавяне на имот


    //Валидация за типа файлове
    if (strpos($_FILES['img']['type'], 'image') === false) { 
        die ('Invalid file format. Accepted formats are JPG, JPEG and PNG');
    }

    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES['img']['name']);//Записване на директорията в низ 
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));//Преобразуване на низа в низ само с малки букви (за всеки случай)

    if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)){ //Преместване на качения файл в директория
        
        echo "<p class='text-center text-success'> Имотът беше добавен успешно! </p>";

    } else {
        echo "<p class='text-center text-danger'> Грешка в качването на файла!</p>";
    }

    $nameProperty = $_POST['name_property'];
    $street = $_POST['street'];
    $area = $_POST['ID_area'];
    $propertyType = $_POST['ID_property_type'];
    $price = $_POST['price'];
    $query = "INSERT INTO property (name_property, street, ID_area, ID_property_type, img, price) VALUES ('$nameProperty', '$street', '$area', '$propertyType', '$target_file', '$price')"; //Заявка за въвеждане на данните за имота в БД
    mysqli_query($con, $query); //Изпълняване на заявката
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
    <title>Добавяне на имот</title>
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
                <h2>Добави имот</h2>
            </div>
            
            <div class="col-4"></div>
        </div>
        
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4 text-center">
                <form action="addProperty.php" method="POST" enctype="multipart/form-data">
                    <br><br>
                    <label>Име на Имот: </label>
                    <input type="text" name="name_property" class="form-control" required> <br>
                    <label>Улица: </label>
                    <input type="text" name="street" class="form-control" required> <br>
                    <label>Район: </label>
                    <select name="ID_area" class="form-control" required>
                        <?php
                            $query = "SELECT ID_area, name FROM area"; //Заявка за получаване на райони
                            $resultArea = mysqli_query($con, $query); //Изпълняване на заявка
                            mysqli_fetch_all($resultArea); //Обработване на резултат

                            foreach ($resultArea as $resAr) { //Цикъл изпълняващ се за всеки резултат

                                echo "<option value='" . $resAr['ID_area'] . "'>" . $resAr['name'] . "</option>";

                            }
                        ?>
                    </select><br>

                    <label for="">Тип: </label>
                    <select name="ID_property_type" class="form-control" required>
                        <?php
                            $query = "SELECT * FROM property_type"; //Заявка за получаване на тип имот
                            $resultType = mysqli_query($con, $query); //Изпълняване на заявка
                            mysqli_fetch_all($resultType); //Обработване на резултат

                            foreach ($resultType as $resTy) { //Цикъл изпълняващ се за всеки резултат

                                echo "<option value='" . $resTy['ID_property_type'] . "'>" . $resTy['property_type'] . "</option>";

                            }
                        ?>
                    </select><br>

                    <label>Цена: </label>
                    <input type="text" name="price" class="form-control" required> <br>

                    <label>Снимка: </label>
                    <input type="file" name="img" class="form-control-file" accept="image/*" required> <br> <br>
                    <button type="submit" class="btn btn-primary">Добавяне на имота</button>
                </form>
            </div>
            <div class="col-4"></div>
        </div>
</body>

</html>