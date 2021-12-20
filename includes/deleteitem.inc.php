<?php

  $id = htmlspecialchars($_GET['id']);

  // If deleteProduct is not set inside the code send them back (someone tryed to access the page through the url)
  if (!isset($_POST["deleteProduct"])) {
    header("location: /bookworm/pages/edit_item/index.php?id= " . $id . "");
    exit();
  }

  // Fetch product and product_add

  // Delete product_add

  // Delete product

  // Unlink img_dir

  // Unlink des_dir

  // Go back to browse

?>
