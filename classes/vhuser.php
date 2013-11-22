<?php
require_once('include/functions.inc.php');

class vhuser {

  function __construct() {

  }

  function setInst($firstname,$lastname,$email,$password) {
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->email = $email;
    $this->password = $password;
  }


 function startSession() {

   if (!isset($_SESSION)) session_start();

   $_SESSION['uinfos']['id'] = $this->id;
   $_SESSION['uinfos']['username'] = $this->username;
   //$_SESSION['uinfos']['is_admin'] = $this->is_admin;

   //if (isset($this->city) && $this->city != "" ) $_SESSION['uinfos']['city'] = $this->city;
   //if (isset($this->country) && $this->country != "" ) $_SESSION['uinfos']['country'] = $this->country;
   //if (isset($this->telephone) && $this->telephone != "" ) $_SESSION['uinfos']['telephone'] = $this->telephone;

   
 }

 function auth($username,$password) {
      global $dbhandler;
      $email = protect('sql',$username);
      $dh = $dbhandler->query("SELECT * FROM user WHERE username='$username' AND is_revoked = 0 ;");     
      //if (!$dh) die(mysql_error());
      
      $ans = $dh->fetch();
      $sha1_password = sha1($ans['salt'] . $password );
      if ($sha1_password == $ans['password']) {
        $this->id = $ans['id'];
        $this->safe_passwd = $password;
        return $this->id;
      }
      return -1;
  }

  function load() {
    global $dbhandler;
    $this->id= protect('sql',$this->id);
    $dh = $dbhandler->query("SELECT * FROM user WHERE id=" . $this->id .";");
    $ans = $dh->fetch();

    //$this->firstname = $ans['firstname'];
    //$this->lastname = $ans['lastname'];
    $this->username = $ans['username'];
    //$this->lastlogin = $ans['lastlogin'];
    //$this->has_membership = $ans['has_membership'];
    //$this->is_expert = $ans['is_expert'];
    //$this->is_admin = $ans['is_admin'];
    //$this->created = $ans['created'];
    //$this->fcreated = strftime("%a %d %h %Y",$ans['created']);
    //$this->safe_type = $ans['safe_type'];

    /* EXTRA INF */
    //$this->city = $ans['city'];
    //$this->country = $ans['country'];
    //$this->telephone = $ans['telephone'];

  }


  function loadFromEMail() {
    global $dbhandler;
    $this->email= protect('sql',$this->email);
    $dh = mysql_query("SELECT * FROM chiliuser WHERE email='" . $this->email ."';", $dbhandler);

    if (mysql_num_rows($dh) == 0) return false;
    $ans = mysql_fetch_assoc($dh);

    $this->id = $ans['id'];
    $this->firstname = $ans['firstname'];
    $this->lastname = $ans['lastname'];
    $this->email = $ans['email'];
    $this->lastlogin = $ans['lastlogin'];
    $this->has_membership = $ans['has_membership'];
    $this->is_admin = $ans['is_admin'];
    $this->is_expert = $ans['is_expert'];
    $this->created = $ans['created'];
    $this->fcreated = strftime("%a %d %h %Y",$ans['created']);
    $this->safe_type = $ans['safe_type'];


    /* EXTRA INF */
    $this->city = $ans['city'];
    $this->country = $ans['country'];
    $this->telephone = $ans['telephone'];

    return true;

  }





  function del() {
    global $dbhandler;
    if ($this->id > 0) {
      mysql_query("DELETE FROM chiliuser WHERE id='" .$this->id . "';");
    }
  }

  function disable() {
    global $dbhandler;
    if ($this->id > 0) {
      mysql_query("UPDATE chiliuser set is_revoked = 1 WHERE id='" .$this->id . "';");
    }
  }

