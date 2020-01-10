<?php
$bill=json_decode($datapay['bill_id']);
                        $billing=GetAll('sv_bill',array('id'=>'where/'.$bill[0]))->row_array();
                                $kelas=GetValue('kelas','kelas_siswa',array('siswa_id'=>'where/'.$billing['siswa_id'],'ta'=>'where/'.$billing['ta']));
?>
<?php for($is=1;$is<=2;$is++){?><div style="width:48%; display:inline;float:left; margin-left: 1%;">
    <center>KWITANSI PEMBAYARAN SPP ADMINISTRASI</center>
<table width="100%">
    <tr>
        <td width="30%">No Kwitansi</td><td width="3%">:</td><td width="67%"><?php echo $datapay['no_payment']?></td>
    </tr>
    <tr>
        <td width="30%">Nama</td><td width="3%">:</td><td width="67%"><b><?php echo GetValue('nama_siswa','master_siswa',array('id'=>'where/'.$billing['siswa_id']))?> | <?php echo GetValue('title','master_kelas',array('id'=>'where/'.$kelas))?></b></td>
    </tr>
    <?php foreach($bill as $bl){
    
                        $billing=GetAll('sv_bill',array('id'=>'where/'.$bl))->row_array();
                        $billingd=GetAll('sv_bill_detail',array('bill_id'=>'where/'.$bl))->result_array();
    ?>
    <tr>
        <td width="30%"><?php echo $billing['title']?></td><td width="3%">:</td><td width="67%">
            
            
    <?php foreach($billingd as $bd){?>
            [<?php echo $bd['item']?> :<?php echo Rupiah($bd['nominal'])?>],
    <?php }?>
</td>
    </tr>
    <?php }?>
</table>
   
    
    <hr>
    <table width="100%">
    <tr>
        <td width="10%">Total</td><td width="3%">:</td><td width="30%" style="font-size:11pt;"><b><?php echo Rupiah($datapay['total'])?></b></td><td align="center">Oleh</td><td align="center">Kasir</td>
    </tr>
    <tr>
        <td width="10%">Uang Bayar</td><td width="3%">:</td><td width="20%" colspan="3" style="font-size:11pt;"><b><?php echo Rupiah($datapay['bayar'])?></b></td>
    </tr>
    <tr>
        <td width="10%">Kembali</td><td width="3%">:</td><td width="20%" colspan="3" style="font-size:11pt;"><b><?php echo Rupiah($datapay['kembali'])?></b></td>
    </tr>
    <tr>
        <td width="10%">Metode</td><td width="3%">:</td><td width="30%" style="font-size:11pt;"><b><?php echo strtoupper($datapay['metode'])?></b></td><td align="center"><span style="color:grey;font-size:8pt;">-nama-</span></td><td align="center"><?php echo GetValue('name','sv_admin',array('id'=>'where/'.$datapay['created_by'])) ?></td>
    </tr>
</table>
    
    <hr>
    <div  style="text-align:center; width:100%;">
    <h style="color:grey;font-size:8pt;">Dengan ditandatanganinya kwitansi ini, maka sekolah dan pemohon setuju atas data transaksi yang tertera di atas. Mohon disimpan hingga pembayaran berikutnya. Terima kasih</h>
    </div>
</div>&nbsp;
<?php }?>
<script type="text/javascript">
window.print();
</script>