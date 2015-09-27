PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE "user" ("id" INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL , "username" VARCHAR NOT NULL , "password" VARCHAR NOT NULL , "salt" VARCHAR, "is_revoked" INTEGER NOT NULL  DEFAULT 0, rsa_key TEXT, lastconn INTEGER NOT NULL DEFAULT 0);
INSERT INTO "user" VALUES(1,'Admin','dcd382119fab2e5487452ef448672f3112468a7a','fzxpe',0,NULL,1443384791);
CREATE TABLE "valuecfg" ("id" INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL  UNIQUE , "name" VARCHAR NOT NULL , "pnl_pp" INTEGER NOT NULL , "min_stop" INTEGER NOT NULL , "broker_map" VARCHAR NOT NULL , "unit" VARCHAR NOT NULL , "start_hour" VARCHAR NOT NULL , "end_hour" VARCHAR NOT NULL );

INSERT INTO "valuecfg" VALUES(1,'CAC40',1,10,'IX.D.CAC.IMF.IP','point','09:00','17:30');
INSERT INTO "valuecfg" VALUES(2,'ITALY40',1,20,'IX.D.MIB.IFM.IP','point','09:00','17:30');
INSERT INTO "valuecfg" VALUES(3,'DAX',5,10,'IX.D.DAX.IMF.IP','point','09:00','17:30');
INSERT INTO "valuecfg" VALUES(4,'DOW',1,10,'IX.D.DOW.IFE.IP','point','14:00','23:00');
INSERT INTO "valuecfg" VALUES(26,'FX_EURUSD',1,10,'CS.D.EURUSD.MINI.IP','pip','00:00','23:59');
INSERT INTO "valuecfg" VALUES(27,'FX_EURJPY',1,10,'CS.D.EURJPY.MINI.IP','pip','00:00','23:59');
INSERT INTO "valuecfg" VALUES(28,'GOLD',1,10,'CS.D.CFEGOLD.CFE.IP','point','09:30','22:00');
INSERT INTO "valuecfg" VALUES(29,'CAC40_HL',10,10,'IX.D.CAC.IDF.IP','point','09:00','17:30');
INSERT INTO "valuecfg" VALUES(30,'DAX_HL',10,10,'IX.D.DAX.IDF.IP','point','09:30','17:30');
INSERT INTO "valuecfg" VALUES(31,'EURUSD_HL',10,10,'CS.D.EURUSD.CFD.IP','pip','00:00','23:59');
INSERT INTO "valuecfg" VALUES(32,'FX_EURCHF',1,10,'CS.D.EURCHF.MINI.IP','pip','00:00','23:59');
INSERT INTO "valuecfg" VALUES(33,'NIKKEI',1,10,'IX.D.NIKKEI.IFM.IP','point','00:00','10:00');
INSERT INTO "valuecfg" VALUES(34,'FTSE100',1,10,'IX.D.FTSE.IFE.IP','point','09:30','17:30');
INSERT INTO "valuecfg" VALUES(35,'USDCAD_HL',10,10,'CS.D.USDCAD.CFD.IP','pip','00:00','23:59');
INSERT INTO "valuecfg" VALUES(36,'GBPUSD_HL',10,10,'CS.D.GBPUSD.CFD.IP','pip','00:00','23:59');
INSERT INTO "valuecfg" VALUES(37,'EURAUD_HL',10,10,'CS.D.EURAUD.CFD.IP','pip','00:00','23:59');



