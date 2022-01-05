<?php
  session_start();
  include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/dbh.inc.php';
  include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/functions.inc.php';
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="/bookworm/resources/css/style.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
     <title></title>
   </head>
   <body>

     <div class="header">
       <a href='/bookworm/' style='text-decoration: none; color: white'>Bookworm</a>
       <?php

       // Variables
       $is_signedin = isset($_SESSION["uid"]);
       $is_admin = false;
       $user = null;

        // Not Signed in
        if (!$is_signedin) {
          echo "<li> <a href='/bookworm/pages/signup'><i class='bi-pencil-square'></i> Sign Up</a> </li>";
          echo "<li> <a href='/bookworm/pages/login'><i class='bi-person-fill'></i> Log In</a> </li>";
        }
        // Signed in
        else {
          $user = fetch_user($conn, $_SESSION["uid"], null);
          $is_admin = ($is_signedin && $user['admin'] == 1);

          // Customer
          if (!$is_admin) {
            echo "<li> <a href='/bookworm/includes/logout.inc.php'><i class='bi-box-arrow-left'></i> Log Out</a> </li>";
            echo "<li> <a href='/bookworm/pages/cart/index.php'><i class='bi-bag-fill'></i> Cart</a> </li>";
            echo "<li> <a href='/bookworm/pages/profile'><i class='bi-person-circle'></i> " . $user['fname'] . " " . $user['lname'] . "</a> </li>";
          }
          // Administrator
          else {
            echo "<li> <a href='/bookworm/includes/logout.inc.php'><i class='bi-box-arrow-left'></i> Log Out</a> </li>";
            echo "<li> <a href='/bookworm/pages/add_item'><i class='bi-file-plus-fill'></i> Add Book</a></li>";
            echo "<li> <a href='/bookworm/pages/profile'><i class='bi-person-circle'></i> " . $user['fname'] . " " . $user['lname'] . " [Admin]</a> </li>";
          }
        }

        ?>
        <li> <a href='/bookworm/'><i class='bi-book'></i> Browse</a> </li>
     </div>

  </body>
</html>
