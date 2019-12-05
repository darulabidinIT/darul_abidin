<div class="col-sm-12">
	<div class="col-sm-1">Location
		
	</div>
	<div class="col-sm-1">Tailyman
		
	</div>
	<div class="col-sm-1">3T
		
	</div>
	<div class="col-sm-1">5T
		
	</div>
	<div class="col-sm-1">8T
		
	</div>
	<div class="col-sm-1">10T
		
	</div>
	<div class="col-sm-1">12T
		
	</div>
	<div class="col-sm-1">14T
		
	</div>
	
</div>
<div class="col-sm-12">
<?php echo form_hidden('tables',$a= (isset($tables) ? $tables : ''))?>
	<div class="col-sm-1">
	<?php $nm_f="tables"?>
	<?php echo form_hidden($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control''");?>
	
	<?php $nm_f="location"?>
	<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f]: ''),"id='$nm_f' class='form-control ");?>
		
	</div>
	<div class="col-sm-1">
	<?php $nm_f="tailyman"?>
	<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]): ''),"id='$nm_f' class='form-control currency' ");?>
		
	</div>
	<div class="col-sm-1">
	<?php $nm_f="3T"?>
	<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]): ''),"id='$nm_f' class='form-control currency' ");?>
		
	</div>
	<div class="col-sm-1">
	<?php $nm_f="5T"?>
	<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]) : ''),"id='$nm_f' class='form-control currency' ");?>
		
	</div>
	<div class="col-sm-1">
	<?php $nm_f="8T"?>
	<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]): ''),"id='$nm_f' class='form-control currency' ");?>
		
	</div>
	<div class="col-sm-1">
	<?php $nm_f="10T"?>
	<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]) : ''),"id='$nm_f' class='form-control currency' ");?>
		
	</div>
	<div class="col-sm-1">
	<?php $nm_f="12T"?>
	<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]) : ''),"id='$nm_f' class='form-control currency' ");?>
		
	</div>
	<div class="col-sm-1">
	<?php $nm_f="14T"?>
	<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]) : ''),"id='$nm_f' class='form-control currency' ");?>
		
	</div>
	
	<p><?php echo $message?></p>
</div>


<script>
  $(function() {
    $('.currency').maskMoney({thousands:",",decimal:"",precision:0});
  })
</script>