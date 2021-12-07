<?php

  session_start();

  // Variables
  $id = $_GET['id'];

  // used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  if (isset($_SESSION["uid"])) {
    $result = addToCart2($conn, $id, $_SESSION["uid"]);

    if ($reult == true) {
      echo "I DID IT";
      // code...
    }
    else {
      echo "I failed";
    }
  }
  else {
    header("location: /bookworm/pages/login");
    exit();
  }


 ?>
