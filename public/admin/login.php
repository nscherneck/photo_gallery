<?php //login.php
require_once ("../../includes/initialize.php");

if($session->is_logged_in()) {
  redirect_to("index.php");
}

if (isset($_POST['submit'])) { // form has been submitted

  $username = trim($_POST['username']);
  $password = trim($_POST['password']);

  // check database for username/password
  $found_user = User::authenticate($username, $password);

  if($found_user) {
      $session->login($found_user);
      log_action("Login: ", $username . " logged in.");
      redirect_to("index.php");
      } else {
          $message = "Username / password combination is incorrect.";
      }
} else { // form has not been submitted
  $username = "";
  $password = "";
  $message = "Enter Username and Password";
}
?>

<html>
  <head>
    <link href="../stylesheets/main.css" media="all" rel="stylesheet" type="text/css" />
    <title></title>
  </head>
  <body>
    <div id="header">
      <h1>Photo Gallery</h1>
      <p><a href="../index.php">Home</a> | <a href="../gallery.php">Photo Gallery</a> | <a href="register.php">Register</a>
    </div>
    <div id="main">

      <h2>Staff Login</h2>
      <?php echo output_message($message); ?>

      <form action="login.php" method="post">
        <table>
          <tr>
            <td>Username:</td>
            <td>
              <input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
            </td>
          </tr>
          <tr>
            <td>Password:</td>
            <td>
              <input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" />
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <input type="submit" name="submit" value="Login">
            </td>
          </tr>
        </table>
      </form>

<?php include_layout_template('footer.php'); ?>
