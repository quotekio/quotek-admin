<?php

   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
   require_once "valuecfg.php";
   require_once "corecfg.php";

   $cfg = getActiveCfg();
   $vals = getCfgValues($cfg->id);

   
?>

<div class="app-display" id="visualize">
        
  	    <div class="page-header">
  		  <h3>Visualize
  		    <small><?= $lang_array['visualize']['subtitle']  ?></small>
            </h3>
        </div>

        <div class="row-fluid">
          <div class="navbar">
            <div class="navbar-inner">

              <div class="span4">

                <div class="span3">
                    <h3>Début:</h3>
                 </div>

                 <div class="span9">

                  <div id="visualize-datepicker-tinf" class="input-append date" style="margin-top:15px">
                  <input id="visualize-input-tinf" data-format="yyyy-MM-dd hh:mm:ss" type="text" style="font-size:14px!important;height:27px "></input>
                  <span class="add-on btn-success" style="padding-top:4px!important;padding-bottom:4px!important;background:#699E00!important">
                    <i data-time-icon="icon-time icon-white" data-date-icon="icon-calendar icon-white">
                    </i>
                  </span>
                </div>

              </div>


              </div>

              <div class="span4">
                <div class="span3">
                  <h3>Fin:</h3>
                </div>

                <div class="span9">

                  <div id="visualize-datepicker-tsup" class="input-append date" style="margin-top:15px">
                  <input id="visualize-input-tsup" data-format="yyyy-MM-dd hh:mm:ss" type="text" style="font-size:14px!important;height:27px "></input>
                  <span class="add-on btn-success" style="padding-top:4px!important;padding-bottom:4px!important;background:#699E00!important">
                    <i data-time-icon="icon-time icon-white" data-date-icon="icon-calendar icon-white">
                    </i>
                  </span>
                </div>

                </div>

              </div>

              <div class="span4" style="text-align:right">
                <a class="btn btn-success" style="margin-top:12px!important">
                  Visualize!
                </a>
              </div>


            </div>
          </div>
        </div>


        <div class="row-fluid">

        <?php

        $i=0;
        foreach($vals as $v) {
          $i++;
        ?>

        <div class="span6">
          <div class="app-headed-white-frame" style="height:300px">
            <div class="app-headed-frame-header"><h4><?= $v->name ?></h4></div>
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


  $('#visualize-datepicker-tinf').datetimepicker({
      language: 'fr-FR'
    });

    $('#visualize-datepicker-tsup').datetimepicker({
      language: 'fr-FR'
    });



  function displayGraph(iname) {

    var data = $.ajax({'url': '/async/vhmodules/visualize/stats?tinf=' + tinf + "&tsup=" + tsup + "&indice=" + iname })
    
    var options = {

            xaxis: {
              mode: "time",
              axisLabel: 'Time'
            },   

            grid: {
                   show: true,
                   borderWidth: 0,
                   hoverable: true,
                   clickable: true,
             },

             selection: {
                    mode: "x"
             },

    };


  }




</script>