<?php

include("./fun.php");

header("Content-type:text/json");
$json = isset($_POST['data']) ? $_POST['data'] : false;
$x = new stdClass();
//print $json;
try {
    $data = json_decode($json);
} catch(Exception $err) {
    $data = false;
}
if (!!$data) {
    $x->data = $data;
    $x->pid = $data->id;
    file_put_contents("./patients/".$x->pid.".txt", json_encode($x->data));
} else {
    $x->error = "No data received.";
}
$json = json_encode($x);
print $json;

?>