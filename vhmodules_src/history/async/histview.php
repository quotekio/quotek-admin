<?php
include('include/functions.inc.php');

global $lang;
selectLanguage();

include ("lang/$lang/app.lang.php");
include ('backendwrapper.php');

$b = new backendwrapper();
$cur_month = mktime (0, 0, 0, date("n"), 1);
$phistlist = $b->query_history($cur_month,time(0)); 

?>

<table class="table table-striped table-bordered" id="histpostable">

  <tr>
	  <th><?=  $lang_array['app']['name'] ?></th>
	  <th>Id <?= $lang_array['app']['broker'] ?></th>
	  <th><?= $lang_array['app']['size'] ?></th>
	  <th><?= $lang_array['app']['open'] ?></th>
	  <th><?= $lang_array['app']['stop'] ?></th>
	  <th><?= $lang_array['app']['limit'] ?></th>
    <th><?= $lang_array['app']['open_time'] ?></th>
    <th><?= $lang_array['app']['close_time'] ?></th>

	  <th>PNL</th>
    <th> PNL Peak</th>
  </tr>

  <?php foreach($phistlist as $pos)  {?>

  <tr>
    <td><?= $pos->indice ?></td>
    <td><?= $pos->epic ?></td>
    <td><?=$pos->size ?></td>
    <td><?=$pos->open ?></td>
    <td><?=$pos->stop ?></td>
    <td><?=$pos->limit ?></td>
    <td><?= $pos->open_time ?></td>
    <td><?= $pos->close_time ?></td>
    <td style="font-weight:bold;color:<?= ($pos->pnl > 0) ? '#699e00' : '#c00' ?>" ><?=$pos->pnl ?></td>
    <td style="font-weight:bold;color:<?= ($pos->pnl_peak > 0) ? '#699e00' : '#c00' ?>" ><?=$pos->pnl_peak ?></td>
    

  </tr>


  <?php } ?>

</table>
