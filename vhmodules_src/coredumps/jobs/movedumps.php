<?php

  $period = 30; 

  $exec = function() {

    $DUMP_FILE = "/tmp/adam.core";
    if ( is_file($DUMP_FILE) ) {
      exec("gdb -q -n -ex 'bt full' -batch /usr/local/adam/bin/adam $DUMP_FILE > /tmp/adam/dbg/" . time(0));
      unlink($DUMP_FILE);
    }

  }

?>