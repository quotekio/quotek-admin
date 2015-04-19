<?php

include('functions.inc.php');

global $lang;
selectLanguage();

include ("lang/$lang/app.lang.php");
include ('backendwrapper.php');

$b = new backendwrapper();
$cur_month = gmmktime (0, 0, 0, gmdate("n"), 1);
$phistlist = $b->query_history($cur_month,time(0)); 


?>


<table class="table table-striped table-bordered" id="histpostable">

  <tr>
	  <th><?=  $lang_array['app']['name'] ?></th>
	  <th class="s_hide">Id <?= $lang_array['app']['broker'] ?></th>
	  <th class="s_hide"><?= $lang_array['app']['size'] ?></th>
	  <th class="s_hide"><?= $lang_array['app']['open'] ?></th>
	  <th class="s_hide"><?= $lang_array['app']['stop'] ?></th>
	  <th class="s_hide"><?= $lang_array['app']['limit'] ?></th>
	  <th>PNL</th>
    </th> PNL Peak</th>

  </tr>

  <?php foreach($phistlist as $pos)  {?>

  <tr>
    <td><?= $pos->indice ?></td>
    <td class="s_hide"><?= $pos->epic ?></td>
    <td class="s_hide"><?=$pos->size ?></td>
    <td class="s_hide"><?=$pos->open ?></td>
    <td class="s_hide"><?=$pos->stop ?></td>
    <td class="s_hide"><?=$pos->limit ?></td>
    <td style="font-weight:bold;color:<?= ($pos->pnl > 0) ? '#699e00' : '#c00' ?>" ><?=$pos->pnl ?></td>
    <td style="font-weight:bold;color:<?= ($pos->pnl > 0) ? '#699e00' : '#c00' ?>" ><?=$pos->pnl ?></td>
  </tr>


  <?php } ?>

</table>
