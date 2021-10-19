
//// Initiatlize an NPM project and Require a few more libraries that will require installation:
/*
npm init -y
npm install dotenv
npm install express
npm install ws
*/


//// Require the db tools
//const {ConnectionString} = require('connection-string');
//const db = require('./db/db');

const path = require('path');
require('dotenv').config()
const PORT = process.env.PORT || 3000;
const express = require('express');
//const socks = require('ws').Server;


//// Now create and start up a server instance with express, with a few specifications:
const server = express()
	//// Use ejs
	.set('view engine', 'ejs')
	//// We'll also use the /public directory as a static folder
	//// Anything that goes to /public/whatever. will just serve up whatever.file
	//// This is useful for using external JS and CSS in our index.html file, for example
	//// And finally, let's listen on our PORT so we can visit this app in a browser
	.use('/public', express.static('public'))
	.use(express.urlencoded({extended:true}))
	//// Specify a 'get' route for the homepage:
	.get('/', function(req, res){
		//// We'll just be serving up the index.html that's in the 'public' folder
//		res.sendFile(path.join(__dirname, 'public/index.html'));
		res.render('index', {});
	})
	.listen(PORT, () => console.log("Listening on PORT " + PORT))
	;



/*
const wss = new socks({ server });
wss.on('connection', (ws) => {
	ws._data = {}
	ws.on('close', () => console.log('Client disconnected'));
	ws.on('message', message => {
		let mdata = JSON.parse(message);
		if (mdata.action=="init") {
			console.log(mdata.message);
			ws._data.bpm_id = mdata.bpm_id;
            var m = {action:"log", content:"Welcome!", bpm_id: mdata.bpm_id};
			ws.send(JSON.stringify(m));
		}
		if (mdata.action=="bpm") {
			console.log("bpm received from browser: ", mdata.bpm, ws._data.bpm_id);
            var m = {action:"bpm", bpm:mdata.bpm};
//			ws.send(JSON.stringify(m));
		    wss.clients.forEach((ws) => {
				if (ws._data.bpm_id == mdata.bpm_id) {
			        ws.send(JSON.stringify(m));
				}
		    });


		}
	})
})
*/