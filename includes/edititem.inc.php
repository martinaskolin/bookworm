<?php

  $id = htmlspecialchars($_GET['id']);

  // If submit is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["submit"])) {
    header("location: /bookworm/pages/edit_item/index.php?id= " . $id . "");
    exit();
  }

  // Variables
  $book = $_POST["book"];
  $author = $_POST["author"];
  $ISBN = $_POST["ISBN"];
  $price = $_POST["price"];
  $stock = $_POST["stock"];

  // Image
  $file = $_FILES["file"];
  $fileName = $_FILES["file"]["name"];
  $fileTmpName = $_FILES["file"]["tmp_name"];
  $fileSize =  $_FILES["file"]["size"];
  $fileError = $_FILES["file"]["error"];

  // Description
  $description = $_POST["description"];

  // Used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  // Error checks
  if ($ISBN != "") {
    if (checkForExistingISBN($conn, $ISBN)) { header("location: /bookworm/pages/edit_item/index.php?id=" . $id . "&error=BOOK_ALREADY_EXISTS"); exit(); }
  }

  editProduct($conn, $book, $author, $ISBN, $price, $stock, $file, $fileName, $fileTmpName, $fileSize, $fileError, $description, $id);

  header("location: /bookworm/pages/edit_item/index.php?id=" . $id . "");
  exit();

?>
