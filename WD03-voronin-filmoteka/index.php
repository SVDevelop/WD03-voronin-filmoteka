<?php 

$connect = mysqli_connect('localhost', 'root', 'onqDorUOebDa', 'WD03-voronin-filmoteka');

if (mysqli_connect_error()) {
  die("Ошибка подключения");
}

$errors = array();
$success = false;
$info = '';

if ($_GET) {
  if ($_GET['action'] == 'delete') {
    $query = "DELETE FROM `films` WHERE `id` = ' " . mysqli_real_escape_string($connect, $_GET['id']) . "' LIMIT 1 ";

    mysqli_query($connect, $query);

    if (@mysqli_affected_rows($connect) > 0) {
      $info = "Фильм успешно удален";
    }
    // else {
    //   $info = "Ошибка удаления фильма";
    // }
  }
}

// if (array_key_exists('add', $_POST)) {
//   if ($_POST['title'] == '') {
//     $errors[] = "Не введено навзание фильма";
//   }
//   else if ($_POST['genre'] == '') {
//     $errors[] = "Не введен жанр фильма";
//   }
//   else if ($_POST['year'] == '') {
//     $errors[] = "Не указан год создания фильма";
//   }
//   else {

//     $query = "INSERT INTO `films` (`title`, `genre`, `year`) VALUES (
//    '" . mysqli_real_escape_string($connect, $_POST['title']) ."', 
//    '" . mysqli_real_escape_string($connect, $_POST['genre']) ."', 
//    '" . mysqli_real_escape_string($connect, $_POST['year']) ."'
//      )";

//     if(mysqli_query($connect, $query)) {
//       $success = true;
//     }
//     else {
//       echo "<p>Ошибка. Фильм не был добавлен в базу.</p>";
//     }
//   }
// }

$queryAll = "SELECT * FROM `films`";
$result = mysqli_query($connect, $queryAll);
$films = array();

if ($result) {
        while ($row = mysqli_fetch_array($result)) {
          $films[] = $row;
        }
      }

?>


<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8"/>
    <title>UI-kit и HTML фреймворк - Документация</title>
    <!--[if IE]>
      <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <![endif]-->
    <meta title="viewport" content="width=device-width,initial-scale=1"/>
    <meta title="keywords" content=""/>
    <meta title="description" content=""/><!-- build:cssVendor css/vendor.css -->
    <link rel="stylesheet" href="libs/normalize-css/normalize.css"/>
    <link rel="stylesheet" href="libs/bootstrap-4-grid/grid.min.css"/>
    <link rel="stylesheet" href="libs/jquery-custom-scrollbar/jquery.custom-scrollbar.css"/><!-- endbuild -->
<!-- build:cssCustom css/main.css -->
    <link rel="stylesheet" href="./css/main.css"/><!-- endbuild -->
    <link rel="stylesheet" href="./css/custom.css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800&amp;subset=cyrillic-ext" rel="stylesheet">
<!--[if lt IE 9]>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script><![endif]-->
  </head>
  <body>
    <div class="container user-content pt-35">
      <h1 class="title-1"> Фильмотека</h1>
      <?php 

        if ($info != '') {
          ?>
          <div class="notification"><?php echo $info?></div>
          <?php
        }

        if ($success == true) {
          ?>
          <div class="success">Фильм был успешно добавлен в базу!</div>
          <?php
        }
        foreach ($films as $key => $value) {
        ?>
        <div class="card mb-20">
          <div class="card__header">
            <h4 class="title-4"><?php echo $films[$key]['title'];?></h4>
            <div class="button-block">
              <a href="edit.php?id=<?php echo $films[$key]['id'];?>" class="button button--edit">Редактировать</a>
              <a href="?action=delete&id=<?php echo $films[$key]['id'];?>" class="button button--delete">Удалить</a>
            </div>
          </div>
          <div class="badge"><?php echo $films[$key]['genre'];?></div>
          <div class="badge"><?php echo $films[$key]['year'];?></div>
        </div>
        <?php  
          }  
        ?>
      <div class="panel-holder mt-80 mb-40">
        <div class="title-4 mt-0">Добавить фильм</div>
        <form action="add.php" method="POST">
          <?php  
            for ($index = 0; $index < count($errors); $index++) {
              echo '<div class="error">'.$errors[$index].'</div>';
            }
            
          ?>
          <!-- <div class="error hidden">Название фильма не может быть пустым.</div> -->
          <label class="label-title">Название фильма</label>
          <input class="input" type="text" placeholder="Такси 2" name="title" value="<?=@$title ?>" />
          <div class="row">
            <div class="col">
              <label class="label-title">Жанр</label>
              <input class="input" type="text" placeholder="комедия" name="genre" value="<?=@$genre ?>" />
            </div>
            <div class="col">
              <label class="label-title">Год</label>
              <input class="input" type="text" placeholder="2000" name="year" value="<?=@$year ?>" />
            </div>
          </div>
          <input type="submit" class="button" href="regular" value="Добавить" name="add">
          <!-- </div><a class="button" href="regular">Добавить	</a> -->
        </form>
      </div>
    </div><!-- build:jsLibs js/libs.js -->
    <script src="libs/jquery/jquery.min.js"></script><!-- endbuild -->
<!-- build:jsVendor js/vendor.js -->
    <script src="libs/jquery-custom-scrollbar/jquery.custom-scrollbar.js"></script><!-- endbuild -->
<!-- build:jsMain js/main.js -->
    <script src="js/main.js"></script><!-- endbuild -->
    <script defer="defer" src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  </body>
</html>