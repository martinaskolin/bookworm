<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <?php include_once '../../includes/header.inc.php'; ?>

    <!-- Disable login page when logged in -->
    <?php
      if(isset($_SESSION['uid'])) {
        header('location: /bookworm/');
        exit();
      }
    ?>

    <div class="inputContainer-div">
      <div class="inputContainer-header">
        <h1><i class='bi-person-circle'></i></h1>
      </div>

      <section class="inputContainer-form">
        <form action="../../includes/login.inc.php" method="post">
          <input type="inputText" name="email" placeholder="Email...">
          <input type="password" name="pwd" placeholder="Password...">
          <button type="inputSubmit" name="submit">Log In</button>
        </form>
        <p class="errorMessage"><?php
          if (isset($_GET["error"]) && $_GET["error"] == "WRONG_LOGIN") {
            echo "Incorrect credentials!";
          }
        ?></p>
      </section>
    </div>
  </body>
</html>
