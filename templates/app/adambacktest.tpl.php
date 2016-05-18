<div class="app-display" id="qatebacktest">

  
  <div class="title">
    <h3><?= $lang_array['app']['qatebacktest_title'] ?> <small><?= $lang_array['app']['qatebacktest_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?=  $lang_array['app']['qatebacktest_expl'] ?></p>
    </div>

   </div>

  <div class="table-ct" id="backtests-table-wrapper">
  </div>
  


 
</div>

<script type="text/javascript">

  qateRefreshTable('backtests-table');

  $('#qatebacktest').bind('afterShow',function() {

    $('.newbtn').removeAttr('href');
    $('.newbtn').removeAttr('target');
    $('.newbtn').click(function() {
                                 qateShowBacktestEditor();
                                 $('#editor-title').html("<?= $lang_array['app']['qatebacktest_editor_create_title']  ?>");
                                 $('#editor-action').html("<?= $lang_array['app']['create'] ?>");

                                 $('#editor-action').off();
                                 $('#editor-action').click(function() {
                                     qateSaveBacktest();
                                 });

                           });

    $('.newbtn').attr('data-original-title', '<?= $lang_array['app']['newbacktest_tooltip'] ?>')
    .tooltip('fixTitle');

   });


</script>