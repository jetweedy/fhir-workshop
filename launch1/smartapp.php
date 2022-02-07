<?php
include("./fun.php");
$jkid = grabVar("jkid");
$jkey = grabVar("jkey");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Example SMART App</title>
        <script src="https://cdn.jsdelivr.net/npm/fhirclient/build/fhir-client.js"></script>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

<script>
var jkid = <?php print $jkid; ?>;
var jkey = <?php print $jkey; ?>;
</script>

        <style>
            #patient, #meds {
                font-family: Monaco, monospace;
                white-space: pre;
                font-size: 13px;
                height: 30vh;
                overflow: scroll;
                border: 1px solid #CCC;
            }
        </style>
    </head>
    <body>
        <h4>Current Patient</h4>
        <div id="patient">Loading...</div>
        <br/>
        <h4>Medications</h4>
        <div id="meds">Loading...</div>
        <script type="text/javascript">
            FHIR.oauth2.ready().then(function(client) {
                
                // Render the current patient (or any error)
                client.patient.read().then(
                    function(pt) {
//                        console.log("pt.id", pt.id);
//                        console.log("pt.birthDate", pt.birthDate);
                        document.getElementById("patient").innerText = JSON.stringify(pt, null, 4);



                        // Get MedicationRequests for the selected patient
                        client.request("/Immunization?patient=" + client.patient.id, {
                            resolveReferences: [ "immunizationReference" ],
                            graph: true
                        })
                        // Reject if no MedicationRequests are found
                        .then((data) => {
                            if (!data.entry || !data.entry.length) {
                                throw new Error("No immunizations found for the selected patient");
                            }
                            return data.entry;
                        })
                        // Render the current patient's medications (or any error)
                        .then(
                            (meds) => {
                                var balls = [];
                                for (var m in meds) {
        //                            console.log(JSON.stringify(meds[m].resource, null, 2));
                                    if (meds[m].resource.vaccineCode.text.indexOf('Influenza') > -1) {
                                        var mdate = meds[m].resource.occurrenceDateTime;
                                        var mdate = Date.parse(mdate);
                                        var ndate = Date.now();
                                        var diff = Math.floor(ndate - mdate);
                                        var day = 1000 * 60 * 60 * 24;
                                        var days = Math.floor(diff/day);
                                        if (days < 1000) {
        //                                    console.log(JSON.stringify(meds[m].resource, null, 2));
                                            balls.push({
                                                "datetime": meds[m].resource.occurrenceDateTime.substring(0,10)
                                                ,
                                                "text": meds[m].resource.vaccineCode.text.substring(0
                                                    ,meds[m].resource.vaccineCode.text.indexOf(",")
                                                    )
                                            });
                                        }
                                    }
                                }
                                
                                client.request("/Media?type=image&subject=Patient/"+client.patient.id, {})
                                .then((media) => {

                                    var images = [];
                                    if (media.entry) {
                                        for (var e in media.entry) {
                                            var me = media.entry[e];
                                            console.log(me);
                                            try {
                                                mdata = me.resource.content.data;
                                                images.push(mdata);
                                            } catch(er) {
                                                console.log("er", er);
                                            };
                                            
                                        }
                                    }

                                    
                                    var pdata = {
                                        id:  pt.id
                                        ,
                                        images: images
                                        ,
                                        birthdate: pt.birthDate
                                        ,
                                        immunizations: balls                            
                                    };
                                    var getdata = encodeURIComponent(JSON.stringify(pdata));
                                    var postdata = JSON.stringify(pdata);
                                    var url = "https://trianglewebtech.com/www/FHIR/launch1/catchersmitt.php";
                                    //console.log("url", url);
                                    $.post(url, {data:postdata}, (r) => {
                                        console.log(r);
                                    });

                                    
                                });


                            },
                            function(error) {
                                document.getElementById("meds").innerText = error.stack;
                            }
                        );


        /*                
                        // Get MedicationRequests for the selected patient
                        client.request("/MedicationRequest?patient=" + client.patient.id, {
                            resolveReferences: [ "medicationReference" ],
                            graph: true
                        })
                        // Reject if no MedicationRequests are found
                        .then(function(data) {
                            if (!data.entry || !data.entry.length) {
                                throw new Error("No medications found for the selected patient");
                            }
                            return data.entry;
                        })
                        // Render the current patient's medications (or any error)
                        .then(
                            function(meds) {
                                var mdiv = document.getElementById("meds");
                                mdiv.innerHTML = "";
                                var ul = document.createElement("ul");
                                mdiv.appendChild(ul);
                                for (var m in meds) {
                                    var li = document.createElement("li");
                                    li.innerHTML = meds[m].resource.medicationCodeableConcept.text;
                                    console.log(meds[m].resource.medicationCodeableConcept.text);
                                    ul.appendChild(li);
                                }
        //                        document.getElementById("meds").innerText = JSON.stringify(meds, null, 4);
                            },
                            function(error) {
                                document.getElementById("meds").innerText = error.stack;
                            }
                        );
        */



                    },
                    function(error) {
                        document.getElementById("patient").innerText = error.stack;
                    }
                );




            }).catch(console.error);
        </script>
    </body>
</html>