<?php

require_once('adamobject.php');

$PERM_NONE = 0x00;
$PERM_READ = 0x01;
$PERM_WRITE = 0x02;

class permission extends adamobject {

}


function loadPermissions($user_id) {

  $permissions = array();
  global $dbhandler;
  $dbh = $dbhandler->query("SELECT id FROM permission WHERE user_id= '" . $userid . "';");
  while( $ans = $dbh->fetch() ) {
    $perm = new permission();
    $perm->id = $ans['id'];
    $perm->load();
    $permissions[] = $perm;
  }
  return $permissions;
}


/* New class for user management , replaces vhuser. */
class user extends adamobject {

  function startSession() {
    if (!isset($_SESSION)) session_start();
    $_SESSION['uinfos']['id'] = $this->id;
    $_SESSION['uinfos']['username'] = $this->username;    
  }

  /* Convenience function because we don't know user id in advance */
  function load($username) {
    global $dbhandler;
    $dbh = $dbhandler->query("SELECT * FROM " . get_class($this) . " WHERE username= '" . $this->username . "';");
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

  function checkPermissions($app) {
    $permissions = loadPermissions($this->id);

    foreach ($permissions as $perm) {
      if ($app == $perm->application) {
        return $perm->right;
      }
    }
    return $PERM_NONE;
  }
}

?>