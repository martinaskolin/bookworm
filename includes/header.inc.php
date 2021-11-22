<?php
  session_start();
  include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/dbh.inc.php';
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
       <h2>Bookworm</h2>
       <li> <a href='/bookworm/'>Browse</a> </li>
       <?php
         if (isset($_SESSION["uid"])) {
           include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/functions.inc.php';
           $userArr = fetch_user($conn, $_SESSION["uid"], null);

           echo "<li> <a href='/bookworm/includes/logout.inc.php'>Log Out</a> </li>";
           echo "<li> <a href='/bookworm/pages/profile'>" . $userArr['fname'] . " " . $userArr['lname'] . "</a> </li>";
           echo "<li> <a href='/bookworm/pages/cart/index.php'>Cart</a> </li>";
         }
         else {
           echo "<li> <a href='/bookworm/pages/login'>Log In</a> </li>";
           echo "<li> <a href='/bookworm/pages/signup'>Sign Up</a> </li>";
         }
        ?>
     </div>

  </body>
</html>
