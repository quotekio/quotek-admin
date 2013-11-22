<?php
   include('include/functions.inc.php');   
   $lang='';
   selectLanguage();

   include ("lang/$lang/app.lang.php");

   if (!isset($_REQUEST['tname'])) die('Invalid Table Name');
   $tname = $_REQUEST['tname'];

   if ($tname == 'strategies-table') include('templates/tables/strategies.tpl.php');
   else if ($tname == 'values-table') include('templates/tables/values.tpl.php');
   else if ($tname == 'corecfg-table') include('templates/tables/corecfg.tpl.php');
   else if ($tname == 'brokercfg-table') include('templates/tables/brokercfg.tpl.php');
   else if ($tname == 'backtests-table') include('templates/tables/backtests.tpl.php');

?>