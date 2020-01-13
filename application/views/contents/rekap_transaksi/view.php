<style>
    .row{
        margin-bottom:5px;
    }
</style>
<div class="well">
<span style="font-size:24px; margin-bottom:5%; margin-top:5%;"><?php echo $this->title;?></span>
</div>
<div class="col-md-12" style="margin-bottom:10px">
    <fieldset>
        <legend>Search Terms</legend>
        <form method="post" id="get_rekap">
        <div class="col-md-12">
            <div class="row">
                <?php $nm_f="no_sisda";?>
                <div class="col-md-2"><label>No. Sisda :</label></div>
                <div class="col-md-4"><?php echo form_input($nm_f,(post($nm_f)?post($nm_f):""),"class=''") ?></div>
            </div>
            <div class="row">
                <?php $nm_f="nama_siswa";?>
                <div class="col-md-2"><label>Nama Siswa :</label></div>
                <div class="col-md-4"><?php echo form_input($nm_f,(post($nm_f)?post($nm_f):""),"class=''") ?></div>
            </div>
            <div class="row">
                <?php $nm_f="jenjang";?>
                <div class="col-md-2"><label>Jenjang :</label></div>
                <div class="col-md-4"><?php echo form_dropdown($nm_f,$opt_jenjang,(post($nm_f)?post($nm_f):""),"class='select2' onchange='changejenjang(this.value)' ") ?></div>
            </div>
            <div class="row">
                <?php $nm_f="tingkat";?>
                <div class="col-md-2"><label>Tingkat :</label></div>
                <div class="col-md-4" id="tingkatdiv"><?php echo form_dropdown($nm_f,array(''=>'-All-'),(post($nm_f)?post($nm_f):""),"class='select2'") ?></div>
            </div>
            <div class="row">
                <?php $nm_f="periode";?>
                <div class="col-md-2"><label>Periode :</label></div>
                <div class="col-md-4"><?php echo form_dropdown($nm_f,$opt_ta,(post($nm_f)?post($nm_f):""),"class='select2'") ?></div>
            </div>
            
            <div class="row">
                <div class="col-md-2"><label>Tanggal Transaksi :</label></div>
                <div class="col-md-2"><?php echo form_input('tgl_start',(post($nm_f)?post($nm_f):""),"class='date-picker' placeholder='Start Date'") ?></div>
                <div class="col-md-2"><?php echo form_input('tgl_end',(post($nm_f)?post($nm_f):""),"class='date-picker' placeholder='End Date'") ?></div>
            </div>
            
        </div>
            <button type="button" onclick="caridata()" class="btn btn-info">Search</button>
            <button type="button" onclick="rekapsetoran()" class="btn btn-info">Rekap Setoran Hari Ini</button>
        </form>
    </fieldset>
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
    if (com == 'rekaptagihan' ) {
       // alert('ok');
		window.location = _base_url + controller + 'rekap_bulan/';
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
setInterval("$('#flex1').flexReload()",50000 );
                    function changejenjang(val){
                     $('#tingkatdiv').load('<?php echo base_url()?>load/loadtingkat/'+val,{},function(e){
                         
                        });
                    }
                    function caridata(){
                        var formdata = $('#get_rekap').serializeArray();
                        $('#tabledata').append("<img src='<?php echo base_url()?>assets/img/load.gif' width='5px'></img>");
                        $('#tabledata').load('<?php echo base_url()?>rekap_transaksi/load/',{fd:formdata},function(e){
                                
                        });
                        
                    }
                    function rekapsetoran(){
                        
                        window.location = _base_url +  'rekap_transaksi/rekapsetoran/';
                    }
</script>
<div class="col-md-12">
    <div id="tabledata" class="col-md-12">
        
    </div>
    <!--div class="layout-grid">
	<table id="flex1" style="display:none; "></table>
    </div-->
</div>