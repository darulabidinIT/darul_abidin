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
            <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
            
            <?php $nm_f="id_admin_grup";?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                        <?php echo form_dropdown($nm_f,$opt2,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen'")?>
             </div>
    		<div class="form-group">
            
            <?php $nm_f="id_menu_admin";?>
                        <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
                        <?php echo form_dropdown($nm_f,$opt,isset($val[$nm_f]) ? $val[$nm_f] : ''," data-rel='chosen'")?>
             </div>
    		<div class="form-group">
                        <label for="exampleInputEmail3">Is Active?</label> 
                        <input data-no-uniform="true" type="checkbox" <?php echo $a = ($val['is_active']=='Active' ? 'checked' : '');?> name="is_active" class="iphone-toggle">
             </div>
    		<div class="form-group">
            <button type="submit" class="btn pull-right">Submit</button>
            </form>
             </div>
    	</div>
    	
    </div>
    </div>
</div>