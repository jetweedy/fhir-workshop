<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Example-SMART-App</title>
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/fhirclient/build/fhir-client.js"></script>
    <!--
    Because this is going through smarthealthit.org's sandbox, it's going to auto-authenticate.
    -->
    <script>
      FHIR.oauth2.authorize({
        client_id: "43cb586a-0ca1-44af-b195-3f2e72365714",
        iss: "https://r3.smarthealthit.org",
        scope: "patient/Patient.read patient/Observation.read patient/Immunization.read launch online_access openid profile",
        redirectUri: "https://jonathantweedy.com/FHIR/smartapp/app.php"
      });
    </script>
  </body>
</html>