  function create() {
    global $dbhandler;
    $this->firstname = protect('sql',$this->firstname);
    $this->lastname = protect('sql',$this->lastname);
    $this->email = protect('sql',$this->email);
    $this->salt = genSalt();
    $this->sha1_password = sha1($this->salt . $this->password);
    $this->created = time();
    $this->lastlogin = $this->created;


    $query = sprintf("INSERT INTO chiliuser(firstname,
					    lastname,
					    email,
					    salt,
					    password,
					    created,
					    lastlogin,
              pref_lang) 
					    VALUES ('%s','%s','%s','%s','%s','%d','%d','%s');",
    $this->firstname,
    $this->lastname,
    $this->email,
    $this->salt,
    $this->sha1_password,
    $this->created,
    $this->lastlogin,
    $this->pref_lang);

    $res = mysql_query($query,$dbhandler);

  }

  function updateLastLogin() {
    $t = time();
    $this->update('lastlogin_prev',$this->lastlogin);
    $this->update('lastlogin',$t);

  }

  function update($key,$value) {

    global $dbhandler;
   
    $key = protect('sql',$key);
    $value=protect('sql',$value);   
    $dbh = mysql_query("UPDATE chiliuser set $key = '$value' WHERE id='" . $this->id ."';",$dbhandler);
    if (!$dbh) {
      //debug
      die(mysql_error());
      return false;
    }
    return true;
  }

  function getEmail() {
    return $this->email;
  }

  function getId() {
    return $this->id;
  }

  function getFirstname() {
    return $this->firstname;
  }

  function getLastname() {
    return $this->lastname;
  }

  function getLastLogin() {
    return $this->lastlogin;
  }


  function getSafeType(){
    return $this->safe_type;
  }

  function isAdmin() {
    return $this->is_admin;
  }

  function hasMembership() {
    return $this->has_membership;
  }

  function isExpert() {
    return $this->is_expert;
  }


  function setID($id) {
   $this->id= $id; 
  }

  function setEmail($email) {
    $this->email = $email;
  }

  function createRPToken() {
    global $dbhandler;
    $token = generateToken();
    $expire = time() + 86400;
    $uid = $this->id;
    mysql_query("DELETE FROM resetpassword WHERE user_id = '$uid';");
    $dh = mysql_query("INSERT INTO resetpassword (user_id,token,expire) VALUES('$uid','$token','$expire');",$dbhandler);
    if (!$dh) die(mysql_error());
    return $token;
  }

  function validateRPToken($token) {

    global $dbhandler;
    $now = time();
    $token = protect('sql',$token);
    $dh = mysql_query("SELECT * FROM resetpassword WHERE token='$token' AND expire > '$now';");
    if (mysql_num_rows($dh) == 0) return false;
    $ans = mysql_fetch_assoc($dh);
    mysql_query("DELETE FROM resetpassword WHERE token='$token';");
    $this->id = $ans['user_id'];
    return true;
  }

  function resetPassword() {
    $newpass = substr(generateToken(),0,7);
    $newsalt = genSalt();
    $this->update('salt',$newsalt);
    $this->update('password',sha1($newsalt . $newpass));
    return $newpass;
  }

  function chpasswd($oldpass,$newpass1,$newpass2) {

   global $dbhandler;

   if ($this->auth($this->email,$oldpass) == -1) return -1;
   if ($newpass1 != $newpass2) return -2;

   $newsalt = genSalt();
   mysql_query("UPDATE chiliuser set password = SHA1('" . $newsalt . $newpass1  . "'), salt='$newsalt' where id='" . $this->id . "';",$dbhandler);

   return 0;
  }

  function chemail($oldpass,$newemail1,$newemail2) {

    global $dbhandler;
    if ($this->auth($this->email,$oldpass) == -1) return -1;
    if ($newemail1 != $newemail2) return -2;    
    mysql_query("UPDATE chiliuser set email = '$newemail1';",$dbhandler);
    $_SESSION['uinfos']['email'] = $newemail1;
    return 0;
  }

  function exists($iemail = NULL) {

    global $dbhandler;
    if ($iemail != NULL) $email = $iemail;
    else $email = $this->email;
    $email = protect('sql',$email);
    $dbh = mysql_query("SELECT id FROM chiliuser WHERE email = '$email';",$dbhandler);
    if (mysql_num_rows($dbh) > 0) return true;
    return false;
  }

}

?>
