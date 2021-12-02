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

      <section class="inputContainer-form">
        <form action="../../includes/checkout.inc.php" method="post">
          <input type="inputText" name="address" placeholder="Address...">
          <button type="inputSubmit" name="submit">Place Order</button>
        </form>
        <h2 class="errorMessage"><?php
          if (isset($_GET["status"]) && $_GET["status"] == "ORDER_NOT_PLACED") {
            echo "The order could not be placed since some items are out of stock!";
          }
          elseif (isset($_GET["error"]) && $_GET["error"] == "EMPTY_INPUT") {
            echo "Please enter an address";
          }
        ?></h2>
      </section>

    </div>

  </body>
</html>
