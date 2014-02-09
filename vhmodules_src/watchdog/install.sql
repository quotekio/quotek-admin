CREATE TABLE "watchdog_cfg" ("id" INTEGER PRIMARY KEY  NOT NULL , 
	                         "check_adam" INTEGER DEFAULT (1), 
	                         "check_gateway" INTEGER DEFAULT(0) );

CREATE TABLE "watchdog_stats" ("tstamp" INTEGER PRIMARY KEY  NOT NULL , 
	                         "adam_alive" INTEGER DEFAULT (0), 
	                         "gateway_alive" INTEGER DEFAULT(0) );


INSERT INTO "watchdog_cfg" (check_adam,check_gateway) VALUES (1,0);