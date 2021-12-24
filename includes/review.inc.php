<?php

  // If submit is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["submit"])) {
    header("location: /bookworm/index.php");
    exit();
  }

  // used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  $type = $_POST["type"];

  if ($type == 'add') {

    // Variables
    $pid = $_POST["pid"];
    $uid = $_POST["uid"];
    $rating = $_POST["rating"];
    $description = $_POST["description"];

    // Error checks
    if (checkEmpty(array($rating, $description)) !== false) { header("location: /bookworm/pages/product/index.php?error=EMPTY_INPUT"); exit(); }

    // Create description file
    $textFileName = uniqid() . ".txt";
    $textFile = fopen($textFileName, "a+");
    file_put_contents($textFileName, $description);
    fclose($textFile);

    // Move file to /bookworm/resources/prod/rev/
    $fileDestination = '../resources/prod/rev/' . $textFileName;
    rename($textFileName, $fileDestination);

    $desDestination = '/bookworm/resources/prod/rev/' . $textFileName;

    $sql = "INSERT INTO review (pid, uid, rating, des_dir) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: /bookworm/pages/product/index.php?error=STMT_FAILED");
      exit();
    }

    mysqli_stmt_bind_param($stmt, "iiis", $pid, $uid, $rating, $desDestination);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: /bookworm/pages/product/index.php?id=". $pid);
    exit();
  }
 ?>
