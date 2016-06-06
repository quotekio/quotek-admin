<?php

/* New class handling strategies through GIT */
require_once('qateobject.php');
require_once('corecfg.php');
require_once('include/functions.inc.php');

use Gitonomy\Git\Repository;
$repository = new Repository($GIT_LOCATION);

class strategy extends qateobject {

  function __construct($name='', $type='', $author='', $created=0, $updated=0) {
    $this->name = $name;
    $this->name_noext = preg_replace('/\.(qs|qsm)/', '',$name);
    $this->type = $type;
    $this->author = $author;
    $this->created = $created;
    $this->updated = $updated;
    $this->active = 0;
  }

  function load() {
    
    //global $repository;
    global $GIT_LOCATION;

    $this->name_noext = preg_replace('/\.(qs|qsm)$/', '', $this->name);

    $nbname = $this->name_noext . ".qnb";

    $this->content = file_get_contents($GIT_LOCATION . '/' . $this->name);
    $this->notebook = file_get_contents($GIT_LOCATION . '/notebooks/' . $nbname );

    $this->loadState();

    if (endsWith($this->name,'.qs')) $this->type = 'normal';
    else if ( endsWith($this->name,'.qsm')) $this->type = 'module';

  }

  function loadState() {

    $astrats = getActiveStrategies();
    if ( in_array($this->name, $astrats) ) $this->active = 1;
    else $this->active = 0;
    
  }


  function save() {

    global $GIT_LOCATION;

    if ( $this->type == 'normal' && ! endsWith($this->name,'.qs') ) $this->name .= ".qs";
    if ( $this->type == 'module' && ! endsWith($this->name,'.qsm') ) $this->name .= ".qsm";

    $this->name_noext = preg_replace('/\.(qs|qsm)$/', '',$this->name);
    $nbname = $this->name_noext . ".qnb";

    $fh = fopen($GIT_LOCATION . '/' . $this->name,'w');
    $fh2 = fopen($GIT_LOCATION . '/notebooks/' . $nbname,'w');

    if ($fh) {
      fwrite($fh,$this->content);
      fclose($fh);
    }
    else {
    }

    if ($fh2) {
      fwrite($fh2,$this->notebook);
      fclose($fh2);
    }
    else {
    }
    

  }


  function delete() {
    global $GIT_LOCATION;
    unlink($GIT_LOCATION . '/' . $this->name);

    $this->name_noext = preg_replace('/\.(qs|qsm)$/', '',$this->name);
    $nbname = $this->name_noext . ".qnb";

    unlink($GIT_LOCATION . '/notebooks/' . $nbname);

  }
 
  function duplicate() {

    global $GIT_LOCATION;
    if ($this->type == 'normal') $ext = '.qs';
    else if ($this->type== 'module') $ext = '.qsm';

    copy($GIT_LOCATION . "/" . $this->name , $GIT_LOCATION . "/" . $this->name_noext . "_copy" . $ext );

  }

  function activate() {
    $acfg = getActiveCfg();
    $acfg->addActiveStrat($this->name);
    $acfg->save();
  }

  function disable() {
    $acfg = getActiveCfg();
    $acfg->removeActiveStrat($this->name);
    $acfg->save();
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

function getActiveStrategies() {
  $acfg = getActiveCfg();
  return $acfg->getActiveStrats();
}

function getStrategies() {

  global $repository;
  global $GIT_LOCATION;

  $astrats = getActiveStrategies();



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

       if ( in_array($f, $astrats)  ) $s->active = 1;
       else $s->active = 0;

       $s->content = "";
       $s->name_noext = preg_replace('/\.(qs|qsm)/', '', $f);
       $strategies[] = $s;
       
     }
   }

  return $strategies;
}

?>