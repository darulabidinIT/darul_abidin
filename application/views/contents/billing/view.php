<div class="well">
    <span style="font-size:24px; margin-bottom:5%; margin-top:5%;"><?php echo $this->title;?></span>
</div>
<div class="col-md-12">
    <button data-toggle="collapse" data-target="#demo" id="searchbutton" class="btn-danger btn"><i class="fa fa-search"></i>&nbsp;Search</button>
<fieldset style="border:1px solid #D4011B; padding-bottom:10px; border-radius:5px;" class="col-md-12 collapse <?php if(isset($_POST['search'])) echo "in"?>" id="demo">
	
	<form enctype="multipart/form-data" method="get" action="<?php echo base_url().$this->utama ?>">
            <div class="col-sm-12 col-md-12" style="margin-top:10px">
                           <div class="col-sm-6 col-md-6"  style="float:none!important;margin:0 auto;">
                                <?php echo form_dropdown('siswa',GetOptAll('master_siswa','-Siswa-',array('nama_siswa'=>'order/asc','nama_siswa'=>'where_not_null/'),'nama_siswa','id','no_sisda'),$_GET['siswa'],'class="select3" id="searchb" ')?>&nbsp; &nbsp; &nbsp;
                           </div><br>
                            <div class="col-sm-6 col-md-6" id="optionjp"  style="float:none!important;margin:0 auto;">
                                <?php echo form_dropdown('ta',GetOptAll('master_tahun_ajaran','-Tahun Ajaran-'),(empty($_GET['ta'])?ambilta():$_GET['ta']),'class="select4"')?>&nbsp; &nbsp; &nbsp;
                            </div><br>
                            <div class="col-sm-6 col-md-6" id="optionjp"  style="float:none!important;margin:0 auto;">
                                <?php echo form_dropdown('kelas',GetOptAll('master_kelas','-Kelas-'),$_GET['ta'],'class="select4"')?>&nbsp; &nbsp; &nbsp;
                            </div><br>
                           <div class="col-sm-6 col-md-6"  style="float:none!important;margin:0 auto;">
                <?php echo form_dropdown('tipe',array(''=>'-Tipe-','spp'=>'SPP','pmb'=>'PMB','custom'=>'Custom'),$_GET['tipe'],'class="select2"');
                //lastq();?>
                    <?php //echo form_input('part',$_POST['part'],'class="" id="'.$nm_f.'" placeholder="Part Number" '); ?>
                           </div>
            </div>
            
            <div class="col-sm-12 col-md-12"><div class="col-sm-12 col-md-12"><input type="submit" value="Search" name="search">&nbsp;<input type="submit" value="Export" name="export"></div></div>
	<div class="col-sm-12" style="margin-top:10px"></div>
	
	</form>

</fieldset>
</div>
 <?php if($this->session->flashdata('message')){?>
<div class="alert alert-success" role="alert">
                        <?php echo $this->session->flashdata('message') ?>
                        </div>
 <?php }?>
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
   if (com == 'rekap tagihan pg' ) {
       // alert('ok');
		window.location = _base_url + controller + 'rekap_bulan/2';
    }
    if (com == 'rekap tagihan tk' ) {
       // alert('ok');
		window.location = _base_url + controller + 'rekap_bulan/3';
    }
    if (com == 'rekap tagihan sd' ) {
       // alert('ok');
		window.location = _base_url + controller + 'rekap_bulan/5';
    }
    if (com == 'rekap tagihan smp' ) {
		window.location = _base_url + controller + 'rekap_bulan/6';
    }
    if (com == 'buat spp manual' ) {
		window.location = _base_url + controller + 'form_manual/';
    }
    if (com == 'buat tagihan custom' ) {
		window.location = _base_url + controller + 'form_custom/';
    }
    if (com == 'select' )
    {
		$('.bDiv tbody tr',grid).addClass('trSelected');
    }

    if (com == 'deselect')
    {
		$('.bDiv tbody tr',grid).removeClass('trSelected');
    }
	if(com=='cetak tagihan'){
		if($('.trSelected',grid).length==1){ 
    			var abbr = [];
    				$('.hDiv th', flex).each( function(index){
       			 abbr[index] = $(this).attr('abbr');
  				  });
		//var items = $('.trSelected',grid);
 		 window.location = _base_url + controller + 'cetak_tagihan/' + $('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', '.trSelected',grid).text();
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
//setInterval("$('#flex1').flexReload()",50000 );
$(document).ready(function(e){

        $('.select3').css('width','600px').select2();
        $('.select4').css('width','200px').select2();
        <?php if($this->input->get('search')){?>
                $('#searchbutton').click();
        <?php }?>
})
</script>

<div class="col-md-12">
    
<div class="layout-grid">
	<table id="flex1" style="display:none; "></table>
</div>
</div>