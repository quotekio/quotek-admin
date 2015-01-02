<?php

function rmdir_recurse($path) {
    $path = rtrim($path, '/').'/';
    $handle = opendir($path);
    while(false !== ($file = readdir($handle))) {
        if($file != '.' and $file != '..' ) {
            $fullpath = $path.$file;
            if(is_dir($fullpath)) rmdir_recurse($fullpath); else unlink($fullpath);
        }
    }
    closedir($handle);
    rmdir($path);
}

function protect($protec_type,$input) {
  switch($protec_type) {
    case 'sql':
      global $dbhandler;
      return $dbhandler->quote($input) ;
      break;
   case 'axss': 
      return htmlspecialchars($input);
      break;
   case 'noexec' :

     //peut pas utiliser escapeshellcmd(); il escape trop de caracteres pour ce qu'on veut faire.
    if (strpos($input,'|') === false &&  
        strpos($input,'&&') === false && 
        strpos($input,'>') === false && 
        strpos($input,';') === false && 
        strpos($input,'<') === false &&
        strpos($input,'\'') === false &&
        strpos($input,'"') === false) {

        return $input; 
    }
     else return "";
     break;
   }
}


function getTZ() {
 return date('T');
}

function genSalt() {
 $nt = generateToken();
 return strtoupper(substr($nt,0,8));
}

//generateToken Alias
function genToken() {
  return generateToken();
}

function generateToken() {
   return md5(rand(0,1000000000));
}

function checkFields($farray) {

  foreach($farray as $field) {
    if (!isset($_REQUEST[$field])) {
      //debug
      echo $field;
      return false;
    }
  }
  return true;
}


function sendEmail($email_type,$lang,$email,$extra_infos,$message_extensions=null) {

   global $MAIL_FROM;
   global $mail;
   $headers ="From: $MAIL_FROM\n";
   $headers .='Content-Type: text/plain; charset="UTF-8"'."\n";
   $headers .="Content-Transfer-Encoding: 8bit\n\n";
   if (! @include_once("lang/$lang/mails/$email_type.lang.php" )) {
     return false;
   }

   $message = $mail['template'];
   foreach($extra_infos as $key => $value) {
     $message = str_replace('%%' . strtoupper($key) . '%%', $value,$message);
   }

   if ($message_extensions != null) {

     foreach($message_extensions as $ext) {
       if (strstr('message_prefix',$ext) == 0) {
         $message = $mail["$ext"] . $message;
       }
       else {
        $message .= $mail["$ext"];
       }
     }

   }

   $subject = $mail['Subject'];
   return mail($email,$subject,$message,$headers);
}


function emailValidate($email) {

$atom   = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';   // caractères autorisés avant l'arobase
$domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)'; // caractères autorisés après l'arobase (nom de domaine)
                               
$regex = '/^' . $atom . '+' .   // Une ou plusieurs fois les caractères autorisés avant l'arobase
'(\.' . $atom . '+)*' .         // Suivis par zéro point ou plus
                                // séparés par des caractères autorisés avant l'arobase
'@' .                           // Suivis d'un arobase
'(' . $domain . '{1,63}\.)+' .  // Suivis par 1 à 63 caractères autorisés pour le nom de domaine
                                // séparés par des points
$domain . '{2,63}$/i';          // Suivi de 2 à 63 caractères autorisés pour le nom de domaine

// test de l'adresse e-mail
if (preg_match($regex, $email)) {
    return true;
} else {

  return false;

}

}


function pathValidate($path,$os) {

  include('conf/regexp.inc.php');

  /* Unix Path Validator */
  if ($os == 'unix') {
    $match_res = preg_match($unixpath, $path);
    if (  $match_res == 0 ) return false;
    else return true;
  }

  /* WIndows Path Validator */
  else if ($os == 'windows') {
    $match_res = preg_match($winpath_1,$path);
    if ($match_res == 0) return false;

    $path_stripped = preg_replace($winpath_1,'',$path);

    $match_res = preg_match($winpath_2,$path_stripped);
    if ($match_res == 0) return false;
    else return true;
     
  }

  else return false;

}


function verifyAuth() {
  if (!isset($_SESSION)  ) session_start();
  if ( isset($_SESSION['uinfos'])) return true;
  else return false;
}


function registerCookie() {

   global $dbhandler;
   global $realip;
   $client_ip = $realip;
   $client_useragent = $_SERVER['HTTP_USER_AGENT'];
   $client_id = $_SESSION['id'];

   $randstring = generateToken();
   $dbh = mysql_query("INSERT INTO cookieauth (id_utilisateur,ip,useragent,cookie_code) VALUES (" .

                       "'$client_id', " .
                       "'$client_ip', " .
                       "'$client_useragent', " .
                       "'$randstring');"
   ,$dbhandler);

   setcookie('lcat_session',$randstring, (time() + 31536000));
}




