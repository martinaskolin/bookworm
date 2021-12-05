<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <?php include_once '../../includes/header.inc.php'; ?>

    <!-- Disable signup page when logged in -->
    <?php
      if(isset($_SESSION['uid'])) {
        header('location: /bookworm/');
        exit();
      }
    ?>

    <div class="inputContainer-div">
      <div class="inputContainer-header">
        <h1><i class='bi-pencil-square'></i></h1>
      </div>

      <section class="inputContainer-form">
        <form action="../../includes/signup.inc.php" method="post">
          <input type="inputText" name="fname" placeholder="First Name...">
          <input type="inputText" name="lname" placeholder="Last Name...">
          <input type="inputText" name="email" placeholder="Email...">
          <input type="password" name="pwd" placeholder="Password...">
          <button type="inputSubmit" name="submit">Sign Up</button>
        </form>
        <p class="errorMessage"><?php
        if (isset($_GET["error"])) {
          $error = $_GET["error"];
          if ($error == "none") {
            echo "Account created!";
          }
          elseif ($error == "STMT_FAILED") {
            echo "Unexpected error when creating account";
          }
          elseif ($error == "EMPTY_INPUT") {
            echo "Please fill in all the fields!";
          }
          elseif ($error == "INVALID_EMAIL") {
            echo "Please enter a valid email!";
          }
          elseif ($error == "EMAIL_ALREADY_EXISTS") {
            echo "This email already has an account!";
          }
        }
        ?></p>
      </section>
    </div>

  </body>
</html>
