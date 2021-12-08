<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/functions.inc.php'; ?>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/header.inc.php'; ?>

    <?php

      $default_img = '/bookworm/resources/images/img_missing.jpg';
      $id = htmlspecialchars($_GET['id']);
      $result = fetch_products($conn, $id);

      if ($product = $result->fetch_assoc()) {
        $add_exist = $product['img_dir'] != null;

        // Image
        echo "<div class='grid-container'>";
        if ($add_exist) { echo "<img src='" . $product['img_dir'] . "'>"; } // Print Product Image
        else { echo "<img src='" . $default_img . "'>"; }                   // Print Default Image

        // Title, author, description
        echo "<div>";
        echo "<h1>". $product['name'] ."</h1>";
        echo "<h3>". $product['author'] ."</h3>";
        if ($add_exist) { echo "<p> ". $product['des_dir'] ." </p>"; }
        else {echo "<p>No description avalible.</p>";}
        echo "</div>";

        // ISBN, price, stock, add button
        echo "<div>";
        echo "<p>ISBN: ". $product['ISBN'] ."</p>";
        echo "<p>Price: ". $product['price'] ."</p>";
        echo "<p>Stock: ". $product['stock'] ."</p>";
        echo "<a href='/bookworm/includes/addtocart.inc.php?id=" . $product['id'] . "' target='_blank'> Add <i class='bi-bag-fill'></i> </a>";
        echo "</div>";

        echo "</div>";
      }

     ?>

  </body>
</html>
