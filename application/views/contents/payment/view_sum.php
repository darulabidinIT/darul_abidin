<div class="alert alert-success" role="alert">
                        Pembayaran Sukses
                        <?php $bill=json_decode($datapay['bill_id']);
                        $billing=GetAll('sv_bill',array('id'=>'where/'.$bill[0]))->row_array();
                                $kelas=GetValue('kelas','kelas_siswa',array('siswa_id'=>'where/'.$billing['siswa_id'],'ta'=>'where/'.$billing['ta']));
                                ?>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="col-md-3" style="font-size:13pt">Tahun Ajaran</div>
            <div class="col-md-3" style="font-size:13pt"><?php echo GetValue('title','master_tahun_ajaran',array('id'=>'where/'.$billing['ta']))?></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="col-md-3" style="font-size:13pt">Nama</div>
            <div class="col-md-6" style="font-size:13pt"><?php echo GetValue('nama_siswa','master_siswa',array('id'=>'where/'.$billing['siswa_id']))?></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="col-md-3" style="font-size:13pt">Kelas</div>
            <div class="col-md-6" style="font-size:13pt"><?php echo GetValue('title','master_kelas',array('id'=>'where/'.$kelas))?></div>
        </div>
    </div>
</div>
<hr>
<?php foreach($bill as $bl){
    
                        $billing=GetAll('sv_bill',array('id'=>'where/'.$bl))->row_array();
                        $billingd=GetAll('sv_bill_detail',array('bill_id'=>'where/'.$bl))->result_array();
    ?>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="col-md-3"><b><?php echo $billing['title']?></b></div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <?php foreach($billingd as $bd){?>
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="col-md-3"><?php echo $bd['item']?></div>
            <div class="col-md-3"><?php echo Rupiah($bd['nominal'])?></div>
        </div>
    </div>
    <hr>
    <?php }?>
</div>
<?php }?>
<hr>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="col-md-3"><h4>Total</h4></div>
            <div class="col-md-3"><h4><?php echo Rupiah($datapay['total'])?></h4></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="col-md-3"><h4>Dibayarkan</h4></div>
            <div class="col-md-3"><h4><?php echo Rupiah($datapay['bayar'])?></h4></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="col-md-3"><h4>Kembali</h4></div>
            <div class="col-md-3"><h4><?php echo Rupiah($datapay['kembali'])?></h4></div>
        </div>
    </div>
</div>
<a class="btn btn-info" href="<?php echo base_url()?>/payment/cetak_kwtiansi/<?php echo $datapay['id'] ?>"><i class="fa fa-print"></i> Cetak Kwitansi</a>