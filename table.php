<?php
  include('./conn.php');
  $sql = mysqli_query($link, 'SELECT `id`, `name`, `description` FROM `Privileges`');
  while ($result = mysqli_fetch_array($sql)) {
    echo "{$result['name']}, {$result['description']}<br>";
  }
?>