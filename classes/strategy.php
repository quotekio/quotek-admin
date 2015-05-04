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

  $strategies = array();
  $commit = $repository->getHeadCommit();
  $tree = $commit->getTree();

  foreach ( $tree->getEntries() as $name => $data) {
    //filters only Quotek strategy files and modules.
    if (endsWith($name,".qs") || endsWith($name,".qsm") ) {

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

  return $strategies;
}


function getActiveStrat() {

}


?>