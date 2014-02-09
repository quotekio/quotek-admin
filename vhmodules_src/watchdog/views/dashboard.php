<?php

  global $dbhandler;
  $dbh = $dbhandler->query("SELECT * FROM watchdog_cfg LIMIT 1");
  $wd_cfg = $dbh->fetch();


?>

<div class="row-fluid" style="margin-bottom:30px">

        <div class="span6" id="">
          <div class="app-headed-white-frame" style="height:130px;width:100%">
            <div class="app-headed-frame-header">
          	<div class="span6">
                  <h4>Watchdog Adam (10h stats)</h4>
                </div>
                <div class="span6">
                  <a class="btn btn-small" 
                     style="margin-top:8px;float:right;margin-right:10px"
                     onclick="adamToggleWatchdog('adam')" >
                    <i id="wd_adam_toggleicon" class="icon icon-<?=  ($wd_cfg['check_adam'] == 1 ) ? "stop" : "play"  ?>"></i></a>
                </div>
            </div>

            <div style="padding:10px;overflow:hidden;width:100%">
              <div style="width:90px;height:80px;float:left">
              <div id="watchdog_adam_health" style="width:80px;height:80px"></div>
              <div id="watchdog_adam_uptime_label" 
                   style="position:relative;margin-top:-50px;margin-left:13px;font-size:15px;color:#333333;font-weight:bold;width:54px;text-align:center">--</div>
              </div>

              <div id="watchdog_adam_health2" style="width:460px;height:80px;float:left;">
              
              </div>

            </div>


          </div>
        </div>

        <div class="span6" id="">
          <div class="app-headed-white-frame" style="height:130px;width:100%">
            <div class="app-headed-frame-header">

                <div class="span6">
          	      <h4>Watchdog Gateway (10h stats)</h4>
                </div>
                <div class="span6">
                  <a class="btn btn-small" 
                     style="margin-top:8px;float:right;margin-right:10px"
                     onclick="adamToggleWatchdog('gateway')">
                     <i id="wd_gateway_toggleicon" class="icon icon-<?=  ($wd_cfg['check_gateway'] == 1 ) ? "stop" : "play"  ?>"></i>
                   </a>
                </div>
            </div>
            <div style="padding:10px;overflow:hidden;width:100%">

              <div style="width:90px;float:left">
                <div id="watchdog_gw_health" style="width:80px;height:80px"></div>
                <div id="watchdog_gw_uptime_label" 
                   style="position:relative;margin-top:-50px;margin-left:13px;font-size:15px;color:#333333;font-weight:bold;width:54px;text-align:center">--</div>
              </div>

              <div id="watchdog_gateway_health2" style="width:460px;height:80px;float:left;"></div>


            </div>

          </div>
        </div>

        

</div>

