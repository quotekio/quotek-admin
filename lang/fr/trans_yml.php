#!/usr/bin/env php
<?php

  function translate_rec($prevkey,$tab,$fh) {
    foreach($tab as $key => $value) {
  
      if (is_array($value)) {
        translate_rec($prevkey . "_" . $key,$value,$fh);     
      }     

      else {
        fwrite($fh, $prevkey . "_" . $key . ": $value\n");
      }
    }
  }

  function translate($file) {

    include($file);
    $file = str_replace('.lang.php','.fr.yml',$file);
    $fh = fopen($file,'w');
    foreach ($lang_array as $key => $value) {
  
      if (is_array($value)) {
        translate_rec($key,$value,$fh);
      }
      else {
        fwrite($fh,"$key: $value\n");
      }
    }
    fclose($fh);
    unset($lang_array);
  }


  $dh = opendir('.');

  while(($f = readdir($dh) ) !== false) {

    if (strstr($f,'lang.php') !== false) {
      print $f . "\n";
      translate($f);


    }
  }
?>
