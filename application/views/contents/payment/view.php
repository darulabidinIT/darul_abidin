<div class="col-md-12" style="margin-bottom:2%;">
    
<span style="font-size:24px; margin-bottom:20%; margin-top:5%;"><?php echo $this->title;?></span>
</div>
 <br/>
 <br/>
 <?php if($this->session->flashdata('message')){?>
<div class="alert alert-success" role="alert">
                        <?php echo $this->session->flashdata('message') ?>
                        </div>
 <?php }?>
 
     <form method="post" action="<?php echo base_url()?>payment/submit_pay">
 <div class="col-md-5">
     <div class="col-md-12">
                    <div class="form-group">
			   
			   <?php $nm_f="ta";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tahun Ajaran</label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f,$opt_ta,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' id='tahun_ajaran'")?>
			   </div>
		   </div>
                    <div class="form-group" style="margin-bottom:20px!important;">
			   
			   <?php $nm_f="jenjang";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Jenjang</label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f,$opt_jenjang,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' onchange='changejenjang(this.value)' id='$nm_f'")?>
			   </div>
		   </div>
                   <div class="form-group" style="margin-bottom:20px!important;">
			   
			   <?php $nm_f="tingkat";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tingkat</label>
				   </div><div class="col-sm-9" id="tingkatdiv">
				   <?php echo form_dropdown($nm_f,$opt_tingkat,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' onchange='changetingkat(this.value)'")?>
			   </div>
		   </div>
                   <div class="form-group" style="margin-bottom:20px!important;">
			   
			   <?php $nm_f="title";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Kelas</label>
				   </div><div class="col-sm-9" id="kelasdiv">
				   <?php echo form_dropdown($nm_f,$opt_kelas,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' onchange='changetingkat(this.value)'")?>
			   </div>
		   </div>
     
                   <div class="form-group" style="margin-bottom:20px!important;">
			   
			   <?php $nm_f="title";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Siswa</label>
				   </div><div class="col-sm-9" id="siswadiv">
				   <?php echo form_dropdown($nm_f,$opt_kelas,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' onchange='changetingkat(this.value)'")?>
			   </div>
		   </div>
     </div>
     <div clas="col-md-12">
        
         <h5><b>Unpaid Bill</b></h5>
             <div clas="col-md-12" id="billdiv">
                 
             </div>
     </div>
 </div>
 <div class="col-md-7">
     <div class="col-md-8 invoice" ><h5>Item</h5></div>
     <div class="col-md-4 invoice" ><h5>Price</h5></div>
     
     <div class="inv_item" style="width:100%"></div>
     
     <div class="col-md-8 invoice" ><h3>Total Price</h3></div>
     <div class="col-md-4 invoice" ><h3><input value="0" name="total" id="total" style="background:white!important;border:0px; max-width: 90%;" class="" readonly=""></h3></div>
     
     
     <div class="col-md-12">
         <div class="col-md-3">Bayar</div> <div class="col-md-6"><input required="" type="number" name="bayar" class="form-control" onkeyup="liatkembalian(this.value)"></div>
     </div>
     <div class="col-md-12">
         <div class="col-md-3">Kembali</div> <div class="col-md-6"><input type="number" id="kembalian" name="kembali" class="form-control"></div>
     </div>
     <div class="col-md-12">
         <div class="col-md-3">Metode</div><div class="col-md-6"> <?php echo form_dropdown('metode',array('cash'=>'Tunai','transfer'=>'Transfer'),'',"onchange='gantimetode(this.value)'")?></div>
     </div>
     <div class="col-md-12" id="divbank" style="display:none">
         <div class="col-md-3">Bank</div><div class="col-md-6"> <?php echo form_dropdown('bank',GetOptAll('master_bank','-Bank-',array()),''," id='bankmode'")?></div>
     </div>
     <div class="col-md-12">
 <button class="btn btn-info" type="submit" onclick="">Pay</button>
     </div>
 </form>
     <style>
        .invoice {  
            border: 1px solid #ddd;
            text-align: left;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 15px;
        }
     </style>
 </div>
<div class="col-sm-12 col-md-12" id="loadview" style="margin-top:2%;">
 
    
</div>


<?php
error_reporting(0);
 echo $js_grid; ?>
<!--input type="button" value="Tambah" onclick="window.location = '<?//= base_url() ?>index.php/ms_con/add'"/-->
<script type="text/javascript">
var _base_url = '<?php echo  base_url() ?>';
var controller = '<?php echo $this->utama?>/';
function del(id) { 
  i = confirm('Hapus : ' + id + ' ?');
  if (i) {
    window.location = _base_url + controller + 'delete/' + id;
  }
}

                   
                    function changejenjang(val){
                     $('#tingkatdiv').load('<?php echo base_url()?>load/loadtingkat/'+val,{},function(e){
                         
                        });
                    }
                    
                    function carikelas(){
                        $('#loadview').empty();
                        $('#loadview').append("<img src='<?php echo base_url()?>assets/img/load.gif'></img>");
                        var ta=$('#tahun_ajaran').val();
                        var jenjang=$('#jenjang').val();
                        var tingkat=$('#tingkat').val();
                        var kelas=$('#kelas').val();
                        $('#loadview').load("<?php echo base_url()?>kelas_siswa/load_view",{ta:ta,j:jenjang,t:tingkat,k:kelas});
                    }
                    
                    function hitungtotal(){
          var sum = 0;
        $('.hargasatuan').each(function()
        {
            sum += parseFloat($(this).val());
            
        });
            //alert(sum);
            semua(sum);
            
            
        }
        function semua(sum){
            $('#total').val(sum);
        }
        function gantimetode(v){
            //alert(v);
            if(v=='transfer'){
                $('#divbank').show();
            }else{
                $('#divbank').hide();
                $('#bankmode').val("");
            }
        }
        function liatkembalian(v){
            var tot=$('#total').val();
            var kembali=v-tot;
            $('#kembalian').val(kembali);
        }
</script>
<!--div class="col-md-12"
<div class="layout-grid">
	<table id="flex1" style="display:none; "></table>
</div>
</div-->