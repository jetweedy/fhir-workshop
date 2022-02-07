<?php
include("./fun.php");

//$pid = "67cbf090-4ddb-4799-99ff-a28abe2740b1";
$pid = "8cf51fe2-bfc1-4284-9c17-d667d902f463";
if (isset($_GET['pid'])) { $pid = $_GET['pid']; }

$jkid = date("Ymdhis").generateRandomString(5);
$jkey = generateRandomString(50);
?>

<pre>

Visit this Demo Launcher and view one of the Patients in the Patient Portal...
<a href="https://launch.smarthealthit.org/" target="_blank">http://launch.smarthealthit.org/</a>

... using this URL in the field at the bottom of the form and Launch:
<a href="https://jonathantweedy.com/FHIR/launch1/smartlaunch/<?php print $jkid; ?>/<?php print $jkey; ?>" target="_blank">https://jonathantweedy.com/FHIR/launch1/smartlaunch/<?php print $jkid; ?>/<?php print $jkey; ?></a>

If you wish to use another patient ID, include it at the top of this page like this:
index.php?pid=DESIRED_PATIENT_ID

<!--
Here's a sample patient link. You can reload this page to get a different patient link by using ?pid=YOUR_DESIRED_PATIENT_ID
<a target="_blank" href="https://launch.smarthealthit.org/ehr.html?app=https%3A%2F%2Fjonathantweedy.com%2FFHIR%2Flaunch1%2Fsmartlaunch%2F<?php print $jkid; ?>%2F<?php print $jkey; ?>%3Flaunch%3DeyJhIjoiMSIsImsiOiIxIiwiYiI6IjY3Y2JmMDkwLTRkZGItNDc5OS05OWZmLWEyOGFiZTI3NDBiMSIsImYiOiIxIn0%26iss%3Dhttps%253A%252F%252Flaunch.smarthealthit.org%252Fv%252Fr4%252Ffhir&user=<?php print $pid; ?>">Click here to access the sample patient.</a>
-->


<!--
SAMPLE URL TO VIEW A PATIENT'S DATA STORED FROM ONE OF THESE CALLS:
https://jonathantweedy.com/FHIR/launch1/viewPatient.php?pid=8cf51fe2-bfc1-4284-9c17-d667d902f463

-->

Upon logging in to a patient, their vax data should get dumped into a folder with their ID in this directory:
<a href="./patients/">./patients/</a>

</pre>

