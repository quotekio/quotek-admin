<?php
include 'strategy.php';

$surl = explode('/', $corrected_uri);
$sname = array_pop($surl);

$s1 = new strategy();
$s1->name = $sname;
$s1->load();

?>

<!DOCTYPE HTML>
<html>
  <head>
     <META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
     <link rel="stylesheet" href="/css/bootstrap.css">
     <link rel="stylesheet" href="/css/bootstrap_ex.css">
     <link rel="stylesheet" href="/css/quotek.css">
     <link rel="stylesheet" href="/css/notebook.css">

  </head>
  <body>
  	<div class="topbar">
  	  <img src="/img/quotek-logo.png" style="height:22px"/>&nbsp;<span style=""><b>(notebook)</b></span>
  	</div>
    <div class="container paper">
      <?= $s1->notebook ?>
    </div>
  </body>
</html>