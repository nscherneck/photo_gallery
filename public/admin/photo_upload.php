<?php //photo_upload.php
require_once ("../../includes/initialize.php");

if(!$session->is_logged_in()) {
  redirect_to("login.php");
}

$max_file_size = 10485760;

if (isset($_POST['submit'])) { // form has been submitted
  $photo = new Photograph();
  $photo->caption = $_POST['caption'];
  $photo->attach_file($_FILES['file_upload']);
  $photo->id = 0;
  if($photo->save()) {
    $session->message("{$photo->filename} was added.");
    redirect_to("list_photos.php");
  } else {
      $session->message = $photo->errors[0];
    }
}

?>

<?php include_layout_template('admin_header.php'); ?>

      <h2>Photo Upload</h2>
      <?php echo output_message($session->message); ?>

      <form action="photo_upload.php" enctype="multipart/form-data" method="POST">

        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>">
        <p><input type="file" name="file_upload"></p>
        <p><input type="text" name="caption" value=""></p>

        <input type="submit" name="submit" value="Upload">

      </form>

<?php include_layout_template('admin_footer.php'); ?>
