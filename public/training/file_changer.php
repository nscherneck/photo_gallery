<?php

echo fileowner('file_permissions.php') . "<br>";

// if we have Posix installed
$owner_id = fileowner('file_permissions.php');
$owner_array = posix_getpwuid($owner_id);

echo $owner_array['name'] . "<br>";

// echo fileperms('file_permissions');
// echo substr(decoct(fileperms('file_permissions')), 2);
// chmod('file_permissions', 0777)

echo is_readable('file_permissions') ? "yes<br>" : "no<br>";
echo is_writeable('file_permissions') ? "yes<br>" : "no<br>";

?>
