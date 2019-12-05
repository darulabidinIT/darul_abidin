<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
$fcl='';
$lcl='';
if($_GET['service']=='LCL'){
	$fcl="display:none";
}
else if($_GET['service']=='FCL'){
	$lcl="display:none";
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
	function client(a){
			var vals=a;
		$.post( "<?php echo base_url()?>load/marketingclient/", { v:vals },
		function( data ) {
			$('#shipper').val(data);
			location.reload();
		});
			
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
		   
				<div class="form-group" id="prospeks">
					
					<div class="col-sm-3">
						<?php $nm_f="prospek";?>
						<label for="<?php echo $nm_f?>">Marketing Form Prospect</label>
					</div>
					<div class ="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_marketing,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select validate[required] form-control " id="'.$nm_f.'" data-placeholder="Choose a State..." onChange="client(this.value)" ')?>
					</div>
				</div>
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="freight";?>
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div>
					<div class="col-sm-3">
						<?php $a="Prepaid";
							$mark=($val[$nm_f]==$a ? TRUE : FALSE);
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
						<label for="<?php echo $nm_f?>"><?php echo $a?></label>&nbsp;&nbsp;&nbsp;&nbsp;
						
						
						<?php $a="Collect";
							$mark=($val[$nm_f]==$a ? TRUE : FALSE);
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
						<label for="<?php echo $nm_f?>"><?php echo $a?></label>&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					
					
					<!--Bagian Kanan-->
					<div class="col-sm-2"  style="display:none">
						<?php $nm_f="type";?>
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div>
					<div class="col-sm-3" style="display:none">
						<?php $a="FCL";
							$mark=($val[$nm_f]==$a || $_GET['service']==$a ? TRUE : FALSE);
							//echo $mark;
							$data = array(
							'name'        => $nm_f,
							'id'          => $nm_f,
							'value'       => $a,
							'checked'     => $mark,
							'style'       => 'margin:10px',
							'onClick'       => 'cektipe(this.value)'
							
							
							);
							
							echo form_radio($data);
							
						?>
						<label for="<?php echo $nm_f?>"><?php echo $a?></label>&nbsp;&nbsp;&nbsp;&nbsp;
						
						
						<?php $a="LCL";
							$mark=($val[$nm_f]==$a || $_GET['service']==$a ? TRUE : FALSE);
							//echo $mark;
							$data = array(
							'name'        => $nm_f,
							'id'          => $nm_f,
							'value'       => $a,
							'checked'     => $mark,
							'style'       => 'margin:10px',
							'onClick'       => 'cektipe(this.value)'
							);
							
							echo form_radio($data);
							
						?>
						<label for="<?php echo $nm_f?>"><?php echo $a?></label>&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					
					
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="line";?>
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div>
					<div class="col-sm-5">
						<?php $a="green";
							$mark=($val[$nm_f]==$a ? TRUE : FALSE);
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
						<label for="<?php echo $nm_f?>"><?php echo $a?></label>&nbsp;&nbsp;&nbsp;&nbsp;
						
						
						<?php $a="red";
							$mark=($val[$nm_f]==$a ? TRUE : FALSE);
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
						<label for="<?php echo $nm_f?>"><?php echo $a?></label>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php $a="yellow";
							$mark=($val[$nm_f]==$a ? TRUE : FALSE);
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
						<label for="<?php echo $nm_f?>"><?php echo $a?></label>&nbsp;&nbsp;&nbsp;&nbsp;
						
					</div>
					
					
					<!--Bagian Kanan-->
					<div class="col-sm-3">
						
						<?php $nm_f="line_2";?>
						<?php $a="PIB";
							$mark=($val[$nm_f]==$a ? TRUE : FALSE);
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
						<label for="<?php echo $nm_f?>"><?php echo $a?></label>&nbsp;&nbsp;&nbsp;&nbsp;
						
						
						<?php $a="BC23";
							$mark=($val[$nm_f]==$a ? TRUE : FALSE);
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
						<label for="<?php echo $nm_f?>"><?php echo $a?></label>&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
					
					
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					<div class="col-sm-3" style="display:none">
					<?php $nm_f="form";?>
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				</div>
				<div class="col-sm-3" style="display:none">
					<?php $a="NORMAL";
						$mark=($val[$nm_f]==$a || strtoupper($_GET['type'])==$a  ? TRUE : FALSE);
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
					<label for="<?php echo $nm_f?>"><?php echo $a?></label>&nbsp;&nbsp;&nbsp;&nbsp;
					
					
					<?php $a="CC";
						$mark=($val[$nm_f]==$a || strtoupper($_GET['type'])==$a ? TRUE : FALSE);
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
					<label for="<?php echo $nm_f?>"><?php echo $a?></label>&nbsp;&nbsp;&nbsp;&nbsp;
					
				</div>
					
					<?php $nm_f="warehouse";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 text-input">
					</div>
					
				</div>
				
				
				<div class="form-group">
					<?php $nm_f="shipper";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_client,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					
					<!--Bagian Kanan--><?php $nm_f="carrier";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_client,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					<?php $nm_f="consignee";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_client,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					
					<!--Bagian Kanan--><?php $nm_f="trucking";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_client,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="airport_dept";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Airport Dept</label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_port,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--Bagian Kanan-->
					<?php $nm_f="invoice";?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Invoice #</label>
						</div><div class="col-sm-2">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 text-input">
					</div>
					<?php $nm_f="invoice_date";?>
					<!--label for="<?php echo $nm_f?>">ETD</label-->
					<div class="col-sm-2">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control date-picker' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					<!--//Bagian Kanan-->
					
					
				</div><div class="form-group">
					
					<?php $nm_f="etd";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">ETD</label>
						</div><div class="col-sm-3">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control date-picker' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					<!--Bagian Kanan-->
					<?php $nm_f="mawb";?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">MAWB #</label>
						</div><div class="col-sm-2">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 text-input">
					</div>
					<?php $nm_f="mawb_date";?>
					<!--label for="<?php echo $nm_f?>">ETD</label-->
					<div class="col-sm-2">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control date-picker' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					<!--//Bagian Kanan-->
					
					
				</div><div class="form-group">
					
					<?php $nm_f="transhipment";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_port,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--Bagian Kanan-->
					<?php $nm_f="hawb";?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">HAWB#</label>
						</div><div class="col-sm-2">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 text-input">
					</div>
					<?php $nm_f="hawb_date";?>
					<!--label for="<?php echo $nm_f?>">ETD</label-->
					<div class="col-sm-2">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control date-picker' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					<!--//Bagian Kanan-->
					
					
				</div><div class="form-group">
					
					<?php $nm_f="eta_transhipment";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">ETA</label>
						</div><div class="col-sm-3">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control date-picker' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					<!--Bagian Kanan-->
					<?php $nm_f="lc";?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">L/C #</label>
						</div><div class="col-sm-2">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 text-input">
					</div>
					<?php $nm_f="lc_date";?>
					<!--label for="<?php echo $nm_f?>">ETD</label-->
					<div class="col-sm-2">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control date-picker' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					<!--//Bagian Kanan-->
					
					
				</div><div class="form-group">
					
					<?php $nm_f="airport_dest";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Airport Dest</label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_port,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					<!--Bagian Kanan-->
					
					<?php $nm_f="stf_date";?>
					<div class="col-sm-2">
					<label for="<?php echo $nm_f?>">Stf Date</label>
					</div>
					<div class="col-sm-2">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control date-picker' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					<!--//Bagian Kanan-->
					
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="eta_dest";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">ETA</label>
						</div><div class="col-sm-3">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control date-picker' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					<!--Bagian Kanan-->
					<?php $nm_f="gross_weight";?>
					<div class="col-sm-2" style="<?php echo $lcl?>">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-4" style="<?php echo $lcl?>">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 text-input">
						<?php $nm_f="gross_metric";?>
						<?php echo form_dropdown($nm_f,$opt_metric,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select col-sm-3" id="'.$nm_f.'" ')?>
					</div>
					
					<!--//Bagian Kanan-->
					
					
				</div>
				
				<div class="form-group">
					<?php $nm_f="airline";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">First Airline</label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_airline,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					
					<!--Bagian Kanan-->
					<?php $nm_f="net_weight";?>
					<div class="col-sm-2" style="<?php echo $lcl?>">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-4" style="<?php echo $lcl?>">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 text-input">
						<?php $nm_f="net_metric";?>
						<?php echo form_dropdown($nm_f,$opt_metric,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select col-sm-3" id="'.$nm_f.'" ')?>
					</div>
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					<?php $nm_f="flight";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Flight</label>
						</div><div class="col-sm-3">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 text-input">
					</div>
					
					<!--Bagian Kanan-->
					<?php $nm_f="volume_weight";?>
					<div class="col-sm-2" style="<?php echo $lcl?>">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-4" style="<?php echo $lcl?>">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-8 text-input">
						<?php $nm_f="volume_metric";?>
						<?php echo form_dropdown($nm_f,$opt_metric,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select col-sm-3" id="'.$nm_f.'" ')?>
					</div>
					<!--//Bagian Kanan-->
					
					
				</div>
				<div class="form-group">
					<?php $nm_f="airline_2";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">2nd Airline</label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_airline,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
					</div>
					
					<!--Bagian Kanan-->
					<div class="col-sm-2"  style="<?php echo $fcl?>">
						<label for="<?php echo $nm_f?>">No. of Container</label>
						</div><div class="col-sm-1"  style="<?php echo $fcl?>">
						<?php $nm_f="cont_20";
						?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-10 text-input">20'
						</div><div class="col-sm-1"  style="<?php echo $fcl?>">
						<?php $nm_f="cont_40";
						?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-10 text-input">40'
						</div><div class="col-sm-1"  style="<?php echo $fcl?>">
						<?php $nm_f="cont_45";
						?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-10 text-input">45'
					</div>
					<!--//Bagian Kanan-->
					
				</div>
				<div class="form-group">
					<?php $nm_f="flight_2";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Flight</label>
						</div><div class="col-sm-3">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 text-input">
					</div>
					
					<!--Bagian Kanan-->
					<?php $nm_f="desc_goods";?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Desc</label>
						</div><div class="col-sm-3">
						<?php echo form_textarea($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control '");?>
						
					</div>
					<!--//Bagian Kanan-->
					
					
				</div>
				
				<div class="form-group">
					
					<?php $nm_f="packages";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control '");?>
						<?php $nm_f="packages_metric";?>
						<?php echo form_dropdown($nm_f,$opt_metric,$sel,'class="col-sm-3" id="'.$nm_f.'" ')?>
						
					</div>
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="PIB_PEB_BC23";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">PIB/PEB/BC23</label>
						</div><div class="col-sm-3">
						<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control '");?>
						
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