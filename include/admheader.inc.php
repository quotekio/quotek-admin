<?php
  require_once('include/admfunctions.inc.php'); 
  require_once('classes/chiliuser.php');
  require_once('classes/chiliconfig.php');
?>

<!DOCTYPE HTML>
<html>
<head>

  <META http-equiv="Content-Type" Content="text/html; charset=UTF-8">
  <title>Back Office Chiliconfig 0.1</title>

  <LINK rel=stylesheet type="text/css" href="/css/chiliconfig.css">
  <LINK rel=stylesheet type="text/css" href="/css/builder.css">
  <LINK rel=stylesheet type="text/css" href="/css/adm.css">
  <LINK rel=stylesheet type="text/css" href="/css/ui-lightness/jquery-ui-1.8.23.custom.css">

  <LINK REL="SHORTCUT ICON" href="/favicon.png">
  
  <script type="text/javascript" src="/js/jquery.js"></script>
  <script type="text/javascript" src="/js/jquery-ui-1.8.23.custom.min.js"></script>
  <script type="text/javascript" src="/js/chiliconfig.js"></script>

</head>

<body>

  <div style="background:white;color:black" id="ajaxdbg"></div>
  <div id="modal_win"></div>
  <div id="modal_bg"></div>

  <div id="cbuilder_menu">
  Chiliconfig <font style="color:#f26024">BackOffice</font> 
  </div>
