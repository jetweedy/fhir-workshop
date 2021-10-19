from flask import Flask
from flask import request
from flask import Markup
from flask import jsonify
from flask import render_template
import urllib.request
import json
from fhirclient import client
import subprocess

app = Flask(__name__)
settings = {
	'app_id': 'my_web_app',
	'api_base': 'https://r3.smarthealthit.org/'
}

@app.route("/")
def index():
	return "Welcome home."


@app.route("/restart/")
def restart():
	subprocess.run(["heroku", "restart"])
	return ""


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
		# return 'You entered:'+request.form.get('text1');
		smart = client.FHIRClient(settings=settings)
		smart.prepare()
		import fhirclient.models.patient as p
		search = p.Patient.where({'name':request.form.get('text1')})
		patients = search.perform_resources(smart.server)
		serializablepatientarray = []
		output = "<table>"
		for patient in patients:
			output = output + "<tr>"
			output = output	+ "<td><a href='/patient/"+patient.id+"'>" + patient.name[0].given[0] + "</a></td>"
			output = output	+ "<td><a href='/patient/"+patient.id+"'>" + patient.name[0].family + "</a></td>"
			output = output + "</tr>"
		output = output + "</table>"
		return render_template('search.html', output = Markup(output));

if __name__ == "__main__":
	app.run()

@app.route("/patient/", defaults={'id':None})
@app.route("/patient/<id>/")
def patient(id):
	helloval = request.args.get('hello');
	output = "<p>";
	smart = client.FHIRClient(settings=settings)
	smart.prepare()
	smart = client.FHIRClient(settings=settings)
	import fhirclient.models.patient as p
	try:
		import fhirclient.models.patient as p
		patient = p.Patient.read(id, smart.server)
		output = "<h2>" + id + "</h2><p>" + patient.name[0].given[0] + " " + patient.name[0].family + "</p>"
	except:
		output = "Cannot find a patient based on the ID provided."
	return output;




"""


"""

	
