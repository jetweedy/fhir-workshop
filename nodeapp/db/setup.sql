CREATE DATABASE fhirapp;
CREATE USER fhirapp IDENTIFIED BY 'fhirapp';
GRANT ALL PRIVILEGES ON fhirapp.* TO fhirapp;

/*
CREATE TABLE IF NOT EXISTS fhirapp_users (
		id int not null auto_increment primary key
		, email varchar(200)
		, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	);
*/
