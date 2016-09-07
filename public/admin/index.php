<?php //index.php
require_once ("../../includes/initialize.php");

if(!$session->is_logged_in()) {redirect_to("login.php");}

?>

<?php include_layout_template('admin_header.php'); ?>

      <h2>Menu</h2>
      <a href="logfile.php">Event Log</a><br>
      <a href="logout.php">Logout</a><br>

<?php include_layout_template('admin_footer.php'); ?>