CREATE TABLE "broker" ("id" INTEGER PRIMARY KEY  NOT NULL , "name" VARCHAR NOT NULL , "module_name" VARCHAR NOT NULL , "needs_gateway" INTEGER NOT NULL  DEFAULT 0, "gateway_cmd" VARCHAR, has_demo_mode INTEGER, has_push_mode INTEGER, demo_url VARCHAR, live_url VARCHAR);
INSERT INTO "broker" VALUES(1,'IG Markets CFD Trading','igconnector3',0,'',NULL,NULL,'https://demo-api.ig.com','https://api.ig.com');
CREATE TABLE "corestats_history" ("t" INTEGER NOT NULL ,"pnl" FLOAT NOT NULL  DEFAULT (null) , "nbpos" INTEGER NOT NULL  DEFAULT 1);
CREATE TABLE "valuecfg_map" ("config_id" INTEGER NOT NULL , "indice_id" INTEGER NOT NULL , PRIMARY KEY ("config_id", "indice_id"));
INSERT INTO "valuecfg_map" VALUES(5,1);
INSERT INTO "valuecfg_map" VALUES(5,2);
INSERT INTO "valuecfg_map" VALUES(5,3);
INSERT INTO "valuecfg_map" VALUES(5,4);
INSERT INTO "valuecfg_map" VALUES(5,12);
INSERT INTO "valuecfg_map" VALUES(1,1);
INSERT INTO "valuecfg_map" VALUES(1,2);
INSERT INTO "valuecfg_map" VALUES(1,3);
INSERT INTO "valuecfg_map" VALUES(1,4);
CREATE TABLE "brokercfg" ("id" INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL , "name" VARCHAR NOT NULL , "username" VARCHAR NOT NULL , "password" VARCHAR, "broker_id" INTEGER NOT NULL , "api_key" VARCHAR, broker_account_mode VARCHAR, broker_mode VARCHAR);
INSERT INTO "brokercfg" VALUES(12,'IG_API','***REMOVED***','***REMOVED***',1,'***REMOVED***','demo','push');
CREATE TABLE "corecfg" ("id" INTEGER PRIMARY KEY  NOT NULL ,"name" VARCHAR NOT NULL ,"broker_id" INTEGER,"aep_enable" INTEGER,"aep_listen_port" INTEGER,"aep_listen_addr" VARCHAR,"mm_capital" FLOAT,"mm_max_openpos" INTEGER,"mm_max_openpos_per_epic" INTEGER,"mm_reverse_pos_lock" INTEGER,"mm_reverse_pos_force_close" INTEGER,"mm_max_loss_percentage_per_trade" FLOAT,"mm_critical_loss_percentage" FLOAT,"mm_max_var" FLOAT,"created" INTEGER,"updated" INTEGER,"active" INTEGER DEFAULT (0) , "extra" TEXT, "ticks" INTEGER NOT NULL  DEFAULT 1000000, "backend_id" INTEGER, "backend_host" VARCHAR, "backend_username" VARCHAR, "backend_password" VARCHAR, "backend_db" VARCHAR, "backend_port" INTEGER, getval_ticks INTEGER, getpos_ticks INTEGER, eval_ticks INTEGER, active_strategies VARCHAR);
INSERT INTO "corecfg" VALUES(1,'Default',12,1,9999,'127.0.0.1',2000.0,5,2,1,0,15.0,30.0,NULL,1419892584,1419892584,1,'',4000000,1,'127.0.0.1','root','root','adam',8086,1000000,NULL,1000000,'default.qs');
CREATE TABLE "backtest" ("id" INTEGER PRIMARY KEY  NOT NULL ,"name" VARCHAR NOT NULL ,"type" VARCHAR NOT NULL ,"start" INTEGER NOT NULL ,"end" INTEGER NOT NULL ,"genetics_population" INTEGER,"genetics_survivors" INTEGER,"genetics_newcomers" INTEGER,"genetics_converge_thold" INTEGER,"genetics_max_generations" INTEGER,"genetics_recompute_winners" BOOL,"speed" INTEGER NOT NULL  DEFAULT (100) ,"config_id" INTEGER NOT NULL ,"strategy_id" INTEGER NOT NULL );
CREATE TABLE "backend" ("id" INTEGER PRIMARY KEY  NOT NULL , "name" VARCHAR NOT NULL , "module_name" VARCHAR NOT NULL );
INSERT INTO "backend" VALUES(1,'Influx Backend Module','influxdbbe');
INSERT INTO "backend" VALUES(2,'Dummy Backend Module','dummy');
CREATE TABLE permission (id INTEGER PRIMARY KEY,
	                     user_id INTEGER,
                         scope VARCHAR(256),
                         right INTEGER);
DELETE FROM sqlite_sequence;
INSERT INTO "sqlite_sequence" VALUES('user',1);
INSERT INTO "sqlite_sequence" VALUES('valuecfg',25);
INSERT INTO "sqlite_sequence" VALUES('brokercfg',12);
COMMIT;
