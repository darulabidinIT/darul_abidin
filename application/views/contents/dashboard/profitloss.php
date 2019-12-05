<?php 
			$profit=$this->db->query("SELECT * FROM sv_setup_profit_loss WHERE type='profit'")->result_array();
			$loss=$this->db->query("SELECT * FROM sv_setup_profit_loss WHERE type='loss'")->result_array(); ?>
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
            $('#container2').highcharts({
				 credits: {
					enabled: false
					},
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Profit Loss. <?php echo GetMonthFull(date('m')).' '.date('Y')?>'
                },
                subtitle: {
                    text: 'Click the columns to view details.'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Capaian'
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
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>idr {point.y}</b><br/>'
                },
				
                drilldown: {
                    series: [
				
					{
						id: 'profit',
						data: [<?php
				$a=1;
				$totun=0;
					foreach ($profit as $untung){ 
					$l=$this->db->query("SELECT SUM(".$untung['transaksi'].") as untung FROM sv_jurnal_detail LEFT JOIN sv_jurnal ON sv_jurnal_detail.id_jur=sv_jurnal.id WHERE MONTH(sv_jurnal.post_tgl)='".date('m')."' AND  YEAR(sv_jurnal.post_tgl)='".date("Y")."' AND sv_jurnal_detail.akun='".$untung['coa']."'   ")->row_array();
					$laba=$l['untung'];
					$totun+=$laba;
				?>
								['<?php echo $untung['title'] ?>', <?php echo $laba?>],
				<?php $a++; } ?>
						]
					},
					{
						id: 'loss',
						data: [<?php
 // print_mz($loss);
					$b=1;
					$totrug=0;
						foreach ($loss as $rugi){ 
						$l=$this->db->query("SELECT SUM(".$rugi['transaksi'].") as rugi FROM sv_jurnal_detail LEFT JOIN sv_jurnal ON sv_jurnal_detail.id_jur=sv_jurnal.id WHERE MONTH(sv_jurnal.post_tgl)='".date('m')."' AND  YEAR(sv_jurnal.post_tgl)='".date('Y')."' AND sv_jurnal_detail.akun='".$rugi['coa']."'  ")->row_array();
						$rugis=$l['rugi'];
						$totrug+=$rugis;?>
								['<?php echo $rugi['title'] ?>', <?php echo $rugis?>],
				<?php $a++; } ?>
						]
					},
					]
                },
                series: [{
                    name: 'Summary Profit Loss',
                    colorByPoint: true,
                    data: [
						{
							name: 'Profit',
							y: <?php echo $totun;?>,
							drilldown: 'profit',
							color:'green'
						},
						{
							name: 'Loss',
							y: <?php echo $totrug?>,
							drilldown: 'loss',
							color:'red'
						},
					]
                }],
            });
        }
    });
});


		</script>
<div id="container2" style="min-width: 310px; height: 400px; margin: 0 " class="col-md-12"></div>