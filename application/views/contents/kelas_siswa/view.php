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
 <div class="col-md-12">
                    <div class="form-group">
			   
			   <?php $nm_f="ta";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tahun Ajaran</label>
				   </div><div class="col-sm-9">
				   <?php echo form_dropdown($nm_f,$opt_ta,(isset($val[$nm_f]) ? $val[$nm_f] : ambilta()),"class='select2' id='tahun_ajaran'")?>
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
 </div>
 <button class="btn" onclick="carikelas()">Search</button>
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
//$('.flex1').flexigrid({height:'auto',width:'auto',striped:false});

function edit(id) {
  window.location = _base_url + controller + 'input/' + id;
}

function detail(id) {
  window.location = _base_url + controller + 'form/' + id;
}
function btn(com,grid)
{
    if (com == 'add' ) {
		window.location = _base_url + controller + 'form/';
    }
	
    if (com == 'select' )
    {
		$('.bDiv tbody tr',grid).addClass('trSelected');
    }

    if (com == 'deselect')
    {
		$('.bDiv tbody tr',grid).removeClass('trSelected');
    }
	if(com=='edit'){
		if($('.trSelected',grid).length==1){ 
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
		//var items = $('.trSelected',grid);
 		 window.location = _base_url + controller + 'form/' + $('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', '.trSelected',grid).text();
			} else {
				return false;
			} 
	}
	if (com=='delete')
    {
           if($('.trSelected',grid).length>0){
			   if(confirm('Delete ' + $('.trSelected',grid).length + ' items?')){
		        var flex = $(grid).closest('.flexigrid');
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
    	
   				 $('.res').html('');//div.res - area for display result
		            var items = $('.trSelected',grid);
		            var itemlist ='';
		        	for(i=0;i<items.length;i++){
					//itemlist+=items[i].id+",";
					//var iteming=$('td:"no_reg" >div', items[i]).text();
					itemlist+=$('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', items[i]).text()+",";
					}
					  	
					$.ajax({
					   type: "POST",
					   url: "<?php echo site_url($this->utama."/deletec");?>",
					   data: "items="+itemlist,
					   success: function(data){
					   	$('#flex1').flexReload();
						//alert(data);
						alert('Sukses!');
					   }
					});
				}
			} else {
				return false;
			} 
      }           
}
setInterval("$('#flex1').flexReload()",50000 );
                   
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
</script>
<!--div class="col-md-12"
<div class="layout-grid">
	<table id="flex1" style="display:none; "></table>
</div>
</div-->