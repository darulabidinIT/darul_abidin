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
			   
			   <?php $nm_f="code";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-2 validate[required] text-input">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="name";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
			   </div>
			   </div><div class="form-group">
			   
			   <?php $nm_f="file_name";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
			   </div>
		   </div>
		   <div class="form-group">
			   <?php $nm_f="group";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="class";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="before_print";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="syntax";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="total_parameter";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="syntax";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">&nbsp;</label>
				   </div><div class="col-sm-3">
				  <div class="checkbox ">
				   <label>
					   <?php $nm_f="global";?>
					   <input name="<?php echo $nm_f?>" class="ace ace-checkbox-2" type="checkbox" <?php echo $b=($val[$nm_f]=='Y'? 'checked' : '' ); ?> />
					   <span class="lbl"> Global</span>
				   </label>
			   </div>
			   </div>
			   <div class="form-group">
				   <div class="col-sm-1">
					   <?php $nm_f="status";?>
					   <label for="<?php echo $nm_f?>" class="pull-right">Status</label>
				   </div>
				   <div class="col-sm-3">
					   <?php $a="Active";
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
					   
					   
					   <?php $a="Suspend";
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