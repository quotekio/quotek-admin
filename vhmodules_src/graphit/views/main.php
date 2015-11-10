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

          <div class="app-headed-white-frame" style="padding-bottom:20px">
            <div class="app-headed-frame-header">
             
              <div class="span6" style="text-align:left">
                <h4 id="grapheditor-title"></h4>
              </div>
   
              <div class="span6" style"text-align:right">
                <button style="margin-top:15px" type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="$('#grapheditor').slideUp('fast');">&times;</button>
              </div>

            </div>
            
            <div style="padding:15px">
              <!-- Form Fields -->
              <label><b><?= $lang_array['graphit']['name'] ?></b></label>
              <input id="input-grapheditor-name" style="height:27px;width:150px" type="text" value="New Graph">
              <span class="help-block"><?= $lang_array['graphit']['name_hint'] ?></span>

              <label><b><?= $lang_array['graphit']['refresh'] ?></b></label>
              <input id="input-grapheditor-refresh" style="height:27px;width:100px" type="text" value="20">
              <span class="help-block"><?= $lang_array['graphit']['refresh_hint'] ?></span>

              <br><br>
              <h4><?= $lang_array['graphit']['component_title'] ?></h4>

              <table id="input-grapheditor-components" class="table">
              
                <tr id="input-grapheditor-head">
                  <th><?= $lang_array['graphit']['tag_th'] ?></th>
                  <th><?= $lang_array['graphit']['color_th'] ?></th>
                  <th><?= $lang_array['graphit']['type_th'] ?></th>
                  <th><?= $lang_array['graphit']['query_th'] ?></th>
                  <th><?= $lang_array['graphit']['action_th'] ?></th>
                </tr>
              
                <!-- Component adding line -->
                <tr id="components-editor">
                  <td style="border-radius:5px 0px 0px 5px">
                    <input id="input-component-tag" style="background:rgba(255,255,255,0.6);height:27px;width:90px" type="text" value="var@CAC40">
                  </td>

                  <td>
                    <input class="cpicker" id="input-component-color" style="background:rgba(255,255,255,0.6);height:27px;width:70px" type="text" value="#FF0000">
                  </td>

                  <td>
                    <select id="input-component-graph_type" style="background:rgba(255,255,255,0.6);height:34px;width:80px">
                      <option value="line" SELECTED>line</option>
                      <option value="dots">dots</option>
                      <option value="bars">bars</option>
                      <option value="pie">pie</option>

                    </select>
                  </td>

                  <td>
                    <input id="input-component-influx_query" style="background:rgba(255,255,255,0.6);height:27px;width:350px" type="text" value="SELECT last(data) FROM __save__ WHERE tag='var@CAC40'" >
                  </td>

                  <td style="border-radius:0px 5px 5px 0px">
                    <a class="btn btn-warning" onclick="addComponent();" ><?= $lang_array['app']['add'] ?></a>
                  </td>

                </tr>
                <!-- End component adding line -->

              </table>
            </div>
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

  $('.cpicker').colorpicker();

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


  function addComponent() {

   var nc = $('#components-editor').clone();
   
   nc.attr('id','');
   nc.addClass('component-line');
   nc.css('background',$('#input-component-color', nc).val());
   //$('td',nc).css('padding','0px');
   $('td',nc).css('padding-bottom','0px');

   $('a',nc).toggleClass('btn-warning btn-danger');
   $('a',nc).html('<?= $lang_array['app']['del'] ?>');
   
   var head = $('#input-grapheditor-head');
   head.after(nc);
   //nc.appendTo(slot);



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


