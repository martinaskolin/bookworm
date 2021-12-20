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
        <h1><i class='bi-exclamation-triangle-fill'></i></h1>
      </div>
      <div class="inputContainer-form">
        <p class="errorMessage">
          You are trying to delete your account. This action is irreversible. Please provide your password for validation.
        </p>
        <form action="/bookworm/includes/deleteaccount.inc.php" method="post">
          <input type="password" name="pwd" placeholder="Password...">
          <button type="submit" name="deleteAccount">Delete Account</button><br>
        </form>
        <a href='/bookworm/pages/profile/'><button type='inputSubmit' name='submit'>Go Back</button></a>
        <p class="errorMessage"><?php
          if (isset($_GET["error"])) {
            if ($_GET['error'] == "WRONG_PASSWORD") {
              echo "Wrong password!";
            }
            elseif ($_GET['error'] == "ORDER_EXISTS") {
              echo "Can't delete accounts with active orders!";
            }
          }
        ?>
        </p>
      </div>
    </div>

  </body>
</html>
