<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bookworm/pages/login/style.css">
    <title></title>
  </head>
  <body>

    <?php include_once '../../includes/header.inc.php'; ?>

    <div class="login-div">
      <div class="login-header">
        <p>Log In To Account</p>
      </div>

      <section class="login-form">
        <form action="../../includes/login.inc.php" method="post">
          <input type="text" name="email" placeholder="Email...">
          <input type="password" name="pwd" placeholder="Password...">
          <button type="submit" name="submit">Log In</button>
        </form>
      </section>
    </div>
  </body>
</html>
