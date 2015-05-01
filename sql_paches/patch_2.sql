CREATE TABLE permission (id INTEGER PRIMARY KEY,
	                     user_id INTEGER,
                         scope VARCHAR(256),
                         right INTEGER);

ALTER TABLE user add column rsa_key TEXT;
ALTER TABLE user add column lastconn INTEGER NOT NULL DEFAULT 0;




