<div class="app-display" id="builder">

  
   <div id="app-builder-help-content" style="display:none">
    <div class="alert alert-info" style="margin:0px!important">
      <?= $lang_array['app']['builder_help'] ?>
     </div>
   </div>

   <div id="app-builder-help-title" style="display:none">
    <?= $lang_array['app']['builder_help_title'] ?>
   </div>


	<div class="page-header" style="overflow:hidden">
           <div style="width:80%;float:left"> 
           <h3><?= $lang_array['app']['builder']  ?>
             <small><?= $lang_array['app']['builder_subtitle']  ?></small>
           </h3>
         </div>
          <div style="width:20%;float:left;text-align:right">
            <a class="btn" href="#">
              <img id="app-builder-illus" style="height:50px" src="">
            </a>
          </div>
    </div>

    
  <div id="app-builder-horiz-dotted-steplist-container"> </div>

<!--
  <div id="app-builder-treeview" style="display:none">
  </div>
-->

  <div class="well" style="padding-left:0px;padding-right:0px" id="app-builder-container">

     

     <div class="row-fluid" style="">
      <div class="span1"></div>
       <!-- <div class="span1" style="margin-top:120px">
         <a class="app-builder-nav-btn2" id="app-builder-prev-btn" href="#" onclick="">&lsaquo;&lsaquo;</a>
       </div> -->
       <div class="span10" id="app-builder-middle">

         

       </div>
       <!-- <div class="span1" style="text-align:right;margin-top:120px">
         <a class="app-builder-nav-btn2" id="app-builder-next-btn" 
            style="border-radius:8px 0px 0px 8px;"
            href="#" onclick="">&rsaquo;&rsaquo;</a>
       </div> -->
       <div class="span1"></div>
     </div>

    <div style="text-align:center">
    
    </div>

  </div>


  <div class="navbar navbar-fixed-bottom">

    <div class="navbar-inner" style="">

      <div style="width:60%;float:left">

      <div class="alert alert-danger" id="app-builder-alert-enveloppe" style="display:none;margin-bottom:0px">
        <div id="app-builder-alert"></div>
      </div>

      </div>

      <div style="width:40%;margin-left:60%;text-align:right">

       <a class="btn btn-info" id="app-builder-help-link" rel="popover" data-placement="top" href="#">?</a>

       <a class="btn btn-danger" onclick="appConfirm('reset-builder')" href="#"><?= $lang_array['app']['builder_reset']  ?></a>

       <div class="btn-group">       
       <a id="app-builder-prev-btn" class="btn btn-inverse disabled" onclick="appBuilderPrev();" href="#"><?= $lang_array['app']['builder_prev']  ?></a>
       <a id="app-builder-next-btn" class="btn btn-inverse" onclick="appValidStep();" href="#"><?= $lang_array['app']['builder_next'] ?></a>
       </div>

       <a id="app-builder-finish-btn" class="btn disabled" onclick="" href="#" style="margin-right:15px"><?= $lang_array['app']['builder_finish'] ?></a>


      </div>

    </div>

  </div>


</div>

<script type="text/javascript">
      $('#app-builder-help-link').popover({html: true, content: $('#app-builder-help-content').html(),title: $('#app-builder-help-title').html()});
</script>
