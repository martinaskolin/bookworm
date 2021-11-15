<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <?php include_once '../../includes/header.inc.php'; ?>

    <section class="signup-form">
      <form action="../../includes/signup.inc.php" method="post">
        <input type="text" name="fname" placeholder="First Name...">
        <input type="text" name="lname" placeholder="Last Name...">
        <input type="text" name="email" placeholder="Email...">
        <input type="password" name="pwd" placeholder="Password...">
        <button type="submit" name="submit">Sign Up</button>
      </form>
    </section>

  </body>
</html>
