<?php
  session_start();

  // If submit is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["submit"])) {
    header("location: ../pages/checkout");
    exit();
  }

  // Variables
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $address = $_POST["address"];
  $zipcode = $_POST["zipcode"];
  $city = $_POST["city"];
  $country = $_POST["country"];
  $email = $_POST["email"];

  // used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  // Error checks
  if (checkEmpty(array($fname, $lname, $address, $zipcode, $city, $country, $email)) !== false) { header("location: ../pages/checkout?error=EMPTY_INPUT"); exit(); }
  if (checkEmail($email) !== false) { header("location: /bookworm/pages/checkout?error=INVALID_EMAIL"); exit(); }
  $cart = fetch_cart($conn, $_SESSION["uid"]);
  if (!$cart->fetch_assoc()) {
    header("location: /bookworm/pages/checkout?error=EMPTY_CART");
    exit();
  }

  placeOrder($conn, $fname, $lname, $address, $zipcode, $city, $country, $email, $_SESSION["uid"]);

 ?>
