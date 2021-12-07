<?php
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  session_start();

  // Variables
  $id = $_GET['id'];

  // used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  if (isset($_SESSION["uid"])) {
    $result = removeFromCart($conn, $id, $_SESSION["uid"]);
    }
  else {
    header("location: /bookworm/pages/cart");
    exit();
  }
?>
