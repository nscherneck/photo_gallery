<?php

// close files first. can't delete open files.
// must have write permission on the folder containing the file

// delete files carefully with:

if(unlink('filetest.txt')) {
  echo "File deleted successfully";
} else {
  echo "File not deleted";
}



?>
