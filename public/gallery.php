<?php require_once("../includes/initialize.php"); ?>

<?php

// 1. The current page number ($current_page)
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

// 2. Records per page ($per_page)
$per_page = 8;

// 3. Total record count ($total_count)
$total_count = Photograph::count_all();

// find all photos
// $photos = Photograph::find_all();

$pagination = new Pagination($page, $per_page, $total_count);

// instead of finding all records, just find the records for this page

$sql = "SELECT * FROM photographs LIMIT {$per_page} OFFSET {$pagination->offset()}";
$photos = Photograph::find_by_sql($sql);

  // neet to add ?page=$page to all links we want to
  // maintain the current page (or store $page in session)

 ?>

<?php include_layout_template('header.php'); ?>

      <h2>Uploaded Photos</h2>

<?php
// $photos = Photograph::find_all();
foreach($photos as $photo) {
  echo "<div id=\"photo\">" . PHP_EOL;
  echo "<a href=\"photo.php?id={$photo->id}\">";
  echo "<img src=\"../" . $photo->image_path() . "\" width=\"300px\" height=\"auto\">" . "</a>" . PHP_EOL;
  echo "<p>" . $photo->caption . "</p>" . PHP_EOL;
  echo "</div>" . PHP_EOL ;
}

?>

<div id="pagination" style="clear: both;">

<?php

  if($pagination->total_pages() > 1) {

    if($pagination->has_previous_page()) {
      echo " <a href=\"gallery.php?page=";
      echo $pagination->previous_page();
      echo "\">&laquo; Previous</a> ";
    }

    for($i=1; $i <= $pagination->total_pages(); $i++) {
      if($i == $page) {
        echo "<span class=\"selected\">{$i}</span>";
      } else {
      echo " <a href=\"gallery.php?page={$i}\">{$i}</a> ";
      }
    }

    if($pagination->has_next_page()) {
      echo " <a href=\"gallery.php?page=";
      echo $pagination->next_page();
      echo "\">Next &raquo;</a> ";
    }

  }
?>
</div>

<?php include_layout_template('footer.php'); ?>
