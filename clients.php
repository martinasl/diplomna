<?php
    session_start(); //Стартиране на сесия

    require_once 'db.php';

    if($_SESSION['logged'] !== 'client') { //Проверка дали има логнат клиент

        header('Location: login.php');

    }

    if (isset($_GET['ID_city'])) { //Проверка дали има подадена заявка за филтриране
        
        $filterCity = $_GET['ID_city'];
        $getAreaId = "SELECT ID_area FROM area WHERE ID_city = '$filterCity'";
        $resultQry = mysqli_fetch_all(mysqli_query($con, $getAreaId), MYSQLI_ASSOC); //Изпълняване нa заявка за получаване на всички ID_area

        $id_areas = '';

        foreach ($resultQry as $item) { //Минаване на масива през цикъл
            $id_areas .= "'" . $item['ID_area'] . "'" . ','; //Създаване на низ от резултати
        }

        //Премахване на последната запетая от резултатите
        $id_areas = rtrim($id_areas, ",");

        $query = mysqli_query($con, "SELECT name_property, street, ID_area, ID_property_type, img, price FROM property WHERE ID_area IN ($id_areas);"); //Изпълняване на заявка за получаване на имотите от определения район чрез $id_areas
    } else { //Ако няма подадена заявка за филтър

        $query = mysqli_query($con, "SELECT name_property, street, ID_area, ID_property_type, img, price FROM property;"); //Изпълняване на заявка за получаване на всички имоти
        
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
    <title>Обяви</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <?php
                    if (isset($_SESSION['logged'])) {
                        
                        echo "<a class='btn btn-outline-danger' href='logout.php'>Изход</a>";

                    }

                ?>
            </div>
            
            <div class="col">
                <h1 class="text-center">Обяви</h1>
            </div>

            <div class="col"></div>
        </div>

        <div class="row">
            <div class="col"></div>
            <div class="col">
                <form class="form-group" method="GET" action="clients.php">
                    <label>Град</label>
                    <select name="ID_city" class="form-control" required>
                        <?php
                            $cityQuery = "SELECT ID_city, name_city FROM city"; //Заявка за получаване на град
                            $result = mysqli_query($con, $cityQuery); //Изпълняване на заявка
                            mysqli_fetch_all($result); //Обработване на резултат

                            foreach ($result as $res) { //Цикъл изпълняващ се за всеки резултат
                                echo "<option value='" . $res['ID_city'] . "'>" . $res['name_city'] . "</option>";
                            }
                        ?>
                    </select>
                    
                    <button type="submit" class="btn btn-primary">Търсене</button>
                </form>
            </div>
            
        <div class="col"></div>
        </div>
        <div class="row">
            <?php
                if ($query !== false) { //Ако има имоти отговарящи на филтъра
                    
                    $i = 0;
                    while ($row = mysqli_fetch_array($query)) { //Цикъл за всеки имот

                        if($i/3 === 1) { //На всеки 3-ти имот
                        echo "<div class='w-100'></div>"; //Разделител, за да може да има по 3 имота на ред
                        $i=0;

                }
                echo
                " <div class='col my-3'>
                <div class='card' style='width: 18rem;'>
                <img class='card-img-top' src='{$row['img']}' alt='Card image cap'>
                <div class='card-body'>
                <h5 class='card-title'>{$row['name_property']}</h5>
                <p class='card-text'>
                Тип: " . mysqli_fetch_array(mysqli_query($con, "SELECT property_type FROM property_type WHERE ID_property_type = '{$row['ID_property_type']}';"))[0] . " <br>Град: ";
                $area = mysqli_fetch_array(mysqli_query($con, "SELECT name FROM area WHERE ID_area = '{$row['ID_area']}';"))[0];
                $idCity = mysqli_fetch_array(mysqli_query($con, "SELECT ID_city FROM area WHERE ID_area = '{$row['ID_area']}';"))[0];
                $city = mysqli_fetch_array(mysqli_query($con, "SELECT name_city from city WHERE ID_city = '{$idCity}';"))[0];
                $area = mysqli_fetch_array(mysqli_query($con, "SELECT name FROM area WHERE ID_area = '{$row['ID_area']}';"))[0];
                echo " $city
                <br>
                Район: $area
                <br>
                Улица: {$row['street']}
                <br>
                Цена: {$row['price']}
                </p>
                </div>
                </div>
                </div>
                ";
                $i++;
                }
                } else { //Ако няма имоти отговарящи на филтъра

                    echo "<b class='text-danger text-center'>Няма имоти в избрания град</b>";

                }
            ?>
        </div>
    </div>
</body>

</html>