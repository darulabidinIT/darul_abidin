<div class="col-md-8 invoice" style="min-height:32px!important;">
    <?php //foreach($qbill as $qb){?>
    <input type="hidden" name="id_bill[]" value="<?php echo $qbill['id']?>">
    <div class="row">
        <div class="col-md-12" >
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?php echo $qbill['id']?>" aria-expanded="true" aria-controls="collapseOne">
             <?php echo $qbill['title']?>
            </button>
        </div>
    </div>
    <?php //}?>
</div>
<div class="col-md-4 invoice" style="min-height:32px!important;">
    <input type="price" class="hargasatuan" value="<?php echo uang($billprice['price'])?>" style="background:white!important;border:0px;" readonly="">
</div>
<!--div class="col-md-12 invoice" -->
    <div id="collapse<?php echo $qbill['id']?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body">
          <?php foreach($qbilld as $qb){?>
          <div class="col-md-8" style="min-height:32px!important;border-left: 1px solid #ddd;">
        
        <div class="row">
            <div class="col-md-12" >
                
                &nbsp;&nbsp;&nbsp;<?php echo $qb['item']?>
            </div>
        </div>
    </div>
    <div class="col-md-4" style="min-height:32px!important;border-left: 1px solid #ddd;border-right: 1px solid #ddd;text-align: left;">
    <input type="price" class="hargaeceran" value="<?php echo uang($qb['nominal'])?>" style="background:white!important;border:0px;" readonly="">
    </div>
          
        <?php }?>
      </div>
    </div>
<!--/div-->
<script>
</script>