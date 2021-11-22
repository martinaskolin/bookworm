<?php

  // If submit is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["submit"])) {
    header("location: /bookworm/pages/login");
    exit();
  }

  // Variables
  $email = $_POST["email"];
  $pwd = $_POST["pwd"];

  // used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  loginUser($conn, $email, $pwd);

 ?>
