<?php

   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
   require_once "graph.php";

   $graphs = getGraphs();

   
?>

<div id="visualize-tooltip" style="display:none;position:absolute;padding:4px;background:#131517;border-radius:4px;font-size:11px;opacity:1.0!important;z-index:3000">
</div>


<div class="app-display" id="graphit">
        
  	    <div class="title">
  		  <h3>Graph-it
  		    <small><?= $lang_array['graphit']['subtitle']  ?></small>
            </h3>
        </div>

        <!-- Graph Editor -->
        <div id="grapheditor" class="row-fluid" style="margin-bottom:30px;display:none">

          <div class="app-headed-white-frame" style="height:300px;padding-bottom:20px">
            <div class="app-headed-frame-header">
             
              <div class="span6" style="text-align:left">
                <h4 id="grapheditor-title"></h4>
              </div>
   
              <div class="span6" style"text-align:right">
                <button style="margin-top:15px" type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$('#grapheditor').slideUp('fast');">&times;</button>
              </div>

            </div>
             
            <!-- Form Fields -->

          </div>

        </div>
        <!-- End Graph Editor -->




        <div class="row-fluid">

        <?php

        $i=0;
        foreach($graphs as $g) {
          $i++;
        ?>

        <div class="span6">
          <div class="app-headed-white-frame" style="height:300px;padding-bottom:20px">
            <div class="app-headed-frame-header">
             
              <div class="span6" style="text-align:left">
                <h4><?= $g->name ?></h4>
              </div>
            </div>
              <div linked-asset="<?= $g->name ?>" id="visualize-draw" style="height:267px;text-align:center;">
              <br><img src="/img/loader2.gif" style="width:25px;margin-top:100px"/>
             </div>
          </div>
        </div>

        <?php
          if ($i %2 == 0) {
            echo "</div><div class=\"row-fluid\" style=\"margin-top:25px\">";
          }
        }

        ?>

      </div>

</div>


<script type="text/javascript">

  function grapObject(action, type, data) {

    data = (typeof data == 'undefined') ? "" : data;

    var rgo = $.ajax({

      url: '/async/vhmodules/graphit/graphobject',
      type: 'POST',
      data : { 'action': action,
              'type': type,
              'data': data },
      async: true,
      cache: false,
      success: function() {

      }

    });

  }


  function dispGraph(tag, existing_plot) {

  }

  function dispAllGraph() {

  }

  function showGraphEditor(mode) {

    if (mode == "create") $('#grapheditor-title').html('<?= $lang_array['graphit']['editor_create_title'] ?>');
    else $('#grapheditor-title').html('<?= $lang_array['graphit']['editor_edit_title']   ?>');

    $('#grapheditor').slideDown("fast");

  }


  $('#graphit').bind('afterShow',function() {

    $('.newbtn').show();
    $('.newbtn').off('click');
    $('.newbtn').click(function() {  showGraphEditor("create");   });
      
  });

  $(document).ready(function() {

  });


</script>


