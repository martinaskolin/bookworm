<?php

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Check Password: returns true if password match hashed version
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function checkPassword($raw_pwd, $raw_salt, $hashed_pwd) {
    return 0 == strcmp(hash("sha256", $raw_pwd . $raw_salt), $hashed_pwd);
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
  // Check Email: returns true if email is ok
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function checkEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return true;
    }
    return false;
  }

  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  // Display Products: Displays all products specified
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function displayProducts($conn) {
    $sql = "SELECT * FROM product;"; // change later to filter products
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // Display all results from query
      while ($product = $result->fetch_assoc()){
        $sql = "SELECT * FROM product_add pa inner join product p on pa.pid = p.id WHERE p.id = '" . $product['id'] . "'"; // change to more time efficient solution
        $result_add = $conn->query($sql);

        echo "<div>";
        // Fetch additional information
        if ($result_add->num_rows == 1) {
          $product_add = $result_add->fetch_assoc();
          echo "<img src='" . $product_add['img_dir'] . "'>";
        }
        else { echo "<img src='/bookworm/resources/images/img_missing.jpg'>"; }

        echo "<p>" . $product['name'] . "</p>";
        echo "<a href=''> " . $product['price'] . " <i class='bi-bag-fill'></i> </a>";
        echo "</div>";
      }
    }
  else { echo "No match could be found"; }
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
  // Create User: Creates a user from param.
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function createUser($conn, $fname, $lname, $email, $pwd) {
    $sql = "INSERT INTO user (fname, lname, email, pwd_sha256, pwd_salt) VALUES (?, ?, ?, ?, ?);";
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
  // Login User: Starts a session given correct email and pwd
  // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
  function loginUser($conn, $email, $pwd) {
    $userArr = fetch_user($conn, null ,$email);

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
      header("location: /bookworm/index.php");
      exit();
    }
  }

 ?>
