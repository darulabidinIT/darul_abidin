<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>

    
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
			<form id="form" method="post" action="<?php echo base_url($this->utama)?>/submit" class="form-horizontal formular" >
				<?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
		   
			
		   
		   <div class="form-group">
			   
			   <?php $nm_f="name";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]" required>
			   </div>
		   </div>
				<!--div class="form-group">
					<?php $nm_f="service";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
					
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-3">
						<?php echo form_dropdown($nm_f,$opt_service,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..."	')?>
					</div>
				</div-->
				<div class="form-group">
					<?php $nm_f="udm";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
				
				<div class="col-sm-3">
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div><div class="col-sm-3">
					<?php echo form_dropdown($nm_f,$opt_metric,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
				</div>
				</div>
				<div class="form-group">
					<?php $nm_f="currency";
						$sel=(isset($val[$nm_f]) ? $val[$nm_f] : '');
						if($this->session->flashdata('clientbaru')){ $sel=$this->session->flashdata('clientbaru');}
					?>
				
				<div class="col-sm-3">
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div><div class="col-sm-3">
					<?php echo form_dropdown($nm_f,$opt_metric,$sel,'class="chosen-select form-control" id="'.$nm_f.'" data-placeholder="Choose a State..." ')?>
				</div>
				</div><div class="form-group">
			   
			   <?php $nm_f="acno";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Sales Account No.</label>
				   </div><div class="col-sm-4">
				   <?php echo form_dropdown($nm_f,$opt_coa, (isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='chosen-select form-control'")?>
			   </div>
			   <?php $nm_f="tax";?>
			   <div class="col-sm-1">
				   <label for="<?php echo $nm_f?>">Tax</label>
				   </div><div class="col-sm-3">
				   <?php echo form_dropdown($nm_f,$opt_tax, (isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='chosen-select form-control'")?>
			   </div>
		   </div>
		   <div class="form-group">
			   <?php $nm_f="acno2";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Cost Account No.</label>
				   </div><div class="col-sm-4">
				   <?php echo form_dropdown($nm_f,$opt_coa, (isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='chosen-select form-control'")?>
			   </div>
			   <?php $nm_f="tax2";?>
			   <div class="col-sm-1">
				   <label for="<?php echo $nm_f?>">Tax</label>
				   </div><div class="col-sm-3">
				   <?php echo form_dropdown($nm_f,$opt_tax, (isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='chosen-select form-control'")?>
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