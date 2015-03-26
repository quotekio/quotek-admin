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

  function drawReachGraph() {

     var rsr = $.ajax({ url: '/async/vhmodules/reach/stats?year=<?= $year = date("Y"); ?>' ,
  						 cache: false,
  						 async:true,
  						 success: function() {

                           var placeholder = $('#dashboard-graph-performance');
                           placeholder.width( placeholder.parent().width() );

                           var options = {

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

                           var d_raw = $.parseJSON(rsr.responseText);

                           var data = [
                              {
                                          label: "Goal",
                                          data: d_raw.goal_data ,
                                          lines: {
                                              lineWidth: 2,
                                              fill:false,
                                          },
                                          color: "#cccccc"
                                      },

                               {
                                           label: "Perf-",
                                           data: d_raw.perf_data_negative ,
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
                                              data: d_raw.perf_data,
                                              bars: {
                                                  show:true,
                                                  fill: true,
                                                  fillColor: 'rgba(105, 158, 0, .6)',

                                                  barWidth: 5 * 24 * 60 * 60 * 1000,
                                                },
                                                color: "#699e00"
                                  },





                                          



                           ]; 
                             


                           $.plot(placeholder,  data ,options);

  						 }


  						});


  }


  $('#dashboard').bind('afterShow',function() {
    drawReachGraph();
  });

  window.setInterval("drawReachGraph();", 60000);


</script>