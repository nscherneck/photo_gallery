<?php //index.php
require_once ("../../includes/initialize.php");

if(!$session->is_logged_in()) {redirect_to("login.php");}

?>

<?php include_layout_template('admin_header.php'); ?>

      <h2>Home</h2>

      <?php echo output_message($session->message); ?>

      <?php
      $photos = Photograph::find_all();
      foreach($photos as $photo) {
        echo "<div id=\"photo\">" . PHP_EOL;
        echo "<img src=\"../" . $photo->image_path() . "\" width=\"300px\" height=\"auto\">" . PHP_EOL;
        echo "<p>" . $photo->caption . "</p>" . PHP_EOL;
        echo "<p>" . $photo->size_as_text() . "</p>" . PHP_EOL;
        echo "<p>" . $photo->id . "</p>" . PHP_EOL;
        echo "<a href=\"delete_photo.php?id={$photo->id}\">Delete</a>";
        echo "</div>" . PHP_EOL ;
      }
      ?>

<?php include_layout_template('admin_footer.php'); ?>
