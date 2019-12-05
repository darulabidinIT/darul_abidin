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
       <form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit" class="form-horizontal formular" role="form">
		   
		   
		   <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
		   
		   <div class="form-group">
			   
			   <?php $nm_f="currency";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-3">
				   <?php echo form_dropdown($nm_f,$opt_curr,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="chosen-select"')?>
				  </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="kurs";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?> Rupiah</label>
				   </div><div class="col-sm-3">
				   <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control validate[required,custom[number]] currency" ')?>
				  </div>
		   </div>
			<div class="form-group">
					
					<?php $nm_f="effective";?>
					<div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Effective Date</label>
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
            <button type="submit" class="btn pull-right">Submit</button>
            
             </div>
			 </form>
    	</div>
    </div>
    </div>
</div>