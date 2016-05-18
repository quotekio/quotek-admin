<?php

  $period = 30; 

  $exec = function() {

    $DUMP_FILE = "/tmp/qate.core";
    if ( is_file($DUMP_FILE) ) {
      exec("gdb -q -n -ex 'bt full' -batch /usr/local/qate/bin/qate $DUMP_FILE > /tmp/qate/dbg/" . time(0));
      unlink($DUMP_FILE);
    }

  }

?>
