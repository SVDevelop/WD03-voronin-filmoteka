<?php 

$connect = mysqli_connect('localhost', 'root', 'onqDorUOebDa', 'WD03-voronin-filmoteka');

if (mysqli_connect_error()) {
  die("Ошибка подключения");
}

$errors = array();
$success = false;
$info = '';
$film = array();

if (array_key_exists('update', $_POST)) {
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
    $query = "UPDATE `films` SET 
    `title` = '" . mysqli_real_escape_string($connect, $_POST['title']) ."', 
    `genre` = '" . mysqli_real_escape_string($connect, $_POST['genre']) ."', 
    `year` = '" . mysqli_real_escape_string($connect, $_POST['year']) ."' 
    WHERE `id` =  ".mysqli_real_escape_string($connect, $_GET['id'])." LIMIT 1";
  }

  if(mysqli_query($connect, $query)) {
    $success = true;
  }
  else {
    $success = false;
  }
}

$queryAll = "SELECT * FROM `films` WHERE `id` = ' " . mysqli_real_escape_string($connect, $_GET['id']) . "' LIMIT 1";
$result = mysqli_query($connect, $queryAll);

if ($result) {
          $film[] = mysqli_fetch_array($result);
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
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/><!-- build:cssVendor css/vendor.css -->
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
      <h1 class="title-1">Фильм <?=$film[0]['name']?></h1>
      <?php 

        if ($info != '') {
          ?>
          <div class="notification"><?php echo $info?></div>
          <?php
        }

        if ($success == true) {
          ?>
            <div class="success">Информация о фильме успешно обновлена!</div>
          <?php
        }
        ?>
      <div class="panel-holder mb-20">
        <div class="title-4 mt-0">Редактировать данные о фильме</div>
        <form action="edit.php?id=<?=$film[0]['id']?>" method="POST">
          <?php  
            for ($index = 0; $index < count($errors); $index++) {
              echo '<div class="error">'.$errors[$index].'</div>';
            }
            
          ?>
          <!-- <div class="error hidden">Название фильма не может быть пустым.</div> -->
          <label class="label-title">Название фильма</label>
          <input class="input" type="text" placeholder="Такси 2" name="title" value="<?=$film[0]['title']?>" />
          <div class="row">
            <div class="col">
              <label class="label-title">Жанр</label>
              <input class="input" type="text" placeholder="комедия" name="genre" value="<?=$film[0]['genre']?>" />
            </div>
            <div class="col">
              <label class="label-title">Год</label>
              <input class="input" type="text" placeholder="2000" name="year" value="<?=$film[0]['year']?>" />
            </div>
          </div>
          <input type="submit" class="button pb-20" href="regular" value="Сохранить изменения" name="update">
          <!-- </div><a class="button" href="regular">Добавить	</a> -->
        </form>
      </div>
      <a href="index.php" class="button">Вернуться на главную</a>
    </div><!-- build:jsLibs js/libs.js -->
    <script src="libs/jquery/jquery.min.js"></script><!-- endbuild -->
<!-- build:jsVendor js/vendor.js -->
    <script src="libs/jquery-custom-scrollbar/jquery.custom-scrollbar.js"></script><!-- endbuild -->
<!-- build:jsMain js/main.js -->
    <script src="js/main.js"></script><!-- endbuild -->
    <script defer="defer" src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  </body>
</html>