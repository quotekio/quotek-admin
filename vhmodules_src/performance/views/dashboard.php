<?php
   global $lang;
   include ( dirname(__FILE__) . "/../lang/$lang/vhmodule.lang.php");

?>

<div class="row-fluid" style="margin-top:30px">

	<div id="reach-dashboard-ct" class="app-headed-white-frame" style="height:280px;width:100%">
	  <div class="app-headed-frame-header">
		    <h4>Performance</h4>
	  </div>

	  <div style="text-align:center;width:100%">
	    <div id="dashboard-graph-performance" style="height:230px;width:800px;margin-left:auto;margin-right:auto">
	    </div>
	  </div>


	</div>

</div>

<script type="text/javascript">

  function drawPerfGraphs() {

     var rsr = $.ajax({ url: '/async/vhmodules/performance/perfstats' ,
  						 cache: false,
  						 async:true,
  						 success: function() {

                           var d_raw = $.parseJSON(rsr.responseText);


                           /* ###### REACH RENDER ###### */

                           var reach_placeholder = $('#dashboard-graph-performance');
                           reach_placeholder.width( reach_placeholder.parent().width() );

                           var reach_options = {
                                   xaxis: {
                                   	mode: "time",
                                   	 //timeformat: "%W",
                                   	 //tickSize: [1, "week"],
                                   	 axisLabel: 'Week'
                                   },   
                                   grid: {
                                          show: true,
                                          borderWidth: 0,
                                    },
                                    legend: {
                                             show: false
                                    },

                           };

                           var reach_data = [
                              {
                                          label: "Goal",
                                          data: d_raw.reach.goal_data ,
                                          lines: {
                                              lineWidth: 2,
                                              fill:false,
                                          },
                                          color: "#cccccc"
                                      },

                               {
                                           label: "Perf-",
                                           data: d_raw.reach.perf_data_negative ,
                                           bars: {
                                              show:true,
                                              fill: true,
                                              fillColor: 'rgba(204, 0, 0, .6)',
                                              barWidth: 5 * 24 * 60 * 60 * 1000,
                                           },
                                           color: "#c00"
                                       },

                                  {
                                              label: "Perf+",
                                              data: d_raw.reach.perf_data,
                                              bars: {
                                                  show:true,
                                                  fill: true,
                                                  fillColor: 'rgba(105, 158, 0, .6)',

                                                  barWidth: 5 * 24 * 60 * 60 * 1000,
                                                },
                                                color: "#699e00"
                                  },
                           ]; 
                             
                           $.plot(reach_placeholder,reach_data,reach_options);


                           /* ###### TRADE RATIOS RENDER ###### */

                           var trade_ratio_options = { series: {

                                 grow: { active: true, duration: 5000 },
                                 pie: {
                                       innerRadius: 0.8,
                                       radius: 1,
                                       show: true,
                                       label: { show:false },
                                       stroke:{
                                         width:0
                                       }

                                     },
                                 },
                                 legend: {
                                   show: false,
                                   radius: 10
                                 },
                               };


                           var trade_ratio_day_data = [{ label: "profit", data: d_raw.perf.trade_ratios.day[0] , color: '#699e00', grow: { growings:[ { stepMode: "minimum" } ]} },
                                              { label: "loss", data: d_raw.perf.trade_ratios.day[1], color: '#c00', grow: { growings:[ { stepMode: "minimum" } ]} }
                                             ];

                           var trade_ratio_week_data = [{ label: "profit", data: d_raw.perf.trade_ratios.week[0], color: '#699e00', grow: { growings:[ { stepMode: "minimum" } ]}},
                                              { label: "loss", data: d_raw.perf.trade_ratios.week[1], color: '#c00', grow: { growings:[ { stepMode: "minimum" } ]}}
                                             ];

                           var trade_ratio_month_data = [{ label: "profit", data: d_raw.perf.trade_ratios.month[0], color: '#699e00', grow: { growings:[ { stepMode: "minimum" } ]}},
                                               { label: "loss", data: d_raw.perf.trade_ratios.month[1], color: '#c00', grow: { growings:[ { stepMode: "minimum" } ]}}
                                              ];

                           $.plot($('#performance-trdph'),trade_ratio_day_data,trade_ratio_options);
                           $.plot($('#performance-trwph'),trade_ratio_week_data,trade_ratio_options);
                           $.plot($('#performance-trmph'),trade_ratio_month_data,trade_ratio_options);

                           /* ################################## */


  						 }


  						});


  }


  $('#dashboard').bind('afterShow',function() {
    drawPerfGraphs();
  });

  window.setInterval("drawPerfGraphs();", 20000);


</script>