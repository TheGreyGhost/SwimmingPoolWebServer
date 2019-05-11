<html>
<head>
<script type="text/javascript" src="./resources/extl/dygraph.js"></script>
<link rel="stylesheet" href="./resources/extl/dygraph.css" />
</head>
<body>
<div id="graphdiv"></div>
<?php 
require __DIR__.'/../php/get_historical.php';
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  // use json_encode to pass data from PHP to javascript literal
  var historydata = <?php echo json_encode($historydata); ?>;

  var SECONDS_FROM_1970_TO_2000 = 946684800;
  var unixtime = 0;	
  document.write("start<br>");
  // convert timestamp unixtime to javascript dates
  hdrows = historydata.length;
  hdcols = historydata[0].length	
  for (i = 0; i < hdrows; i++) {
    for (j=0; j < hdcols; ++j) 
      historydata[i][j] = +historydata[i][j]; // convert string to number
    unixtime = historydata[i][0] + SECONDS_FROM_1970_TO_2000;
    historydata[i][0] = new Date(unixtime * 1000);
  }
  document.write("finish<br>");

  //Google Stuff
  google.charts.load('current', {packages: ['corechart']});
  google.charts.setOnLoadCallback(loadData);

  function loadData() {
    var dt_history = new google.visualization.DataTable({
      cols: [{id: 'timestampUTC', label: 'Task', type: 'date'},
             {id: 'hx_hot_inlet_ave', label: 'Temperature from panels', type: 'number'},
             {id: 'hx_hot_outlet_ave', label: 'Temperature to panels', type: 'number'},
             {id: 'hx_cold_inlet_ave', label: 'Temperature from pool', type: 'number'},
             {id: 'hx_cold_outlet_ave', label: 'Temperature to pool', type: 'number'},
             {id: 'ambient_temperature', label: 'Ambient temperature', type: 'number'},
             {id: 'cumulative_insolation', label: 'Sunshine since midnight', type: 'number'},
            ]
    	});
    dt_history.addRows(historydata);	 
    g = new Dygraph(
        document.getElementById("graphdiv"),  // containing div
        dt_history,
        { }                                   // the options
      );
  }
</script>
</body>
</html>
