<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>
<script>
	$(document).ready(function(e){
		$('.marketing_id').css('display','none');
	});
	function gantigrup(val){
		if(val!=3){
		$('.marketing_id').css('display','none');}
		else{
		$('.marketing_id').css('display','');
		}
	}
</script>
 <div>
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
</div>
<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="<?php echo GetValue('icon','sv_menu',array('filez'=>'where/'.$this->utama))?>"></i> <?php echo $this->title;?></h2>

        
    </div>
    	<div class="box-content">
       <form method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit">
    		<div class="form-group">
            
            <?php $nm_f="username";?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control">
				<?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
    		<div class="form-group">
            <?php $nm_f="password";?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                        <input type="password" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="" class="form-control">
			</div>
				<?php
					if($this->session->userdata('webmaster_id')!=$val['id']){?>
    		<div class="form-group">
            <?php $nm_f="name";?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                        <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control">
             </div>
    		<div class="form-group">
            			<?php $nm_f="id_admin_grup";?>
                        <label for="exampleInputEmail3">Grup Admin</label>
             			<?php echo form_dropdown($nm_f,$opt,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen' onChange='gantigrup(this.value)'")?>
                        
             </div>
    		<div class="form-group marketing_id">
            			<?php $nm_f="id_marketing";?>
                        <label for="exampleInputEmail3">Marketing ID</label>
             			<?php echo form_dropdown($nm_f,$opt_marketing,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen' class='chosen-select'")?>
                        
             </div>
    		<div class="form-group">
            <?php $nm_f="avatar";?>
                        <label for="<?php echo $nm_f?>">Avatar<?php if($type=="Edit"){echo " (Kosongkan Jika Foto tidak diganti)";}?></label>
                        <input type="file" name="<?php echo $nm_f?>" id="<?php echo $nm_f?>">
			</div>
    		<div class="form-group">
                        <label for="exampleInputEmail3">Is Active?</label> 
							<label>
							<input data-no-uniform="true" type="checkbox" <?php echo $a = ($val['is_active']=='Active' ? 'checked' : '');?> name="is_active" class="ace ace-switch ace-switch-6">
							<span class="lbl"></span>
							</label>
			</div>
			 <?php }?>
    		<div class="form-group">
            <button type="submit" class="btn pull-right">Submit</button>
            </form>
             </div>
    	</div>
    	
    </div>
    </div>
</div>