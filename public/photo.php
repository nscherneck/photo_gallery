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


  if (isset($_POST['submit'])) { // form has been submitted
	  $author = trim($_POST['author']);
	  $body = trim($_POST['body']);
    $tmp_id = NULL;

	  $new_comment = Comment::make($photo->id, $author, $body, $tmp_id);
	  if($new_comment) {
      // comment saved
			// No message needed; seeing the comment is proof enough.

	    // Important!  You could just let the page render from here.
	    // But then if the page is reloaded, the form will try
			// to resubmit the comment. So redirect instead:
      $new_comment->id = 0;
      if($new_comment->create()) {
        $session->message = "Success.";
        $new_url = "photo.php?id=" . $photo->id;

        $new_comment->try_to_send_notification();
        
        header($new_url);
      } else {
        $session->message = "Could not save to the database.";
      }
      // $session->message = "Object created.";
	    // redirect_to("photo.php?id={$photo->id}");

		} else {
			// Failed
	    $session->message = "There was an error that prevented the comment from being saved.";
		}
	} else {
		$author = "";
		$body = "";
	}

$comments = $photo->comments();

?>

<?php include_layout_template('header.php'); ?>

<a href="gallery.php">&laquo; Back</a>
<br><br>

<div style="margin-left: 20px;">
  <img src="<?php echo $photo->image_path(); ?>" width="750px">
  <h4><?php echo $photo->caption; ?></h4>

  <hr class="dash">

  <div id="comments">
    <?php foreach($comments as $comment): ?>
      <div class="comment" style="margin-bottom: 1em; margin-top: 1em;">
        <div class="body">
          <h5><?php echo strip_tags($comment->body, '<strong><em><p>'); ?></h5>
        </div>
        <div class="author" style="font-size: 0.8em;">
          <?php echo "By: " . htmlentities($comment->author); ?>
        </div>
        <div class="meta-info" style="font-size: 0.8em;">
          <?php echo "On: " . datetime_to_text($comment->created); ?>
        </div>
      </div>
      <hr class="dash">
    <?php endforeach; ?>
    <?php if(empty($comments)) { echo "<h5>No comments.</h5><hr class=\"dash\">"; } ?>
  </div>



</div>

<!-- list comments -->




<div id="comment-form">
  <h5>Add a New Comment</h5>
  <?php echo output_message($session->message); ?>
  <form action="photo.php?id=<?php echo $photo->id; ?>" method="post">
    <table>
      <tr>
        <td>Your name:</td>
        <td><input type="text" name="author"></td>
      </tr>
      <tr>
        <td>Your comment:</td>
        <td><textarea name="body" cols="40" rows="8"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="submit" value="Submit Comment" /></td>
      </tr>
    </table>
  </form>
</div>




<?php include_layout_template('footer.php'); ?>
