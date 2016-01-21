CREATE TABLE "user_permissions" (  "id" INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL , 
	                               "user_id" INTEGER NOT NULL,

	                               "stop_bot" BOOLEAN DEFAULT TRUE,
	                               "start_bot" BOOLEAN DEFAULT TRUE,
                                   "restart_bot" BOOLEAN DEFAULT TRUE,

                                   "create_config" BOOLEAN DEFAULT TRUE,
	                               "edit_config" BOOLEAN DEFAULT TRUE,
	                               "delete_config" BOOLEAN DEFAULT TRUE,

	                               "create_strat" BOOLEAN DEFAULT TRUE,
	                               "edit_strat" BOOLEAN DEFAULT TRUE,
	                               "delete_strat" BOOLEAN DEFAULT TRUE,
	                               
	                               "create_broker" BOOLEAN DEFAULT TRUE,
	                               "edit_broker" BOOLEAN DEFAULT TRUE,
	                               "delete_broker" BOOLEAN DEFAULT TRUE,
	                               
                                   "create_asset" BOOLEAN DEFAULT TRUE,
	                               "edit_asset" BOOLEAN DEFAULT TRUE,
	                               "delete_asset" BOOLEAN DEFAULT TRUE,

                                   "activate_config" BOOLEAN DEFAULT TRUE,
                                   "activate_strat" BOOLEAN DEFAULT TRUE,
                                   "disable_strat" BOOLEAN DEFAULT TRUE,

                                   "create_user" BOOLEAN DEFAULT TRUE,
                                   "delete_user" BOOLEAN DEFAULT TRUE,
                                   "edit_user" BOOLEAN DEFAULT TRUE,

                                   "create_backtest" BOOLEAN DEFAULT TRUE,
                                   "delete_backtest" BOOLEAN DEFAULT TRUE,
                                   "edit_backtest" BOOLEAN DEFAULT TRUE,
                                   
                                   "edit_userperms" BOOLEAN DEFAULT TRUE,

	                               "edit_running_config" BOOLEAN DEFAULT TRUE,
	                               "edit_running_strat" BOOLEAN DEFAULT TRUE,
	                               "edit_running_broker" BOOLEAN DEFAULT TRUE

	                            );