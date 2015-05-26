CREATE TABLE permission (id INTEGER PRIMARY KEY AUTOINCREMENT,
	                     user_id INTEGER,
                         scope VARCHAR(256),
                         right INTEGER);

ALTER TABLE user ADD COLUMN rsa_key TEXT;
ALTER TABLE user ADD COLUMN lastconn INTEGER NOT NULL DEFAULT 0;
ALTER TABLE corecfg ADD COLUMN active_strat VARCHAR;
DROP TABLE strategy;






