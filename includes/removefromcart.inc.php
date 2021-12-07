<?php

  session_start();

  $id = $_GET['id'];

  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  removeFromCart($conn, $id, $_SESSION['uid']);

?>
