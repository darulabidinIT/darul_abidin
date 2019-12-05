
		   <div class="form-group">
			   <div class="col-sm-3">
				   <label for=""><strong>No Plat</strong></label>
				   </div><div class="col-sm-9">
				   <label for=""><strong>Cost</strong></label>
			   </div>
			 </div>
<?php foreach($truck as $truk){ ?>
		   <div class="form-group">
			   <?php echo form_hidden('truck[]',$truk['id']);?>
			   <?php $nm_f="amount";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo $truk['code']?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>[]"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required] currency">
			   </div>
			 </div>
<?php } ?>
<script>
  $(function() {
    $('.currency').maskMoney({thousands:",",decimal:".",precision:2});
  })
</script>
			   