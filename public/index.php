<?php require_once("../includes/initialize.php"); ?>

<?php include_layout_template('header.php'); ?>

      <h2>Welcome!</h2>

<?php

$user = User::find_by_id(11);
echo $user->full_name();

echo "<hr />";

$users = User::find_all();
foreach($users as $user) {
  echo "User: ". $user->username ."<br />";
  echo "Name: ". $user->full_name() ."<br /><br />";
}

?>

<?php include_layout_template('footer.php'); ?>
