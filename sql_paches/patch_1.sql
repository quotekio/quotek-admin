ALTER TABLE corecfg ADD column getval_ticks INTEGER;
ALTER TABLE corecfg ADD column getpos_ticks INTEGER;
ALTER TABLE corecfg ADD column eval_ticks INTEGER;

ALTER table broker ADD column has_demo_mode INTEGER;
ALTER table broker ADD column has_push_mode INTEGER;
ALTER table broker ADD column demo_url VARCHAR;
ALTER table broker ADD column live_url VARCHAR;

ALTER table brokercfg ADD column broker_account_mode VARCHAR;
ALTER table brokercfg ADD column broker_mode VARCHAR;

UPDATE broker SET demo_url = 'https://demo-api.ig.com', live_url = 'https://api.ig.com', module_name = 'igconnector3' WHERE module_name = 'igconnector' ;
