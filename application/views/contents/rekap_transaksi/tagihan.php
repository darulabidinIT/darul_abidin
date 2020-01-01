<table style="width:100%" border="1" cellspacing="0">
    <tr>
        <th colspan="2" align="center">SLIP TAGIHAN SMPIT DARUL ABIDIN</th>
    </tr>
    <tr>
        <th width="30%" align="left">Nama Siswa</th><th align="left"><?php echo GetValue('nama_siswa','master_siswa',array('id'=>'where/'.$datapay['siswa_id'])) ?></th>
    </tr>
    <tr>
        <th width="30%" align="left">Kelas</th><th align="left"><?php echo GetValue('title','master_kelas',array('id'=>'where/'.GetValue('kelas','kelas_siswa',array('siswa_id'=>'where/'.$datapay['siswa_id'],'ta'=>'where/'.$datapay['ta'])))) ?></th>
    </tr>
    <tr>
        <th width="30%" align="left">Nama Tagihan</th><th align="left"><?php echo $datapay['title']?></th>
    </tr>
</table>
<table border="1" cellspacing="0" style="width:100%">
    <tr>
        <th width="5%">No</th>
        <th width="70%">Uraian</th>
        <th width="25%">Jumlah</th>
    </tr>
    <?php
    $a=1;
    $detail=GetAll('bill_detail',array('bill_id'=>'where/'.$datapay['id']))->result_array();
    $total=0;
    foreach($detail as $dt){
        $total+=$dt['nominal'];
    ?>
    <tr>
        <th width="5%" align="left"><?php echo $a;?></th>
        <th width="70%" align="left"><?php echo $dt['item']?></th>
        <th width="25%" align="right"><?php echo Rupiah($dt['nominal'])?></th>
    </tr>
    <?php $a++; }?>
    <tr>
        <th width="75%" align="center" colspan="2">Jumlah Harus Dibayar</th>
        <th width="25%" align="right"><?php echo Rupiah($total) ?></th>
    </tr>
</table>

<p>Nb : </p>
<ul>
<li>Tanggal Cetak  <?php echo tglindofull(date('Y-m-d'))?></li>
<li>Mohon tagihan ini dibawa ke TU</li>
<li>Mohon abaikan surat ini apabila telah melakukan pembayaran atas tagihan tersebut.</li>
</ul>


<script type="text/javascript">
//window.print();
</script>