<?php //index.php
require_once ("../../includes/initialize.php");

if(!$session->is_logged_in()) {redirect_to("login.php");}

?>

<?php include_layout_template('admin_header.php'); ?>

<?php

$user = new User();
$user->username = "bdugan";
$user->password = "daniel";
$user->first_name = "Bill";
$user->last_name = "Dugan";
$user->create();

// $user = User::find_by_id(17);
// $user->password = "yolanda";
// $user->save();

$user = User::find_by_id(18);
$user->delete();

echo $user->first_name;


 ?>

<?php include_layout_template('admin_footer.php'); ?>
