<?php
  session_start();

  // If submit or delete is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["submit"]) && !isset($_POST["delete"])) {
    header("location: /bookworm/");
    exit();
  }

  // used PHP scripts
  require_once "dbh.inc.php";

  // Delete
  if (isset($_POST["delete"])) {
    $conn->query("DELETE product, product_add FROM product INNER JOIN product_add ON product.id = product_add.pid WHERE product.id = ".$_GET['id'].";");
  }
  // Update product information
  else {
    $sql = "SELECT p.* FROM cart_item ci, product p WHERE ci.uid = ? AND p.id = ci.pid;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: /bookworm/pages/checkout?error=STMT_FAILED");
      exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
  }

  // Variables
  /*$newFname = $_POST["newFname"];
  $newLname = $_POST["newLname"];
  $newEmail = $_POST["newEmail"];
  $newPwd = $_POST["newPwd"];
  $oldPwd = $_POST["oldPwd"];

  // used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  // Error checks
  if ($newEmail != null){
    if (checkEmail($newEmail) !== false) { header("location: ../pages/profile?error=INVALID_EMAIL"); exit(); }
    if (checkForExistingEmail($conn, $newEmail)) { header("location: ../pages/profile?error=EMAIL_ALREADY_EXISTS"); exit(); }
  }

  editUser($conn, $newFname, $newLname, $newEmail, $newPwd, $oldPwd, $_SESSION["uid"]);
*/
 ?>
