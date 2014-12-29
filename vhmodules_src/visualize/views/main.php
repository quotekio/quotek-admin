<?php

   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");
   require_once "valuecfg.php";
   require_once "corecfg.php";

   $cfg = getActiveCfg();
   $vals = getCfgValues($cfg->id);

   
?>

<div id="visualize-tooltip" style="display:none;position:absolute;padding:4px;background:#131517;border-radius:4px;font-size:11px;opacity:1.0!important;z-index:3000">
</div>


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
                <div class="btn-group" style="margin-top:12px!important">
                <a id="btn-autoupdate" class="btn btn-primary" onclick="toggleAutoUpdate()">Autoupdate: true</a>
                <a class="btn btn-success">
                  Visualize!
                </a>
                </div>
              </div>


            </div>
          </div>
        </div>


        <div class="row-fluid" id="graphlarge" style="padding-top:30px;padding-bottom:30px"></div>

        <div class="row-fluid">

        <?php

        $i=0;
        foreach($vals as $v) {
          $i++;
        ?>

        <div class="span6">
          <div class="app-headed-white-frame" style="height:300px">
            <div class="app-headed-frame-header">
              <div class="span6">
                <h4><?= $v->name ?></h4>
              </div>
              <div class="span6">
                <div class="btn-group">
                  <a class="btn">
                    <i class="icon-indent-right icon-white"></i>
                  </a>

                  <a class="btn btn-primary" onclick="enlargeGraph('<?= $v->name ?>')">
                    <i class="icon-fullscreen icon-white"></i>
                  </a>
                  
                </div>
              </div>
            </div>
              <div id="visualize-draw-<?= str_replace('_','', $v->name) ?>" style="height:267px;text-align:center">
             <img src="/img/loader2.gif" style="width:25px;margin-top:120px"/>
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

 
  function enlargeGraph(iname) {

    var graphbox = $('#visualize-draw-'+ iname.replace('_','') ).parent().parent();
    $('#graphlarge').append(graphbox.html());
    displayGraph(iname);

  }


  function toggleAutoUpdate() {


    //disable
    if( $('#btn-autoupdate').hasClass('btn-primary') ) {
      $('#btn-autoupdate').removeClass('btn-primary');
      $('#btn-autoupdate').html('Autoupdate: false');

      <?php foreach($vals as $v) { ?>
      clearInterval(au<?= $v->name ?>);
      <?php } ?>

    }

    //enable
    else {
      $('#btn-autoupdate').addClass('btn-primary');
      $('#btn-autoupdate').html('Autoupdate: true');

      <?php foreach($vals as $v) { ?>
        au<?= $v->name ?> = setInterval("displayGraph('<?= $v->name ?>',plot<?= $v->name ?>)",20000);
      <?php } ?>


    }


  }



  $('#visualize-datepicker-tinf').datetimepicker({
      language: 'fr-FR'
    });

    $('#visualize-datepicker-tsup').datetimepicker({
      language: 'fr-FR'
    });


  function displayGraph(iname, existing_plot) {

    var existing_plot = (typeof existing_plot != 'undefined') ? existing_plot : null;

    var tinf = $('#visualize-input-tinf').val();
    var tsup = $('#visualize-input-tsup').val();
 
    if (tinf == "") {
    
      var pdate = new Date(); 

      pdate.setHours(pdate.getHours()-3);

      var h = pdate.getHours();
      if (h<10) h = "0" + h;

      var m = pdate.getMinutes();
      if (m<10) m = "0" + m;

      var month = pdate.getMonth() + 1 ;
      if (month<10) month = "0" + month;

      var day = pdate.getDate();
      if (day<10) day = "0" + day;

      var secs = pdate.getSeconds();
      if (secs<10) secs = "0" +secs;

      tinf = pdate.getFullYear() + 
            "-" + 
            month +
            "-" + 
            day + 
            " " + 
            h + 
            ":" +
            m +
            ":" +
            secs;

    }

    if (tsup == "") {

      var cdate = new Date();

      var h = cdate.getHours();
      if (h<10) h = "0" + h;

      var m = cdate.getMinutes();
      if (m<10) m = "0" + m;

      var secs = cdate.getSeconds();
      if (secs<10) secs = "0" +secs;
     
      var month = cdate.getMonth() + 1 ;
      if (month<10) month = "0" + month;

      var day = cdate.getDate();
      if (day<10) day = "0" + day;

      tsup = cdate.getFullYear() + 
            "-" + 
            month + 
            "-" +
            day + 
            " " + 
            h + 
            ":" +
            m +
            ":" +
            secs; 

    }


    var placeholder = $('#visualize-draw-' + iname.replace('_','') );

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

    var data = [{ data: null,
                 lines: { fill: true,
                          lineWidth: 2,
                          zero: false },
                  color: '#38b7e5',
                  label: iname,
                 
                  }, ];

    var plot = null;

    var rdata = $.ajax({'url': '/async/vhmodules/visualize/stats?tinf=' + tinf + "&tsup=" + tsup + "&indice=" + iname + "&resolution=30s",
                       'type': 'GET',
                       'cache': false,
                       'async': true,
                       'success': function() {

                          data[0].data = $.parseJSON(rdata.responseText);
                          
                          if (existing_plot == null) {
 
                            plot = $.plot(placeholder, data , options);

                            placeholder.bind("plotclick", function (event, pos, item) {
                              if (item) {
                                $("#clickdata").text(" - click point " + item.dataIndex + " in " + item.series.label);
                                plot.highlight(item.series, item.datapoint);
                              }
                            });

                            placeholder.bind("plotselected", function (event, ranges) {

                                    $.each(plot.getXAxes(), function(_, axis) {
                                      var opts = axis.options;
                                      opts.min = ranges.xaxis.from;
                                      opts.max = ranges.xaxis.to;
                                    });
                                    plot.setupGrid();
                                    plot.draw();
                                    plot.clearSelection();
                                });



                            placeholder.bind("plothover", function (event, pos, item) {

                              if (item) {
                                  var x = item.datapoint[0].toFixed(2),
                                    y = item.datapoint[1].toFixed(2);

                                  //$("#visualize-tooltip").html(item.series.label + " of " + x + " = " + y)
                                  $("#visualize-tooltip").html(item.series.label + ": " + y )
                                    .css({top: item.pageY+5, left: item.pageX+5})
                                    .fadeIn(200);
                                } 

                                else {
                                  $("#visualize-tooltip").hide();
                                }
                              
                            });

                        }

                        //update
                        else {

                          existing_plot.setData(data);
                          existing_plot.draw();
                          plot = existing_plot;
                        }




                       } });
    

  
  return plot;

  }
  

  var au = null;

  <?php foreach($vals as $v) { ?>
    var plot<?= $v->name ?> = null;
    var au<?= $v->name ?> = null;
  <?php } ?>

  $('#visualize').bind('afterShow',function() {

    <?php foreach($vals as $v) { ?>

      plot<?= $v->name ?> = displayGraph('<?= $v->name ?>');

      au<?= $v->name ?> = setInterval("displayGraph('<?= $v->name ?>',plot<?= $v->name ?>)",20000);

    <?php } ?>


  });

</script>


