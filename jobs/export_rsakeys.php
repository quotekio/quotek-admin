<?php

$period=60;
$exec = function() {

  global $GIT_USER;
  $users = getUserList();
  $keylist = "";

  foreach ($users as $user) {
    if (isset($user->rsa_key)) $keylist .= $user->rsa_key . "\n";
  }
  file_put_contents("/home/$GIT_USER/.ssh/authorized_keys",$keylist);
};

?>