<div class="app-display" id="adambacktest">

  
  <div class="title">
    <h3><?= $lang_array['app']['adambacktest_title'] ?> <small><?= $lang_array['app']['adambacktest_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?=  $lang_array['app']['adambacktest_expl'] ?></p>
    </div>

   </div>

  <div class="table-ct" id="backtests-table-wrapper">
  </div>
  


 
</div>

<script type="text/javascript">

  adamRefreshTable('backtests-table');

  $('#adambacktest').bind('afterShow',function() {

    $('.newbtn').removeAttr('href');
    $('.newbtn').removeAttr('target');
    $('.newbtn').click(function() {
                                 adamShowBacktestEditor();
                                 $('#editor-title').html("<?= $lang_array['app']['adambacktest_editor_create_title']  ?>");
                                 $('#editor-action').html("<?= $lang_array['app']['create'] ?>");

                                 $('#editor-action').off();
                                 $('#editor-action').click(function() {
                                     adamSaveBacktest();
                                 });

                           });

    $('.newbtn').attr('title','<?= $lang_array['app']['newbacktest'] ?>');

   });


</script>