<script type="text/javascript">
$(function () {

    Highcharts.data({
        csv: document.getElementById('tsv').innerHTML,
        itemDelimiter: '\t',
        parsed: function (columns) {

            var brands = {},
                brandsData = [],
                versions = {},
                drilldownSeries = [];

            // Parse percentage strings
            columns[1] = $.map(columns[1], function (value) {
                if (value.indexOf('%') === value.length - 1) {
                    value = parseFloat(value);
                }
                return value;
            });

            $.each(columns[0], function (i, name) {
                var brand,
                    version;

                if (i > 0) {

                    // Remove special edition notes
                    name = name.split(' -')[0];

                    // Split into brand and version
                    version = name.match(/([0-9]+[\.0-9x]*)/);
                    if (version) {
                        version = version[0];
                    }
                    brand = name.replace(version, '');

                    // Create the main data
                    if (!brands[brand]) {
                        brands[brand] = columns[1][i];
                    } else {
                        brands[brand] += columns[1][i];
                    }

                    // Create the version data
                    if (version !== null) {
                        if (!versions[brand]) {
                            versions[brand] = [];
                        }
                        versions[brand].push(['v' + version, columns[1][i]]);
                    }
                }

            });

            $.each(brands, function (name, y) {
                brandsData.push({
                    name: name,
                    y: y,
                    drilldown: versions[name] ? name : null
                });
            });
            $.each(versions, function (key, value) {
                drilldownSeries.push({
                    name: key,
                    id: key,
                    data: value
                });
            });

            // Create the chart
            $('#container').highcharts({
				 credits: {
					enabled: false
					},
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Marketing Performances. <?php echo GetMonthFull(date('m')).' '.date('Y')?>'
                },
                subtitle: {
                    text: 'Click the columns to view results.'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Total Marketing Form Prospect'
                    }
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> Prospect Entry<br/>'
                },

                series: [{
                    name: 'All Marketing',
                    colorByPoint: true,
                    data: [
					<?php $mar=GetAll('sv_master_sales',array())->result_array();
					//$drill[]=array();
						$a=0;
						foreach($mar as $sales){
							$sum=$this->db->query("SELECT COUNT(id) as tot, 
(SELECT COUNT(id) as WIN FROM sv_marketing_form_prospect WHERE status='WIN' AND marketing=".$sales['id']." AND MONTH(create_date)='".date('m')."' AND YEAR(create_date)='".date("Y")."') as WIN,
(SELECT COUNT(id) as LOOSE FROM sv_marketing_form_prospect WHERE status='LOOSE' AND marketing=".$sales['id']." AND MONTH(create_date)='".date('m')."' AND YEAR(create_date)='".date("Y")."' ) as LOOSE,
(SELECT COUNT(id) as ONGOING FROM sv_marketing_form_prospect WHERE status='ONGOING' AND marketing=".$sales['id']." AND MONTH(create_date)='".date('m')."' AND YEAR(create_date)='".date("Y")."') as ONGOING
 FROM sv_marketing_form_prospect WHERE marketing=".$sales['id']." AND MONTH(create_date)='".date('m')."' AND YEAR(create_date)='".date("Y")."'")->row_array();
					$drill[$a]['salesid']=$sales['id'];
					$drill[$a]['WIN']=$sum['WIN'];
					$drill[$a]['LOOSE']=$sum['LOOSE'];
					$drill[$a]['ONGOING']=$sum['ONGOING'];
					?>
					
						{
							name: '<?php echo $sales['name']?>',
							y: <?php echo $sum['tot']?>,
							drilldown: '<?php echo $sales['id']?>'
						},
						<?php 
						$a++;
						} ?>	
					]
                }],
                drilldown: {
                    series: [
					<?php foreach($drill as $down){ ?>
					{
                id: '<?php echo $down['salesid']?>',
                data: [
                    ['Win', <?php echo $down['WIN']?>],
                    ['Lose', <?php echo $down['LOOSE']?>],
                    ['In Process', <?php echo $down['ONGOING']?>]
                ]
					},<?php } ?>
			]
                }
            });
        }
    });
});


		</script>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 " class="col-md-12"></div>