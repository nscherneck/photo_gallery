<?php

// we already used:
// dirname()
// is_dir()

// getcwd() current working directory
echo getcwd() . "<br>";
echo "<hr>";

// mkdir()

if(!is_dir('new')) {
  if(mkdir('CTL/Belmont CO/Bldg FA/Reports', 0777, true)) { // 0777 is the PHP default and is "wide open"
    echo "New directory created";
  } else {
    echo "Not created";
  }
} else {
  echo "Directory already exists.";
}

echo "<hr>";

// changing dirs
chdir('CTL');
echo "Current working directory: " . getcwd() . "<br>";

echo "<hr>";

// removing directories
$dir_to_remove = 'Belmont CO/Bldg FA/Reports'; // only removes the Reports directory (cannot remove directories recursively)
if(rmdir($dir_to_remove)) {
    echo $dir_to_remove . " has been removed.";
    echo "<hr>";
    chdir('..');
    echo "Current working directory: " . getcwd() . "<br>";
} else {
  echo "Could not remove " . $dir_to_remove;
}

// directories must be closed and EMPTY before removal (and be careful)
// scripts to help wipe out directories with files:
// http://www.php.net/manual/en/function.rmdir.php

 ?>
