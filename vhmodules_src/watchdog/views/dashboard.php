<div class="row-fluid" style="margin-bottom:30px">

        <div class="span6" id="">
          <div class="app-headed-white-frame" style="height:130px;width:100%">
            <div class="app-headed-frame-header">
          	    <h4>Watchdog adam</h4>
            </div>

            <div style="padding:10px">
              <div id="watchdog_adam_health" style="width:80px;height:80px"></div>
            </div>


          </div>
        </div>

        <div class="span6" id="">
          <div class="app-headed-white-frame" style="height:130px;width:100%">
            <div class="app-headed-frame-header">
          	    <h4>Watchdog Gateway</h4>
            </div>
            <div style="padding:10px">
              <div id="watchdog_gw_health" style="width:80px;height:80px"></div>
            </div>

          </div>
        </div>

        

</div>

<script type="text/javascript">

  function adamUpdateWatchdogGraphs() {

    var wsr = $.ajax ({ url: '/async/vhmodules/watchdog/watchdogstats',
                        type: 'GET',
                        cache: false,
                        async: true,
                        success: function() {

                           var wd_stats = $.parseJSON(wsr.responseText);
                           var wsize = 1 - wd_stats.adam_uptime;
                           
                           $.plot('#watchdog_adam_health',[ { 'label': '', 'data': wsize , 'color': '#FFFFFF'   } , { 'label': '', 'data': wd_stats.adam_uptime , 'color': '#43C83C'   } ]
                            , {
                            series: {
                                pie: {
                                    innerRadius: 0.5,
                                    show: true,
                                    label: {  show: false }
                                }
                              },
                              legend: {
                                show: false
                              }
                            });
                           

                     }

      }); 
 
  }

  adamUpdateWatchdogGraphs();
  setInterval('adamUpdateWatchdogGraphs()',60000);


/*
   $.plot('#watchdog_adam_health',[  { 'label': '', 'data': 0.2, 'color': '#FFFFFF'   } , { 'label': '', 'data': 0.8, 'color': '#43C83C'   } ]
   	, {
    series: {
        pie: {
            innerRadius: 0.5,
            show: true,
            label: {  show: false }
        }
      },
      legend: {
        show: false
      }
    });

   $.plot('#watchdog_gw_health',[  { 'label': '', 'data': 0.1, 'color': '#FFFFFF'   } , { 'label': '', 'data': 0.9, 'color': '#FF0000'   } ], {
    series: {
        pie: {
            innerRadius: 0.5,
            show: true,
            label: {  show: false }
        }
      },
      legend: {
        show: false
      }
    });
*/


</script>