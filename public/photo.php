<?php require_once("../includes/initialize.php");

if(empty($_GET['id'])) {
  $session->message("No photograph ID was provided.");
  redirect_to("index.php");
}

$photo = Photograph::find_by_id($_GET['id']);
  if(!$photo) {
    $session->message("Photo could not be located.");
    redirect_to("index.php");
  }

?>

<?php include_layout_template('header.php'); ?>

<a href="gallery.php">&laquo; Back</a>
<br><br>

<div style="margin-left: 20px;">
  <img src="<?php echo $photo->image_path(); ?>" width="750px">
  <p><?php echo $photo->caption; ?></p>
</div>



<?php include_layout_template('footer.php'); ?>
