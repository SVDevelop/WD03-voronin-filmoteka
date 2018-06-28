<?php 

$connect = mysqli_connect('localhost', 'root', 'onqDorUOebDa', 'WD03-voronin-filmoteka');

if (mysqli_connect_error()) {
  die("Ошибка подключения");
}

$errors = array();
$success = false;
$info = '';
$film = array();


if (array_key_exists('add', $_POST)) {
  if ($_POST['title'] == '') {
    $errors[] = "Не введено навзание фильма";
  }
  else if ($_POST['genre'] == '') {
    $errors[] = "Не введен жанр фильма";
  }
  else if ($_POST['year'] == '') {
    $errors[] = "Не указан год создания фильма";
  }
  else {

    $query = "INSERT INTO `films` (`title`, `genre`, `year`) VALUES (
   '" . mysqli_real_escape_string($connect, $_POST['title']) ."', 
   '" . mysqli_real_escape_string($connect, $_POST['genre']) ."', 
   '" . mysqli_real_escape_string($connect, $_POST['year']) ."'
     )";

    if(mysqli_query($connect, $query)) {
      $success = true;
//перенаправление на главную после добавления
    if (!empty($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: index.php");
    }
    exit;
//=========================================
    }
    else {
      echo "<p>Ошибка. Фильм не был добавлен в базу.</p>";
    }
  }
}


$queryAll = "SELECT * FROM `films` WHERE `id` = ' " . mysqli_real_escape_string($connect, $_GET['id']) . "' LIMIT 1";
$result = mysqli_query($connect, $queryAll);

if ($result) {
          $film[] = mysqli_fetch_array($result);
      }

?>