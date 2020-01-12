<div class="col-md-8 invoice" style="min-height:32px!important;">
    
    <div class="row">
        <div class="col-md-12" >
             Nominal Pembayaran
        </div>
    </div>
</div>
<div class="col-md-4 invoice" style="min-height:32px!important;">
    Tanggal Pembayaran
</div>
<?php foreach($qbill as $qb){?>
<div class="col-md-8 invoice" style="min-height:32px!important;">
    
    <div class="row">
        <div class="col-md-12" >
             <?php echo uang($qb['bayar'])?>
        </div>
    </div>
</div>
<div class="col-md-4 invoice" style="min-height:32px!important;">
    <?php echo tglindo($qb['created_on'])?>
</div>

    <?php }?>
</script>