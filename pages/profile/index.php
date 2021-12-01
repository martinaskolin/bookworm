<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bookworm/pages/profile/style.css">
    <title></title>
  </head>
  <body>

    <?php include_once '../../includes/header.inc.php'; ?>

    <div class="profile-div">
      <div class="profile-header">
        <?php
          if (isset($_SESSION["uid"])) {
            include_once $_SERVER['DOCUMENT_ROOT']. '/bookworm/includes/functions.inc.php';
            $userArr = fetch_user($conn, $_SESSION["uid"], null);
            echo "<h1><i class='bi-person-circle'></i> " . $userArr['fname'] . " " . $userArr['lname'] . "</h1>";
            echo "<p><i class='bi bi-envelope-fill'></i> " . $userArr['email'] . "</p>";
          }
        ?>
      </div>

      <section class="editprofile-form">
        <form action="../../includes/editprofile.inc.php" method="post">
          <input type="text" name="newFname" placeholder="Edit first name..."><br>
          <input type="text" name="newLname" placeholder="Edit last name..."><br>
          <input type="text" name="newEmail" placeholder="Edit email..."><br>
          <input type="password" name="newPwd" placeholder="New password..."><br>
          <input type="password" name="oldPwd" placeholder="Old password (required)..."><br>
          <button type="submit" name="submit">Save</button>
        </form>
        <h2><?php
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
        ?></h2>
      </section>
    </div>

  </body>
</html>
