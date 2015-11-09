CREATE TABLE "graph" ("id" INTEGER PRIMARY KEY  NOT NULL ,
	                "name" VARCHAR NOT NULL,
	                "refresh" INTEGER,
	                "lastupdate" INTEGER);


#INSERT INTO graph(name,refresh,lastupdate) VALUES ('Dummy_',20,0);

CREATE TABLE "graph_component" ("id" INTEGER PRIMARY KEY  NOT NULL ,
	                     "graph_id" INTEGER,
	                     "influx_query" VARCHAR,
	                     "graph_type" VARCHAR,
	                     "container" VARCHAR,
	                     "color" VARCHAR);





