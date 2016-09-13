<?php //index.php
require_once ("../../includes/initialize.php");

if(!$session->is_logged_in()) {redirect_to("login.php");}

?>

<?php include_layout_template('admin_header.php'); ?>

      <h2>Event Log</h2>
      <hr>
<?php

$logfile = SITE_ROOT . DS . 'logs' . DS . 'system_log.txt';
$read_content = "";


if(isset($_GET['clear']) && ($_GET['clear'] == 'true')) {
  file_put_contents($logfile, '');
  log_action('LOG CLEARED ', "by USER ID {$session->user_id}");
  redirect_to("logfile.php");
}

if(!(is_file($logfile))) {
  echo "Error: system log file not found.";
}

if($handle = fopen($logfile, 'r')) {
  while(!feof($handle)) {
    $read_content .= fgets($handle);
  }
  } else {
    echo "Error: system log file is not readable.";
  }
  fclose($handle);


echo "<pre>" . nl2br($read_content) . "</pre>";

?>

<a href="logfile.php?clear=true">Clear Log File</a>

<?php include_layout_template('admin_footer.php'); ?>
