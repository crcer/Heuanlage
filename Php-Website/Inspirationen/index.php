<!doctype html>

<?php
 include 'Tempwerte.php';
?>
<html lang="de">
<head>
<meta charset="utf-8" />
<title>Temp</title>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>

<script>
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart_tag',
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Tagestemperaturverlauf',
                x: -20 //center
            },

            xAxis: {
				title: {
                    text: 'Uhrzeit'
                },
                categories: ['1', '2', '3', '4', '5', '6',
                    '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18',
                    '19', '20', '21', '22', '23', '24']
            },
            yAxis: {
                title: {
                    text: 'Temperatur ( °C )'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                        return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y +'°C';
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Temperatur',
                data: [<?php daytemp(); ?>]
            }]
        });
    });

});
</script>

</head>
<body>
<!-- Highstock -->
<script src="http://code.highcharts.com/stock/highstock.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
<!-- Highcharts -->
<script src="http://code.highcharts.com/highcharts.js"></script>


<h1>Temperatur</h1>


	<div id="chart_tag" style="height: 450px; min-width: 600px"></div>
	<br/>
	<!-- <div id="chart_historisch" style="height: 500px; min-width: 600px"></div> -->


</body>
</html>
