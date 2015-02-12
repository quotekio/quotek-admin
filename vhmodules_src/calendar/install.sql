CREATE TABLE "calendar_event" ("id" INTEGER PRIMARY KEY  NOT NULL ,
	                       "year" INTEGER NOT NULL,
                           "week" INTEGER NOT NULL,

                           "name" VARCHAR,

                           );

CREATE TABLE "calendar_asset_link" ( "id" INTEGER PRIMARY KEY NOT NULL,
                                     "event_id" INTEGER,
                                     "asset_id" INTEGER,);


