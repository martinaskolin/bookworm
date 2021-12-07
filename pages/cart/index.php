<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <!-- Check for URL manipulation -->
    <?php
      if(!isset($_SERVER['HTTP_REFERER'])) {
        header('location: /bookworm/');
        exit();
      }
    ?>

    <?php include_once '../../includes/header.inc.php'; ?>

    <?php
      echo "<h1> Shopping Cart </h1>";

      $result = fetch_cart($conn, $_SESSION['uid']);

      if (mysqli_num_rows($result) > 0) {
        $sum = 0;
        while($item = mysqli_fetch_assoc($result)){
        echo "<p>" . $item['name'] . " " . $item['price'] . " kr </p>";
        echo "<a href='/bookworm/includes/removefromcart.inc.php?id=" . $item['id'] . "'> <p> Remove </p></a>";
        //echo gettype($_SESSION["uid"]);
        //echo "<button onclick='testPrint()'>Click me</button>";
        $sum = $sum + $item['price'];
      }
      echo "<p> Total cost is: "  . $sum . " kr </p>";


    }

      else {
        echo "<p> No items in your cart yet </p>";
      }

    ?>

  </body>
</html>
