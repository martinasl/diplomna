<?php

$con=mysqli_connect("localhost:8111", "root", "") or die (mysqli_error ());// Свързване към БД
mysqli_select_db($con,"diplomna") or die(mysqli_error());// Избиране на БД