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
       Bookworm
       <?php
         if (isset($_SESSION["uid"])) {
           include_once $_SERVER['DOCUMENT_ROOT'] . '/bookworm/includes/functions.inc.php';
           $userArr = fetch_user($conn, $_SESSION["uid"], null);

           echo "<li class='grow'> <a href='/bookworm/includes/logout.inc.php'>Log Out <i class='bi-box-arrow-left'></i></a> </li>";
           echo "<li class='grow'> <a href='/bookworm/pages/cart/index.php'>Cart <i class='bi-bag-fill'></i></a> </li>";
           echo "<li class='grow'> <a href='/bookworm/pages/profile'>" . $userArr['fname'] . " " . $userArr['lname'] . " <i class='bi-person-circle'></i></a> </li>";
         }
         else {
           echo "<li class='grow'> <a href='/bookworm/pages/signup'>Sign Up <i class='bi-pencil-square'></i> </a> </li>";
           echo "<li class='grow'> <a href='/bookworm/pages/login'>Log In <i class='bi-person-fill'></i></a> </li>";
         }
        ?>
        <li class='grow'> <a href='/bookworm/'>Browse <i class='bi-book'></i></a> </li>
     </div>

  </body>
</html>
