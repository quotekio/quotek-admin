<?php

require_once('adamobject.php');
require_once('include/functions.inc.php');

$PERM_NONE = 0x00;
$PERM_READ = 0x01;
$PERM_WRITE = 0x02;

class permission extends adamobject {

}

function loadPermissions($user_id) {
  $permissions = array();
  global $dbhandler;
  $dbh = $dbhandler->query("SELECT id FROM permission WHERE user_id= '" . $user_id . "';");
  while( $ans = $dbh->fetch() ) {
    $perm = new permission();
    $perm->id = $ans['id'];
    $perm->load();
    $permissions[] = $perm;
  }
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
  
  function checkPermissions($sc) {
    if (! isset($this->permissions)) $this->loadPermissions();
    foreach ($this->permissions as $perm) {
      if ($sc == $perm->scope) {
        return $perm->right;
      }
    }
    return $PERM_NONE;
  }
}

?>