<?php
//Соединение с БД
$servername = "localhost";
$username = "root";
$db_password = "";
$db = 'contact_us';

//проверка соединения
$mysqli = mysqli_connect($servername, $username, $db_password, $db);
if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}
//Определение mode
$mode = isset($_REQUEST['mode']) ? $_REQUEST['mode'] : false;
//режим Авторизации
if ($mode==='auth') { 
  //Проверка пароля админа
  if (trim($_REQUEST['password'] === 'admin')) {
    $mode='admin';
    //Если пройдена авторизация, то подгружаем пагинацию
    require "paginator.php";;
    //Иначе - повторная авторизация
  } else require 'auth.html';
// режим Админа
} else if ($mode==='admin')
  {require "paginator.php";
  exit;
    
//Сбор заполненных форм при срабатывании кнопки submit
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_REQUEST['first_name']);
    $last_name = trim($_REQUEST['last_name']);
    $email = trim($_REQUEST['email']);
    $client = trim($_REQUEST['client']);
    $advice = trim($_REQUEST['advice']);
    $comm_user = trim($_REQUEST['comm_user']);
    $upload = '<a href="'.'http://localhost/contact_us/files/'.$_FILES['file']['name'].'">Ссылка</a>';
      //Сохранение в базу данных. Аллерты загрузки и отправки
      if (!isset($_FILES['file']['name'])) {
        $success = $mysqli->query("INSERT INTO contact (first_name, last_name, email, client, advice, comm_user, upload) VALUES ('$first_name', '$last_name', '$email', '$client', '$advice', '$comm_user', '&#8595;&#8595;&#8595;')");
      } else { 
        $download = $mysqli->query("INSERT INTO contact (first_name, last_name, email, client, advice, comm_user, upload) VALUES ('$first_name', '$last_name', '$email', '$client', '$advice', '$comm_user', '$upload')");}
    
    //Почта
    //Обработка, фильтрация и преобразование данных из HTML форм для письма
      $first_name = trim(urldecode(htmlspecialchars($_POST['first_name'])));
      $last_name = trim(urldecode(htmlspecialchars($_POST['last_name'])));
      $email = trim(urldecode(htmlspecialchars($_POST['email'])));
      $client = trim(urldecode(htmlspecialchars($_POST['client'])));
      $advice = trim(urldecode(htmlspecialchars($_POST['advice'])));
      $comm_user = trim(urldecode(htmlspecialchars($_POST['comm_user'])));
      $upload = trim('http://localhost/contact_us/files/'.$_FILES['file']['name']);

      //Письмо админу
        $to="testadmtestov@gmail.com";
        $subject="Обратная связь";
        $message=("Имя:". $first_name . " Фамилия:" . $last_name . " Email:" . $email . " Клиент:" . $client . " Рекомендация:" . $advice . " Комментарий:" . $comm_user . " Файл:" .  $upload);
        
        $mail = mail($to, $subject, $message);
      
        

    require 'index.html';

} else require 'index.html';