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
				
				<?php echo form_hidden('redirect',isset($_GET['redirect']) ? $_GET['redirect'] : '')?>
				<?php echo form_hidden('formid',isset($_GET['formid']) ? $_GET['formid'] : '')?>
			
		   
		   <div class="form-group">
			   
			   <?php $nm_f="code";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-2 text-input" readonly>
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
			   
			   <?php $nm_f="search_name";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4">
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="sales";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f,$opt_sales,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='chosen-select col-sm-3' ");?>
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="address";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-4">
				   Default :
				   <?php echo form_textarea($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control'");?>
				   </div><div class="col-sm-4">
				   <?php $nm_f="address_tax";?>
				   Tax :
				   <?php echo form_textarea($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control'");?>
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <div class="col-sm-3">
				   <?php $nm_f="npwp";?>
				   <label for="<?php echo $nm_f?>">NPWP</label>
			   </div>
			   <div class="col-sm-4">
				   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control'");?>
			   </div>
			   
			   <div class="col-sm-1">
				   <?php $nm_f="due_date";?>
				   
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
			   </div>
			   <div class="col-sm-3">
				   
					   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' col-sm-8' ");?>Day(s)
					   
			   </div>
			   
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="cp1";?>
			   <div class="col-sm-2">
				   <label for="<?php echo $nm_f?>">Contact Person</label>
			   </div>
			   <div class="col-sm-1"><label class="pull-right"> #1</label>
			   </div>
			   <div class="col-sm-4">
				   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control'");?>
			   </div>
			   <div class="col-sm-1">
				   
				   <?php $nm_f="cp2";?>
				   <label for="<?php echo $nm_f?>" class="pull-right"	>#2</label>
				   </div><div class="col-sm-3">
				   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control'");?>
			   </div>
			   
		   </div>
		   
		   <div class="form-group">
			   
			   <?php $nm_f="phone1";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Phone</label>
				   
			   </div>
			   <div class="col-sm-4">
				   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control'");?>
			   </div>
			   <?php $nm_f="phone2";?>
			   <div class="col-sm-1">
				   <label for="<?php echo $nm_f?>">/</label>
				   </div><div class="col-sm-3">
				   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control'");?>
			   </div>
			   
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="fax1";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Facsimile</label>
				   </div><div class="col-sm-4">
				   
				   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control'");?>
			   </div>
			   <?php $nm_f="fax2";?>
			   <div class="col-sm-1">
				   <label for="<?php echo $nm_f?>">/</label>
				   
				   </div><div class="col-sm-3">
				   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' form-control'");?>
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="email";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   
				   </div><div class="col-sm-9">
				   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' col-sm-3'");?>
			   </div>
			   
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="website";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   
				   </div><div class="col-sm-9">
				   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' col-sm-3'");?>
			   </div>
			   
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="bank_acc";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   
				   </div><div class="col-sm-9">
				   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' col-sm-3'");?>
				   <div class="checkbox ">
					   <label>
						   <?php $nm_f="bank_acc_grp";?>
						   <input name="<?php echo $nm_f?>" class="ace ace-checkbox-2" type="checkbox" <?php echo $b=($val[$nm_f]=='Y'? 'checked' : '' ); ?> />
						   <span class="lbl"> Group</span>
					   </label>
				   </div>
			   </div>
			  
			   
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="others";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   
				   </div><div class="col-sm-9">
				   <?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class=' col-sm-3'");?>
			   </div>
			   
		   </div>
		   <div class="form-group">
			   
			   <div class="col-sm-3">
				   <?php $nm_f="status";?>
				   <label for="<?php echo $nm_f?>">Status</label>
			   </div>
			   <div class="col-sm-9">
				   <?php $a="1";
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
				   <label for="<?php echo $nm_f?>"><?php echo 'Active'?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				   
				   
				   <?php $a="0";
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
				   <label for="<?php echo $nm_f?>"><?php echo 'Suspend'?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				   
				  
				   
				   
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