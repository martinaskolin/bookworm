<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title></title>
  </head>
  <body>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/constants.inc.php'; ?>
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

      $result = fetch_products($conn, null);

      if ($result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {

          if (!$is_admin) {
            if ($product['stock'] == 0) {
              continue;
            }
          }  

          // Product dependent Variables
          $add_exist = ($product['img_dir'] != null); // Additional information exist for the product

          // Print product
          echo "<div>";
          if ($product['img_dir'] != null && file_exists($_SERVER['DOCUMENT_ROOT'] . $product['img_dir'])) {
             echo "<a href='/bookworm/pages/product/?id=". $product['id'] ."'><img src='" . $product['img_dir'] . "'></a>";
          }
          else { echo "<a href='/bookworm/pages/product/?id=". $product['id'] ."'><img src='" . $dir_defaultimg . "'></a>"; }
          echo "<li><a href='/bookworm/pages/product/?id=". $product['id'] ."'>" . $product['name'] . "</a></li>";

          if ($is_admin) { echo "<a class='button' href='/bookworm/pages/edit_item/index.php?id=" . $product['id'] . "'> Edit <i class='bi-pencil-square'></i> </a>"; } // Admin edit
          else { echo "<a class='button' href='/bookworm/includes/addtocart.inc.php?id=" . $product['id'] . "'> " . $product['price'] . " <i class='bi-bag-fill'></i> </a>"; } // Customer buy

          echo "</div>";

        }
      }

      else { echo "No match could be found"; }

      ?>
    </div>
  </body>
</html>
