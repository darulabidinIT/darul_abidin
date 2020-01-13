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
 <form method="post" action="<?php echo base_url()?>pembagian_kelas/submit">
 <div class="col-md-12">
                    <div class="form-group col-md-12" style="margin-bottom:20px!important;">
			   
			   <?php $nm_f="ta";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tahun Ajaran</label>
				   </div><div class="col-sm-9">
                                        <div class="col-sm-3">
				   <?php echo form_dropdown($nm_f,$opt_ta,(isset($val[$nm_f]) ? $val[$nm_f] : ambilta()),"class='select2' id='tahun_ajaran' onchange='gantita(this.value)' disabled")?>
                                        </div>
			   </div>
		   </div>
                   
                    <div class="form-group col-md-12" style="margin-bottom:20px!important;">
			   
			   <?php $nm_f="kelas";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Kelas</label>
				   </div><div class="col-sm-9">
                                        <div class="col-sm-3">
				   <?php echo form_dropdown($nm_f,$opt_kelas,(isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='select2' onchange='changekelas(this.value)' id='$nm_f' required")?> 
                                        </div>
			   </div>
		   </div>
                   
 </div>
 <button class="btn" type="button" onclick="editkelas()">Search</button>
</form>
<div class="col-sm-12 col-md-12" id="divkelas" style="margin-top:2%;">
 
    
</div>


<?php
error_reporting(0);?>
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
//$('.flex1').flexigrid({height:'auto',width:'auto',striped:false});

function edit(id) {
  window.location = _base_url + controller + 'input/' + id;
}

function detail(id) {
  window.location = _base_url + controller + 'form/' + id;
}
                   
                    function changekelas(val){
                     $('#sppdiv').load('<?php echo base_url()?>load/loadspp/'+val,{v:val},function(e){
                         
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
                    function gantita(v){
                        $('#divsiswa').empty();
                        $('#divsiswa').load("<?php echo base_url()?>pembagian_kelas/load_siswa",{ta:v});
                    }
                    $(document).ready(function(e){
                        //$("#tahun_ajaran").select2("val", "<?php echo ambilta()?>");
                         
                        gantita($("#tahun_ajaran").val())
                    });
                    function editkelas(){
                        $('#divkelas').empty();
                        $('#divkelas').append("<img src='<?php echo base_url()?>assets/img/load.gif'></img>");
                        let ta = <?php echo ambilta()?>;
                        let kelas = $('#kelas').val();
                        
                        $('#divkelas').load("<?php echo base_url().$this->utama?>/load_kelas",{t:ta,k:kelas});
                    }
</script>