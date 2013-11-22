
<?php

  require_once('include/functions.inc.php');
  require_once('classes/chiliuser.php');
  require_once('classes/chilimessage.php');

  session_start();

  $lang = 'en';
  selectLanguage();

  $errhandler = new chilierror($lang);
  $okhandler  = new chilisuccess($lang);

  if (!verifyAuth()) die('ERROR: User not authenticated');
  if (count($_REQUEST) < 1) die('ERROR: No settings were passed to save');

  if (!isset($_REQUEST['confirm_passwd']) ) die('ERROR: No confirmation password was provided');
    
  $cu = new chiliuser();
  $cu->setID($_SESSION['uinfos']['id']);
  $cu->load();

  if ($cu->auth($_SESSION['uinfos']['email'],$_REQUEST['confirm_passwd'] )  < 0 ) {
    die($errhandler->getMessage('ERR_INVALID_PASSWD',true));
  }

  
  // ###### EMAIL CHANGE ######
  if (isset($_REQUEST['settings_email'])) {

    if (! emailValidate($_REQUEST['settings_email']) ) die($errhandler->getMessage('ERR_INVALID_EMAIL',true));
    //verifier que nouvel email pas deja en base pour un autre user
    $cu->update('email',$_REQUEST['settings_email']);

  }

  // ###### PASSWORD CHANGE #######
  if (isset($_REQUEST['password'])) {
    
    if (strlen($_REQUEST['password']) < 8 ) die($errhandler->getMessage('ERR_SHORTPASS',true)) ;  
    if (!isset($_REQUEST['password2'])) die('ERROR: password confirmation was not sent');
    if ($_REQUEST['password'] != $_REQUEST['password2']) die($errhandler->getMessage('ERR_PASSWD_MISMATCH',true));

    $cu->chpasswd($_REQUEST['confirm_passwd'],$_REQUEST['password'],$_REQUEST['password2']);
    if ($cu->getSafeType() == 'passwd_synced' ) {
      appReinitSafe($_REQUEST['password']);
    }


  }

  //####### SAFE INITIALISATION/CLOSING #######

  if (isset($_REQUEST['enable_safe']) ) {
    appInitSafe($_REQUEST['confirm_passwd']);
    $cu->update('safe_type','passwd_synced');
  }

  else {
    if ( $cu->getSafeType() != 'none') {
      appRemoveSafe();
      $cu->update('safe_type','none');
      $_SESSION['uinfos']['safe_stype'] = 'none';  
    } 
  }
  
 // ###### OTHER SETTINGS ######
 if (isset($_REQUEST['settings_country'])) {
   $cu->update('country',$_REQUEST['settings_country']);
   $_SESSION['uinfos']['country'] = $_REQUEST['settings_country'];

 }

if (isset($_REQUEST['settings_city'])) {
   $cu->update('city',$_REQUEST['settings_city']);
   $_SESSION['uinfos']['city'] = $_REQUEST['settings_city'];

 } 

if (isset($_REQUEST['settings_preflang'])) {
   $cu->update('pref_lang',$_REQUEST['settings_preflang']);

 } 
 
 $okhandler->printm('OK_SAVED_SETTINGS',true);

?>