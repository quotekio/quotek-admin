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
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Debt", "60"),("Dette","60");

INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("1Q", "20"),("2Q","20"),("3Q","20"),("4Q","20");
INSERT INTO flashnews_keyword ( "word", "weight") VALUES ("Q1", "20"),("Q2","20"),("Q3","20"),("Q4","20");


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
