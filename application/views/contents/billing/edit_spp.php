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
       <form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/custom_submit" class="form-horizontal formular" role="form">
		   
		   <?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
				
				<?php echo form_hidden('redirect',isset($_GET['redirect']) ? $_GET['redirect'] : '')?>
				<?php echo form_hidden('formid',isset($_GET['formid']) ? $_GET['formid'] : '')?>
			
                    <div class="form-group">
			   
			   <?php $nm_f="type";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Type</label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f,array(''=>'-Type-','custom'=>'custom','pmb'=>'PMB'),(isset($val['type']) ? $val['type'] : ambilta()),"class='select2' id='$nm_f' required")?>
			   </div>
		   </div>
		    <div class="form-group">
			   
			   <?php $nm_f="ta";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tahun Ajaran</label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f,$opt_ta,(isset($val['ta']) ? $val['ta'] : ambilta()),"class='select2' id='$nm_f' required onchange='gantita()'")?>
			   </div>
		   </div>
		   
		  
                   <div class="form-group">
			   
			   <?php $nm_f="siswa_id";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Nama</label>
				   </div><div class="col-sm-4" id="pilihan_nama_siswa">
			   </div>
		   </div>
           
                   <div class="form-group">
			   
			   <?php $nm_f="title";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Nama Bill</label>
				   </div><div class="col-sm-4">
				   <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='' id=''")?>
			   </div>
		   </div>
           
                   <div class="form-group">
			   
			   <?php $nm_f="generate_date";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tanggal Pembuatan</label>
				   </div><div class="col-sm-4">
				   <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : date('Y-m-d')),"class='date-picker' id='$nm_f'")?>
			   </div>
		   </div>
           
                   <div class="form-group">
			   
			   <?php $nm_f="due_date";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Batas Akhir Pembayaran</label>
				   </div><div class="col-sm-4">
				   <?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='date-picker' id='$nm_f'")?>
			   </div>
		   </div>
               <div class="form-group">
                   <hr>
                   <h3>Item SPP</h3>
                   
                   
               </div>
           <div class="form-group col-md-12" id="area-item">
                   <?php
                   $itemspp=json_decode($val['item_spp']);
                   //print_r($itemspp);
                   ?>
               <?php if(isset($itemspp->item)){?>
                <?php
                $ct=1;
                foreach($itemspp->item as $it) {
                    $data['item_']=$it;
                    $data['id_data']=$val['id'];
                    $data['id']=$ct;
                    ?>
               <div class="area-item form-group" id="area-item-<?php echo $ct?>" style="border-bottom:1px #0044cc dashed;margin-bottom:20px;"><?php $this->load->view('contents/kelas_siswa/item_update',$data);?></div>
                    
                <?php $ct++; }?>
               <?php }?>
                   
                   
           </div>
           <div class="form-group col-md-12" id="area-item-custom">
               <?php if(isset($itemspp->custom)){?>
                <?php
                $ct=1;
                foreach($itemspp->custom as $it) {
                    //print_r($it);
                    $data['item_']=$it->item;
                    $data['item_price']=$it->price;
                    $data['id_data']=$val['id'];
                    $data['id']=$ct;
                    ?>
               <div class="area-item-custom form-group" id="area-item-custom-<?php echo $ct?>" style="border-bottom:1px #0044cc dashed;margin-bottom:20px;">
               <?php 
                    $this->load->view('contents/kelas_siswa/item_custom_update',$data);?>
               </div>
                    
                <?php $ct++; }?>
               <?php }?>
                   
                   
           </div>
           <div class="form-group">
                    <h5><a href="#area-produk" onclick="tambahitem()" id="tomboltambah">+ Tambah Item</a></h5> 
                    <h5><a href="#area-produk" onclick="tambahitemcustom()" id="tomboltambahcustom">+ Tambah Item Custom</a></h5>
           </div>
           
           <div class="form-group col-md-12">
               <h4>Total Price</h4>
               <?php echo form_input('totalprice','','class="" style="background:white!important;border:0px;" readonly id="total"')?>
               
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
       function tambahitem(){
        var itungproduk=$('.area-item').length;
        var ta=$('#ta').val();
        var siswa=$('#siswa_id').val();
        var idsekarang=itungproduk+1;
        if(itungproduk==0){ 
            var oi ='';
        }else{
            var oi='<a href="#" onClick="hapusitem(this)">(HAPUS)</a>';
        }
            $('#area-item').append('<div class="area-item form-group" id="area-item-'+idsekarang+'" style="border-bottom:1px #0044cc dashed;margin-bottom:20px;"><img src="<?php echo base_url().'assets/img/load.gif'?>" width="100px"></div>');
            $('#tomboltambah').hide();
            setTimeout(function(){ $('#area-item-'+idsekarang).load('<?php echo base_url()?>billing/item/'+idsekarang,{t:ta,s:siswa},function(e){
                    $('#tomboltambah').show();
            }); }, 200);        
        }
        
        function tambahitemcustom(){
        var itungcustom=$('.area-item-custom').length;
        
        var ta=$('#ta').val();
        var siswa=$('#siswa_id').val();
        var customsekarang=itungcustom+1;
        if(itungcustom==0){ 
            var oi ='';
        }else{
            var oi='<a href="#" onClick="hapuscustom(this)">(HAPUS)</a>';
        }
            $('#area-item-custom').append('<div class="area-item-custom form-group" id="area-item-custom-'+customsekarang+'" style="border-bottom:1px #0044cc dashed;margin-bottom:20px;"><img src="<?php echo base_url().'assets/img/load.gif'?>" width="100px"></div>');
            $('#tomboltambahcustom').hide();
            setTimeout(function(){ $('#area-item-custom-'+customsekarang).load('<?php echo base_url()?>billing/item_custom/'+customsekarang,{t:ta,s:siswa},function(e){
                    $('#tomboltambahcustom').show();
            }); }, 200);        
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
        }
        $(document).ready(function(e){
            $('.select3').css('width','400px').select2({});
            gantita();
        })
        function gantita(){
            var ta=$('#ta').val();
            $('#pilihan_nama_siswa').load('<?php echo base_url('billing')?>/load_siswa',{t:ta});
        }   
        
</script>