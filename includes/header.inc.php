<?php
  session_start();
  include_once 'dbh.inc.php';
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="/bookworm/resources/css/style.css">
     <title></title>
   </head>
   <body>

     <div class="header">
       <h2>Bookworm</h2>
       <li><a href='/bookworm/'>Browse</a><li>
       <li><a href='/bookworm/pages/cart/index.php'>Cart</a><li>
       <?php
         if (isset($_SESSION["uid"])) {
           echo "<li><a href='/bookworm/pages/logout'>Log Out</a><li>";
           echo "<li><a href='/bookworm/pages/profile'>Profile</a><li>";
         }
         else {
           echo "<li><a href='/bookworm/pages/login'>Log In</a><li>";
           echo "<li><a href='/bookworm/pages/signup'>Sign Up</a><li>";
         }
        ?>
     </div>

  </body>
</html>
