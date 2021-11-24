<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/functions.inc.php'; ?>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/header.inc.php'; ?>

    <!-- ~~~~~~~~~~~~~~~ Search Container ~~~~~~~~~~~~~~~ -->
    <!--<div class="">
      <input type="text" name="search" placeholder="Search...">
    </div>-->

    <!-- ~~~~~~~~~~~~~~~ Product Container ~~~~~~~~~~~~~~~ -->
    <div class="product-container">
      <?php displayProducts($conn); ?>
    </div>

    <div class = "products">
      <h1> Products </h1>
      <?php
      $sql = "SELECT * FROM `product`;";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
          echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["price"]. "<br>";
        }
      }
      ?>
    </div>

  </body>
</html>
