
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

    if (isset($_SESSION["uid"])){
      //echo "<h1> Came to false statement </h1>";
      echo "<h1> Shopping Cart </h1>";
      $sql = "SELECT p.* FROM cart_item ci, product p WHERE p.id = ci.pid;";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
        echo "<p> Product id is: " . $row['id'] . " product name is " . $row['name'] . " </p>";
        //echo "<a href='/bookworm/includes/addtocart.inc.php?id=" . $row['price'] . " <i class='bi-bag-fill'></i>";
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
