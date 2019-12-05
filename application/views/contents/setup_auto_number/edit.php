<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>
<script>
		var tahun='<?php echo substr(date("Y"),-2);?>';
		var month='<?php echo substr(date("m"),-2);?>';
		function rendersample(){
			
			
				fulldigit=$('#prefix1').val();
			digit1=fulldigit.substr(1);
			digit2=$('#prefix_separator1').val();
			digit3=$('#prefix2').val();
			digit4=$('#prefix_separator2').val();
			digit5=$('#prefix3').val();
			digit6=$('#prefix_separator3').val();
			
			digit7='';
			width=$('#width').val();
			digit=$('#digit').val();
			for(a=1;a<=digit;a++){
			digit7+=width;
			}
			digit8=$('#prefix_suffix_separator').val();
			digit9=$('#suffix1').val();
			digit10=$('#suffix_separator1').val();
			digit11=$('#suffix2').val();
			digit12=$('#suffix_separator2').val();
			digit13=$('#suffix3').val();
			digit12=$('#suffix_separator3').val();
			
			result=digit1+digit2+digit3+digit4+digit5+digit6+digit7+digit8+digit9+digit10+digit11+digit12;
			
			result=result.replace('YEAR',tahun);
			result=result.replace('MONTH',month);
			
			$('#sample').val(result);
				
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
			   
			   <?php $nm_f="code";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-2 text-input">
			   </div>
		   </div>
				<div class="form-group">
			   
			   <?php $nm_f="name";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4">
			   </div>
			</div>
			
				<div class="form-group">
					<div class="col-sm-3">
						<?php $nm_f="option";?>
						<label for="<?php echo $nm_f?>" class="">Option Type</label>
					</div>
					<div class="col-sm-9">
						<?php $a="switch";
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
						<label for="<?php echo $nm_f?>">Switch Enable</label>&nbsp;&nbsp;&nbsp;&nbsp;
						
						
						<?php $a="auto";
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
						<label for="<?php echo $nm_f?>">Auto Only</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<?php $a="manual";
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
						<label for="<?php echo $nm_f?>">Manual Only</label>&nbsp;&nbsp;&nbsp;&nbsp;
					</div>
				</div>
				<div class="form-group">
					
					<?php $nm_f="use_parent_number";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Use Parent Number</label>
					</div>
					<div class="col-sm-2">
								<input name="<?php echo $nm_f?>" class="" type="checkbox" <?php echo $b=($val[$nm_f]=='Y'? 'checked' : '' ); ?> />
					</div>
					<div class="col-sm-2">
						<?php $nm_f="parent_separator";?>
						
						<label for="<?php echo $nm_f?>">Parent Separator</label></div><div class="col-sm-1">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-6 ">
					</div>
					<div class="col-sm-1">
						<?php $nm_f="throw";?>
						<label for="<?php echo $nm_f?>">Throw</label>
						</div><div class="col-sm-1">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12">
					</div>
					</div>
					
				<div class="form-group">
					
					<?php $nm_f="use_last_number";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Use Last Number</label>
					</div>
					<div class="col-sm-2">
						<input name="<?php echo $nm_f?>" class="" type="checkbox" <?php echo $b=($val[$nm_f]=='Y'? 'checked' : '' ); ?> />
					</div>
					<div class="col-sm-2">
						<?php $nm_f="width";?>
						
						<label for="<?php echo $nm_f?>">Width</label>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-6">
					</div>
					<div class="col-sm-2">
						<?php $nm_f="digit";?>
						<label for="<?php echo $nm_f?>">Digit(s)</label>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-6">
					</div>
				</div>
				<div class="form-group">
					
					<?php $nm_f="prefix1";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Prefix</label>
					</div>
					<div class="col-sm-2">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12">
					</div>
					<div class="col-sm-1">
						<?php $nm_f="prefix_separator1";?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-6">
					</div>
					<div class="col-sm-2">
						<?php $nm_f="prefix2";?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : 'YEAR') ?>" class="col-sm-12">
					</div>
					<div class="col-sm-1">
						<?php $nm_f="prefix_separator2";?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-6 ">
					</div>
					<div class="col-sm-2">
						<?php $nm_f="prefix3";?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : 'MONTH') ?>" class="col-sm-12 ">
					</div>
					<div class="col-sm-1">
						<?php $nm_f="prefix_separator3";?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-6">
					</div>
				</div>
				<div class="form-group">
					
					<?php $nm_f="prefix_suffix_separator";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Prefix-Suffix Separator</label>
					</div>
					<div class="col-sm-1">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 ">
					</div>
					
				</div>
				<div class="form-group">
					
					<?php $nm_f="suffix1";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Suffix</label>
					</div>
					<div class="col-sm-2">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 ">
					</div>
					<div class="col-sm-1">
						<?php $nm_f="suffix_separator1";?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-6 ">
					</div>
					<div class="col-sm-2">
						<?php $nm_f="suffix2";?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 ">
					</div>
					<div class="col-sm-1">
						<?php $nm_f="suffix_separator2";?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-6 ">
					</div>
					<div class="col-sm-2">
						<?php $nm_f="suffix3";?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-12 ">
					</div>
					<div class="col-sm-1">
						<?php $nm_f="suffix_separator3";?>
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-6 ">
					</div>
				</div>
				
				<div class="form-group">
					
					<?php $nm_f="sample";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-9">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 " readonly onClick="rendersample()">
					</div>
				</div>
			</div>
		</div>
	</div>
			

			   
		   <div class="form-group">
			   <div class="col-sm-3">
				  
			   </div>
			   
    		<div class="form-group">
            <button type="submit" class="btn pull-right">Submit</button>
            
             </div>
			 </form>
    	</div>
    </div>
    </div>
</div>