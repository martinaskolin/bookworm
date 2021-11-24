<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <?php require_once '../../includes/header.inc.php';
          require_once '../../includes/cart.inc.php';
          require_once '../../includes/dbh.inc.php';
          require_once '../../includes/functions.inc.php';
          require_once '../../includes/user.inc.php';


          //Function to print out the user's name
          if (isset($_SESSION["id"])){
            $userArr = fetch_user($conn, $_SESSION["id"], null);
            $data1 = "Hello ";
            $data2 = $userArr['fname'];

            echo "<h1>" . $data1 . $data2 . "! </h1>";
          }

          else {
            echo "<h1> Please log in to access your profile </h1>";
          }




          ?>
    </body>
    </html>
