<?php
  include ('classes/strategy.php');
  $strats = getStrategies();
?>

<table class="table table-striped" id="strategies-table" style="margin-top:20px">
  <tr>
    <th><?= $lang_array['app']['name'] ?></th>
    <th><?= $lang_array['app']['type'] ?></th>
    <th><?= $lang_array['app']['author'] ?></th>
    <th><?= $lang_array['app']['status'] ?></th>
    <th><?= $lang_array['app']['createdon'] ?></th>
    <th><?= $lang_array['app']['updatedon'] ?></th>
    <th><?= $lang_array['app']['actions'] ?></th>
  </tr>

<?php

foreach ($strats as $strat) {
    $tdclass = ($strat->active ==1 ) ? 'activated' : '';
    $togglebtn_class = ($strat->active == 1) ? "btn-info" : "btn-success";
    $togglebtn_icon = ($strat->active == 1) ? "icon-stop" : "icon-play";
    $actbtnclick = "adamToggleStrat($(this));" ;
    $delbtnclass = ($strat->active == 1) ? "disabled" : "btn-danger";
    $deltbtnclick = ($strat->active == 1) ? "" :  "adamDelStrat('" . $strat->name . "');" ;    
?>

  <tr id="strategy-line-<?= $strat->name ?>">
    <td class="<?= $tdclass  ?>"><?=  $strat->name ?></td>
    <td class="<?= $tdclass  ?>"><?=  $strat->type ?></td>
    <td class="<?= $tdclass  ?>"><?=  $strat->author ?></td>
    <?php if ( $strat->type == "normal" )  { ?>
      <td class="<?= $tdclass  ?>"> <span text-disabled="<?= $lang_array['app']['disabled'] ?>" text-active="<?= $lang_array['app']['active'] ?>" class="label label-<?= ($strat->active == 1) ? "success" : "inverse"  ?>"><?=  ($strat->active == 1) ? $lang_array['app']['active']: $lang_array['app']['disabled'] ?> </div></td>
    <?php } else { ?>
      <td class="<?= $tdclass  ?>"> -- </td>
    <?php } ?>

    <td class="dtime <?= $tdclass  ?>"><?=  $strat->created ?></td>
    <td class="dtime <?= $tdclass  ?>"><?=  $strat->updated ?></td>
    <td class="<?= $tdclass  ?>">
      <div class="btn-group" style="<?= ( $strat->type != 'normal' )  ? 'margin-left:40px' : '' ?>">

        <?php if ($strat->type == "normal") {  ?>

        <a class="btn <?= $togglebtn_class ?> btn-toggle-strat" id="btn-toggle-strat" onclick="<?= $actbtnclick ?>" ><i class="icon-white <?= $togglebtn_icon ?>"></i></a>
        <?php } ?>
        <a class="btn btn-inverse btn-strat-edit" target="_blank" href="/app/editor?strat=<?= $strat->name ?>"
           rel="tooltip"
           title="<?= $lang_array['app']['strategy_actions_edit'] ?>">
          <i class="icon-white icon-edit"></i>
        </a>
        <a onclick="$(this).tooltip('hide');adamCloneStrat('<?= $strat->name ?>');" class="btn btn-inverse" rel="tooltip"  title="<?= $lang_array['app']['strategy_actions_clone'] ?>">
          <i class="icon-white icon-leaf"></i>
        </a>
        <a onclick="<?= $deltbtnclick ?>" class="btn <?= $delbtnclass ?>" id="btn-del-strat" rel="tooltip" title="<?= $lang_array['app']['strategy_actions_delete'] ?>">
          <i class="icon-white icon-remove-sign" ></i>
        </a>
      </div>

    </td>
  </tr>

<?php } ?>
</table>

<script type="text/javascript">

</script>