<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bookworm/resources/css/form-style.css">
    <title></title>
  </head>
  <body>

    <?php include_once '../../includes/header.inc.php'; ?>

    <!-- Check for URL manipulation -->
    <?php
      if(!isset($_SERVER['HTTP_REFERER'])){
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
        <p>Your Order Has Been Placed!</p>
      </div>
    </div>

  </body>
</html>