function  cookieAuth() {

   global $dbhandler;
   global $realip;
   
   if (isset($_COOKIE['lcat_session']) ) {

      $lcat_session = $_COOKIE['lcat_session'];
      $client_ip = $realip;
      $client_useragent = $_SERVER['HTTP_USER_AGENT'];


     $lcat_session = protect('sql',$lcat_session);


      $dba = mysql_query("SELECT * FROM cookieauth WHERE cookie_code ='$lcat_session' LIMIT 1;"
                         , $dbhandler );

      
     $numrows = mysql_num_rows($dba);		
   

      if ( $numrows == 0 ) return false;

      else {
      	
			$result = mysql_fetch_row($dba);

			
            //cookie auth OK ! on établie la session
            if ($result[2] == $client_ip && $result[3] == $client_useragent) {

              $dba = mysql_query("SELECT * FROM utilisateur WHERE id_hexstring ='" . $result[1] ."' AND status !='desactive' LIMIT 1;"
                         , $dbhandler ); 

              
              $result = mysql_fetch_row($dba);

              $_SESSION['id']= $result[1];
			  $_SESSION['nickname']= $result[2];
			  $_SESSION['email']= $result[4];
			  $_SESSION['realname']= $result[5];

              return true;

            }
            

            //sinon cookie compromis / probleme: on efface
            else {

              return false;

            }
			
      }
    
   }
   
   return false;

}


function curl_getfile($url, $sortie, $timeout = 10)
{
    if ($fp = fopen($sortie, 'w')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $ret = curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return $ret;
    }
    return false;
}




function limitstr($str,$limit) {

  $result = substr($str,0,$limit);
  
  if ($result != $str) $result.="...";
  
  return $result;

}


function updatePassword($user_id,$oldpassword,$newpassword) {


  if (strlen($newpassword) < 6) die ('Erreur: Le nouveau mot de passe est trop court !');

  global $dbhandler;
  global $SALT;

  $oldpassword_hash = sha1( $SALT .  $oldpassword);
  $newpassword_hash = sha1( $SALT .  $newpassword);


  $dbh = mysql_query("SELECT password from utilisateur WHERE id_hexstring= '$user_id';",$dbhandler);
  
  $ans = mysql_fetch_assoc($dbh);

  if ($ans['password'] != $oldpassword_hash) die ('Erreur: Mot de passe courrant invalide !');

 
  $dbh = mysql_query("UPDATE utilisateur set password = '$newpassword_hash' WHERE id_hexstring= '$user_id';",$dbhandler);


}



function updateEmail($user_id,$email) {

   if ( checkExists('email',$email)) {

      die ('Erreur: cet email éxiste déjà dans notre base de données');

   }

  if ( ! emailValidate($email) ) {

    die ('Erreur: L\'email fourni n\'est pas au bon format');

  }

  $dba = mysql_query("UPDATE utilisateur set email ='$email' WHERE id_hexstring = '$user_id' ; ");

  $_SESSION['email'] = $email;
       
}




/*
function selectLanguage() {
  global $lang;
  global $LANG_LIST;

  if (!isset($_SESSION)) session_start();
  if (isset($_SESSION['lang'])) $lang = $_SESSION['lang'];

  else if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){

    $found = false;
    $al_str = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    $al = explode(',',$al_str);
    foreach($al as $accepted_language) {
      foreach ($LANG_LIST as $key => $value) {
        if (strstr($accepted_language,$key) !== false) {
          $lang = $key;
          return;
        }
      }
    }
    $lang = 'en';
  }
  else $lang = 'en';
}
*/

/* temp function for selectlanguage, which gives priority to fr */
function selectLanguage() {
  global $lang;
  global $LANG_LIST;

  if (!isset($_SESSION)) session_start();
  if (isset($_SESSION['lang'])) $lang = $_SESSION['lang'];
  else $lang = 'fr';
}


 function getPageTitle() {
  global $lang;
  global $lang_array;
  global $corrected_uri;

  require_once("lang/$lang/titles.lang.php");

  if (isset($titles[$corrected_uri])) return $titles[$corrected_uri];
  else return $lang_array['title'];
 }

 
function apiinfos() {
  global $API_VERSION;
  global $API_LASTMOD;
  echo "Chiliconfig API Version $API_VERSION\n";
  echo "Last Modifications: $API_LASTMOD\n";  
}?>