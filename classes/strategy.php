<?php

/* New class handling strategies through GIT */
require_once('adamobject.php');
require_once('corecfg.php');
require_once('include/functions.inc.php');

use Gitonomy\Git\Repository;
$repository = new Repository($GIT_LOCATION);

class strategy {

  function __construct($name, $type, $author, $created, $updated) {
    $this->name = $name;
    $this->type = $type;
    $this->author = $author;
    $this->created = $created;
    $this->updated = $updated; 
  }

  function save() {

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
  $tree = $commit->getTree();

  $nlist = array();

  foreach ( $tree->getEntries() as $name => $data) {
    //filters only Quotek strategy files and modules.
    if (endsWith($name,".qs") || endsWith($name,".qsm") ) {

      $nlist[] = $name;

      if (endsWith($name,".qs")) $type = 'normal';
      else $type = 'module';

      $last = $commit->getLastModification($name);
      $author = $last->getAuthorName();
      $created = $last->getAuthorDate()->getTimestamp();
      $updated = $created;

      $s = new strategy($name,$type,$author,$created,$updated);
      $s->active = 0;
      $s->content = "";
      $strategies[] = $s;

    }
  }

  //checks for untracked files
  $allfiles  = opendir($GIT_LOCATION);
  echo "FOOB";
  while( $f = readdir($allfiles) ) {

     echo "file:" . $f;
     if ( ( endsWith($f,".qs") || endsWith($f,".qsm") )  && ! in_array($f, $nlist)  ) {

       if (endsWith($f,".qs")) $type = 'normal';
       else $type = 'module';

       $author = '--';
       $created = 0;
       $updated = 0;

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