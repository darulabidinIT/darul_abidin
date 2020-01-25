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
			   
			   <?php $nm_f="ta";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tahun Ajaran</label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f,$opt_ta,(isset($val[$nm_f]) ? $val[$nm_f] : ambilta()),"class='select2'")?>
			   </div>
		   </div>
		   
		   <div class="form-group">
			   
			   <?php $nm_f="jenjang";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Jenjang</label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f,$opt_jenjang,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' onchange='changejenjang(this.value)'")?>
			   </div>
		   </div>
                   <div class="form-group">
			   
			   <?php $nm_f="tingkat";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tingkat</label>
				   </div><div class="col-sm-9" id="tingkatdiv">
				   <?php echo form_dropdown($nm_f,$opt_tingkat,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' onchange='changetingkat(this.value)'")?>
			   </div>
		   </div>
                    <div class="form-group">
			   
			   <?php $nm_f="type";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tipe Item</label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f,GetOptAll('sv_ref_item_custom','-Tipe Tagihan-'),(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2'")?>
			   </div>
		   </div>
                   <div class="form-group">
			   
			   <?php $nm_f="title";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Nama Item</label>
				   </div><div class="col-sm-9">
				   <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='' ")?>
			   </div>
		   </div>
                   <div class="form-group">
			   
			   <?php $nm_f="price";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Nominal</label>
				   </div><div class="col-sm-9" id="">
				   <?php echo form_input($nm_f,(isset($val[$nm_f]) ? uang(str_replace('.',',',$val[$nm_f])) : ''),"class='currency' pattern='^\Rp \d{1,3}(.\d{3})*(\,\d+)?$' ")?>
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
	$('#target').mask('9.99');
	$('#comission').mask('9.99');
                    function changetingkat(val){
                     $('#kelasdiv').load('<?php echo base_url()?>setup_itempay/loadkelas/'+val,{},function(e){
                         
                        });
                    }
                    function changejenjang(val){
                     $('#tingkatdiv').load('<?php echo base_url()?>setup_itempay/loadtingkat/'+val,{},function(e){
                         
                        });
                    }
</script>