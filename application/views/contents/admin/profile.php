<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>

 <div>
    <ul class="breadcrumb">
        <li>
            <a href="#">Home</a>
        </li>
        <li>
            <a href="<?php echo base_url($this->utama)?>">Profile</a>
        </li>
        <li>
            <a href="#"><?php echo $type?></a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="glyphicon glyphicon-user"></i> Profile</h2>

        
    </div>
    	<div class="box-content">
       <form method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit_profile" class="form-horizontal formular">
				<?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
			<div class="col-md-6">
				<div class="form-group">
					<?php $nm_f="nip";?>
					<div class="col-md-3">
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-md-7">
						<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''), "id='$nm_f' class='form-control'");  ?>
					</div>
				</div>
			<div class="form-group">
				<?php $nm_f="name";?>
				<div class="col-md-3">
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div><div class="col-md-7">
					<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''), "id='$nm_f' class='form-control'");  ?>
				</div>
             </div>
    		<div class="form-group">
				<?php $nm_f="sex";?>
				<div class="col-md-3">
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div><div class="col-md-7">
					<?php echo form_dropdown($nm_f,array('L'=>'Laki-Laki','P'=>'Perempuan'),$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''), "id='$nm_f' class='form-control'");  ?>
				</div>
             </div>
    		<div class="form-group">
				<?php $nm_f="birthday";?>
				<div class="col-sm-3">
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				</div>
				<div class="col-sm-9">
					<div class="input-group">
						<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control date-picker' data-date-format='yyyy-mm-dd'");?>
						<span class="input-group-addon">
							<i class="fa fa-calendar bigger-110"></i>
						</span>
					</div>
				</div>
             </div>
    		<div class="form-group">
				<?php $nm_f="address";?>
				<div class="col-md-3">
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div><div class="col-md-7">
					<?php echo form_textarea($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''), "id='$nm_f' class='form-control'");  ?>
				</div>
             </div>
    		<div class="form-group">
				<?php $nm_f="phone";?>
				<div class="col-md-3">
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div><div class="col-md-7">
					<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''), "id='$nm_f' class='form-control'");  ?>
				</div>
             </div>
    		<div class="form-group">
				<?php $nm_f="email";?>
				<div class="col-md-3">
					<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div><div class="col-md-7">
					<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''), "id='$nm_f' class='form-control'");  ?>
				</div>
             </div>
			 </div>
			 <div class="col-md-6">
				<fieldset class="col-md-12">
				<legend>Avatar</legend>
				<img src="<?php echo base_url('assets')?>/ace/avatars/<?php echo GetValue('avatar','admin_profile',array('id'=>'where/'.$this->session->userdata('webmaster_id')))?>" style="max-width:80%" />
					<br/>
					<br/>
					<br/>
					<div class="form-group">
						<?php $nm_f="avatar";?>
                        <label for="<?php echo $nm_f?>">Avatar<?php if($type=="Edit"){echo " (Kosongkan Jika Foto tidak diganti)";}?></label>
                        <input type="file" name="<?php echo $nm_f?>" id="<?php echo $nm_f?>">
					</div>
				</fieldset>
				
			 </div>
			 <div class="col-md-12">
    		<div class="form-group">
            <button type="submit" class="btn ">Submit</button>
            </div>
             </div>
			 </form>
    	</div>
    	
    </div>
    </div>
</div>