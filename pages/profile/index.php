<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <?php include_once '../../includes/header.inc.php'; ?>

    <!-- Disable profile page when not logged in -->
    <?php
      if(!isset($_SESSION['uid'])) {
        header('location: /bookworm/');
        exit();
      }
    ?>

    <div class="inputContainer-div">
      <div class="inputContainer-header">
        <?php
          if (isset($_SESSION["uid"])) {
            include_once $_SERVER['DOCUMENT_ROOT']. '/bookworm/includes/functions.inc.php';
            $userArr = fetch_user($conn, $_SESSION["uid"], null);
            echo "<h1 class='profileName'><i class='bi-person-circle'></i> " . $userArr['fname'] . " " . $userArr['lname'] . "</h1>";
            echo "<p class='profileEmail'><i class='bi bi-envelope-fill'></i> " . $userArr['email'] . "</p>";
          }
        ?>
      </div>

      <section class="inputContainer-form">
        <form action="../../includes/editprofile.inc.php" method="post">
          <input type="inputText" name="newFname" placeholder="Edit first name..."><br>
          <input type="inputText" name="newLname" placeholder="Edit last name..."><br>
          <input type="inputText" name="newEmail" placeholder="Edit email..."><br>
          <input type="password" name="newPwd" placeholder="New password..."><br>
          <input type="password" name="oldPwd" placeholder="Old password (required)..."><br>
          <button type="inputSubmit" name="submit">Save</button>
        </form>
        <p class="errorMessage"><?php
        if (isset($_GET["error"])) {
          $error = $_GET["error"];
          if ($error == "none") {
            echo "Profile updated!";
          }
          elseif ($error == "STMT_FAILED") {
            echo "Unexpected error when updating profile";
          }
          elseif ($error == "WRONG_PASSWORD") {
            echo "Enter your current password to make changes!";
          }
          elseif ($error == "NEW_PASSWORD_SAME_AS_OLD") {
            echo "New password is the same as current password!";
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
