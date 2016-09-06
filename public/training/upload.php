<?php


 ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

    <?php
      // The maximum file size (in bytes) must be declared before the file input field
      // and can't be larger than the setting for upload_max_filesize in php.ini.
      //
      // This form value can be manipulated. You should still use it, but you rely on
      // upload_max_filesize as the absolute limit.
      //
      // Think of it as a polite declaration: "Hey PHP, here comes a file less than X...."
      // PHP will stop and complain once X is exceeded.
      //
      // 1 megabyte is actually 1,048,576 bytes.
      // You can round it unless precision matters.

     ?>
    <?php if(!empty($message)) { echo "<p>{$message}</p>"; } ?>
    <form action="upload.php" enctype="mutipart/form-data" method="POST">

      <input type="hidden" name="MAX_FILE_SIZE" value="10485760">
      <input type="file" name="file_upload">

      <input type="submit" value="Upload">

    </form>

  </body>
</html>
