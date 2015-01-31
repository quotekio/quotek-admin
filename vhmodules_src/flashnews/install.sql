CREATE TABLE flashnews_keyword (  "id" INTEGER PRIMARY KEY  NOT NULL , 
	                                "word" VARCHAR, 
	                                "weight" INTEGER );

CREATE TABLE flashnews_datasource (  "id" INTEGER PRIMARY KEY  NOT NULL ,
	                                 "source_type" VARCHAR, 
	                                 "source_name" VARCHAR,
	                                 "source_description" VARCHAR, 
	                                 "source_url" VARCHAR,
	                                 "trust_weight" INTEGER );

CREATE TABLE flashnews_news ( "id" INTEGER PRIMARY KEY  NOT NULL ,
	                          "source_id" INTEGER,
	                          "published_on" INTEGER,
                              "received_on" INTEGER,
                              "content" VARCHAR NOT NULL,
                              "priority" INTEGER,
                              "crc32" INTEGER       
                             );


INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("ECB", "50"),("BCE","50"),("FED", "50"),("Fed","50"),("jobs", "30");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Greece", "50"),("Greek","50"),("Syriza", "60"),("Tsipras","30");


INSERT INTO flashnews_datasource ( "source_type", "source_name", "source_description", "source_url", "trust_weight")
                                 VALUES ( 'twitter', 'Wall Street Journal Twitter Account', '', 'WSJ', '1');






