<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <!-- Check for URL manipulation -->
    <?php
      if(!isset($_SERVER['HTTP_REFERER'])){
        header('location: /bookworm/');
        exit();
      }
    ?>

    <?php include_once '../../includes/header.inc.php'; ?>

    <div class="inputContainer-div">
      <div class="inputContainer-header">
        <p>Your Order Has Been Placed!</p>
      </div>
    </div>

  </body>
</html>
