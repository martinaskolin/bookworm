<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/constants.inc.php'; ?>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/functions.inc.php'; ?>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/header.inc.php'; ?>

    <?php

      // Variables
      $id = htmlspecialchars($_GET['id']);
      $result = fetch_products($conn, $id);

      if ($product = $result->fetch_assoc()) {

        echo "<div class='product-container'>";

          // Product Image
          if ($product['img_dir'] != null && file_exists($_SERVER['DOCUMENT_ROOT'] . $product['img_dir'])) { echo "<img src='" . $product['img_dir'] . "'>"; }
          else { echo "<img src='" . $dir_defaultimg . "'>";}

          // Product Info
          echo "<div id='info'>";

            echo "<ul>";
              echo "<li class='name'>". $product['name'] ."</li>";
              echo "<li class='author'>". $product['author'] ."</li>";
            echo "</ul>";

            echo "<ul class='overflow'>";
              if ($product['des_dir'] != null && file_exists($_SERVER['DOCUMENT_ROOT'] . $product['des_dir'])) {
                $description = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $product['des_dir']);
                echo "<li>". $description ."</li>";
              }
              else {
                echo "<li>No description avalible.</li>";
              }
              echo "<p>ISBN: ". $product['ISBN'] ."</p>";
              echo "<p>Stock: ". $product['stock'] ."</p>";
            echo "</ul>";

          echo "</div>";

          // Product buttons
          echo "<div id='btns'>";
            echo "<a href='/bookworm/includes/addtocart.inc.php?id=" . $product['id'] . "' target='_blank'> ". $product['price'] ." <i class='bi-bag-fill'></i> </a>";
          echo "</div>";

          // Reviews
          echo "<div class='review-container'>";
            $result = fetch_reviews($conn, $product['id']);

            while ($review = $result->fetch_assoc()) {
              echo "<div class='review'>";
                // Rating
                echo "<h3>Rating: ". $review['rating'] ."</h3>";
                // Description
                if ($review['des_dir'] != null && file_exists($_SERVER['DOCUMENT_ROOT'] . $review['des_dir'])) {
                  $description = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $review['des_dir']);
                  echo $description;
                }
              echo "</div>";
            }
          echo "</div>";


        echo "</div>";

        echo "</div>";
      }

     ?>

  </body>
</html>
