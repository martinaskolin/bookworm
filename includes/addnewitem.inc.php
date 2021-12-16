<?php

  // If submit is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["submit"])) {
    header("location: ../pages/add_item");
    exit();
  }

  // Variables
  $book = $_POST["book"];
  $author = $_POST["author"];
  $ISBN = $_POST["ISBN"];
  $price = $_POST["price"];
  $stock = $_POST["stock"];
  $file = $_FILES["file"];
  $fileName = $_FILES["file"]["name"];
  $fileTmpName = $_FILES["file"]["tmp_name"];
  $fileSize =  $_FILES["file"]["size"];
  $fileError = $_FILES["file"]["error"];

  // used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  // Error checks
  if (checkEmpty(array($book, $author, $ISBN, $price, $stock)) !== false) { header("location: /bookworm/pages/add_item?error=EMPTY_INPUT"); exit(); }
  if (checkForExistingISBN($conn, $ISBN)) { header("location: ../pages/add_item?error=BOOK_ALREADY_EXISTS"); exit(); }

  createNewItem($conn, $book, $author, $ISBN, $price, $stock, $file, $fileName, $fileTmpName, $fileSize, $fileError);

?>
