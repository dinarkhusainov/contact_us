<?php

// Устанавливаем число сообщений выводимых на станице
$num = 10;
// Извлекаем из URL текущую страницу методом Гет
$page = $_GET['page'];
// Определяем общее число сообщений в базе данных
$result = $mysqli->query("SELECT count(id) FROM contact");  
$post = mysqli_fetch_row($result);
$posts=current($post);

// Общее число страниц
$total = intval(($posts - 1) / $num) + 1;

// Начало сообщений для текущей страницы
$page = intval($page);

  if(empty($page) or $page < 0) $page = 1;
  if($page > $total) $page = $total;

// Начало сообщений
$start = $page * $num - $num;

$result = $mysqli->query("SELECT * FROM contact LIMIT $start, $num");
  while ( $postrow[] = mysqli_fetch_array($result))
    // стрелки назад
    if ($page != 1) $pervpage = '<a href= ./index.php?mode=admin&page=1><<</a>
      <a href= ./index.php?mode=admin&page='. ($page - 1) .'><</a> ';
    // стрелки вперед
    if ($page != $total) $nextpage = ' <a href= ./index.php?mode=admin&page='. ($page + 1) .'>></a>
      <a href= ./index.php?mode=admin&page=' .$total. '>>></a>';

    // определяем две  станицы с краев, если они есть
    if($page - 2 > 0) $page2left = ' <a href= ./index.php?mode=admin&page='. ($page - 2) .'>'. ($page - 2) .'</a> | ';
    if($page - 1 > 0) $page1left = '<a href= ./index.php?mode=admin&page='. ($page - 1) .'>'. ($page - 1) .'</a> | ';
    if($page + 2 <= $total) $page2right = ' | <a href= ./index.php?mode=admin&page='. ($page + 2) .'>'. ($page + 2) .'</a>';
    if($page + 1 <= $total) $page1right = ' | <a href= ./index.php?mode=admin&page='. ($page + 1) .'>'. ($page + 1) .'</a>';

// Вывод пагинации
echo $pervpage.$page2left.$page1left.'<b>'.$page.'</b>'.$page1right.$page2right.$nextpage;

//Подключаем форму
require 'admin.html';

?> 