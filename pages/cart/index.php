
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
      echo "<h1> Shopping Cart </h1>";

      $sql = "SELECT p.* FROM cart_item ci, product p WHERE p.id = ci.pid;";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        $sum = 0;
        while($item = mysqli_fetch_assoc($result)){
        echo "<p>" . $item['name'] . " " . $item['price'] . " kr </p>";
        echo "<a href='/bookworm/includes/removeFromCart.inc.php?id=" . $item['id'] . "' target='_blank'> <p> Remove </p></a>";
        //echo gettype($_SESSION["uid"]);
        //echo "<button onclick='testPrint()'>Click me</button>";
        $sum = $sum + $item['price'];
      }
      echo "<p> Total cost is: "  . $sum . " kr </p>";


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
