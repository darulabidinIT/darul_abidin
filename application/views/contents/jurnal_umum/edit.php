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
			<form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url('printing')?>/jurnal_umum" class="form-horizontal formular" role="form">
				<?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
				
				<?php echo form_hidden('job_order',isset($job_order) ? $job_order : '')?>
		   
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="coa";?>
						<label for="<?php echo $nm_f?>">Account</label>
					</div>
					<div class ="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_coa,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
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
    		<div class="form-group">
            <button type="submit" class="btn pull-right">Submit</button>
            
             </div>
			 </form>
    	</div>
    </div>
    </div>
</div>