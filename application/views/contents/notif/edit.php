<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>
<script>
	function generatequotation(val){
		$('#area_quotation').empty();
		val = val || $( "input[name='id']" ).val();
		var client = $('#client').val();
		var service = $('#service').val();
		var type = $('#type').val();
		var ids=val;
		//var from = $('#from').val();
		//var to = $('#to').val();
		//alert(service);
		//alert(from+' '+to);
		if(service){
			if(type && service!=3){
			if(type==4 || type==5){
				 
				var from = $('#from_sea').val();
				var to = $('#to_sea').val();
			}
			else if(type==6){
				
				var from = $('#from_air').val();
				var to = $('#from_air').val();
			}
		}
		else{
				if(service==3){
					
					var from = $('#from_trucking').val();
					var to = $('#to_trucking').val();
				}
		}
		}
	
		
		/* 
		alert('s:'+service);
		alert('t:'+type);
		alert('f:'+from);
		alert('to:'+to); */
		if(service=='1' || service=='2' ){
			if(client && service && type && from && to ){
				//alert('yes');
				
				$('#area_quotation').load("<?php echo base_url('load')?>/generatequotation/",{c:client,s:service,t:type,f:from,to:to,v:ids},function(){
					
					$('#area_quotation').show();
				});
			$('#area_quotation').show();
		}}
		else{
			if(client && service && from && to ){
				//alert('yes');
				$('#area_quotation').load("<?php echo base_url('load')?>/generatequotation/",{c:client,s:service,f:from,to:to,v:ids},function(){
					
					$('#area_quotation').show();
				});
			}
		}
	}
		$(document).ready(function(e){
				<?php if(!isset($val['id'])){?>
			$('.divexim').hide();
			$('.diveximsea').hide();
			$('.diveximair').hide();
			$('.divtrucking').hide();
				<?php }else{?>
					var service=$('#service').val();
					var tipe=$('#type').val();
				pilihservice(service);
				pilihtype(tipe);
				generatequotation(<?php echo $val['id']?>);
				<?php }?>
		});
		function pilihservice(val){
			if(val==1 || val==2){
				//export import
				$('.typeaheadtruck').prop('disabled',true);
				$('.divtrucking').hide();
				$('.divexim').show();
			}
			if(val==3){
					//trucking
				$('.divexim').hide();
				$('.diveximsea').hide();
				$('.diveximair').hide();
				$('.divtrucking').show();
				$('.typeaheadtruck').prop('disabled',false);
				$('.typeaheadair').prop('disabled',true);
				$('.typeaheadsea').prop('disabled',true);
			}
			setTimeout(function(){
			generatequotation();},1000);
		}function pilihtype(val){
			if(val==4 || val==5){
					//exim sea
				$('.diveximair').hide();
				$('.divtrucking').hide();
				$('.diveximsea').show();
				$('.typeaheadtruck').prop('disabled',true);
				$('.typeaheadair').prop('disabled',true);
				$('.typeaheadsea').prop('disabled',false);
			}
			if(val==6){
					//exim air
				$('.diveximsea').hide();
				$('.divtrucking').hide();
				$('.diveximair').show();
				$('.typeaheadtruck').prop('disabled',true);
				$('.typeaheadair').prop('disabled',false);
				$('.typeaheadsea').prop('disabled',true);
			}
			setTimeout(function(){
			generatequotation();},1000);
		}
	$('#from_trucking').change(function(e){
			generatequotation();	
	});
	$('#to_trucking').change(function(e){
			generatequotation();	
	});
	$('#from_sea').change(function(e){
			generatequotation();	
	});
	$('#to_sea').change(function(e){
		generatequotation();	
	});
	$('#from_air').change(function(e){
			generatequotation();	
	});
	$('#to_air').change(function(e){
		generatequotation();	
	});
	$('#status').change(function(e){
		generatequotation();	
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
				<?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '','class="id"')?>
		   <div class="form-group" id="area_quotation" style="display:none;">
			   AREA QUOTATION DISINI
		   </div>
				<div class="form-group">
					
					<?php $nm_f="client";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_client,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..."  onChange="generatequotation()" ')?>
						</div><div class="col-sm-3">
						<a href="<?php echo base_url('master_client')?>/form/?redirect=marketing&formid=<?php echo isset($val['id']) ? $val['id'] : '';?>">+ Add Client</a>
					</div>
					
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="service";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_service,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." onChange="pilihservice(this.value)" required')?>
					</div>
					
					
				</div>
				<div class="form-group divexim">
					
					<?php $nm_f="type";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_exim_service,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." onChange="pilihtype(this.value)" id="'.$nm_f.'" ')?>
					</div>
					
					
				</div>
				<div class="form-group diveximair">
					
					<?php $nm_f="from";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>_air" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 typeaheadair " onChange="generatequotation()">
					</div>
					
					<?php $nm_f="to";?>
					<div class="col-sm-1">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>_air" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 typeaheadair " onChange="generatequotation()">
					</div>
				</div>
					<div class="form-group diveximsea">
						
						<?php $nm_f="from";?>
						<div class="col-sm-3">
							<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
							</div><div class="col-sm-3">
							<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>_sea" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 typeaheadsea " onChange="generatequotation()">
						</div>
						
						<?php $nm_f="to";?>
						<div class="col-sm-1">
							<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
							</div><div class="col-sm-3">
							<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>_sea" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 typeaheadsea " onChange="generatequotation()">
						</div>
					</div>
				
				
			<div class="form-group divtrucking">
					
					<?php $nm_f="from";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>_trucking" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 typeaheadtruck " onChange="generatequotation()">
					</div>
					
				<?php $nm_f="to";?>
				<div class="col-sm-1">
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div><div class="col-sm-3">
					<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>_trucking" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 typeaheadtruck " onChange="generatequotation()">
				</div>
					
				</div>
				
				<div class="form-group">
					
					<?php $nm_f="status";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Status</label>
						</div><div class="col-sm-9">
						<div class="radio">
							<label>
								<input name="<?php echo $nm_f?>" type="radio" class="ace" value="ONGOING" <?php echo $bs=(isset($val['id']) && $val['status'] == 'ONGOING' ? 'checked' : 'checked')?> />
								<span class="lbl">
								<i class="ace-icon fa fa-bell-o bigger-110 purple"></i> On Progress</span>
							</label>
						</div>
						
						<div class="radio">
							<label>
								<input name="<?php echo $nm_f?>" type="radio" class="ace" value="LOOSE" <?php echo $bs=(isset($val['id']) && $val['status'] == 'LOOSE' ? 'checked' : '')?>/>
								<span class="lbl"><i class="ace-icon fa fa-times bigger-110 red"></i> Loose</span>
							</label>
						</div>
						
						<div class="radio">
							<label>
								<input name="<?php echo $nm_f?>" type="radio" class="ace" value="WIN" <?php echo $bs=(isset($val['id']) && $val['status'] == 'WIN' ? 'checked' : '')?> />
								<span class="lbl"><i class="ace-icon fa fa-check bigger-110 green"></i> Win</span>
							</label>
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
		
<script>
	
	ace.vars['TRUCK'] = [
	<?php
//print_mz($loc);
	foreach($loc as $loka){?>
		"<?php echo $loka?>",
	<?php }?>]
	 ace.vars['SEA'] = [
	<?php foreach($seaport as $pelabuhan){?>
	"<?php echo $pelabuhan->name?>",
	<?php }?>
	] 
	ace.vars['AIR'] = [
	<?php foreach($airport as $pelabuhan){?>
		"<?php echo $pelabuhan->name?>",
	<?php }?>
	] 
</script>