<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>
<script>
	$(document).ready(function(e){
		
			var client = $('#messers').val()
			var from = $('#loading').val();
			var to = $('#unloading').val();
			var service = '3';
			var ids='';
			
				$('#area_quotation').load("<?php echo base_url('load')?>/generatequotation/",{c:client,s:service,f:from,to:to,v:ids},function(){
					
					$('#area_quotation').show();
	});
	});
	
	
	function client(a){
		var vals=a;
		$.post( "<?php echo base_url()?>load/marketingtrucking/", { v:vals },
		function( data ) {
				oy=data.split('/');
			$('#messers').val(oy[0]);
			$('#loading').val(oy[1]);
			$('#unloading').val(oy[2]);
			$('#service').val(oy[3]);
			$('#vehicle_no').val(oy[4]);
			location.reload();
		});
		
	}	
	function lihatvendor(a){
		var vals=a;
		$.post( "<?php echo base_url()?>load/vendortruck/", { v:vals },
		function( data ) {
			$('#vendor').val(data);
		});
		
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
		   <div class="form-group" id="area_quotation" style="display:none;">
			   AREA QUOTATION DISINI
		   </div>
			
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="prospek";?>
						<label for="<?php echo $nm_f?>">Marketing Form Prospect</label>
					</div>
					<div class ="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_marketing,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." onChange="client(this.value)" ')?>
					</div>
				</div>
		   <div class="form-group">
			   
			   <?php $nm_f="messers";
				   $sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
			   if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-3">
				   <?php echo form_dropdown($nm_f,$opt_client,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
			   </div>
			   
			   </div>
				<div class="form-group">
					
					<?php $nm_f="npwp";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-9">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
					</div>
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="due_date";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo 'Due Date'?></label>
						</div><div class="col-sm-9">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
					</div>
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="bank_acc";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo 'Bank Acc'?></label>
						</div><div class="col-sm-9">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
					</div>
					
				</div>
				
				<div class="form-group" style="<?php echo isset($_GET['service']) ? "display:none" : ""?>">
			   
					<div class="col-sm-3">
						<?php $nm_f="type";?>
					</div>
				<div class="col-sm-3">
					   <?php $a="dedicated";
						   $mark=($val[$nm_f]==$a || $_GET['service']==$a ? TRUE : FALSE);
						   //echo $mark;
						   $data = array(
						   'name'        => $nm_f,
						   'id'          => $nm_f,
				'value'       => $a,
						   'checked'     => $mark,
						   'style'       => 'margin:10px',
						   
						   
						   );
						   
						   echo form_radio($data);
						   
					   ?>
					 <label for="<?php echo $nm_f?>">Dedicated</label>&nbsp;&nbsp;&nbsp;&nbsp;
					 
					 
					 <?php $a="on_call";
						 $mark=($val[$nm_f]==$a || $_GET['service']==$a ? TRUE : FALSE);
						 //echo $mark;
						 $data = array(
						 'name'        => $nm_f,
						 'id'          => $nm_f,
						 'value'       => $a,
						 'checked'     => $mark,
						 'style'       => 'margin:10px',
						 );
						 
						 echo form_radio($data);
						 
					 ?>
					 <label for="<?php echo $nm_f?>">On Call</label>&nbsp;&nbsp;&nbsp;&nbsp;
				 </div>
			</div>
				<div class="form-group">
					
					<?php $nm_f="pic";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-9">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
					</div>
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="loading";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Loading</label>
						</div><div class="col-sm-9">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 ">
					</div>
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="unloading";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Unloading</label>
						</div><div class="col-sm-9">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4">
					</div>
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="request_date";?>
					<div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Request Date</label>
						</div><div class="col-sm-3">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='validate[required,custom[date]] form-control date-picker' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="service";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Service(Truck Type)</label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_trucking,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." readonly="readonly" ')?>
					</div>
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="vehicle_no";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Vehicle No</label>
						</div><div class="col-sm-9">
						<?php echo form_dropdown($nm_f,$opt_truck,$val[$nm_f],'class="chosen-select col-md-5" id="'.$nm_f.'" data-placeholder="Choose a State..." onChange="lihatvendor(this.value)" readonly="readonly" ')?>
					</div>
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="vendor";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Vendor</label>
						</div><div class="col-sm-9">
						<?php echo form_input($nm_f, (isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="col-md-5" id="'.$nm_f.'" readonly ')?>
					</div>
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="rit";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">RIT / Truck / Days</label>
						</div><div class="col-sm-9">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
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