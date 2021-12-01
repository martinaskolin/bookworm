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
      <?php

      $result = fetch_products($conn);

      if ($result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {

          echo "<div>";
          if ($product['img_dir'] != null) { echo "<img src='" . $product['img_dir'] . "'>"; } // Img exist
          else { echo "<img src='/bookworm/resources/images/img_missing.jpg'>"; } // Img doesnt exist
          echo "<p>" . $product['name'] . "</p>";

          if ($userArr['admin'] == 0) {
            echo "<a href='/bookworm/includes/addtocart.inc.php?id=" . $product['id'] . "' target='_blank'> " . $product['price'] . " <i class='bi-bag-fill'></i> </a>";
          }
          else {
            echo "<a href='/bookworm/pages/edit/index.php?id=" . $product['id'] . "'> Edit <i class='bi-pencil-square'></i> </a>";
          }
          echo "</div>";

        }
      }

      else { echo "No match could be found"; }

      ?>
    </div>

  </body>
</html>
