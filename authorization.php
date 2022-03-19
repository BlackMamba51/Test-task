<?php require __DIR__ . '/header.php' ?>



<?php

if(isset($_POST['do_authorization'])) {
  $fileName = 'data.json';
  $dataFile = file($fileName);
  $loginNumber = 0;
  $isAuthorized = false;
  $authorizationArray = array(
    'authorizationLogin' => $_POST['login'],
    'authorizationPassword' => $_POST['password'],
  );
  $json = json_decode(file_get_contents($fileName), TRUE);
    $dataArray = array();
    foreach($dataFile as $line) {

      $info = explode('}', $line);
      $infoUser = explode(',', implode($info));
    
        foreach($infoUser as $count) {
          $dataArray['login'] = $infoUser[$loginNumber];  
          $dataArray['password'] = $infoUser[$loginNumber + 1];  
           
          if("\"{$_POST['login']}\"" === explode(':', $dataArray['login'])[1] && "\"{$_POST['password']}\"" === explode(':', $dataArray['password'])[1]) {
            header("Location: http://localhost/maneodev/hello.php");
            $isAuthorized = true;
          } else {
            $loginNumber++;
          }
         
          
            
        }
        if($isAuthorized) {
          array_push($json, $authorizationArray);
          $jsonString = json_encode($json);
          file_put_contents($fileName, $jsonString);
        } else {
          echo 'Неправильный логин или пароль';
        }
    }
}

?>


  <div class="form">
    <h2>Авторизация</h2>

    <form class="class-form" action="authorization.php" method="post">
      <label>
        Логин
        <input id="login" type="text" name="login" placeholder="Your login" class="input-line">
      </label>
      <label>
        Пароль
        <input type="password" name="password" placeholder="Your password" class="input-line">
      </label>
      <input type="submit" name="do_authorization" class="button-sumbit" value="Авторизоваться">
    </form>
    <a href="registration.php">Если вы еще незарегистированы</a>
  </div>


<?php require __DIR__ . '/footer.php' ?>