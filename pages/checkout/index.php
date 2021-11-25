<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bookworm/pages/checkout/style.css">
    <title></title>
  </head>
  <body>

    <?php include_once '../../includes/header.inc.php'; ?>

    <div class="checkout-div">
      <div class="checkout-header">
        <p>Checkout</p>
      </div>

      <section class="checkout-form">
        <form action="../../includes/checkout.inc.php" method="post">
          <input type="text" name="address" placeholder="Address...">
          <button type="submit" name="submit">Place Order</button>
        </form>
      </section>
    </div>

  </body>
</html>
