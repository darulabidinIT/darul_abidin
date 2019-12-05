<span style="font-size:24px; margin-bottom:5%; margin-top:5%;"><?php echo $this->title;?></span>
<?php 
error_reporting(0); ?>
<?php
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
	if(com=='Input Progress'){
		if($('.trSelected',grid).length==1){ 
			var abbr = [];
			$('.hDiv th', flex).each( function(index){
				abbr[index] = $(this).attr('abbr');
			});
			//var items = $('.trSelected',grid);
			if($('td:nth-child('+ (1+$.inArray('number',abbr)) +')>div', '.trSelected',grid).text().indexOf("TRC") >-1){
			window.location = _base_url + 'trucking_progress/form/0/' + $('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', '.trSelected',grid).text();
			}
			else{
				return false;
			}
		} else {
			return false;
		} 
	}
	if(com=='View Progress'){
		if($('.trSelected',grid).length==1){ 
			var abbr = [];
			$('.hDiv th', flex).each( function(index){
				abbr[index] = $(this).attr('abbr');
			});
			//var items = $('.trSelected',grid);
			if($('td:nth-child('+ (1+$.inArray('number',abbr)) +')>div', '.trSelected',grid).text().indexOf("TRC") >-1){
			window.location = _base_url + 'trucking_progress/main/' + $('td:nth-child('+ (1+$.inArray('idnya',abbr)) +')>div', '.trSelected',grid).text();
			}
			else{
				return false;
			} 
		}
		else {
			return false;
		} 
	}
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
</script>
<div class="layout-grid">
	<table id="flex1" style="display:none; "></table>
</div>