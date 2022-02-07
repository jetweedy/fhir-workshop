<?php

//header("Content-type:text/json");
include("./fun.php");
$pid = grabVar("pid");
if ($pid=="") { $pid = "8cf51fe2-bfc1-4284-9c17-d667d902f463"; }
if (file_exists("./patients/".$pid.".txt")) {
    $json = file_get_contents("./patients/".$pid.".txt");
    $data = json_decode($json);
//    print_r($data);
    foreach($data->images as $image) {
        print "<img src='data:image/jpeg;base64,".$image."' />";
    }
//    print $json;
}

?>