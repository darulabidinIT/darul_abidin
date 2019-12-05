<div class="col-sm-12">
	<div class="col-sm-3">Item
		
	</div>
	<div class="col-sm-1">Charges LCL
		
	</div>
	<div class="col-sm-1">Charges 20'
		
	</div>
	<div class="col-sm-1">Charges 40'
		
	</div>
	<div class="col-sm-1">Charges 45'
		
	</div>
	<div class="col-sm-1">Remarks
		
	</div>
	
</div>
<?php echo form_hidden('tables',$a= (isset($tables) ? $tables : ''))?>
<?php
$i=0;
 foreach($val as $val){?>
<div class="col-sm-12">
	<div class="col-sm-3">
	<?php $nm_f="item"?>
	<?php echo form_hidden("inpust[$i][".$nm_f."]",$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control''");?>
	<?php $nm_f="client"?>
	<?php echo form_hidden("inpust[$i][".$nm_f."]",$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control''");?>
	<?php $nm_f="service"?>
	<?php echo form_hidden("inpust[$i][".$nm_f."]",$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control''");?>
		<?php echo $val['name']?>
	</div>
	<div class="col-sm-1">
	<?php $nm_f="charge_lcl"?>
	<?php echo form_input("inpust[$i][".$nm_f."]",$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]) : ''),"id='$nm_f' class='form-control currency' ");?>
		
	</div>
	<div class="col-sm-1">
	<?php $nm_f="charge_20"?>
	<?php echo form_input("inpust[$i][".$nm_f."]",$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]) : ''),"id='$nm_f' class='form-control currency' ");?>
		
	</div>
	<div class="col-sm-1">
	<?php $nm_f="charge_40"?>
	<?php echo form_input("inpust[$i][".$nm_f."]",$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]) : ''),"id='$nm_f' class='form-control currency' ");?>
		
	</div>
	<div class="col-sm-1">
	<?php $nm_f="charge_45"?>
	<?php echo form_input("inpust[$i][".$nm_f."]",$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]) : ''),"id='$nm_f' class='form-control currency' ");?>
		
	</div>
	<div class="col-sm-1">
	<?php $nm_f="remarks"?>
	<?php echo form_input("inpust[$i][".$nm_f."]",$a= (isset($val[$nm_f]) ? numbers($val[$nm_f]) : ''),"id='$nm_f' class='form-control' ");?>
		
	</div>
	
	<p><?php echo $val['message']?></p>
</div>
<?php $i++;}?>



<script>
  $(function() {
    $('.currency').maskMoney({thousands:",",decimal:"",precision:0});
  })
</script>