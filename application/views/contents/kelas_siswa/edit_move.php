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
       <form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/move_submit" class="form-horizontal formular" role="form">
		   
		   <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
				
				<?php echo form_hidden('redirect',isset($_GET['redirect']) ? $_GET['redirect'] : '')?>
				<?php echo form_hidden('formid',isset($_GET['formid']) ? $_GET['formid'] : '')?>
			
		    <div class="form-group col-md-12 col-sm-12" style="margin-bottom:20px;">
			   
			   <?php $nm_f="ta_";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tahun Ajaran</label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f,$opt_ta,(isset($val['ta']) ? $val['ta'] : ''),"class='select2' disabled")?>
			   </div>
		   </div>
		   
                   <div class="form-group col-md-12" style="margin-bottom:5px;">
			   
			   <?php $nm_f="nama_";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Nama</label>
				   </div><div class="col-sm-4">
				   <?php echo form_input($nm_f,(isset($val['id']) ? GetValue('nama_siswa','master_siswa',array('id'=>'where/'.$val['siswa_id'])) : ''),"class='form-control' readonly")?>
			   </div>
		   </div>
          
		  
                   <div class="form-group col-md-12">
			   
			   <?php $nm_f="kelas";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Kelas</label>
				   </div><div class="col-sm-9">
				  <?php echo form_dropdown($nm_f,$opt_kelas,(isset($val['kelas']) ? $val['kelas'] : ''),"class='select2' onchange='changetingkat(this.value)'")?>
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
    $(document).ready(function(e){
    });
	$('#target').mask('9.99');
	$('#comission').mask('9.99');
        
</script>