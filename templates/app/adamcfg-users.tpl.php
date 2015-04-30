<div class="app-display" id="adamcfg-users">

  <div class="title">
    <h3><?= $lang_array['app']['cfg_users_title'] ?> <small><?= $lang_array['app']['cfg_users_subtitle'] ?></small></h3>
  </div>

  <div class="row-fluid">
    <div class="span8">
       <p><?=  $lang_array['app']['cfg_users_expl'] ?></p>
    </div>

   </div>

  <div class="table-ct" id="userscfg-table-wrapper">
  </div>
  
</div>

<script type="text/javascript">

  function adamUsercfgEditorNav(obj) {
     $('.usercfg-editor-frame').hide();
     $('#usercfg-editor-' +  obj.attr('id') ).show();

     $('.usercfg-editor-navlink').parent().removeClass('active');
     obj.parent().addClass('active');

  }


</script>