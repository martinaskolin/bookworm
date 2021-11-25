<?php
  session_start();

  // If submit is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["submit"])) {
    header("location: ../pages/checkout");
    exit();
  }

  // Variables
  $address = $_POST["address"];

  // used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  // Error checks
  if (checkEmpty(array($address)) !== false) { header("location: ../pages/checkout?error=EMPTY_INPUT"); exit(); }

  placeOrder($conn, $address, $_SESSION["uid"]);

 ?>
