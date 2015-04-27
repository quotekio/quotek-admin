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
                                 },
                               };

                           var trade_ratio_day_data = [{ label: "profit", data: d_raw.perf.trade_ratios.day[0] , color: '#699e00' },
                                              { label: "loss", data: d_raw.perf.trade_ratios.day[1], color: '#c00'}
                                             ];

                           var trade_ratio_week_data = [{ label: "profit", data: d_raw.perf.trade_ratios.week[0], color: '#699e00' },
                                              { label: "loss", data: d_raw.perf.trade_ratios.week[1], color: '#c00', }
                                             ];

                           var trade_ratio_month_data = [{ label: "profit", data: d_raw.perf.trade_ratios.month[0], color: '#699e00'},
                                               { label: "loss", data: d_raw.perf.trade_ratios.month[1], color: '#c00'}
                                              ];

                           if (d_raw.perf.trade_ratios.day[0] == 0 && d_raw.perf.trade_ratios.day[1] == 0 ) {
                             trade_ratio_day_data = [{ label: "nulldata", data: 1 , color: '#cccccc' }]; 
                           }

                           if (d_raw.perf.trade_ratios.week[0] == 0 && d_raw.perf.trade_ratios.week[1] == 0 ) {
                             trade_ratio_week_data = [{ label: "nulldata", data: 1 , color: '#cccccc'}]; 
                           }

                           if (d_raw.perf.trade_ratios.month[0] == 0 && d_raw.perf.trade_ratios.month[1] == 0 ) {
                             trade_ratio_month_data = [{ label: "nulldata", data: 1 , color: '#cccccc'}]; 
                           }

                           $.plot($('#performance-trdph'),trade_ratio_day_data,trade_ratio_options);
                           $.plot($('#performance-trwph'),trade_ratio_week_data,trade_ratio_options);
                           $.plot($('#performance-trmph'),trade_ratio_month_data,trade_ratio_options);

                           $('#performance-trdph-label').html( d_raw.perf.trade_ratios.day[0] + "/" + (d_raw.perf.trade_ratios.day[0] + d_raw.perf.trade_ratios.day[1]));
                           $('#performance-trwph-label').html( d_raw.perf.trade_ratios.week[0] + "/" + (d_raw.perf.trade_ratios.week[0] + d_raw.perf.trade_ratios.week[1]));
                           $('#performance-trmph-label').html( d_raw.perf.trade_ratios.month[0] + "/" + (d_raw.perf.trade_ratios.month[0] + d_raw.perf.trade_ratios.month[1]) );



                           if (  d_raw.perf.trade_ratios.day[0] >= d_raw.perf.trade_ratios.day[1] ) {
                             $('#performance-trdph-label').css('color','#699e00');
                           }

                           else if (  d_raw.perf.trade_ratios.day[0] < d_raw.perf.trade_ratios.day[1] ) {
                             $('#performance-trdph-label').css('color','#c00000');
                           }

                           if ( d_raw.perf.trade_ratios.week[0] >= d_raw.perf.trade_ratios.week[1] ) {
                             $('#performance-trwph-label').css('color','#699e00');
                           }

                           else if (  d_raw.perf.trade_ratios.week[0] < d_raw.perf.trade_ratios.week[1] ) {
                             $('#performance-trwph-label').css('color','#c00000');
                           }

                           if ( d_raw.perf.trade_ratios.month[0] >= d_raw.perf.trade_ratios.month[1] ) {
                             $('#performance-trmph-label').css('color','#699e00');
                           }

                           else if (  d_raw.perf.trade_ratios.month[0] < d_raw.perf.trade_ratios.month[1] ) {
                             $('#performance-trmph-label').css('color','#c00000');
                           }



                           /* ##### TRADE STATS RENDER ##### */

                           $('#apnl-daily').html( d_raw.perf.trade_apnls.day );
                           $('#apnl-p-daily').html( d_raw.perf.trade_apnlps.day );
                           $('#apnl-weekly').html( d_raw.perf.trade_apnls.week );
                           $('#apnl-p-weekly').html( d_raw.perf.trade_apnlps.week );
                           $('#apnl-monthly').html( d_raw.perf.trade_apnls.month );
                           $('#apnl-p-monthly').html( d_raw.perf.trade_apnlps.month );

                           if ( d_raw.perf.trade_apnls.day >= 0 ) $('#apnl-daily').css('color','#699e00');
                           else $('#apnl-daily').css('color','#c00000');
                           if ( d_raw.perf.trade_apnlps.day >= 0 ) $('#apnl-p-daily').css('color','#699e00');
                           else $('#apnl-p-daily').css('color','#c00000');

                           if ( d_raw.perf.trade_apnls.week >= 0 ) $('#apnl-weekly').css('color','#699e00');
                           else $('#apnl-weekly').css('color','#c00000');
                           if ( d_raw.perf.trade_apnlps.week >= 0 ) $('#apnl-p-weekly').css('color','#699e00');
                           else $('#apnl-p-weekly').css('color','#c00000');

                           if ( d_raw.perf.trade_apnls.month >= 0 ) $('#apnl-monthly').css('color','#699e00');
                           else $('#apnl-monthly').css('color','#c00000');
                           if ( d_raw.perf.trade_apnlps.month >= 0 ) $('#apnl-p-monthly').css('color','#699e00');
                           else $('#apnl-p-monthly').css('color','#c00000');




 





                           /* ################################## */




  						 }


  						});


  }


  $('#dashboard').bind('afterShow',function() {
    drawPerfGraphs();
  });

  window.setInterval("drawPerfGraphs();", 20000);


</script>