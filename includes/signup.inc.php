<?php

  // If submit is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["submit"])) {
    header("location: ../pages/signup");
    exit();
  }

  // Variables
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $email = $_POST["email"];
  $pwd = $_POST["pwd"];

  // used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  // Error checks
  if (checkEmpty(array($fname, $lname, $email, $pwd)) !== false) { header("location: ../pages/signup?error=EMPTY_INPUT"); exit(); }
  if (checkEmail($email) !== false) { header("location: ../pages/signup?error=INVALID_EMAIL"); exit(); }
  if (checkForExistingEmail($conn, $email)) { header("location: ../pages/signup?error=EMAIL_ALREADY_EXISTS"); exit(); }

  createUser($conn, $fname, $lname, $email, $pwd);

 ?>
