#!/usr/bin/python3
import cgitb
cgitb.enable()
print("Content-Type:text/json\r\n\r\n")

import json
from fhirclient import client
import fhirclient.models.patient as p

def pretty(js):
    return json.dumps(js, indent=2)
def prettyprint(x):
    print(pretty(x))

settings = {
    'app_id': 'my_web_app',
    'api_base': 'https://r3.smarthealthit.org'
}
smart = client.FHIRClient(settings=settings)
prep = smart.prepare()
search = p.Patient.where({'name':'Smith'})
patients = search.perform_resources(smart.server)
### Create a serializable array of the patients
serializablepatientarray = []
for patient in patients:
    serializablepatientarray.append(patient.as_json());
prettyprint(serializablepatientarray)

