<?php
    require "db_historical_connect.php";

    // Get the latest sensor reading, round the result for each sensor and update webpage
    $sql = "SELECT `timestampUTC`, `hx_hot_inlet_ave`, `hx_hot_outlet_ave`, `hx_cold_inlet_ave`,  `hx_cold_outlet_ave`,  `temp_ambient_ave`,  `cumulative_insolation` FROM `LoggedData` ORDER BY timestampUTC LIMIT 5;";
    $result = mysqli_query($conn_hist, $sql);
    $historydata = mysqli_fetch_all($result);
    mysqli_free_result($result);
    mysqli_close($conn_hist);

if(empty($historydata)) {
    // you have no results to work with so perhaps handle this as error condition and exit/redirect.
  die("No data found");
}
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // use json_encode to pass data from PHP to javascript literal
    var historydata = <?php echo json_encode($historydata); ?>;

   hdlen = historydata.length;	
   for (i = 0; i < 3; i++) {
     document.writeln(historydata[i][0]);
   }

   document.writeln("----");
   for (i = 0; i < 3; i++) {
     document.writeln(historydata[0][i]);
   }

    //Google Stuff
//    google.charts.load('current', {packages: ['corechart']});
//    google.charts.setOnLoadCallback(drawChart);

//    function drawChart() {
        // Define the chart to be drawn.
//        var data = new google.visualization.DataTable();
//        data.addColumn('string', 'Element');
//        data.addColumn('number', 'Percentage');
//        data.addRows(rows);         

        // Set chart options
  //      var options = {
//            title:'Sales',
//            titleTextStyle: {color: 'white', bold: true},
//            height:300,
//            backgroundColor: '#3a3939',
//            color: '#fff',
//            legend: {textStyle: {color: 'white'}},
//            hAxis: {gridlines: {color: 'black'}}
//        };

//        // Instantiate and draw the chart.
//        var chart = new google.visualization.PieChart(document.getElementById('SalesChar'));
//        chart.draw(data, options );
//    }
</script>