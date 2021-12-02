<?php
  session_start();

  // If submit is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["submit"])) {
    header("location: /bookworm/pages/profile/");
    exit();
  }

  // Variables
  $newFname = $_POST["newFname"];
  $newLname = $_POST["newLname"];
  $newEmail = $_POST["newEmail"];
  $newPwd = $_POST["newPwd"];
  $oldPwd = $_POST["oldPwd"];

  // used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  // Error checks
  if ($newEmail != null){
    if (checkEmail($newEmail) !== false) { header("location: ../pages/profile?error=INVALID_EMAIL"); exit(); }
    if (checkForExistingEmail($conn, $newEmail)) { header("location: ../pages/profile?error=EMAIL_ALREADY_EXISTS"); exit(); }
  }

  editUser($conn, $newFname, $newLname, $newEmail, $newPwd, $oldPwd, $_SESSION["uid"]);

 ?>
