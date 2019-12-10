

<script type="text/javascript">
    
$(function () {
Highcharts.chart('container', {

    title: {
        text: 'Transaksi <?php echo date('M Y')?>'
    },

    subtitle: {
        text: ''
    },
    xAxis: {
        title: {
            text: 'Tanggal'
        },
        categories: [<?php 
        $fdate=tanggalpenuh(date('Y-m-d'));
        $enddate=substr($fdate,8,2);
        for($a=1;$a<=$enddate;$a++){
            echo "$a,";
            
        }?>]
    },

    yAxis: {
        title: {
            text: 'Pemasukan'
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },


    series: [{
        name: 'Pemasukan',
        data: [
            <?php 
            for($a=1;$a<=$enddate;$a++){
                $ddate=date('Y-m-').$a;
            $q=$this->db->query("SELECT COALESCE(SUM(total),0) as total FROM sv_bill_payment WHERE DATE(created_on)='$ddate'")->row_array();
            echo $q['total'].",";
            }?>
            
        ]
    },],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

});
});
</script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 " class="col-md-12"></div>