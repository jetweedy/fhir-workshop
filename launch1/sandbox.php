<?php
include("./fun.php");
$jkid = grabVar("kid");
$jkey = grabVar("key");

header("Content-type:text/plain");
print_r($_GET);

?>