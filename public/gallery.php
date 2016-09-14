<?php require_once("../includes/initialize.php"); ?>

<?php include_layout_template('header.php'); ?>

      <h2>Uploaded Photos</h2>

<?php
$photos = Photograph::find_all();
foreach($photos as $photo) {
  echo "<div id=\"photo\">" . PHP_EOL;
  echo "<a href=\"photo.php?id={$photo->id}\">";
  echo "<img src=\"../" . $photo->image_path() . "\" width=\"300px\" height=\"auto\">" . "</a>" . PHP_EOL;
  echo "<p>" . $photo->caption . "</p>" . PHP_EOL;
  echo "</div>" . PHP_EOL ;
}


?>

<?php include_layout_template('footer.php'); ?>
