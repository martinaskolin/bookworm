<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bookworm/resources/css/form-style.css">
    <title></title>
  </head>
  <body>

    <?php include_once '../../includes/header.inc.php'; ?>

    <!-- Check for URL manipulation -->
    <?php
      if(!isset($_SERVER['HTTP_REFERER'])) {
        header('location: /bookworm/');
        exit();
      }
    ?>

    <!-- Disable page when not logged in -->
    <?php
      if(!isset($_SESSION['uid'])) {
        header('location: /bookworm/');
        exit();
      }
    ?>

    <div class="inputContainer-div">
      <div class="inputContainer-header">
        <p>Add New Item</p>
      </div>

      <section class="inputContainer-form">
        <form action="/bookworm/includes/addnewitem.inc.php" method="post" enctype="multipart/form-data">
          <input type="inputText" name="book" placeholder="Book Name...">
          <input type="inputText" name="author" placeholder="Author...">
          <input type="inputText" name="ISBN" placeholder="ISBN...">
          <input type="number" name="price" placeholder="Price..." min="0">
          <input type="number" name="stock" placeholder="Stock..." min="0"><br><br>
          <label class="imageUpload" for="file">Upload image</label><br>
          <input type="file" id="file" name="file"><br>
          <button type="inputSubmit" name="submit">Add Item</button>
        </form>
        <p class="errorMessage"><?php
          if (isset($_GET["error"])) {
            $error = $_GET["error"];
            if ($error == "none") {
              echo "Book added!";
            }
            elseif ($error == "STMT_FAILED") {
              echo "Unexpected error when creating account";
            }
            elseif ($error == "EMPTY_INPUT") {
              echo "Please fill in all the fields!";
            }
            elseif ($error == "BOOK_ALREADY_EXISTS") {
              echo "This book already exists!";
            }
            elseif ($error == "FILETYPE_NOT_ALLOWED") {
              echo "Only jpeg, jpg and png are allowed!";
            }
            elseif ($error == "UPLOAD_ERROR") {
              echo "Unexpected error when uploading file";
            }
            elseif ($error == "FILE_TOO_BIG") {
              echo "This file is too large!";
            }
          }
        ?></p>
      </section>
    </div>

  </body>
</html>
