#!/usr/bin/python3
#import cgitb
#cgitb.enable()
#print("Content-Type:text/html\r\n\r\n")
#print("Hello Python!")

from flask import Flask


from flask import request
from flask import Markup
from flask import jsonify
from flask import render_template
from flask import Response
import urllib.request
import json
from fhirclient import client
import requests

import fhirclient.models.patient as p
import fhirclient.models.medicationstatement as ms

# Try 'Duck' as a name when searching vonk.fire.ly
# Try 'Thiel' as a name when searching smarthealthit.org

settings = {
    'app_id': 'my_web_app',
    'api_base': 'https://r3.smarthealthit.org'
}
smart = client.FHIRClient(settings=settings)
prep = smart.prepare()


app = Flask(__name__)
@app.route("/")
def index():
	return "Welcome home."


@app.route("/smartapp/", methods=['GET', 'POST'])
def smartapp():
	return render_template('smartapp.html');

@app.route("/smartlaunch/", methods=['GET', 'POST'])
def smartlaunch():
	return render_template('smartlaunch.html');


@app.route("/form/", methods=['GET', 'POST'])
def form():
	if request.method == 'GET':
		return '''
			<form method="post">
				Search for a Name: <input type="text" name="text1" />
				<input type="submit" name="Search" value="Search" />
			</form>
		'''
	else:
		output = ""
		dataUrl = settings['api_base'] + "/Patient/?name="+request.form.get('text1')
		response = (requests.get(dataUrl).text)
		data = json.loads(response)
		print(type(data))
		patients = data.get('entry')
#		with urllib.request.urlopen(dataUrl) as response:
#			patients = json.loads( response.read() );
		output = "<table>"
		for entry in patients:
			patient = entry.get('resource')
			output = output + "<tr>"
			output = output	+ "<td><a href='/patient/"+patient.get('id')+"'>";
			output = output + patient.get('name')[0].get('given')[0] + " " + patient.get('name')[0].get('family') + " (" + patient.get('id') + ")";
							
			output = output + "</a></td>"
			output = output + "</tr>"
		output = output + "</table>"
		return render_template('search.html', output = Markup(output));
#		return Response( output , mimetype='text/json')



@app.route("/patient/", defaults={'id':None})
@app.route("/patient/<id>/")
def patient(id):
#	helloval = request.args.get('hello');
	output = "<p>";
	try:
		patient = p.Patient.read(id, smart.server)
		output = "<h2>" + id + "</h2><p>" + patient.name[0].given[0] + " " + patient.name[0].family + "</p>"
		search = ms.MedicationStatement.where({'patient':id});
		meds = search.perform_resources(smart.server)
		medslist = {}
		serializablemedarray = []
		for med in meds:
			serializablemedarray.append(med.as_json());
			mlkey = False;
			# Try to get an existent 'mlkey' with name of medicine from varying structures
			try:
				mlkey = med.medicationCodeableConcept.text
			except:
				mlKey = False
			try:
				mlkey = med.contained[0].code.coding[0].display
			except:
				mlKey = False
			try:
				mlkey = med.medicationCodeableConcept.coding[0].display
			except:
				mlKey = False
			if (mlkey is not False) and (mlkey in medslist):
				medslist[mlkey]['instances'].append(med.as_json())
			else:
				medslist[mlkey] = {}
				medslist[mlkey]['instances'] = []
				medslist[mlkey]['name'] = mlkey
		output = output + "<h4>Medications</h4><ul>";
		for m in medslist:
			output = output + "<li>" + medslist[m]['name'] + "</li>" 
		output = output + "</ul>";
	except:
		output = "Cannot find a patient based on the ID provided."
#	return Response( json.dumps(medslist) , mimetype='text/json' );
#	return Response( json.dumps(serializablemedarray) , mimetype='text/json')
	return output;



if __name__ == "__main__":
	app.run()





	
