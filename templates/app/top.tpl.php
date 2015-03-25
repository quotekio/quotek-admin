<?php ?>

<div class="navbar navbar-static-top">
 
  <div class="navbar-inner" style="background:#F3F3F4!important">


     <div style="float:left;width:166px">

       <a href="#" onclick="adamShowAbout()"><img style="height:30px;margin-top:4px;" src="/img/quotek-logo.png"></a>
     </div>

      <div style="float:left;margin-left:20px;width:300px;height:40px;margin-top:-5px" id="adam-top-modules">
        <?php  loadVHViews($vhms,'top') ?>
      </div>



      <!-- Disabled command prompt, we don't need it so far
      <div style="float:right;margin-top:10px;margin-right:50px"class="input-append">
        <input id="adam-cmdprompt" type="text">
        <button id="adam-cmdsend-btn" class="btn" type="button"><i class="icon-white icon-chevron-right"></i></button>
      </div>
      -->

      <div class="btn-group" style="float:right;margin-right:20px;margin-top:10px">
        
        <?php  loadVHViews($vhms,'topbtn') ?>

        <a class="btn disabled" id="app-stopadam" rel="tooltip" title="<?= $lang_array['app']['adam_stop'] ?>">
        	<i class="icon-white icon-stop"></i>
        </a>
        <a class="btn disabled" 
                 id="app-startadam" 
                 rel="tooltip" 
                 title="<?= $lang_array['app']['adam_start'] ?>">
                 <i class="icon-white icon-play"></i>
        </a>

        <a class="btn btn-warning" id="app-restartadam" onclick="adamRestart();" rel="tooltip" title="<?= $lang_array['app']['adam_restart'] ?>"><i class="icon-white icon-refresh"></i></a>
        
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  $('#adam-cmdprompt').keydown(function (event) {
         var keypressed = event.keyCode || event.which;
         if (keypressed == 13) {
             adamSendOrder();
         }
  });

  $('#adam-cmdsend-btn').click(function(){ adamSendOrder(); });

  $('#app-stopadam').tooltip({placement:'bottom',container: 'body'});
  $('#app-startadam').tooltip({placement:'bottom',container: 'body'});
  $('#app-restartadam').tooltip({placement:'bottom',container: 'body'});
</script>
