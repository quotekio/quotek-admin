CREATE TABLE "vstore_cache" ("id" INTEGER PRIMARY KEY  NOT NULL , 
	                       "year" INTEGER NOT NULL DEFAULT (1970), 
	                       "month" INTEGER NOT NULL DEFAULT(1),
	                       "content" TEXT,
	                       "updated" INTEGER NOT NULL DEFAULT(0));
