<div class="col-md-5">
    <?php foreach($qbill as $qb){?>
    <div class="row">
        <div class="col-md-12" style="border-bottom:1px solid blue;">
            <input type="checkbox" id="checkspp-<?php echo $qb['id']?>" name="bill" value="1" onchange="masukinbill(<?php echo $qb['id']?>)"> <?php echo $qb['title']?>
        </div>
    </div>
    <?php }?>
</div>
<script>
    function masukinbill(v){
        //alert('ok');
        var cekbox=$('#checkspp-'+v).val();
        if ($('#checkspp-'+v).is(":checked"))
        {
            var act='add';
        }else{
            var act='del';
        }
        var itungproduk=$('.itemnya').length;
        var idsekarang=itungproduk+1;
        if(act=='add'){
        $('.inv_item').append('<div class="itemnya form-group" id="itemnya-'+v+'" style="border-bottom:1px #0044cc dashed;margin-bottom:20px;"><img src="<?php echo base_url().'assets/img/load.gif'?>" width="100px"></div>');
            //$('#tomboltambah').hide();
            setTimeout(function(){ $('#itemnya-'+v).load('<?php echo base_url()?>payment/item_bill_pmb/'+v+'/'+act+'/'+idsekarang,function(e){
                    //$('#tomboltambah').show();
                    
                    hitungtotal();
            }); }, 200);
            setTimeout(function(){ $('#paidhistory').load('<?php echo base_url()?>payment/item_pay_pmb/'+v+'/'+act+'/'+idsekarang,function(e){
                    $.post('<?php echo base_url()?>payment/item_paid_pmb/'+v,function(e){
                        $('#paid').val(e);
                        hitungtotal();
                    });
            }); }, 200);
        
        }else{
            $('#paidhistory').empty();
            $('#paid').val(0);
            $('#itemnya-'+v).remove();
            
                hitungtotal();
        }
    }
</script>