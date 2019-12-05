
		   <div class="form-group">
			   <?php echo form_hidden('truck[]','');?>
			   <?php $nm_f="amount";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>[]"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required] currency">
			   </div>
			   </div>
<script>
  $(function() {
    $('.currency').maskMoney({thousands:",",decimal:"",precision:0});
  })
</script>
			   