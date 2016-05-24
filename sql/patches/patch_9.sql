ALTER TABLE backtest RENAME TO backtest_old;

CREATE TABLE "backtest" ("id" INTEGER PRIMARY KEY  NOT NULL,
	                     "name" VARCHAR NOT NULL ,
	                     "type" VARCHAR NOT NULL ,
	                     "start" INTEGER NOT NULL ,
	                     "end" INTEGER NOT NULL ,
	                     "genetics_population" INTEGER,
	                     "genetics_survivors" INTEGER,
	                     "genetics_newcomers" INTEGER,
	                     "genetics_converge_thold" INTEGER,
	                     "genetics_max_generations" INTEGER,
	                     "genetics_recompute_winners" BOOL,
	                     "config_id" INTEGER NOT NULL ,
	                     "strategy_name" VARCHAR NOT NULL );


DROP TABLE backtest_old ;