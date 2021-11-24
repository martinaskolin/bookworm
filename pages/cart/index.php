
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <?php require_once '../../includes/header.inc.php';
          require_once '../../includes/cart.inc.php';
          require_once '../../includes/dbh.inc.php';
          require_once '../../includes/functions.inc.php'; ?>

    <?php

    if (isset($_SESSION["id"])){
      //echo "<h1> Came to false statement </h1>";
      echo "<h1> Shopping Cart </h1>";
      $sql = "SELECT * FROM `cart_item`;";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
          echo "<p> Made it here </p> ";
        }
      }
      else {
        echo "<p> No items in your cart yet </p>";
      }

    }else {
            echo "<p> Please log in to see your cart </p>";

    }
    ?>

  </body>
  </html>
