<?php

function getRealIP() {
  if (!isset($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['REMOTE_ADDR'];
  else return $_SERVER['HTTP_X_FORWARDED_FOR'];
}

?>


