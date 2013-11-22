<?php

class snapshot {

    function __construct($fname,$fsize,$fchksum) {
       $this->name = $fname;
       $this->size = $fsize;
       $this->chksum = $fchksum;
    }

    function snapshot() {
       global $ADAM_SNAPDIR;
       global $ADAM_ROOT; 
       copy("$ADAM_ROOT/admin/data/vh.sqlite","$ADAM_SNAPDIR/vh_$datestr.sqlite");
    }

    function import() {

    }

}


function listSnapshots() {
  global $ADAM_SNAPDIR;
  $result = array();
  $dfh = opendir($ADAM_SNAPDIR);

  while(( $fname = readdir($dfh))) {
     if ($fname != '.' && $fname != '..') {
       $s_name = str_replace(".sqlite","",$fname);
       $s_size = filesize("$ADAM_SNAPDIR/$fname");
       $s_checksum = sha1_file("$ADAM_SNAPDIR/$fname");
       $result[] = new snapshot($s_name,$s_size,$s_checksum);
     }
  }
  return $result;
}


function importSnapshot($sname) {

}


?>
