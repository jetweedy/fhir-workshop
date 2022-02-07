	# Smart on FHIR Python and HTML Tools

Flask routing demo, as well as the launch/index files for the SMART on FHIR launch example.

## Demo

(Coming soon...)

## Installing it yourself

Assuming you have a cgi/python-enabled web server, then first make sure you have flash installed. We're assuming Python3, so depending on your installation of python and pip, one of these should work.

```
pip3 install flask
pip install flask
python -m pip install flask
python3 -m pip install flask
```

Then you'll want to specifically install a few other things (now I'm just assuming 'pip' works... modify appropriately):

```
pip install fhirclient
pip install gunicorn
```

## Running the Application:

If you trust your network and/or you're in something like Virtualbox/Vagrant:
```
flask run --host=0.0.0.0
```

This allows someone other than the Vagrant box itself (like your host computer) to view the site in a browser.