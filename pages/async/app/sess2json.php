<?php

  session_start();

  if (count($_REQUEST) == 0) {
    echo json_encode($_SESSION);
  }

  else {

    foreach($_REQUEST as $key => $value) {
      $param  = $key;
      break;
    }
    echo json_encode($_SESSION["$param"]);
  }

?>