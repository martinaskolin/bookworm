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

    <!-- Check for URL manipulation -->
    <?php
      if(!isset($_SERVER['HTTP_REFERER'])) {
        header('location: /bookworm/');
        exit();
      }
    ?>

    <!-- Disable page when not logged in -->
    <?php
      if(!isset($_SESSION['uid'])) {
        header('location: /bookworm/');
        exit();
      }
    ?>

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
              echo "<p>Stock: ". $product['stock'] ."</p><br>";

              //Edit product
              echo "<h3>Edit product:</h3>";
              echo "<form action='/bookworm/includes/edititem.inc.php?id=" . $product['id'] . "' method='post' enctype='multipart/form-data'>";
                echo "<input type='inputText' name='book' placeholder='Edit Book Name...'><br><br>";
                echo "<input type='inputText' name='author' placeholder='Edit Author Name...'><br><br>";
                echo "<input type='inputText' name='ISBN' placeholder='Edit ISBN...'><br><br>";
                echo "<input type='number' name='stock' placeholder='Edit Stock...' min='0'><br><br>";
                echo "<input type='number' name='price' placeholder='Edit Price...' min='0'><br><br>";
                echo "<input type='file' id='file' name='file'><br><br>";
                echo "<label class='descriptionText' for 'description'></label>";
                echo "<textarea id='description' name='description' rows='6' cols='40' placeholder='Edit Description...'></textarea><br><br>";
                echo "<button type='inputSubmit' name='submit'>Save</button>";
              echo "</form><br><br>";

              //Delete product
              echo "<form action='/bookworm/includes/deleteitem.inc.php?id=" . $product['id'] . "' method='post'>";
                echo "<button type='inputSubmit' name='deleteProduct'>Delete Product</button>";
              echo "</form><br>";

            echo "</ul>";

          echo "</div>";

          // Product buttons
          echo "<div id='btns'>";
            echo "<a>" . $product['price'] ." <i class='bi-bag-fill'></i> </a>";
          echo "</div>";

        echo "</div>";
      }

     ?>

  </body>
</html>
