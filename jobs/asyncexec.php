<?php

$JOBS_DIR = dirname(__FILE__);

/* LOADING OF MAIN VH CLASSES AND OBJECTS */
include ( $JOBS_DIR . "/../conf/config.inc.php");
include "executor.php";

$ex = new executor($EXEC_QUEUE_FILE);
$ex->poll();

?>