<?php

class snapshot {

    function __construct($fname,$fsize,$fchksum) {
       $this->name = $fname;
       $this->size = $fsize;
       $this->chksum = $fchksum;
    }

    function snapshot() {
       global $QATE_SNAPDIR;
       global $QATE_ROOT; 
       copy("$QATE_ROOT/admin/data/vh.sqlite","$QATE_SNAPDIR/vh_$datestr.sqlite");
    }

    function import() {

    }

}


function listSnapshots() {
  global $QATE_SNAPDIR;
  $result = array();
  $dfh = opendir($QATE_SNAPDIR);

  while(( $fname = readdir($dfh))) {
     if ($fname != '.' && $fname != '..') {
       $s_name = str_replace(".sqlite","",$fname);
       $s_size = filesize("$QATE_SNAPDIR/$fname");
       $s_checksum = sha1_file("$QATE_SNAPDIR/$fname");
       $result[] = new snapshot($s_name,$s_size,$s_checksum);
     }
  }
  return $result;
}


function importSnapshot($sname) {

}


?>
