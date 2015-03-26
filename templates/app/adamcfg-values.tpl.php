<div class="app-display" id="adamcfg-values">


  <div class="title">
    <h3><?= $lang_array['app']['adamvalues'] ?> <small><?= $lang_array['app']['adamvalues_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?=  $lang_array['app']['adamvalues_expl'] ?></p>
    </div>

   </div>

  
  <div class="table-ct" id="values-table-wrapper">
  </div>

</div>

<script type="text/javascript">

  adamRefreshTable('values-table');
  

  $('#adamcfg-values').bind('afterShow',function() {

      $('.newbtn').click(function() {
                                 adamShowValueEditor();
                                 $('#editor-title').html("<?= $lang_array['app']['adamvalue_editor_create_title']  ?>");
                                 $('#editor-action').html("<?= $lang_array['app']['create'] ?>");

                                 $('#editor-action').off();
                                 $('#editor-action').click(function() {  adamSaveValue();  });

                               });

      $('.newbtn').attr('title','<?= $lang_array['app']['adamvalues_new'] ?>');
  });


 
</script>