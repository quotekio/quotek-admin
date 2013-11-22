<?php

 require_once("include/functions.inc.php");

//container class for data
class message {

  function __construct($id,$str_id,$message) {
    $this->id = $id;
    $this->str_id = $str_id;
    $this->message = $message;
  }

  function getID() {
    return $this->id;
  }

  function getStrID() {
    return $this->str_id;
  }

  function getMessage() {
    return $this->message;
  }

  function getAll() {
    return array($this->id,$this->str_id,$this->message);
  }

}

function resolveMessage($mlist,$term) {

  if (is_numeric($term)) {

    foreach($mlist as $message) {
      if ($term == $message->getID()) {
        return $message;
      }
    }
  }

  else {

    foreach($mlist as $message) {
      if ($term == $message->getStrID()) {
        return $message;
      }
    }
 }

 return $mlist[0];

}


class chilisuccess {

  function __construct($lang) {
    include("lang/$lang/success.lang.php");
    $this->mlist = $success;
  }

  function getMessage($msg_id,$prefix=false,$extra_args=NULL) {
  	$msg = resolveMessage($this->mlist,$msg_id);
  	$message = $msg->getMessage();
  	if ($extra_args != NULL) {
  	  for ($i=0;$i<count($extra_args);$i++) {
        $extra_args[$i] = protect('axss',$extra_args[$i]);
        if (is_string($extra_args[$i]) && strlen($extra_args[$i]) > 40) {
          $extra_args[$i] = substr($extra_args[$i],0,40) . "..";
        }
      }
      $message = vsprintf($message,$extra_args);       
    }
    $message = ($prefix) ? 'OK:' . $message : $message ;
    return $message;
  }


  function printm($msg_id,$prefix=false,$extra_args=NULL) {
    $message = $this->getMessage($msg_id,$prefix,$extra_args);
    print $message;
  }

  
}

class error {
	
  function __construct($lang) {
      include("lang/$lang/errors.lang.php");
      $this->mlist = $errors;
  } 

  function getMessage($msg_id,$prefix=false,$extra_args=NULL) {
    $msg = resolveMessage($this->mlist,$msg_id);
    $message = $msg->getMessage();

    if ($extra_args != NULL) {
      for ($i=0;$i<count($extra_args);$i++) {
        $extra_args[$i] = protect('axss',$extra_args[$i]);
        if (is_string($extra_args[$i]) && strlen($extra_args[$i]) > 40) {
          $extra_args[$i] = substr($extra_args[$i],0,40) . "..";
        }
      }
      $message = vsprintf($message,$extra_args);       
    }

    $message = ($prefix) ? 'ERR:' . $message : $message ;
    return $message;
  }

  function printm($msg_id,$prefix=false,$extra_args=NULL) {
    $message = $this->getMessage($msg_id,$prefix,$extra_args);
    print $message;
  }

}

?>