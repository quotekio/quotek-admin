CREATE TABLE permission (id INTEGER PRIMARY KEY,
	                     user_id INTEGER,
                         application VARCHAR(256),
                         right INTEGER);

ALTER TABLE user add column rsa_key TEXT;

