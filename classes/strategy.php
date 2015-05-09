<?php

/* New class handling strategies through GIT */
require_once('adamobject.php');
require_once('corecfg.php');
require_once('include/functions.inc.php');

use Gitonomy\Git\Repository;
$repository = new Repository($GIT_LOCATION);

class strategy extends adamobject {

  function __construct($name='', $type='', $author='', $created=0, $updated=0) {
    $this->name = $name;
    $this->name_noext = preg_replace('/\.(qs|qsm)/', '',$name);
    $this->type = $type;
    $this->author = $author;
    $this->created = $created;
    $this->updated = $updated; 
  }

  function load() {
    
    //global $repository;
    global $GIT_LOCATION;
  
    $this->content = file_get_contents($GIT_LOCATION . '/' . $this->name);
    $this->name_noext = preg_replace('/\.(qs|qsm)/', '', $this->name);

    if (endsWith($this->name,'.qs')) $this->type = 'normal';
    else if ( endsWith($this->name,'.qsm')) $this->type = 'module';

  }


  function save() {

    global $GIT_LOCATION;
    $fh = fopen($GIT_LOCATION . '/' . $this->name,'w');

    if ($fh) {
      fwrite($fh,$this->content);
      fclose($fh);
    }
    else {
    }
  }


  function delete() {
    global $GIT_LOCATION;
    unlink($GIT_LOCATION . '/' . $this->name);
    
  }
 
  function duplicate() {

    global $GIT_LOCATION;
    if ($this->type == 'normal') $ext = '.qs';
    else if ($this->type== 'module') $ext = '.qsm';

    copy($GIT_LOCATION . "/" . $this->name , $GIT_LOCATION . "/" . $this->name_noext . "_copy" . $ext );

  }


  function activate() {

  }

}


function getStratsList() {
    /* Light list  to avoid xfer of 
    large amount of data */
    $slist = getStrategies();
    for($i=0;$i<count($slist);$i++ ) {
       $slist[$i]->content = "";
    }
    return $slist;

}

function getStrategies() {

  global $repository;
  global $GIT_LOCATION;

  $strategies = array();
  $commit = $repository->getHeadCommit();

  //checks for files in working copy.
  $allfiles  = opendir($GIT_LOCATION);
  while( $f = readdir($allfiles) ) {
    
     if ( ( endsWith($f,".qs") || endsWith($f,".qsm") ) ) {

      if (endsWith($f,".qs")) $type = 'normal';
      else if (endsWith($f,".qsm")) $type = 'module';

      try {
        $last = $commit->getLastModification($f);
        $author = $last->getAuthorName();
        $created = $last->getAuthorDate()->getTimestamp();
        $updated = $created;  
      }

      catch(Exception $e) {
         $author = '--';
         $created = 0;
         $updated = 0;
       }

       $s = new strategy($f,$type,$author,$created,$updated);
       $s->active = 0;
       $s->content = "";
       $strategies[] = $s;

     }
   }

  return $strategies;
}


function getActiveStrat() {

}


?>