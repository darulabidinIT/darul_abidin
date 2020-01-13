<?php 
    foreach($qpayment as $qy){
        $qid[]=$qy->id;
    }
    $payment_id=implode(',',$qid);
?>

<style>
    #tablerekap{
        margin-top:10px;    
    }
    table th{
        padding:5px;
        background:cornflowerblue;
        color:white;
        
    }
    
    table td{
        padding:5px;
        background:white;
        color:black;
    }
</style>
<?php 
    $detail=$this->db->query("SELECT a.type type,b.title kategori FROM sv_bill_payment_detail a LEFT JOIN sv_ref_item_custom b ON a.type=b.id WHERE a.type NOT IN(8,87,1,2,28,29,86) AND payment_id IN ($payment_id) GROUP BY a.type")->result_array();
    //lastq();
?>
<div class="col-md-12">
    <button class="btn btn-success pull-right" onclick="exportTableToExcel('tablerekap','Rekap Transaksi <?php echo date('d-m-Y')?>')">Export To Excel</button></div>
    <div class="col-md-12">
<table id="tablerekap" border="1" width="100%">
    <tr>
        <th>Tgl Transaksi</th>
        <th>Kasir</th>
        <th>Cara Bayar</th>
        <th>Nama Siswa</th>
        <th>Unit</th>
        <th>Kelas</th>
        <th>Periode</th>
        <th>Biaya Masuk</th>
        <th>Daftar Ulang</th>
        <th>SPP</th>
        <th>KS</th>
        <th>Catering</th>
        <th>Antar Jemput</th>
        <th>Rumah Berbagi</th>
        <?php foreach($detail as $dt){?>
            <th><?php echo $dt['kategori']?></th>
        <?php }?>
        <th>Jumlah</th>
    </tr>
    <?php foreach($qpayment as $qp){
        $biaya_masuk=$this->db->query("SELECT total FROM sv_bill_payment_detail WHERE payment_id='".$qp->id."' AND type='8'")->row_array();
        $du=$this->db->query("SELECT total FROM sv_bill_payment_detail WHERE payment_id='".$qp->id."' AND type='87'")->row_array();
        $spp=$this->db->query("SELECT total FROM sv_bill_payment_detail WHERE payment_id='".$qp->id."' AND type='1'")->row_array();
        $ks=$this->db->query("SELECT total FROM sv_bill_payment_detail WHERE payment_id='".$qp->id."' AND type='2'")->row_array();
        $catering=$this->db->query("SELECT total FROM sv_bill_payment_detail WHERE payment_id='".$qp->id."' AND type='28'")->row_array();
        $anter_jemput=$this->db->query("SELECT total FROM sv_bill_payment_detail WHERE payment_id='".$qp->id."' AND type='29'")->row_array();
        $rumah_berbagi=$this->db->query("SELECT total FROM sv_bill_payment_detail WHERE payment_id='".$qp->id."' AND type='86'")->row_array();
        
         foreach($detail as $dt){
         $ss[$dt['type']]=$this->db->query("SELECT SUM(total) as total FROM sv_bill_payment_detail WHERE payment_id='".$qp->id."' AND type = '".$dt['type']."'")->row_array();
         
         }
         
        ?>
    <tr>
        <td><?php echo tglindo($qp->created_on)?></td>
        <td><?php echo $qp->kasir?></td>
        <td><?php echo $qp->metode?></td>
        <td><?php echo $qp->nama_siswa?></td>
        <td><?php echo $qp->jenjang_ ?></td>
        <td><?php echo $qp->kelas_ ?></td>
        <td><?php echo $qp->tahun_ajaran_?></td>
        <td><?php echo uang($biaya_masuk['total']) ?></td>
        <td><?php echo uang($du['total']) ?></td>
        <td><?php echo uang($spp['total']) ?></td>
        <td><?php echo uang($ks['total']) ?></td>
        <td><?php echo uang($catering['total']) ?></td>
        <td><?php echo uang($anter_jemput['total']) ?></td>
        <td><?php echo uang($rumah_berbagi['total']) ?></td>
        <?php foreach($detail as $dt){?>
            <td><?php echo uang($ss[$dt['type']]['total'])?></td>
        <?php }?>
        <td><?php echo uang($qp->total) ?></td>
    </tr>
    <?php }?>
</table>
    </div>
<script>
    function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>  