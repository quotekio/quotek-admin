<div class="app-display" id="qatecfg-values">


  <div class="title">
    <h3><?= $lang_array['app']['qatevalues'] ?> <small><?= $lang_array['app']['qatevalues_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?=  $lang_array['app']['qatevalues_expl'] ?></p>
    </div>

   </div>

  
  <div class="table-ct" id="values-table-wrapper">
  </div>

</div>

<script type="text/javascript">

  qateRefreshTable('values-table');
  

  $('#qatecfg-values').bind('afterShow',function() {

      $('.newbtn').removeAttr('href');
      $('.newbtn').removeAttr('target');
      $('.newbtn').click(function() {
                                 qateShowValueEditor();
                                 $('#editor-title').html("<?= $lang_array['app']['qatevalue_editor_create_title']  ?>");
                                 $('#editor-action').html("<?= $lang_array['app']['create'] ?>");

                                 $('#editor-action').off();
                                 $('#editor-action').click(function() {  qateSaveValue();  });

                               });

     $('.newbtn').attr('data-original-title', '<?= $lang_array['app']['newvalue_tooltip'] ?>')
    .tooltip('fixTitle');

  });


 
</script>