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
        <p>Checkout</p>
      </div>

      <div class="displayCart-div"><?php
        $cart = fetch_cart($conn, $_SESSION['uid']);
        $sum = 0;
        if ($cart->num_rows > 0) {
          while ($item = $cart->fetch_assoc()) {
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
            echo "<div class='displayCart-text'><p>" . $product['name'] . "</p><p>Price: " . $product['price'] . "</p></div>";
            echo "</div>";
          }
          echo "<div class='total-container'>Total Cost: " . $sum . "</div>";
        }
      ?></div>

      <div class="inputContainer-form">
        <form action="../../includes/checkout.inc.php" method="post">
          <input type="inputText" name="fname" placeholder="First name...">
          <input type="inputText" name="lname" placeholder="Last name...">
          <input type="inputText" name="address" placeholder="Address...">
          <input type="inputText" name="zipcode" placeholder="Zip code...">
          <input type="inputText" name="city" placeholder="City...">
          <input type="inputText" name="country" placeholder="Country...">
          <input type="inputText" name="email" placeholder="Email...">
          <button type="inputSubmit" name="submit">Place Order</button>
        </form>
        <p class="errorMessage"><?php
          if (isset($_GET["error"])) {
            $error = $_GET["error"];
            if ($error == "ORDER_NOT_PLACED") {
              echo "The order could not be placed since some items are out of stock!";
            }
            elseif ($error == "EMPTY_INPUT") {
              echo "Please fill in all the fields!";
            }
            elseif ($error == "INVALID_EMAIL") {
              echo "Please enter a valid email!";
            }
            elseif ($error == "EMPTY_CART") {
              echo "Your cart is empty, order not placed";
            }
          }
        ?></p>
      </div>

    </div>

  </body>
</html>
