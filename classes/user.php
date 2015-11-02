<?php

require_once('adamobject.php');
require_once('include/functions.inc.php');


function loadPermissions($user_id) {

  global $dbhandler;
  $dbh = $dbhandler->query("SELECT * FROM user_permissions WHERE user_id= '" . $user_id . "';");
  $pemissions = $dbh->fetchAll();
  return $permissions;

}

function getUserList() {
  global $dbhandler;
  $ulist = array();
  $dbh = $dbhandler->query("SELECT id FROM user;");
  while ( $ans = $dbh->fetch() ) {
    $u = new user();
    $u->id = $ans['id'];
    $u->load();
    $ulist[] = $u;
  }
  return $ulist;
}


/* New class for user management , replaces vhuser. */
class user extends adamobject {

  function startSession() {
    if (!isset($_SESSION)) session_start();
    $_SESSION['uinfos']['id'] = $this->id;
    $_SESSION['uinfos']['username'] = $this->username;    
  }

  /* Convenience function because we don't know user id in advance */
  function loadByUsername($username) {
    global $dbhandler;

    $this->username = $username;
    $dbh = $dbhandler->query("SELECT * FROM user WHERE username= '" . $this->username . "';");
    $ans = $dbh->fetch();
    /* new way (new life) to retrieve parameters */
    foreach($ans as $key => $value) {
      if ($value !== null) {
        $this->map($key,$value);
      }
    }
  }

  function auth($password) {
       $sha1_password = sha1($this->salt . $password );
       if ($sha1_password == $this->password) {
         return true;
       }
       return false;
   }



  function loadPermissions() {
    $this->permissions = loadPermissions($this->id);
    return $this->permissions;
  }

  function updateLastConn() {
    $this->lastconn = time(0);
    $this->save();
  }
  
  function save() {

    if ( isset($this->newpassword) ) {
      $this->salt = genSalt();
      $this->password = sha1($this->salt . $this->newpassword);
      unset($this->newpassword);
    }

    parent::save();
    
  }
  
  function checkPermissions($tocheck) {
    if (! isset($this->permissions)) $this->loadPermissions();
    foreach ($tocheck as $tc) {
     
      if (! in_array($tc, $this->permissions)) return false;
      else if ($this->permissions[$tc] === false) return false
    }
    return true;
  }
}

?>