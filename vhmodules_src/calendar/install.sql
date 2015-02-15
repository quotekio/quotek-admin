CREATE TABLE "calendar_event" ("id" INTEGER PRIMARY KEY  NOT NULL ,
	                       "start" INTEGER NOT NULL,
                           "end" INTEGER NOT NULL,
                           "name" VARCHAR NOT NULL,
                           "importance" VARCHAR NOT NULL,
                           "linked_value" VARCHAR);