<script type="text/javascript">

  function adamToggleWatchdog(wdtype) {

    if (wdtype == 'adam') {

      //enable adam wd
      if ( $('#wd_adam_toggleicon').hasClass('icon-play') ) {

        $.ajax({ url: '/async/vhmodules/watchdog/watchdogconfig?action=enable_adam',
                 type: 'GET',
                 cache: false,
                 async: false });
        $('#wd_adam_toggleicon').removeClass('icon-play');
        $('#wd_adam_toggleicon').addClass('icon-stop');

      }

      //disable adam wd
      else {

         $.ajax({ url: '/async/vhmodules/watchdog/watchdogconfig?action=disable_adam',
                 type: 'GET',
                 cache: false,
                 async: false });
        $('#wd_adam_toggleicon').removeClass('icon-stop');
        $('#wd_adam_toggleicon').addClass('icon-play');
      
      }

    }

    if (wdtype == 'gateway') {
 
      //enable gateway wd
      if ( $('#wd_gateway_toggleicon').hasClass('icon-play') ) {

        $.ajax({ url: '/async/vhmodules/watchdog/watchdogconfig?action=enable_gateway',
                 type: 'GET',
                 cache: false,
                 async: false });
        $('#wd_gateway_toggleicon').removeClass('icon-play');
        $('#wd_gateway_toggleicon').addClass('icon-stop');

      }

      //disable gateway wd
      else {

         $.ajax({ url: '/async/vhmodules/watchdog/watchdogconfig?action=disable_gateway',
                 type: 'GET',
                 cache: false,
                 async: false });
        $('#wd_gateway_toggleicon').removeClass('icon-stop');
        $('#wd_gateway_toggleicon').addClass('icon-play');
      
      }
    }
  }


  function adamUpdateWatchdogGraphs(h2grid) {

    var wsr = $.ajax ({ url: '/async/vhmodules/watchdog/watchdogstats',
                        type: 'GET',
                        cache: false,
                        async: true,
                        success: function() {

                           var wd_stats = $.parseJSON(wsr.responseText);
                           var wsize = 1 - wd_stats.adam_uptime;
                           var watchdog_adam_color;
                           var watchdog_gw_color;

                           var adam_uptime_percent = wd_stats.adam_uptime * 100;
                           $('#watchdog_adam_uptime_label').html( adam_uptime_percent.toFixed(1) + "%" );
                           if (adam_uptime_percent > 50) {
                             watchdog_adam_color = '#43C83C';
                           }
                           else {
                             watchdog_adam_color = '#FF0032';
                           }

                           $('#watchdog_adam_uptime_label').css('color',watchdog_adam_color);

                           $.plot('#watchdog_adam_health',[ { 'label': '', 'data': wsize , 'color': '#FF0032'   } , { 'label': '', 'data': wd_stats.adam_uptime , 'color': '#43C83C'   } ]
                            , {
                            series: {
                                pie: {
                                    innerRadius: 0.7,
                                    show: true,
                                    label: {  show: false }
                                }
                              },
                              legend: {
                                show: false
                              }
                            });
                           

                          wsize = 1 - wd_stats.gateway_uptime;

                          var gateway_uptime_percent = wd_stats.gateway_uptime * 100;
                          $('#watchdog_gw_uptime_label').html( gateway_uptime_percent.toFixed(1) + "%" );
                          if (gateway_uptime_percent > 50) {
                            watchdog_gw_color = '#43C83C';
                          }
                          else {
                            watchdog_gw_color = '#FF0032';
                          }
                          $('#watchdog_gw_uptime_label').css('color',watchdog_gw_color); 

                          $.plot('#watchdog_gw_health',[ { 'label': '', 'data': wsize , 'color': '#FF0032'   } , { 'label': '', 'data': wd_stats.gateway_uptime , 'color': '#43C83C'   } ]
                            , {
                            series: {
                                pie: {
                                    innerRadius: 0.7,
                                    show: true,
                                    label: {  show: false }
                                }
                              },
                              legend: {
                                show: false
                              }
                            });


                          var health2_options = {
                                  xaxis: {
                                      mode: "time",
                                  },
                                  yaxis: {
                                      min: 0,
                                      max: 1
                                  },
                                  grid: {
                                         show: false
                                         //backgroundColor: { colors: ["#2a2a2a", "#0a0a0a"] }
                                   },

                          };


                          $.plot($('#watchdog_adam_health2'), [{ label: 'uptime graph',
                                                                color: watchdog_adam_color,
                                                                data:  wd_stats.adam_uptime_10h }] , health2_options);

                          $('#watchdog_adam_health2 div.legend table').css({ border: "0px", background: "transparent" });


                          $.plot($('#watchdog_gateway_health2'), [{ label: 'uptime graph',
                                                                color: watchdog_gw_color,
                                                                data:  wd_stats.gateway_uptime_10h }] , health2_options);

                          $('#watchdog_gateway_health2 div.legend table').css({ border: "0px", background: "transparent" });
                          
                     }

      }); 
 
  }

  adamUpdateWatchdogGraphs(false);
  setInterval('adamUpdateWatchdogGraphs(true)',60000);

</script>