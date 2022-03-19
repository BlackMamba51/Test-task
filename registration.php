<?php require __DIR__ . '/header.php' ?>

<?php
  
  if(isset($_POST['do_registration'])) {
    $fileName = 'data.json';
    $dataFile = file($fileName);
    $errorsArray = array();
    if(trim($_POST['login']) === '') {
      $textlogin = '<div style="color: red">Введите логин</div>';
      array_push($errorsArray, 'Введите логин');
    }
    if(trim($_POST['password']) === '') {
      $textPassword = '<div style="color: red">Введите пароль</div>';
      array_push($errorsArray, 'Введите пароль');
    }
    if(trim($_POST['confirm-password']) === '') {
      $textConfirmPassword = '<div style="color: red">Введите пароль еще раз</div>';
      array_push($errorsArray, 'Подтвердите пароль');
    }
    if(trim($_POST['email']) === '') {
      $textEmail = '<div style="color: red">Введите почту</div>';
      array_push($errorsArray, 'Введите почту');
    }
    if(trim($_POST['name']) === '') {
      $textName = '<div style="color: red">Введите имя</div>';
      array_push($errorsArray, 'Введите имя');
    }
    if(!preg_match('/^[a-zA-Z]+$/', $_POST['password']) && !preg_match("/^([0-9])+$/", $_POST['password'])) {
      $textValidatePassword = '<div style="color: red">Пароль должен состоять из букв и цифр, и минимум 6 символов</div>';
      array_push($errorsArray, 'Пароль должен состоять из букв и цифр, и минимум 6 символов');
    }
    if(mb_strlen($_POST['password']) < 6) {
      $textValidatePassword = '<div style="color: red">Пароль должен состоять из букв и цифр, и минимум 6 символов</div>';
      array_push($errorsArray, 'Пароль должен состоять из букв и цифр, и минимум 6 символов');
    }
    if($_POST['password'] !== $_POST['confirm-password']) {
      $textWrongPassword = '<div style="color: red">Пароли не совпадают</div>';
      array_push($errorsArray, 'Пароли не совпадают');
    }
    if(mb_strlen($_POST['login']) < 6) {
      $textValidateLogin = '<div style="color: red">Недопустимая длина логина(минимум 6 символов)</div>';
      array_push($errorsArray, 'Недопустимая длина логина');
    }
    if(!preg_match('/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i', $_POST['email'])) {
      $textValidateEmail = '<div style="color: red">Неверно введен e-mail</div>';
      array_push($errorsArray, 'Неверно введен e-mail');
    }
    if(empty($errorsArray)) {
      $isLoginExist = false;
      $isEmailExist = false;
      $loginNumber = 0;
      $array = array(
          'login' => $_POST['login'],
          'password' => $_POST['password'],
          'email' => $_POST['email'],
          'name' => $_POST['name']);

      if(empty($dataFile)) {
        $json = [];
        array_push($json, $array);
        $jsonString = json_encode($json);
        file_put_contents($fileName, $jsonString);
      } else {
        $json = json_decode(file_get_contents($fileName), TRUE);
        $dataArray = array();
        foreach($dataFile as $line) {

          $info = explode('}', $line);
          $infoUser = explode(',', implode($info));
          
          foreach($info as $count) {
            $dataArray['login'] = $infoUser[$loginNumber];  
            $dataArray['email'] = $infoUser[$loginNumber + 2]; 
            if(in_array("\"{$_POST['login']}\"", explode(':', $dataArray['login']))) {
              $isLoginExist = true;
            }
            if(in_array("\"{$_POST['email']}\"", explode(':', $dataArray['email']))) {
              $isEmailExist = true;
             
            }
            $loginNumber++;
            
          }
        }
        if($isLoginExist) {
          echo '<div style="color: red">Пользователь уже существует</div>';
        } elseif($isEmailExist) {
          echo '<div style="color: red">Пользователь с такой почтой уже существует</div>';
        } else {
          echo '<a href="authorization.php">Можете авторизоваться</a>';
          array_push($json, $array);
          $jsonString = json_encode($json);
          file_put_contents($fileName, $jsonString);
        }
      }
      
     
      
   


      // $array = array(
      //   'login' => $_POST['login'],
      //   'password' => $_POST['password'],
      //   'email' => $_POST['email'],
      //   'name' => $_POST['name']);
      // if(in_array($array['login'], array_values($json))) {
      //   echo '<div style="color: red">Пользователь уже существует</div>';
      // } else {
      //   array_push($json, $array);        
      // }
      // echo (in_array($array['login'], array_values($json)));
      // $jsonString = json_encode($json);
      // file_put_contents($dataFile, $jsonString);
    }

  

  } 
  

?>


<div class="form">
  <h2>Регистрация</h2>
  <div class="circle"><span style="display: block; margin-left: 10px; color: red">Обязательно</span></div>
  <form class="class-form" action="registration.php" method="post">
        <label>
          Логин
          <?php
          if(isset($_POST['do_registration'])) {
            if(trim($_POST['login']) === '') {
              echo $textlogin;
            } elseif(mb_strlen($_POST['login']) < 6) {
              echo $textValidateLogin;
            }
          } ?>
          <input id="login" type="text" name="login" placeholder="Your login" class="input-line">
        </label>
        <label>
          Пароль
          <?php
          if(isset($_POST['do_registration'])) {
            if(trim($_POST['password']) === '') {
              echo $textPassword;
            } elseif( !preg_match('/^[a-zA-Z]+$/', $_POST['password']) && !preg_match("/^([0-9])+$/", $_POST['password'])) {
              echo $textValidatePassword;
            } elseif(mb_strlen($_POST['password']) < 6) {
              echo $textValidatePassword;
            }
          } ?>
          <input type="password" name="password" placeholder="Your password" class="input-line">
        </label>
        <label>
          Подтверждение пароля
          <?php
          if(isset($_POST['do_registration'])) {
            if(trim($_POST['confirm-password']) === '') {
              echo $textConfirmPassword;
            } elseif($_POST['password'] !== $_POST['confirm-password']) {
              echo $textWrongPassword;
            }
          } ?>
          <input type="password" name="confirm-password" placeholder="Confirm password" class="input-line">
        </label>
        <label>
          Почта
          <?php
          if(isset($_POST['do_registration'])) {
            if(trim($_POST['email']) === '') {
              echo $textEmail;
            } elseif(!preg_match('/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i', $_POST['email'])) {
              echo $textValidateEmail;
            }
          } ?>
          <input type="text" name="email" placeholder="Your email" class="input-line" >
        </label>
        <label>
          Имя
          <?php
          if(isset($_POST['do_registration'])) {
            if(trim($_POST['name']) === '') {
              echo $textName;
            }
          } ?>
          <input type="text" name="name" placeholder="Your name" class="input-line" >
        </label>
          <input type="submit" name="do_registration" class="button-sumbit" value="Регистрация">
      </form>
</div>
    
<?php require __DIR__ . '/footer.php' ?>

