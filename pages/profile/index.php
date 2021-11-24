<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
  </head>
  <body>

    <?php include_once '../../includes/header.inc.php'; ?>

    <section class="editprofile-form">
      <form action="../../includes/editprofile.inc.php" method="post">
        <input type="text" name="newFname" placeholder="Edit First Name...">
        <input type="text" name="newLname" placeholder="Edit Last Name...">
        <input type="text" name="newEmail" placeholder="New Email...">
        <input type="password" name="newPwd" placeholder="New Password...">
        <input type="password" name="oldPwd" placeholder="Old Password...">
        <button type="submit" name="submit">Save</button>
      </form>
    </section>

  </body>
</html>
