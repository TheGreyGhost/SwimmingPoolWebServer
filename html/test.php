<html>
<head>
<script type="text/javascript" src="./resources/extl/dygraph.js"></script>
<link rel="stylesheet" href="./resources/extl/dygraph.css" />
</head>
<body>
<div id="graph_temp_pool"></div>
<div id="graph_temp_hx"></div>
<div id="graph_temp_ambient"></div>
<div id="graph_cumulative_insolation"></div>
<div id="graph_pump_runtime"></div>
<div id="graph_status_info"></div>

<?php 
require __DIR__.'/../php/get_historical.php';
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  // use json_encode to pass data from PHP to javascript literal
  var historydata = <?php echo json_encode($historydata); ?>;
  var pumplabels = <?php echo json_encode($pumplabels); ?>;

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
             {id: 'surgetank_level', label: 'Surge Tank Level', type: 'number'},
             {id: 'pump_runtime', label: 'Pump runtime since midnight', type: 'number'},
             {id: 'pump_state', label: 'Pump State Code', type: 'number'}
            ]
    	});
    dt_history.addRows(historydata);	
    
    dv_pool = new google.visualization.DataView(dt_history);
    dv_pool.setColumns([0, 
       {calc:pool_temp_blanking, type:'number', label:'Pool temperature (C)'}]);
    dv_hx = new google.visualization.DataView(dt_history);
    dv_hx.setColumns([0, 1, 2, 3, 4]);
    dv_temp_ambient = new google.visualization.DataView(dt_history);
    dv_temp_ambient.setColumns([0, 5]);
    dv_cumulative_insolation = new google.visualization.DataView(dt_history);
    dv_cumulative_insolation.setColumns([0, 
       {calc:cumul_insol_to_percent_hours, type:'number', label:'Sunshine since midnight (%.hours)'}]);
    dv_pump_runtime = new google.visualization.DataView(dt_history);	
    dv_pump_runtime.setColumns([0,
       {calc:pump_runtime_seconds_to_hours, type:'number', label:'Pump runtime since midnight (hours)'}]);		
    dv_status_info = new google.visualization.DataView(dt_history);
    dv_status_info.setColumns([0,7,9]);	

  function pool_temp_blanking(dataTable, rowNum) {	
    if ((dataTable.getValue(rowNum, 9) & 16) == 16) { // pump is running is status bit 0x10 set
      return dataTable.getValue(rowNum, 3);	  
    } else { // pump not running so pool temp prob not valid
      return NaN;
    }  
  }

  function cumul_insol_to_percent_hours(dataTable, rowNum) {
    return dataTable.getValue(rowNum, 6) / 3600.0;
  }
  function pump_runtime_seconds_to_hours(dataTable, rowNum) {
    return dataTable.getValue(rowNum, 8) / 3600.0;
  }
  function pump_status_to_text(num) {
    var retstr = "???";
    for (i = 0; i < pumplabels.length; ++i) {
      if (parseInt(pumplabels[i][0]) == num) {
        retstr = pumplabels[i][1];
      }
    }	
    retstr += "[" + num.toString() + "]"; 
    return retstr;
  }

    g_pool = new Dygraph(
        document.getElementById("graph_temp_pool"),  
        dv_pool,
        {ylabel: 'Pool Temperature (C)'
         }                                   
      );     
    g_hx = new Dygraph(
        document.getElementById("graph_temp_hx"),  
        dv_hx,
        {ylabel: 'Heat Exchanger Temperatures (C)'
         }                                   
      );
    g_temp_ambient = new Dygraph(
        document.getElementById("graph_temp_ambient"),  
        dv_temp_ambient,
        {ylabel: 'Ambient Temperature (C)'
         }                                   
      );
    g_cumulative_insolation = new Dygraph(
        document.getElementById("graph_cumulative_insolation"),  
        dv_cumulative_insolation,
        {ylabel: 'Sunshine since midnight (%.hours)'
         }                                  
      );
    g_pump_runtime = new Dygraph(
        document.getElementById("graph_pump_runtime"),  
        dv_pump_runtime,
        {ylabel: 'Pump runtime since midnight (hours)'
         }                                  
      );
    g_pump_runtime = new Dygraph(
        document.getElementById("graph_status_info"),  
        dv_status_info,
        { ylabel: 'Status value',
          y2label: 'Surge Tank level',	
          stepPlot: true,
          series: {
            'Surge Tank Level': {
              axis: 'y2'
            }
          },    
          axes: {
            y: {
	      valueFormatter: pump_status_to_text
            },
            y2: {
              	
            }
          } 
        }                                   
      );      
      
  }
</script>
</body>
</html>
