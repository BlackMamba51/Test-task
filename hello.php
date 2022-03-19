<?php require __DIR__ . '/header.php' ?>

<?php 

$login = '';  
$fileName = 'data.json';
$dataFile = file($fileName);
$json = json_decode(file_get_contents($fileName), TRUE);
foreach($dataFile as $line) {

  $info = explode('}', $line);
  $infoUser = explode(',', implode($info));

    foreach($infoUser as $count) {
      $login = $infoUser[count($infoUser) - 2];  
      
      
     
    }
}
if(isset($_POST['logout'])) {
  print_r('dsad');
  array_pop($json);
  $jsonString = json_encode($json);
  file_put_contents($fileName, $jsonString);
  header("Location: http://localhost/maneodev/authorization.php");
}

echo '<div style="font-size: 26px">Hello, </div>' . explode('":"',$login)[1];

?>
<form class="logout-button" action="hello.php" method="post">
  <input class="button-sumbit" name="logout" type="submit" value="Выйти"> 
</form>


<?php require __DIR__ . '/footer.php' ?>