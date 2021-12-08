<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <?php include_once '../../includes/header.inc.php'; ?>

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

    <div class="inputContainer-div">
      <div class="inputContainer-header">
        <p>Shopping Cart</p>
      </div>

      <div class="displayCart-div">
        <?php
          $cart = fetch_cart($conn, $_SESSION['uid']);

          if (mysqli_num_rows($cart) > 0) {
            $sum = 0;
            while($item = mysqli_fetch_assoc($cart)){
              $pid = $item["id"];
              $result = fetch_products_in_cart($conn, $pid);
              $product = $result->fetch_assoc();
              $default_img = '/bookworm/resources/images/img_missing.jpg';
              $add_exist = ($product['img_dir'] != null);
              $sum = $sum + $product['price'];

              // Print item in cart
              echo "<div class='displayCart-item'>";
              echo "<div class='displayCart-image'>";
              if ($add_exist) { echo "<img src='" . $product['img_dir'] . "'>"; } // Print Product Image
              else { echo "<img src='" . $default_img . "'>"; }                // Print Default Image
              echo "</div>";
              echo "<div class='displayCart-text'>";
              echo "<p>" . $product['name'] . "</p><p>Price: " . $product['price'] . "</p>";
              echo "<a href='/bookworm/includes/removefromcart.inc.php?id=" . $item['id'] . "'> <p> Remove </p></a>";
              echo "</div>";
              echo "</div>";
            }
            echo "<div class='total-container'>Total Cost: " . $sum . "</div>";

            // Display "Checkout" button, but only if cart is NOT Empty
            echo "<div class='inputContainer-form'>";
            echo "<a href='../checkout'><button type='inputSubmit' name='submit'>Go To Checkout</button></a>";
            echo "</div>";
          }
          else {
            echo "<p> Cart is empty </p>";
          }
        ?>
      </div>

    </div>

  </body>
</html>
