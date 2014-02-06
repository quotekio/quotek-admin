<?php ?>

<div class="navbar navbar-static-top">
 
  <div class="navbar-inner" style="height:45px">
    <div>

         <img style="height:40px;margin-left:28px;" src="/img/vhlogo2.png">
      
     <a class="btn btn-inverse" style="float:right;margin-top:10px" onclick="adamShowAbout()"><i class="icon-white icon-info-sign"></i></a>

      <div class="btn-group" style="float:right;margin-right:50px;margin-top:10px">
        <a class="btn disabled" id="app-stopadam" rel="tooltip" title="<?= $lang_array['app']['adam_stop'] ?>">
        	<i class="icon-white icon-stop"></i>
        </a>
        <a class="btn disabled" id="app-startadam" rel="tooltip" title="<?= $lang_array['app']['adam_start'] ?>"><i class="icon-white icon-play"></i></a>
        <a class="btn btn-warning" id="app-restartadam" onclick="adamRestart();" rel="tooltip" title="<?= $lang_array['app']['adam_restart'] ?>"><i class="icon-white icon-refresh"></i></a>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  $('#app-stopadam').tooltip({placement:'bottom',container: 'body'});
  $('#app-startadam').tooltip({placement:'bottom',container: 'body'});
  $('#app-restartadam').tooltip({placement:'bottom',container: 'body'});
</script>