<?php

  session_start();

  // If deleteAccount is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["deleteAccount"])) { header("location: /bookworm/pages/profile/"); exit(); }

  $pwd = $_POST["pwd"];

  // used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  deleteAccount($conn, $_SESSION['uid'], $pwd);

  session_start();
  session_unset();
  session_destroy();

  header("location: /bookworm/");
  exit();

?>
