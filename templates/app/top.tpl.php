<?php ?>

<div id="app-topbar-container" class="navbar navbar-static-top" style="display:none">
 
  <div class="navbar-inner" id="app-topbar">

     <div style="float:left;width:166px">

       <a href="#" onclick="adamShowAbout()"><img style="height:30px;margin-top:4px;" src="/img/quotek-logo.png"></a>
     </div>

      <div style="float:left;margin-left:20px;width:300px;height:40px;margin-top:-5px" id="adam-top-modules">
        <?php  loadVHViews($vhms,'top') ?>
      </div>
      
      <div class="langsel-ct dropdown" style="float:right;margin-right:40px;">
        <a id="app-langsel" class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#" rel="tooltip" title="<?= $lang_array['app']['langsel'] ?>"><i class="icon-white icon-globe"></i></a> 
        <ul class="dropdown-menu pull-right">
 
          <?php
            foreach($LANG_LIST as $k => $v) {
          ?>
             <li><a href="/?lang=<?= $k ?>"><?= $v ?></a></li>
          <?php } ?>
        </ul>

      </div>

    </div>
  </div>

  <div id="adam-top-notifier" class="alert alert-info" style="margin-bottom:0px;display:none">
  <div id="notify-restart">
     <?= $lang_array['app']['notify_restart'] ?>
     <script type="text/javascript">
       $('#notify-restart a').click(function() {  adamRestart(); });
     </script>
  </div>
  </div>


  
  <div id="app-titlebar"></div>
  <!-- Dirty Trick to avoid DOM Elt duplication
       puts newbtn to display:false for loading trick
   -->
  <a class="newbtn btn-warning" id="btn-corecfg-new" style="display:none">
      <i class="icon icon-white icon-plus"></i>
  </a>



<div class="robotcontrol" style="display:none">

  <div class="btn-group">
    
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

  <img style="height:25px;margin-left:3px" src="/img/bot_small.png"/>

</div>





<script type="text/javascript">

  $(document).ready(function() {

    $('#app-stopadam').tooltip({placement:'bottom',container: 'body'});
    $('#app-startadam').tooltip({placement:'bottom',container: 'body'});
    $('#app-restartadam').tooltip({placement:'bottom',container: 'body'});

    $('#app-langsel').tooltip({placement:'bottom', container:'body'});
    
    $('.newbtn').tooltip({placement: 'left', container: 'body'});


  });

  



</script>
