
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Temperature</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript">
$(function () {
        $('#container').highcharts({
            chart: {
                zoomType: 'x',
                spacingRight: 20,
				type: 'spline',
                events: {
                    load: function() {
    
                        // set up the updating of the chart each second
                        var cpuseries = this.series[0];
						var roomseries = this.series[1];
						
                        setInterval(function() {
							$.get("backend.php?s="+since, function(data)
							{
								var o = jsondecode(data);
								if(o)
								{
									if(o.carr)
										$.each(o.carr, function()
										{
											cpuseries.addPoint([(this.time+7200000), parseFloat(this.data) ], true, true);
											if(this.time>since)since = this.time+1;
										});
									
									if(o.rarr)
										$.each(o.rarr, function()
										{
											roomseries.addPoint([(this.time+7200000), parseFloat(this.data) ], true, true);
											if(this.time>since)since = this.time+1;
										});
								}
							});
                        }, 60000);
                    }
                }
            },
            title: {
                text: 'Temperature recordings'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' :
                    'Drag your finger over the plot to zoom in'
            },
            xAxis: {
                type: 'datetime',
                maxZoom: 3600000,
                title: {
                    text: null
                }
            },
            yAxis: {
                title: {
                    text: 'Temperature'
                }
            },
            tooltip: {
                shared: true
            },
            legend: {
                enabled: true
            },
            plotOptions: {
                spline: {
                    lineWidth: 4,
                    states: {
                        hover: {
                            lineWidth: 5
                        }
                    },
                    marker: {
                        enabled: false
                    }
                }
            },
            
            series: [{
                name: 'CPU temperature',
                data: [
					<?php
						$since = 0;
						$data = file('data_cpu.csv');
						foreach($data as $line)
						{
							$arr = explode(';',$line);
							$arr[1] = trim($arr[1]);
							echo '['.(($arr[1]+7200)*1000).','.$arr[0].'],'."\n";
							if($arr[1]>$since) $since = $arr[1];
						}
					
					?>
                ]
            }, {
                name: 'Room temperature',
                data: [
					<?php
						$data = file('data_room.csv');
						foreach($data as $line)
						{
							$arr = explode(';',$line);
							$arr[1] = trim($arr[1]);
							echo '['.(($arr[1]+7200)*1000).','.$arr[0].'],'."\n";
							if($arr[1]>$since) $since = $arr[1];
						}
					
					?>
                ]
            }]
        });
    });
	
	var since = <?php echo ($since+1); ?>;
    
	function jsondecode(string)
	{
		var obj = jQuery.parseJSON(string);
		return obj;
	}

		</script>
	</head>
	<body>
<script src="js/highcharts.js"></script>
<script src="js/modules/exporting.js"></script>

<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>

	</body>
</html>
