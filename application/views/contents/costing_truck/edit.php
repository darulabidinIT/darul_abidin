<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>
<script>

$(document).ready(function(e){
	caritruk(1);
	$('#vendor').val(1);
});

function caritruk(vals){
	//alert('al');
	$('#daftartruck').load('<?php echo base_url()?>costing_truck/setvendor/',{id:vals});
}
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
		   
			
		   
		   <div class="form-group">
			   
			   <?php $nm_f="number";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-2 text-input" readonly>
			   </div>
		   </div>
			<div class="form-group">
					
					<?php $nm_f="period";?>
					<div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Period</label>
						</div><div class="col-sm-3">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='validate[required] form-control date-picker' data-date-format='yyyy-mm'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					
				</div>
				<div class="form-group" style="display:none;">	
					<div class="col-sm-3">
						<?php $nm_f="vendor";?>
						<label for="<?php echo $nm_f?>">Vendor</label>
					</div>
					<div class ="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_vendor,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." onChange="caritruk(this.value)" ')?>
					</div>
				</div>
				<div class="form-group">
				<?php $nm_f="coa";?>
				<div class="col-sm-3">
					<label for="<?php echo $nm_f?>">COA</label>
					</div><div class="col-sm-4">
					<?php echo form_dropdown($nm_f,$opt_coa, (isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='chosen-select form-control'")?>
				</div>
				</div>
				<div class="form-group">
				<?php $nm_f="invoice";?>
				<div class="col-sm-3">
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div><div class="col-sm-4">
					<?php echo form_dropdown($nm_f,$opt_invoice, (isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='chosen-select form-control'")?>
				</div>
				</div>
			<div id="daftartruck">
			</div>
    		<div class="form-group">
            <button type="submit" class="btn pull-right">Submit</button>
            
             </div>
			 </form>
    	</div>
    </div>
    </div>
</div>