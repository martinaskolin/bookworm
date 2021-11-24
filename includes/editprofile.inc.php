<?php
  session_start();

  // If submit is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["submit"])) {
    header("location: ../pages/profile");
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
  //if (empty_input($newFname, $newLname, $newEmail, $newPwd) !== false) { header("location: ../pages/profile?error=EMPTY_INPUT"); exit(); }
  //if (empty_input($oldPwd) !== false) { header("location: ../pages/profile?error=MISSING_OLD_PASSWORD"); exit(); }
  if ($newEmail != null){
    if (invalid_email($newEmail) !== false) { header("location: ../pages/profile?error=INVALID_EMAIL"); exit(); }
  }

  editUser($conn, $newFname, $newLname, $newEmail, $newPwd, $oldPwd, $_SESSION["uid"]);

 ?>
