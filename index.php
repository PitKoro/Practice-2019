<!doctype html>
	<html lang="ru">
	<head>
  		<title>admin</title>
	</head>
	<body>
  <?php
    $host = 'localhost';  // Хост
    $user = 'crm';    // Имя пользователя
    $pass = '6QjgPjxQ'; // Установленный вами пароль пользователю
    $db_name = 'crm';   // Имя базы данных
    $link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой

    echo "<meta charset=\"utf8\">";
    header('Content-Type: text/html; charset = utf-8');
   
    mysqli_query($link, 'SET NAMES utf8');


    // Ругаемся, если соединение установить не удалось
    if (!$link) {
      echo 'Can not connect with DB. : code of mistake' . mysqli_connect_errno() . ', mistake: ' . mysqli_connect_error();
      exit;
    }

    //Если переменная name передана
    if (isset($_POST["name"])) {
      //Если это запрос на обновление, то обновляем
      if (isset($_GET['red'])) {
        $ifActive = $_POST['ifActive'] == 'true' ? 1 : 0;
        $sql = mysqli_query($link, "UPDATE `Privileges` SET `name` = '{$_POST['name']}',`description` = '{$_POST['description']}', `ifActive` = {$ifActive} WHERE `id`={$_GET['red']}");

      } else {
        //Иначе вставляем данные, подставляя их в запрос
        $sql = mysqli_query($link, "INSERT INTO `Privileges` (`name`, `description`, `ifActive`) VALUES ('{$_POST['name']}', '{$_POST['description']}', '{$_POST['ifActive']}')");
      }

      //Если вставка прошла успешно
      if ($sql) {
        echo '<p>Успешно!</p>';
      } else {
        echo '<p> Ошибка: ' . mysqli_error($link) . '</p>';
      }
    }

    //Удаляем, если что
    if (isset($_GET['del'])) {
      $sql = mysqli_query($link, "DELETE FROM `Privileges` WHERE `id` = {$_GET['del']}");
      if ($sql) {
        echo "<p>Не существует</p>";
      } else {
        echo '<p>Ошибка: ' . mysqli_error($link) . '</p>';
      }
    }

    //Если передана переменная red, то надо обновлять данные. Для начала достанем их из БД
    if (isset($_GET['red'])) {
      $sql = mysqli_query($link, "SELECT `id`, `name`, `description`, `ifActive`  FROM `Privileges` WHERE `id`={$_GET['red']}");
      $product = mysqli_fetch_array($sql);
    }

  ?>

  
  <?php
  //Получаем данные
  $sql = mysqli_query($link, 'SELECT `id`, `name`, `description`, `ifActive` FROM `Privileges`');
  echo '<h2>Таблица учета привилегий пользователей</h2>';
  echo '<table border="2">';
    while($result = mysqli_fetch_array($sql))#функция вывода таблицы 
    {
      echo "<tr>
     <td> {$result['name']} </td> <td> {$result['description']}</td> <td> {$result['ifActive']}</td>
     <td> <a href='?del={$result['id']}'> Delete</a></td> 
     <td><a href='?red={$result['id']}'>Edit</a> </td>";
    }
    echo "</TABLE>";

    echo "<p></p> <p>Добавить(Изменить) запись</p>";

  // while ($result = mysqli_fetch_array($sql)) {
  //   echo "<p>{$result['id']}) {$result['name']} - {$result['description']}  - {$result['addres']} -
  //   <a href='?del={$result['id']}'> Delete
  //   </a> - <a href='?red={$result['id']}'>Edit</a></p>";
  // }
  ?>

  <p></p>
  <form action="" method="post">
    <table>
      <tr>
        <td>Привилегия:</td>
        <td><input type="text" name="name" value="<?= isset($_GET['red']) ? $product['name'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>Примечание:</td>
        <td><input type="text" name="description" value="<?= isset($_GET['red']) ? $product['description'] : ''; ?>"></td>
      </tr>
      <tr>
        <td>Активность:</td>
        <td>
          <select name = "ifActive">
            <option><? if(isset($_GET['red'])) {echo $product['ifActive'] == 1 ? 'true' : 'false';} ?> </option>
            <option><? if(isset($_GET['red'])) {echo $product['ifActive'] == 1 ? 'false' : 'true';} ?> </option>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="OK"></td>
      </tr>
    </table>
  </form>
  <p><a href="?add=new">Добавить новую запись</a></p>

  <?echo $_GET['red']."<br>";
  echo $product['ifActive'];?>
</body>
</html>
