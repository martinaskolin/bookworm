<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bookworm/pages/checkout/style.css">
    <title></title>
  </head>
  <body>

    <!-- Check for URL manipulation -->
    <?php
      if(!isset($_SERVER['HTTP_REFERER'])){
        // redirect them to your desired location
        header('location: /bookworm/');
        exit();
      }
    ?>

    <?php include_once '../../includes/header.inc.php'; ?>

    <div class="checkout-div">
      <div class="checkout-header">
        <p>Your Order Has Been Placed!</p>
      </div>

      <section class="checkout-form">
      </section>

    </div>

  </body>
</html>
