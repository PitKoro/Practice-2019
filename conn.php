<?php
  $host = 'localhost';  // Хост, у нас все локально
  $user = 'crm';    // Имя созданного вами пользователя
  $pass = '6QjgPjxQ'; // Установленный вами пароль пользователю
  $db_name = 'crm';   // Имя базы данных
  $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой

  // Ругаемся, если соединение установить не удалось
  if (!$link) {
    echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
    exit;
  }
?>