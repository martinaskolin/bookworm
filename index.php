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

      // Product independent Variables
      // $is_signedin = isset($_SESSION["uid"]); (Defined in header.inc.php)
      // $is_admin = ($is_signedin && $user['admin'] == 1); (Defined in header.inc.php)
      $default_img = '/bookworm/resources/images/img_missing.jpg';

      $result = fetch_products($conn);

      if ($result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {

          // Product dependent Variables
          $add_exist = ($product['img_dir'] != null); // Additional information exist for the product

          // Print product
          echo "<div>";
          if ($add_exist) { echo "<img src='" . $product['img_dir'] . "'>"; } // Print Product Image
          else { echo "<img src='" . $default_img . "'>"; }                   // Print Default Image
          echo "<p>" . $product['name'] . "</p>";

          if ($is_admin) { echo "<a href='/bookworm/pages/edit/index.php?id=" . $product['id'] . "'> Edit <i class='bi-pencil-square'></i> </a>"; } // Admin edit
          else { echo "<a href='/bookworm/includes/addtocart.inc.php?id=" . $product['id'] . "'> " . $product['price'] . " <i class='bi-bag-fill'></i> </a>"; } // Customer buy

          echo "</div>";

        }
      }

      else { echo "No match could be found"; }

      ?>
    </div>
  </body>
</html>
