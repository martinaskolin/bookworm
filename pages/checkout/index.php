<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <!-- Check for URL manipulation, UNCOMMENT WHEN CART IS DONE!!! -->
    <?php
    /*  if(!isset($_SERVER['HTTP_REFERER'])) {
        header('location: /bookworm/');
        exit();
      } */
    ?>

    <?php include_once '../../includes/header.inc.php'; ?>

    <div class="inputContainer-div">
      <div class="inputContainer-header">
        <p>Checkout</p>
      </div>

      <div class="displayCart-div"><?php
        displayCart($conn, $_SESSION['uid']);
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
