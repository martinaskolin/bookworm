<?php
  include_once 'includes/dbh.inc.php'
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="resources/css/style.css">
    <title></title>
  </head>
  <body>
    <h1>hello world!</h1>
    <?php
      $sql = "SELECT * FROM users";
      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result);

      if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)){
          foreach ($row as $col) {
            echo $col, " ";
          }
          echo "<br>";
        }
      }
    ?>
    <!--<img src="resources/images/9781631490330.jpg" alt="Crime and Punishment">!-->
  </body>
</html>
