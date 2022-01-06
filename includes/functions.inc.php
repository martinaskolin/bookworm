<?php

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Check Password: returns true if password match hashed version
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function checkPassword($raw_pwd, $raw_salt, $hashed_pwd) {
    return 0 == strcmp(hash("sha256", $raw_pwd . $raw_salt), $hashed_pwd);
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Check Admin: returns true if user is admin
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function checkAdmin($conn, $uid) {
    $userArr = fetch_user($conn, $_SESSION["uid"], null);
    if ($userArr['admin'] == 1) { return true; }
    else { return false; }
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Check Empty: returns true if any of the elements in array is empty
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function checkEmpty($inputArr) {

    foreach ($inputArr as $input) {
      if (empty($input)) { return true; }
    }

    return false;
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Check Email: returns true if email is valid
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function checkEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return true;
    }
    return false;
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Check For Existing Email: returns true if email already is in the table
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function checkForExistingEmail($conn, $email) {
    $emailArr = fetch_emails($conn);
    if ($emailArr != null && in_array($email, $emailArr)) {
      return true;
    }
    return false;
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Check For Existing ISBN: returns true if ISBN (book) already is in the table
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function checkForExistingISBN($conn, $ISBN) {
    $sql = "SELECT ISBN FROM product WHERE ISBN=$ISBN;";
    $result = $conn->query($sql);
    if ($result->fetch_assoc()) {
      return true;
    }
    return false;
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Fetch Product: Returns all product and additional product information
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function fetch_products($conn, $id) {
    if ($id == null) { $sql = "SELECT * FROM product LEFT JOIN product_add ON product.id = product_add.pid;"; }
    else { $sql = "SELECT * FROM product LEFT JOIN product_add ON product.id = product_add.pid WHERE product.id = ". $id . ";";}
    $result = $conn->query($sql);

    return $result;
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Fetch Reviews: Returns all reviews for a product
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function fetch_reviews($conn, $pid) {
    $sql = "SELECT * FROM review LEFT JOIN user ON review.uid = user.id WHERE review.pid = ". $pid .";";
    $result = $conn->query($sql);

    return $result;
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Fetch Products in Cart: Returns all product and additional product information from a specific user's cart
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function fetch_products_in_cart($conn, $pid) {
    $result = $conn->query("SELECT * FROM product LEFT JOIN product_add ON product.id = product_add.pid WHERE id=$pid;");
    return $result;
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Add to Cart: Adds pid and cid as new entry into cart_item (NOT PREP. STMT.)
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function add_to_cart($conn, $pid, $uid) {
    $conn->query("INSERT INTO cart_item(pid, uid) VALUES (". $pid . ", " . $uid . ")");
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Remove From Cart: Removes one item from cart
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function removeFromCart($conn, $id, $uid){
    $conn->query("DELETE FROM cart_item WHERE pid = $id AND uid = $uid LIMIT 1;");
    header("location: /bookworm/pages/cart?status=ITEM_REMOVED");
    exit();
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Fetch cart: returns all products a user has in their cart
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function fetch_cart($conn, $uid) {
    $sql = "SELECT p.* FROM cart_item ci, product p WHERE ci.uid = ? AND p.id = ci.pid;";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: /bookworm/pages/cart?error=STMT_FAILED");
      exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $uid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    return $result;
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Fetch user: returns all users given uid and/or email
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function fetch_user($conn, $uid, $email) {
    $sql = "SELECT * FROM user WHERE id = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: /bookworm/pages/signup?error=STMT_FAILED");
      exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $uid, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    if ($row = mysqli_fetch_assoc($result)) { return $row;}
    else { return false; }
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Fetch emails: returns all email addresses in the user table
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function fetch_emails($conn) {
    $sql = "SELECT email FROM user;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: /bookworm/pages/signup?error=STMT_FAILED");
      exit();
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);

    if ($col = mysqli_fetch_assoc($result)) { return $col;}
    else { return false; }
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Create New Item: Adds a new item to the store
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function createNewItem($conn, $book, $author, $ISBN, $price, $stock) {
    $sql = "INSERT INTO product (name, author, ISBN, price, stock) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: /bookworm/pages/add_item?error=STMT_FAILED");
      exit();
    }

    mysqli_stmt_bind_param($stmt, "sssii", $book, $author, $ISBN, $price, $stock);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Add Image: Adds an image to a book identified by ISBN
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function addImage($conn, $ISBN, $file, $fileName, $fileTmpName, $fileSize, $fileError) {
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
      if ($fileError === 0) {
        if ($fileSize < 1000000) {
          $fileNameNew = uniqid() . "." . $fileActualExt;
          $fileDestination = '../resources/prod/img/' . $fileNameNew;
          move_uploaded_file($fileTmpName, $fileDestination);

          //header("location: /bookworm/pages/add_item?error=" . $fileNameNew);
          //exit();

          // Place file in database
          $result = $conn->query("SELECT id FROM product WHERE ISBN=$ISBN;");
          if ($product = $result->fetch_assoc()) {
            $sql = "INSERT INTO product_add VALUES (?, ?, ?);";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
              header("location: /bookworm/pages/add_item?error=STMT_FAILED");
              exit();
            }

            $imageDir = "/bookworm/resources/prod/img/" . $fileNameNew;

            $text = "No description.";

            mysqli_stmt_bind_param($stmt, "iss", $product['id'], $imageDir, $text);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
          }
        }
        else { header("location: /bookworm/pages/add_item?error=FILE_TOO_BIG"); exit(); }
      }
      else { header("location: /bookworm/pages/add_item?error=UPLOAD_ERROR"); exit(); }
    }
    else { header("location: /bookworm/pages/add_item?error=FILETYPE_NOT_ALLOWED"); exit(); }
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Add Description: Adds a description to a book identified by ISBN
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function addDescription($conn, $ISBN, $description, $fileName) {
    // Create description file
    $textFileName = uniqid() . ".txt";
    $textFile = fopen($textFileName, "a+");
    file_put_contents($textFileName, $description);
    fclose($textFile);

    // Move file to /bookworm/resources/prod/des/
    $fileDestination = '../resources/prod/des/' . $textFileName;
    rename($textFileName, $fileDestination);

    // Receive correct product ID
    $result = $conn->query("SELECT id FROM product WHERE ISBN=$ISBN;");
    if ($product = $result->fetch_assoc()) {
      $pid = $product["id"];
    }

    $descriptionDir = "/bookworm/resources/prod/des/" . $textFileName;

    // See if an image already exists. If not we have to make a new entry in the table product_add
    if ($fileName != "") {
      $sql = "UPDATE product_add SET des_dir=? WHERE pid=?";
      $stmt = mysqli_stmt_init($conn);

      if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../pages/add_item?error=STMT_FAILED");
        exit();
      }

      mysqli_stmt_bind_param($stmt, "si", $descriptionDir, $pid);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
    else {
      $sql = "INSERT INTO product_add VALUES (?, ?, ?);";
      $stmt = mysqli_stmt_init($conn);

      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: /bookworm/pages/add_item?error=STMT_FAILED");
        exit();
      }

      $imageDir = "";

      mysqli_stmt_bind_param($stmt, "iss", $product['id'], $imageDir, $descriptionDir);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Create User: Creates a user from param.
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function createUser($conn, $fname, $lname, $email, $pwd) {
    $sql = "INSERT INTO user (fname, lname, email, pwd_sha256, pwd_salt, admin) VALUES (?, ?, ?, ?, ?, 0);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: /bookworm/pages/signup?error=STMT_FAILED");
      exit();
    }
    $salt = random_bytes(32);
    mysqli_stmt_bind_param($stmt, "sssss", $fname, $lname, $email, hash("sha256", $pwd . $salt), $salt);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: /bookworm/pages/signup?error=none");
    exit();
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Edit User: Edit a user from profile page.
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function editUser($conn, $newFname, $newLname, $newEmail, $newPwd, $oldPwd, $uid) {
    $userArr = fetch_user($conn, $uid, null);

    //Make sure the input old password matches the stored password
    if (!checkPassword($oldPwd, $userArr["pwd_salt"], $userArr["pwd_sha256"])) {
      header("location: ../pages/profile?error=WRONG_PASSWORD");
      exit();
    }

    //Make sure the input new password doesn't match the stored password
    if ($oldPwd == $newPwd) {
      header("location: ../pages/profile?error=NEW_PASSWORD_SAME_AS_OLD");
      exit();
    }

    $salt = null;
    if ($newFname == null){
      $newFname = $userArr["fname"];
    }
    if ($newLname == null){
      $newLname = $userArr["lname"];
    }
    if ($newEmail == null){
      $newEmail = $userArr["email"];
    }
    if ($newPwd == null){
      $newPwd = $oldPwd;
      $salt = $userArr["pwd_salt"];
    }
    else{
      $salt = random_bytes(32);
    }

    $sql = "UPDATE user SET fname=?, lname=?, email=?, pwd_sha256=?, pwd_salt=? WHERE id=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)){
      header("location: ../pages/profile?error=STMT_FAILED");
      exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssss", $newFname, $newLname, $newEmail, hash("sha256", $newPwd . $salt), $salt, $userArr["id"]);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../pages/profile?error=none");
    exit();
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Edit Product: Edit a product from admin page.
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function editProduct($conn, $book, $author, $ISBN, $price, $stock, $file, $fileName, $fileTmpName, $fileSize, $fileError, $description, $pid) {
    $result = fetch_products($conn, $pid);

    if ($product = $result->fetch_assoc()) {
      // Base information
      if ($book == null) { $book = $product['name']; }
      if ($author == null) { $author = $product['author']; }
      if ($ISBN == null) { $ISBN = $product['ISBN']; }
      if ($price == null) { $price = $product['price']; }
      if ($stock == null) { $stock = $product['stock']; }

      $sql = "UPDATE product SET name=?, author=?, ISBN=?, price=?, stock=? WHERE id=?;";
      $stmt = mysqli_stmt_init($conn);

      if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: /bookworm/pages/edit_item/index.php?id=" . $pid . "&error=STMT_FAILED");
        exit();
      }

      mysqli_stmt_bind_param($stmt, "sssiii", $book, $author, $ISBN, $price, $stock, $pid);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      // Image
      if ($fileName != "") {
        if (!isset($product['img_dir'])) {
          addImageFromEdit($conn, $file, $fileName, $fileTmpName, $fileSize, $fileError, $pid);
        }
        else {
          $oldImage = substr($product['img_dir'], 29);
          $oldDescription = $product['des_dir'];
          editProductImage($conn, $file, $fileName, $fileTmpName, $fileSize, $fileError, $pid, $oldImage, $oldDescription);
        }
      }

      // Description
      if (!empty($description)) {
        // Create description file
        $textFileName = uniqid() . ".txt";
        $textFile = fopen($textFileName, "a+");
        file_put_contents($textFileName, $description);
        fclose($textFile);

        // Move file to /bookworm/resources/prod/des/
        $fileDestination = '../resources/prod/des/' . $textFileName;
        rename($textFileName, $fileDestination);

        $descriptionDir = "/bookworm/resources/prod/des/" . $textFileName;

        // Create new entry in table if no entry for the product exists
        if (!isset($product['des_dir'])) {
          $sql = "INSERT INTO product_add VALUES (?, ?, ?);";
          $stmt = mysqli_stmt_init($conn);

          if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /bookworm/pages/edit_item?id=" . $pid . "&error=STMT_FAILED");
            exit();
          }

          $imageDir = "";

          mysqli_stmt_bind_param($stmt, "iss", $pid, $imageDir, $descriptionDir);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
        }
        // Update entry if it already exists
        else {
          $sql = "UPDATE product_add SET des_dir=? WHERE pid=?";
          $stmt = mysqli_stmt_init($conn);

          if (!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../pages/edit_item?id=" . $pid . "&error=STMT_FAILED");
            exit();
          }

          mysqli_stmt_bind_param($stmt, "si", $descriptionDir, $pid);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);

          $oldDescription = substr($product['des_dir'], 29);
          unlink("../resources/prod/des/" . $oldDescription);
        }
      }
    }
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Add Image From Edit: Adds an image to a book identified by ISBN from the edit page
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function addImageFromEdit($conn, $file, $fileName, $fileTmpName, $fileSize, $fileError, $pid) {
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
      if ($fileError === 0) {
        if ($fileSize < 1000000) {
          $fileNameNew = uniqid() . "." . $fileActualExt;
          $fileDestination = '../resources/prod/img/' . $fileNameNew;
          move_uploaded_file($fileTmpName, $fileDestination);

          // Place file in database
          $sql = "INSERT INTO product_add VALUES (?, ?, ?);";
          $stmt = mysqli_stmt_init($conn);

          if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /bookworm/pages/edit_item/index.php?id=" . $pid . "&error=STMT_FAILED");
            exit();
          }

          $imageDir = "/bookworm/resources/prod/img/" . $fileNameNew;

          $text = "No description.";

          mysqli_stmt_bind_param($stmt, "iss", $product['id'], $imageDir, $text);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
        }
        else { header("location: /bookworm/pages/edit_item/index.php?id=" . $pid . "&error=FILE_TOO_BIG"); }
      }
      else { header("location: /bookworm/pages/edit_item/index.php?id=" . $pid . "&error=UPLOAD_ERROR"); }
    }
    else { header("location: /bookworm/pages/edit_item/index.php?id=" . $pid . "&error=FILETYPE_NOT_ALLOWED"); }
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Edit Product Image: Edit an existing product image.
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function editProductImage($conn, $file, $fileName, $fileTmpName, $fileSize, $fileError, $pid, $oldImage, $oldDescription) {
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($fileActualExt, $allowed)) {
      if ($fileError === 0) {
        if ($fileSize < 1000000) {
          $fileNameNew = uniqid() . "." . $fileActualExt;
          $fileDestination = '../resources/prod/img/' . $fileNameNew;
          move_uploaded_file($fileTmpName, $fileDestination);

          // Place file in database
          $sql = "UPDATE product_add SET img_dir=?, des_dir=? WHERE pid=?;";
          $stmt = mysqli_stmt_init($conn);

          if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: /bookworm/pages/edit_item?id=" . $pid . "&error=STMT_FAILED");
            exit();
          }

          $imageDir = "/bookworm/resources/prod/img/" . $fileNameNew;

          mysqli_stmt_bind_param($stmt, "ssi", $imageDir, $oldDescription, $pid);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_close($stmt);
        }
        else { header("location: /bookworm/pages/edit_item/index.php?id=" . $pid . "&error=FILE_TOO_BIG"); }
      }
      else { header("location: /bookworm/pages/edit_item/index.php?id=" . $pid . "&error=UPLOAD_ERROR"); }
    }
    else { header("location: /bookworm/pages/edit_item/index.php?id=" . $pid . "&error=FILETYPE_NOT_ALLOWED"); }

    // Remove the old image from the directory
    unlink("../resources/prod/img/" . $oldImage);
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Login User: Starts a session given correct email and pwd
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function loginUser($conn, $email, $pwd) {
    $userArr = fetch_user($conn, NULL, $email);

    // Wrong username
    if ($userArr == false) {
      header("location: /bookworm/pages/login?error=WRONG_LOGIN");
      exit();
    }
    // Wrong password
    if (!checkPassword($pwd, $userArr['pwd_salt'], $userArr['pwd_sha256'])) {
      header("location: /bookworm/pages/login?error=WRONG_LOGIN");
      exit();
    }
    // Correct username and password
    else {
      session_start();
      $_SESSION["uid"] = $userArr["id"];
      header("location: /bookworm/");
      exit();
    }
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Delete Account: Deletes account from database if correct pwd is provided
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function deleteAccount($conn, $uid, $pwd) {
    $result = $conn->query("SELECT * FROM order_parent WHERE uid=$uid;");
    $userArr = fetch_user($conn, $uid, null);

    // Wrong password
    if (!checkPassword($pwd, $userArr['pwd_salt'], $userArr['pwd_sha256'])) {
      header("location: /bookworm/pages/delete_account?error=WRONG_PASSWORD");
      exit();
    }
    // Order(s) exist
    elseif ($result->fetch_assoc()) {
      header("location: /bookworm/pages/delete_account?error=ORDER_EXISTS");
      exit();
    }
    else {
      // Remove reviews
      $result = $conn->query("SELECT des_dir FROM review WHERE uid=$uid;");
      if ($reviewDir = $result->fetch_assoc()) {
        $review = substr($reviewDir['des_dir'], 29);
        unlink("../resources/prod/rev/" . $review);
      }

      $sql = "DELETE FROM review WHERE uid=$uid;";
      $conn->query($sql);

      // Empty accounts cart
      $sql = "DELETE FROM cart_item WHERE uid=$uid;";
      $conn->query($sql);

      // Delete user
      $sql = "DELETE FROM user WHERE id=$uid;";
      $conn->query($sql);
    }
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Place Order: Place an order on one or multiple items
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function placeOrder($conn, $fname, $lname, $address, $zipcode, $city, $country, $email, $uid) {
    /* Tell mysqli to throw an exception if an error occurs */
    //mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn->begin_transaction();

    //try {
      // Add order parent
      $sql = "INSERT INTO order_parent (fname, lname, address, zip_code, city, country, email, status, uid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);

      $status = "PENDING";
      mysqli_stmt_bind_param($stmt, "ssssssssi", $fname, $lname, $address, $zipcode, $city, $country, $email, $status, $uid);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      // Add order items
      $result = $conn->query("SELECT LAST_INSERT_ID();");
      if ($result2 = $result->fetch_assoc()) {
        $oid = $result2["LAST_INSERT_ID()"];

        $cartArr = fetch_cart($conn, $uid);

        while ($item = $cartArr->fetch_assoc()) {
          $cartArrUpdated = fetch_cart($conn, $uid); // Cart must be fetched every time an item is added, to check the stock
          $itemUpdated = $cartArrUpdated->fetch_assoc();
          if ($itemUpdated["stock"] == 0) {
            //throw new Exception("Empty stock.");
            $conn->rollback();
            header("location: /bookworm/pages/checkout?error=ORDER_NOT_PLACED");
            exit();
          }
          $id = $item["id"];
          $price = $item["price"];
          $ISBN = $item["ISBN"];
          createOrderItem($conn, $oid, $id, $price, $ISBN, $uid);
        }

        // Commit changes if this point is reached
        $conn->commit();

        header("location: /bookworm/pages/checkout_done?status=ORDER_PLACED");
        exit();
      }
    //}
    /*catch (mysqli_sql_exception $exception) {
      $conn->rollback();
      throw $exception;
    }
    catch (Exception $e) {
      $conn->rollback();
      header("location: /bookworm/pages/checkout?error=ORDER_NOT_PLACED");
      exit();
    }*/
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Create Order Item: Create an id for an item in an order
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function createOrderItem($conn, $oid, $id, $price, $ISBN, $uid) {
    $sql = "INSERT INTO order_item (oid, price, ISBN) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "iis", $oid, $price, $ISBN);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Decrease stock by one
    $conn->query("UPDATE product SET stock=stock-1 WHERE id=$id;");

    // Remove item from cart
    $conn->query("DELETE FROM cart_item WHERE pid=$id AND uid=$uid LIMIT 1");
  }

 ?>
