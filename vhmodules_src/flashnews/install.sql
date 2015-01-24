CREATE TABLE flashnews_keywords (  "id" INTEGER PRIMARY KEY  NOT NULL , 
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
                              "content" VARCHAR,
                              "priority" INTEGER,
                              "crc32" INTEGER       
                             );


