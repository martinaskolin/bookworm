<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <?php
      include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/functions.inc.php';
      include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/header.inc.php';

      if (isset($_SESSION["uid"]) && checkAdmin($conn, $_SESSION["uid"]) == true) {
        $sql = "SELECT * FROM product LEFT JOIN product_add ON product.id = product_add.pid WHERE product.id = " . $_GET['id'] . ";"; // change later to filter products
        $result = $conn->query($sql);

        if ($product = $result->fetch_assoc()) {
          echo "<form action='/bookworm/includes/editproduct.inc.php?id=".$_GET['id']."' method='post'>";
          echo "<input type='text' name='name' placeholder='Name' value='" . $product['name'] . "'><br>";
          echo "<input type='text' name='author placeholder='Author'' value='" . $product['author'] . "'><br>";
          echo "<input type='text' name='img_dir' placeholder='Image Directory' value='" . $product['img_dir'] . "'><br>";
          echo "<input type='text' name='des_dir' placeholder='Description Directory' value='" . $product['des_dir'] . "'><br>";
          echo "<input type='text' name='price' placeholder='Price' value='" . $product['price'] . "'><br>";
          echo "<input type='text' name='ISBN' placeholder='ISBN' value='" . $product['ISBN'] . "'><br>";
          echo "<input type='text' name='stock' placeholder='Stock' value='" . $product['stock'] . "'><br>";
          echo "<button type='submit' name='submit'>Save Changes</button></br>";
          echo "<button type='submit' name='delete'>Delete</button>";
          echo "</form>";
        }

      } else { header("location: /bookworm/index.php"); exit();}
    ?>

  </body>
</html>
