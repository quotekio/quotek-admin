<div class="app-display" id="adambacktest">

  
  <div class="title">
    <h3><?= $lang_array['app']['adambacktest_title'] ?> <small><?= $lang_array['app']['adambacktest_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?=  $lang_array['app']['adambacktest_expl'] ?></p>
    </div>

    <div class="span4" style="margin-top:-10px">
       <a id="btn-adambacktest-new" class="btn btn-large btn-warning"><?= $lang_array['app']['newbacktest'] ?></a>
    </div>

   </div>

  <div class="table-ct" id="backtests-table-wrapper">
  </div>
  


 
</div>

<script type="text/javascript">

  adamRefreshTable('backtests-table');

  $('#adambacktest').bind('afterShow',function() {

    $('.newbtn').click(function() {
                                 adamShowBacktestEditor();
                                 $('#editor-title').html("<?= $lang_array['app']['adambacktest_editor_create_title']  ?>");
                                 $('#editor-action').html("<?= $lang_array['app']['create'] ?>");

                                 $('#editor-action').off();
                                 $('#editor-action').click(function() {
                                     adamSaveBacktest();
                                 });

                               });
   });


</script>