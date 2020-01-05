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
       <form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/generate_billing" class="form-horizontal formular" role="form">
		   
		   <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
				
				<?php echo form_hidden('redirect',isset($_GET['redirect']) ? $_GET['redirect'] : '')?>
				<?php echo form_hidden('formid',isset($_GET['formid']) ? $_GET['formid'] : '')?>
			
		    <div class="form-group">
			   
			   <?php $nm_f="ta";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tahun Ajaran</label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f,$opt_ta,(isset($val['ta']) ? $val['ta'] : ambilta()),"class='select2' id='$nm_f' required")?>
			   </div>
		   </div>
		   
		  
                   <div class="form-group">
			   
			   <?php $nm_f="siswa_id";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Nama</label>
				   </div><div class="col-sm-4">
				   <?php echo form_dropdown($nm_f,$opt_siswa,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select3' id='siswa_id' required")?>
			   </div>
		   </div>
                    <div class="form-group">
			   
			   <?php $nm_f="periode[]";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Periode</label>
				   </div><div class="col-sm-4">
				   <?php echo form_dropdown($nm_f,$opt_periode,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select3' id='periode' multiple required")?>
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
        hitungtotal();
    });
	$('#target').mask('9.99');
	$('#comission').mask('9.99');
        function deletebaru(id){
                    $('#area-item-'+id).remove();
                    hitungtotal();
        }
                 function deletebaru_custom(id){
                    $('#area-item-custom-'+id).remove();
                    hitungtotal();
                }
                    function changetingkat(val){
                     $('#kelasdiv').load('<?php echo base_url()?>setup_itempay/loadkelas/'+val,{},function(e){
                         
                        });
                    }
                    function changejenjang(val){
                     $('#tingkatdiv').load('<?php echo base_url()?>setup_itempay/loadtingkat/'+val,{},function(e){
                         
                        });
                    }
       
        
        function hitungtotal(){
          var sum = 0;
        $('.hargasatuan').each(function()
        {
            
            satuan = $(this).val()
            sum += parseFloat(satuan.replace(/\./g,''));
            
        });
           
        sum=formatter.format(sum); 
            semua(sum);
            
            
        }
        function semua(sum){
            $('#total').val(sum);
        }$(document).ready(function(e){
            $('.select3').css('width','400px').select2({});
        })
        
</script>