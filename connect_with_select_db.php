<?php

$link = mysqli_connect("localhost", "root", "", "contact_us");

if ($link === false) {
    die("Ошибка: Не можем подключиться. " . mysqli_connect_error());
} else {

echo "Connect Successfully. Host info: " . mysqli_get_host_info($link) . "<br>";
}
