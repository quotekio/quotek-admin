<?php

require_once('qateobject.php');
require_once('include/functions.inc.php');


function loadPermissions($user_id) {

  $result = array();

  global $dbhandler;
  $dbh = $dbhandler->query("SELECT * FROM user_permissions WHERE user_id= '" . $user_id . "';");
  $permissions = $dbh->fetch();

  //we remove id and user_id from permissions
  array_shift($permissions);
  array_shift($permissions);
  //
  
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
class user extends qateobject {

  function startSession() {
    if (!isset($_SESSION)) session_start();
    $_SESSION['uinfos']['id'] = $this->id;
    $_SESSION['uinfos']['username'] = $this->username;    
  }

  function validateName(){

      if ( ! preg_match ('/^[\w\.-]*$/', $this->username) ) return false;
      if ( strlen($this->username) > 32 ) return false;
      return true; 
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

    if ( isset($this->permissions)  ) unset($this->permissions);

    if ( isset($this->newpassword) ) {
      $this->salt = genSalt();
      $this->password = sha1($this->salt . $this->newpassword);
      unset($this->newpassword);
    }

    parent::save();
    
  }

  function savePermissions($perms) {

    global $dbhandler;
    $id = $this->id;

    $perms = get_object_vars($perms);

    $hasperms_q = "SELECT id from user_permissions WHERE user_id='${id}';";
    $dbh = $dbhandler->query($hasperms_q);

    //we create entry if does not exist.
    if ( count($dbh->fetchAll() ) == 0 ) {
      $dbhandler->query("INSERT INTO user_permissions(user_id) VALUES ('${id}')");
    }

    $query = "UPDATE user_permissions SET ";
    
    $i =0;
    foreach ($perms as $pname => $pvalue) {

      $pvalue = strtoupper($pvalue);
      $query .= "${pname}='${pvalue}'" ;

      if ($i < count($perms) - 1) {
        $query .= ',';
       
      }
      $i++;
    }

    $query .= " WHERE user_id='" . $this->id . "';";
    
    $dbh = $dbhandler->query($query);

  }

  function checkPermissions($tocheck) {
    if (! isset($this->permissions)) $this->loadPermissions();
    foreach ($tocheck as $tc) {
     
      if (! array_key_exists($tc, $this->permissions)) return false;
      else if ($this->permissions[$tc] == 'FALSE') return false;
    }
    return true;
  }
}

?>