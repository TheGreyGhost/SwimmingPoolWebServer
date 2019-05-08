<?php
    require "db_historical_connect.php";


// not-shown: file bootstrapping logic, if any
$rows = [];
// not shown: your DB logic to retrieve records

if(empty($rows)) {
    // you have no results to work with so perhaps handle this as error condition and exit/redirect.
}
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    // use json_encode to pass data from PHP to javascript literal
    var rows = <?php echo json_encode($rows); ?>;

    //Google Stuff
    google.charts.load('current', {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Define the chart to be drawn.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Element');
        data.addColumn('number', 'Percentage');
        data.addRows(rows);         

        // Set chart options
        var options = {
            title:'Sales',
            titleTextStyle: {color: 'white', bold: true},
            height:300,
            backgroundColor: '#3a3939',
            color: '#fff',
            legend: {textStyle: {color: 'white'}},
            hAxis: {gridlines: {color: 'black'}}
        };

        // Instantiate and draw the chart.
        var chart = new google.visualization.PieChart(document.getElementById('SalesChar'));
        chart.draw(data, options );
    }
</script>