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

DELETE FROM flashnews_keyword;

INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("ECB", "50"),("BCE","50");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("FED", "50"),("BNS","40");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Job", "40"),("Emploi","40");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Jobs", "50"),("Emplois","50");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("GDP", "50"),("PIB","50");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Growth", "30"),("Croissance","30");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Or", "50"),("Gold","50");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Brent", "50"),("Brut","40");

INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Résultats", "50"),("Results","50");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Résultat", "40"),("Result","40");

INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Greece", "50"),("Grèce","50");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Greek", "50"),("Grecque","50");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Syriza", "60"),("Tsipras","60");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Euro", "50"),("USD","50");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Dept", "60"),("Dette","60");


DELETE FROM flashnews_datasource;

INSERT INTO flashnews_datasource ( "source_type", "source_name", "source_description", "source_url", "trust_weight")
                                 VALUES ( 'twitter', 'Wall Street Journal Twitter Account', '', 'WSJ', '1');

INSERT INTO flashnews_datasource ( "source_type", "source_name", "source_description", "source_url", "trust_weight")
                                 VALUES ( 'twitter', 'Alexandre Baradez', '', 'abaradez', '1');

INSERT INTO flashnews_datasource ( "source_type", "source_name", "source_description", "source_url", "trust_weight")
                                 VALUES ( 'twitter', 'Zerohedge Twitter Account', '', 'zerohedge', '1');

INSERT INTO flashnews_datasource ( "source_type", "source_name", "source_description", "source_url", "trust_weight")
                                 VALUES ( 'rss', 'Les echos Finance RSS', '', 'http://syndication.lesechos.fr/rss/rss_finance-marches.xml', '1');

INSERT INTO flashnews_datasource ( "source_type", "source_name", "source_description", "source_url", "trust_weight")
                                 VALUES ( 'rss', 'Les echos Bource RSS', '', 'http://rss.feedsportal.com/c/499/f/413863/index.rss', '1');











