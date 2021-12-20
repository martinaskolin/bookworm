<?php

  $id = htmlspecialchars($_GET['id']);

  // If deleteProduct is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["deleteProduct"])) {
    header("location: /bookworm/pages/edit_item/index.php?id= " . $id . "");
    exit();
  }

  // Used PHP scripts
  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  // Fetch product and product_add
  $result = fetch_products($conn, $id);

  if ($product = $result->fetch_assoc()) {
    // Delete product_add
    $sql = "DELETE FROM product_add WHERE pid=$id;";
    $conn->query($sql);

    // Delete product
    $sql = "DELETE FROM product WHERE id=$id;";
    $conn->query($sql);

    // Unlink img_dir
    $image = substr($product['img_dir'], 29);
    unlink("../resources/prod/img/" . $image);

    // Unlink des_dir
    $description = substr($product['des_dir'], 29);
    unlink("../resources/prod/des/" . $description);
  }

  header("location: /bookworm/index.php?status=ITEM_DELETED");
  exit();

?>
