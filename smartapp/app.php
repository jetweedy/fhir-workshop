<?php
include("./fun.php");
/*
$x = new stdClass();
$x->POST = $_POST;
$x->GET= $_GET;
$json = json_encode($x);
file_put_contents("redirect_uri.txt", $json);
header("Content-type:json");
print $json;
*/


?>

<html>
<head>
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/fhirclient/build/fhir-client.js"></script>
</head>
<body>
<pre id="output">
</pre>
<script type="text/javascript">
    FHIR.oauth2.ready(function(client){
        $("#output").html(JSON.stringify(client, null, 2));
    });
</script>
</body>
</html>