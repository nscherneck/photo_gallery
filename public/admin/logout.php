<?php //logout.php
require_once ("../../includes/initialize.php");

    log_action("Logout: ", $_SESSION['username'] . " logged out.");
    $session->logout();
    redirect_to("../index.php");

?>
