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
        
  	    <div class="title">
  		  <h3>Visualize
  		    <small><?= $lang_array['visualize']['subtitle']  ?></small>
            </h3>
        </div>

        <div class="row-fluid">
          <div class="navbar">
            <div class="app-headed-white-frame" style="padding:15px">

              <div class="span4">

                <div class="span3" style="margin-top:8px">
                    <h4><?= $lang_array['visualize']['beginning'] ?>:</h4>
                 </div>

                 <div class="span9">

                  <div id="visualize-datepicker-tinf" class="input-append date" style="margin-top:15px">
                  <input id="visualize-input-tinf" data-format="yyyy-MM-dd hh:mm:ss" type="text" style="font-size:14px!important;height:20px "></input>
                  <span class="add-on btn" style="padding-top:4px!important;padding-bottom:4px!important;">
                    <i data-time-icon="icon-time icon" data-date-icon="icon-calendar icon">
                    </i>
                  </span>
                </div>

              </div>


              </div>

              <div class="span4">
                <div class="span3" style="margin-top:10px">
                  <h4><?= $lang_array['visualize']['end'] ?>:</h4>
                </div>

                <div class="span9">

                  <div id="visualize-datepicker-tsup" class="input-append date" style="margin-top:15px">
                  <input id="visualize-input-tsup" data-format="yyyy-MM-dd hh:mm:ss" type="text" style="font-size:14px!important;height:20px "></input>
                  <span class="add-on btn" style="padding-top:4px!important;padding-bottom:4px!important;">
                    <i data-time-icon="icon-time icon" data-date-icon="icon-calendar icon">
                    </i>
                  </span>
                </div>

                </div>

              </div>

              <div class="span4" style="text-align:right">
                <div class="btn-group" style="margin-top:12px!important">
                <a id="btn-autoupdate" class="btn btn-primary" onclick="toggleAutoUpdate()">Autoupdate: true</a>
                <a id="btn-visualize" class="btn btn-success disabled">
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
          <div class="app-headed-white-frame" style="height:300px;padding-bottom:20px">
            <div class="app-headed-frame-header">
              <div class="span6">
                <div class="btn-group" style="margin-top:11px;margin-right:10px">
                  
                  <a linked-asset="<?= $v->name ?>" 
                      class="btn btn-small btn-info btn-settings" 
                      title="<?= $lang_array['app']['title_graphsettings'] ?>" 
                      id="settings-btn"
                      onclick="toggleGraphSettings('<?= $v->name ?>')">
                       <i class="icon-wrench icon-white"></i>
                  </a>

                  <a id="rbtn" class="btn btn-primary btn-small btn-enlarge" onclick="enlargeGraph('<?= $v->name ?>');" rel="tooltip" title="<?= $lang_array['visualize']['enlarge_graph'] ?>">
                    <i class="icon-fullscreen icon-white"></i>
                  </a>
                </div>

                <div linked-asset="<?= $v->name ?>" id="graph-settings" style="text-align:left;display:none;position:absolute;width:400px;background:white;padding:10px;z-index:100;box-shadow:1px 1px 1px #cccccc">

                  <form>
                  <h4><?= $lang_array['app']['graphcfg_behaviour'] ?></h4>
                  
                  <label><b><?= $lang_array['app']['graphcfg_ctype'] ?></b></label>

                  <table class="table" style="width:100%;text-align:center">
                    <tr>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="charttype-radio-<?= $v->name ?>" value="line" CHECKED></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="charttype-radio-<?= $v->name ?>" value="candle"></td>
                     
                    </tr>
                    <tr>
                      <td><?= $lang_array['app']['ctype_line'] ?></td>
                      <td><?= $lang_array['app']['ctype_candle'] ?></td>

                    </tr>
                  </table>



                  <label><b><?=  $lang_array['app']['graph_refreshrate'] ?></b></label>

                  <table class="table" style="width:100%;text-align:center">
                    <tr>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="refreshrate-radio" value="1000"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="refreshrate-radio" value="5000"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="refreshrate-radio" value="10000"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="refreshrate-radio" value="20000" CHECKED></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="refreshrate-radio" value="60000"></td>
                    </tr>

                    <script type="text/javascript">
                      $('input[name="refreshrate-radio"][linked-asset="<?= $v->name ?>"]').
                      change(function() {  changeRefresh('<?= $v->name ?>', $(this).val() ); });
                    </script>

                    <tr>
                      <td>rt</td>
                      <td>5s</td>
                      <td>10s</td>
                      <td>20s</td>
                      <td>60s</td>
                    </tr>

                  </table>

                  <label><b><?=  $lang_array['app']['graph_resolution'] ?></b></label>

                  <table class="table" style="width:100%;text-align:center">
                    <tr>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="resolution-radio-<?= $v->name ?>" value="1"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="resolution-radio-<?= $v->name ?>" value="10"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="resolution-radio-<?= $v->name ?>" value="20"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="resolution-radio-<?= $v->name ?>" value="30" CHECKED></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="resolution-radio-<?= $v->name ?>" value="60"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="resolution-radio-<?= $v->name ?>" value="120"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="resolution-radio-<?= $v->name ?>" value="300"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="resolution-radio-<?= $v->name ?>" value="1200"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="resolution-radio-<?= $v->name ?>" value="3600"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="resolution-radio-<?= $v->name ?>" value="14400"></td>
                      <td><input linked-asset="<?= $v->name ?>" type="radio" name="resolution-radio-<?= $v->name ?>" value="86400"></td>

                    </tr>

                    <tr>
                      <td>1s</td>
                      <td>10s</td>
                      <td>20s</td>
                      <td>30s</td>
                      <td>1m</td>
                      <td>2m</td>
                      <td>5m</td>
                      <td>20m</td>
                      <td>1h</td>
                      <td>4h</td>
                      <td>1d</td>
                    </tr>

                  </table>
                  
                  <div style="border-top:1px solid #cccccc;width:100%;height:2px"></div>

                  <h4><?= $lang_array['app']['graphcfg_tech_analysis'] ?></h4>

                  <div class="graphoption" style="margin-top:5px">
                    <input linked-asset="<?= $v->name ?>" id="mvavg20" type="checkbox" />&nbsp;<b><?= $lang_array['app']['graph_mvavg20'] ?></b>
                  </div>
                  <div class="graphoption" style="margin-top:5px">
                    <input linked-asset="<?= $v->name ?>" id="mvavg50" type="checkbox" />&nbsp;<b><?= $lang_array['app']['graph_mvavg50'] ?></b>
                  </div>

                  <!-- Disabled tech indicators -->
                  <!--
                  <div class="graphoption" style="margin-top:5px">
                    <input linked-asset="<?= $v->name ?>" id="bollinger" type="checkbox" class="disabled" />&nbsp;<b><?=  $lang_array['app']['graph_bollinger'] ?></b>
                  </div>
                  <div class="graphoption" style="margin-top:5px">
                    <input linked-asset="<?= $v->name ?>" id="lreg" type="checkbox" />&nbsp;<b><?=  $lang_array['app']['graph_lreg'] ?></b>
                  </div>
                  <div class="graphoption" style="margin-top:5px">
                    <input linked-asset="<?= $v->name ?>" id="raff" type="checkbox" />&nbsp;<b><?=  $lang_array['app']['graph_raff'] ?></b>
                  </div>
                  -->

                  </form>



                </div>



              </div>

              <div class="span6" style="text-align:right">
                <h4><?= $v->name ?></h4>
              </div>
            </div>
              <div linked-asset="<?= $v->name ?>" id="visualize-draw" style="height:267px;text-align:center;">
              <br><img src="/img/loader2.gif" style="width:25px;margin-top:100px"/>
             </div>

             <div class="deltapopup" linked-asset="<?= $v->name ?>" style="position:relative;font-size:30px;margin-top:-150px;width:100px;height:100px;float:right"></div>


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


  <?php foreach($vals as $v) { ?>
  var plot<?= str_replace('_','', $v->name) ?> = null;
  var au<?= str_replace('_','', $v->name) ?> = null;

  $('input[linked-asset="<?= $v->name ?>"]').change( function() {

    displayGraph('<?= $v->name ?>');

  } );


  <?php } ?>



  function toggleGraphSettings(iname) {

    var settings_panel = $('#graph-settings[linked-asset=' + iname + ']');
    if ( settings_panel.is(':hidden') ) {

      settings_panel.show();
    }

    else {
      settings_panel.hide();
    }
  }


  function changeRefresh(iname, rate_millisecs) {

    var auname = 'au' + iname.replace('_','');
    eval('clearInterval(' + auname + ');');

    set_interval_str = "setInterval(\"" + "displayGraph('" + iname + "', plot" + iname.replace('_','') + ")\"," + rate_millisecs + ");";
    eval( auname + " = " + set_interval_str );

  }

  function enlargeGraph(iname) {

    var graphbox = $('#visualize-draw[linked-asset=' + iname + ']').parent().parent();

    //hides tooltip
    $('#rbtn',graphbox).tooltip('hide');

    var graphrow = graphbox.parent();
    var graphlarge = $('#graphlarge');

    var gcopy = graphbox.clone();

    graphlarge.append(graphbox.html());
    graphbox.remove();

    var exframe = $('#visualize-draw[linked-asset='+ iname + ']', graphlarge).parent();
    exframe.css({'margin-bottom':'25px'});

    $('#rbtn', exframe).removeClass('btn-primary');
    $('#rbtn', exframe).addClass('btn-danger');
    $('#rbtn', exframe).html('<i class="icon icon-remove-sign"></i>');
    
    $('#rbtn', exframe).attr('onclick', null);
    $('#rbtn', exframe).off('click');
    $('#rbtn', exframe).click(function() {

      graphrow.append(gcopy);
      
      //hides tooltip
      $('#rbtn',exframe).tooltip('hide');
      
      exframe.remove();
      displayGraph(iname);

      $('input[linked-asset="' + iname + '"]').change( function() {
          displayGraph(iname);
      });

      $('.btn-enlarge').tooltip({placement:'bottom',container: 'body'});
      $('.btn-settings').tooltip({placement:'bottom',container: 'body'});

    });

    $('input[linked-asset="' + iname + '"]').change( function() {
          displayGraph(iname);
    });

    displayGraph(iname);

  }


  function disableAutoUpdate() {
    $('#btn-autoupdate').removeClass('btn-primary');
    $('#btn-autoupdate').html('Autoupdate: false');

    <?php foreach($vals as $v) { ?>
    clearInterval(au<?= str_replace('_','', $v->name) ?>);
    <?php } ?>
  }


  function enableAutoUpdate() {
    $('#btn-autoupdate').addClass('btn-primary');
    $('#btn-autoupdate').html('Autoupdate: true');

    <?php foreach($vals as $v) { ?>
      au<?= str_replace('_','', $v->name) ?> = setInterval("displayGraph('<?= $v->name ?>',plot<?= str_replace('_','', $v->name) ?>)",20000);
    <?php } ?>
  }

  

  function disableVisualize() {

    $('#btn-visualize').addClass('disabled');
    $('#btn-visualize').off('click');
  }

  function enableVisualize() {
    $('#btn-visualize').removeClass('disabled');
    $('#btn-visualize').click(function() {  displayAllGraph(true) });

  }

  function toggleAutoUpdate() {

    //disable
    if( $('#btn-autoupdate').hasClass('btn-primary') ) {
      disableAutoUpdate();
      enableVisualize();
    }

    //enable
    else {
      enableAutoUpdate();
      disableVisualize();
    }
  }

  $('#visualize-datepicker-tinf').datetimepicker({
      language: 'fr-FR'
    });

    $('#visualize-datepicker-tsup').datetimepicker({
      language: 'fr-FR'
    });



  function showDelta(iname, delta) {

    var deltadiv = $('.deltapopup[linked-asset=' +  iname + ']');
    
    if ( delta < 0 ) deltadiv.css('color','#FF0000');
    else deltadiv.css('color','#00FF00');

    deltadiv.html(delta);
  }


  function displayGraph(iname, existing_plot, use_dates) {

    //fetch graph settings inputs
    var mvavg20 = $('#mvavg20[linked-asset="' + iname + '"]');
    var mvavg50 = $('#mvavg50[linked-asset="' + iname + '"]');
    var bollinger = $('#bollinger[linked-asset="' + iname + '"]');
    var lreg = $('#lreg[linked-asset="' + iname + '"]');
    var raff = $('#raff[linked-asset="' + iname + '"]');

    var existing_plot = (typeof existing_plot != 'undefined') ? existing_plot : null;
    var use_dates = (typeof use_dates != 'undefined') ? use_dates : null;
    
    var is_filled = true;

    var resolution = $('input[name="resolution-radio-' + iname + '"]:checked').val() ;
    var chart_type = $('input[name="charttype-radio-'  + iname + '"]:checked').val() ;

    var default_time_range = resolution * 1000 * 300;

    //trick to avoid averaging.
    if (resolution == 1) resolution = 0;


    var tinf = "";
    var tsup = "";

    if (use_dates != null) {
      tinf = $('#visualize-input-tinf').val();
      tsup = $('#visualize-input-tsup').val();
    }

    if (tinf == "") {

      var pdate = new Date(Date.now() - tzOffset() * 3600000 - default_time_range ); 

      //pdate.setHours(pdate.getHours()-3);

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

      //we substract timzzone offset and add 30secs (to be sure we have the latest data)
      var cdate = new Date(Date.now() - tzOffset() * 3600000 + 30000);

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

    var placeholder = $('#visualize-draw[linked-asset=' + iname + ']');

  
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
             legend: {
                      show: false
                    },

             selection: {
                    mode: "x"
             },

      };

      if (chart_type == "candle") {

        options.series = { candle: true, lines: false };
      }
      

    var data ;
    
    if (chart_type == "line") {
      data = [{ data: null,
                 lines: { 
                          fill: is_filled,
                          lineWidth: 2,
                          zero: false },
                  color: '#38b7e5',
                  label: iname,
                 
                  }, ];

    }

    else if (chart_type == "candle") {
      data = [{ data: null, candle: true, lines: false}];
    }

    var plot = null;

    var stats_querydata = {
                         'tinf' : tinf,
                         'tsup': tsup,
                         'indice': iname,
                         'resolution': resolution,
                         'time_offset': tzOffset(),
                         'chart': chart_type
                          };

    if (mvavg20.is(':checked') ) stats_querydata['mvavg'] = 20;
    else if (mvavg50.is(':checked')) stats_querydata['mvavg'] = 50;


    if (bollinger.is(':checked')) stats_querydata['add_bollinger'] = true;
    if (lreg.is(':checked')) stats_querydata['linear_regression'] = true;
    if (raff.is(':checked')) stats_querydata['add_raff'] = true;

    var rdata = $.ajax({'url': '/async/vhmodules/visualize/stats',
                       'type': 'GET',
                       'data': stats_querydata,
                       'cache': false,
                       'async': true,
                       'success': function() {

                          var alldata = $.parseJSON(rdata.responseText)

                          data[0].data = alldata.data;

                          if ( typeof alldata.moving_average !== 'undefined' ) {

                            data.push( 

                              { data: alldata.moving_average.moving_average,
                                lines: { 
                                          fill: false,
                                          lineWidth: 1,
                                          zero: false },
                                color: '#FF0000',
                                label: iname + "_mvavg",
                              }
                            );

                            if( typeof alldata.moving_average.bollinger_1 !== 'undefined' ) {

                              data.push( 

                                { data: alldata.moving_average.bollinger_1,
                                  lines: { 
                                            fill: false,
                                            lineWidth: 1,
                                            zero: false },
                                  color: '#FFFFFF',
                                  label: iname + "_bollinger",
                                }
                              );

                              data.push( 

                                { data: alldata.moving_average.bollinger_2,
                                  lines: { 
                                            fill: false,
                                            lineWidth: 1,
                                            zero: false },
                                  color: '#FFFFFF',
                                  label: iname + "_bollinger",
                                }
                              );
                            }
                          }

                          if ( typeof alldata.linear_regression !== 'undefined' ) {

                            data.push( 

                              { data: alldata.linear_regression.linear_regression,
                                lines: { 
                                          fill: false,
                                          lineWidth: 1,
                                          zero: false },
                                color: '#00FF00',
                                label: iname + "_lreg",
                              }
                            );

                            if ( typeof alldata.linear_regression.raff_1 !== 'undefined' ) {
                              data.push( 
                                { data: alldata.linear_regression.linear_raff_1,
                                  lines: { 
                                            fill: false,
                                            lineWidth: 1,
                                            zero: false },
                                  color: '#00FF00',
                                  label: iname + "_raff1",
                                }
                              );

                              data.push( 
                                { data: alldata.linear_regression.linear_raff_2,
                                  lines: { 
                                            fill: false,
                                            lineWidth: 1,
                                            zero: false },
                                  color: '#00FF00',
                                  label: iname + "_raff2",
                                }
                              );

                            }
                          }
                          
                          var delta = 0 ;                
                          if ( data[0].data.length >= 2 ) {
                            delta = data[0].data[data[0].data.length -1 ][1] - data[0].data[data[0].data.length - 2 ][1];

                            if ( data[0].data[data[0].data.length -1 ][1] < 2 ) {
                              delta *= 1000;  
                            }

                            delta = delta.toFixed(4);
                            
                            if (resolution == 0 || resolution == 5) showDelta(iname, delta);
                          }



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
  
  function displayAllGraph(use_dates) {

    var use_dates = ( typeof use_dates != 'undefined'  ) ? use_dates : null ; 

    <?php foreach($vals as $v) { ?>
      plot<?= str_replace('_','', $v->name) ?> = displayGraph('<?= $v->name ?>', null, use_dates);
    <?php } ?>

  }


  $('#visualize').bind('afterShow',function() {
    displayAllGraph();
    enableAutoUpdate();
  });


  $(document).ready(function() {

     $('.btn-enlarge').tooltip({placement:'bottom',container: 'body'});
     $('.btn-settings').tooltip({placement:'bottom',container: 'body'});

  });


</script>


