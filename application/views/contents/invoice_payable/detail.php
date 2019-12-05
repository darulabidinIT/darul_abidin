<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>
<script>
	function cektipe(val){
			//alert(val);
			if(val=="FCL"){
				$('#gross_weight').prop('disabled',true);
				$('#gross_metric').prop('disabled',true);
				$('#net_weight').prop('disabled',true);
				$('#net_metric').prop('disabled',true);
				$('#volume_weight').prop('disabled',true);
				$('#volume_metric').prop('disabled',true);
				$('#cont_20').prop('disabled',false);
				$('#cont_40').prop('disabled',false);
				$('#cont_45').prop('disabled',false);
			}
			else if(val=="LCL"){
				$('#gross_weight').prop('disabled',false);
				$('#gross_metric').prop('disabled',false);
				$('#net_weight').prop('disabled',false);
				$('#net_metric').prop('disabled',false);
				$('#volume_weight').prop('disabled',false);
				$('#volume_metric').prop('disabled',false);
				$('#cont_20').prop('disabled',true);
				$('#cont_40').prop('disabled',true);
				$('#cont_45').prop('disabled',true);
			}
	}
	
	$(document).ready(function(e){
		var tipe = '<?php echo $val['type'];?>';
		cektipe(tipe);
	});
</script>
    
<div class="row">
	<ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="<?php echo base_url($this->utama)?>"><?php echo ucfirst($this->utama)?></a>
        </li>
        <li>
            <a href="#"><?php echo $type?></a>
        </li>
    </ul>
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="<?php echo GetValue('icon','sv_menu',array('filez'=>'where/'.$this->utama))?>"></i> <?php echo $this->title;?></h2>

        
    </div>
    	<div class="box-content">
			<form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit" class="form-horizontal formular" role="form">
				<?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
				
				<?php echo form_hidden('job_order',isset($job_order) ? $job_order : '')?>
		   
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="acc";?>
						<label for="<?php echo $nm_f?>">Account Mapping</label>
					</div>
					<div class ="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_acc,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
				</div>
			<fieldset class="col-md-12">
				<legend>Sales</legend>
				<div class="form-group">
					<?php $nm_f="b_acc";
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Account No.</label>
						</div><div class="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					
					<!--Bagian Kanan-->
					<?php $nm_f="b_tax";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Tax</label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,array('NT','Tax'),(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					<?php $nm_f="b_item";?>
					<div class="col-sm-3" >
						<label for="<?php echo $nm_f?>">Item</label>
						</div><div class="col-sm-3" style="<?php echo $lcl?>">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 validate[required] text-input">
						<?php $nm_f="b_metric";?>
						<?php echo form_dropdown($nm_f,$opt_metric,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="col-sm-3" id="'.$nm_f.'" ')?>
					</div>
					
					<!--Bagian Kanan--><?php $nm_f="b_item_price";
					?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Item Price</label>
						</div><div class="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					
					<div class="col-sm-3">
						
						<label for="<?php echo $nm_f?>">Currency</label>
						</div>
					
					<div class="col-sm-3">
						<?php $nm_f="b_currency";?>
						<?php echo form_dropdown($nm_f,$opt_metric,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" id="'.$nm_f.'" ')?>
					</div>
					<!--Bagian Kanan-->
					<?php $nm_f="b_tax_amount";?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Tax Amount</label>
						</div><div class="col-sm-2"><input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 validate[required] text-input">
					</div>
					<!--//Bagian Kanan-->
					
					
				</div>
				<div class="form-group">
					<?php $nm_f="b_amount";?>
					<div class="col-sm-3" >
						<label for="<?php echo $nm_f?>">Amount</label>
						</div><div class="col-sm-3" style="<?php echo $lcl?>">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 validate[required] text-input">
					</div>
					
					<!--Bagian Kanan--><?php $nm_f="b_subtotal";
					?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Subtotal</label>
						</div><div class="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					<?php $nm_f="b_receipt";?>
					<div class="col-sm-3" >
						<label for="<?php echo $nm_f?>">Receipt From</label>
						</div><div class="col-sm-3" style="<?php echo $lcl?>">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 validate[required] text-input">
					</div>
					
					<!--Bagian Kanan--><?php $nm_f="b_type";
					?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Type</label>
						</div><div class="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="col-sm-3" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--//Bagian Kanan-->
					
					</div><div class="form-group">
					<?php $nm_f="b_desc";?>
					<div class="col-sm-3" >
						<label for="<?php echo $nm_f?>">Add Description</label>
						</div><div class="col-sm-9" style="<?php echo $lcl?>">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 validate[required] text-input">
						
					</div>
					
					
				</div>
		</fieldset>
				
				<fieldset class="col-md-12">
					<legend>Cost</legend>
		<div class="form-group">
					<?php $nm_f="c_acc";
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Account No.</label>
						</div><div class="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					
					<!--Bagian Kanan-->
					<?php $nm_f="c_tax";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Tax</label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,array('NT','Tax'),(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					<?php $nm_f="c_item";?>
					<div class="col-sm-3" >
						<label for="<?php echo $nm_f?>">Item</label>
						</div><div class="col-sm-3" style="<?php echo $lcl?>">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 validate[required] text-input">
						<?php $nm_f="c_metric";?>
						<?php echo form_dropdown($nm_f,$opt_metric,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="col-sm-3" id="'.$nm_f.'" ')?>
					</div>
					
					<!--Bagian Kanan--><?php $nm_f="c_item_price";
					?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Item Price</label>
						</div><div class="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					
					<div class="col-sm-3">
						
						<label for="<?php echo $nm_f?>">Currency</label>
						</div>
					
					<div class="col-sm-3">
						<?php $nm_f="c_currency";?>
						<?php echo form_dropdown($nm_f,$opt_metric,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" id="'.$nm_f.'" ')?>
					</div>
					<!--Bagian Kanan-->
					<?php $nm_f="c_tax_amount";?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Tax Amount</label>
						</div><div class="col-sm-2"><input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 validate[required] text-input">
					</div>
					<!--//Bagian Kanan-->
					
					
				</div>
				<div class="form-group">
					<?php $nm_f="c_amount";?>
					<div class="col-sm-3" >
						<label for="<?php echo $nm_f?>">Amount</label>
						</div><div class="col-sm-3" style="<?php echo $lcl?>">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 validate[required] text-input">
					</div>
					
					<!--Bagian Kanan--><?php $nm_f="c_subtotal";
					?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Subtotal</label>
						</div><div class="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					<?php $nm_f="c_to";?>
					<div class="col-sm-3" >
						<label for="<?php echo $nm_f?>">Receipt From</label>
						</div><div class="col-sm-3" style="<?php echo $lcl?>">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 validate[required] text-input">
					</div>
					
					<!--Bagian Kanan--><?php $nm_f="c_type";
					?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Type</label>
						</div><div class="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="col-sm-3" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--//Bagian Kanan-->
					
					</div><div class="form-group">
					<?php $nm_f="c_desc";?>
					<div class="col-sm-3" >
						<label for="<?php echo $nm_f?>">Add Description</label>
						</div><div class="col-sm-9" style="<?php echo $lcl?>">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 validate[required] text-input">
						
					</div>
					
					
				</div>
			</div> 
				
    		<div class="form-group">
            <button type="submit" class="btn pull-right">Submit</button>
            
             </div>
			 </form>
    	</div>
    </div>
    </div>
</div>