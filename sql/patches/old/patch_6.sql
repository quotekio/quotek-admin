ALTER TABLE corecfg add column notify_to VARCHAR NULL DEFAULT 0;
ALTER TABLE corecfg add column notify_shutdown BOOLEAN NULL DEFAULT 0;
ALTER TABLE corecfg add column notify_report BOOLEAN NULL DEFAULT 0;
ALTER TABLE corecfg add column notify_report_every INTEGER NULL DEFAULT 0;

#ALTER TABLE corecfg add column notify_positions BOOLEAN NULL DEFAULT 0;




