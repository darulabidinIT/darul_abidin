<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
	if(isset($mindate) && isset($val['post_tgl'])){
		if($val['post_tgl']<$mindate){
			?>
			<script>
			//$("#target :input").prop("disabled", true);
			</script>
			<script type="text/javascript">
        $(document).ready(function(){
              $("input").attr("disabled", "disabled");
			$('#form').find('input, textarea, button, select').prop("disabled", true);
			alert('Tanggal sudah melebihi batas toleransi edit');

        });
    </script>
			<?php
		}
	}
	
}
?>
<script>

	function deletec(val){
			if(confirm('Delete items?')){
				$.ajax({
					type: "POST",
					url: "<?php echo site_url($this->utama."/delete_ledger");?>",
					data: "items="+val,
					success: function(data){
						location.reload();
						//alert(data);
						alert('Sukses!');
					}
				});
			}
	}  
	
function tambah(){
	//alert('go');
$('.select2').select2('destroy'); 
  //location.reload();
	/* var $select = $('.select2').select2();
//console.log($select);
$select.each(function(i,item){
  //console.log(item);
  $(item).select2("destroy");
}); */
  setTimeout(addrow(), 2000);
  setTimeout(addlines(), 3000);
  setTimeout(selectadd(), 4000);
};
function addrow(){
  $("table tr:last").clone().appendTo("table");
}
function addlines(){
    $('.currency').maskMoney({thousands:",",decimal:".",precision:2});
}
function selectadd(){	//////////////////
				//select2
				//$('select.form-select').select2();
				$('.select2').select2({allowClear:true});
				$('#select2-multiple-style .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which == 2) $('.select2').addClass('tag-input-style');
					 else $('.select2').removeClass('tag-input-style');
				}); 
				//////////////////
				}

function cekbal(){
    var totaldeb = 0;
    var totalkred = 0;
	$( ".debit" ).each( function(e){
		var a=$( this ).val();
		var a= a.replace(',','');
		var a= a.replace(',','');
		var a= a.replace(',','');
		var a= a.replace(',','');
		var a= a.replace(',','');
		totaldeb += parseFloat( a ) || 0;
	});
	$( ".kredit" ).each( function(e){
		var b=$( this ).val();
		var b= b.replace(',','');
		var b= b.replace(',','');
		var b= b.replace(',','');
		var b= b.replace(',','');
		var b= b.replace(',','');
		totalkred += parseFloat( b ) || 0;
	});
	
			
	var balance=totaldeb-totalkred;
	if(balance==0){
		$('#form').submit();
	}
	else{
    alert('Kredit '+totalkred);	
    alert('Debit '+totaldeb);	
    alert('Belum Balance!!');	
	}
}
</script>
    <script>
    $(window).on('beforeunload', function(){
        //return "This should create a pop-up";
    });
</script>
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
			<form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit" class="form-horizontal formular" role="form" >
				<input type="hidden" name="id" value="<?php echo (isset($val['id']) ? $val['id'] : '') ?>">
		   
			
		   <?php
		   if($pay){
			   $val['voucher']=$val['jo'];
			   $val['ref']=$val['number'];
			   $val['rincian']='Pembayaran Invoice '.$val['number'];
			   $val['doc_tgl']=substr($val['create_date'],0,11);
			   $val['post_tgl']=date("Y-m-d");
			   echo form_hidden('pay','1');
		   } elseif($costruck){
			   $val['voucher']='';
			   $val['ref']=$val['number'];
			   $val['rincian']='Pembayaran Costing '.$val['number'];
			   $val['doc_tgl']=substr($val['create_date'],0,11);
			   $val['post_tgl']=date("Y-m-d");
			   echo form_hidden('pay','1');
		   }
		   ?>
							
								
		   <!--div class="form-group">
			   
			   <?php $nm_f="number";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-2 validate[required] text-input" readonly>
			   </div>
		   </div-->
		   <div class="form-group">
			   
			   <?php $nm_f="ref";
			   
								if($pay){$refs=$utamas[$nm_f];}
								else{$refs=(isset($val[$nm_f]) ? $val[$nm_f] : '');}
			   ?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">No. Voucher</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $refs ?>" class="col-sm-4 validate[required]">
			   </div>
			   </div>
		   <div class="form-group">
			   
			 
			   </div>
				<div class="form-group">
					<?php $nm_f="doc_tgl";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Document Date</label>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control date-picker-this' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					<?php $nm_f="post_tgl";?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Posting Date</label>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='validate[required,custom[date],future[$mindate]] form-control date-picker-this' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
				</div>
				</div>
				<div class="form-group">
					<?php $nm_f="voucher";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Job Number</label>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control' ");?>
							
						</div>
					</div>
					<?php $nm_f="rincian";?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Rincian Transaksi</label>
					</div>
					<div class="col-sm-5">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control'");?>
							
				</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-11">
					<button type="button" class="btn pull-right" onClick="cekbal()">Save</button>
					</div>
				</div>
				<!--/form-->
			 <fieldset>
				<legend>Detail</legend>
				<button type="button" class="btn" id="add" onClick="tambah()">ADD</button>
				<!--form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/add_ledger" class="form-horizontal formular" role="form"-->
				<div class="form-group">
					<table class="table table-striped table-bordered bootstrap-datatable responsive">
						<thead>
							<tr>
								<th class="col-md-2">Account</th>
								<th class="col-md-1">Curr</th>
								<th class="col-md-2">Debit</th>
								<th class="col-md-2">Credit</th>
								<th class="col-md-3">Remark</th>
								<th class="col-md-4">Referal</th>
							</tr>
						</thead>
						<tbody><?php 
							if($pay || $costruck){
								if($pay){
								$isi['id']=0;
								$isi['kredit']=numbers($utamas['amount']);
								$isi['debit']=numbers(0);
								$isi['akun']=$utamas['coa'];
								$isi['remark']=$utamas['remark'];
								$isi['ref']=$val['ref'];
								//$isi['ref']=$utamas['ref'];
								}
								else if($costruck){
								$isi['id']=0;
								$isi['debit']=numbers($utamas['amount']);
								$isi['kredit']=numbers(0);
								$isi['akun']=$val['coa'];
								$isi['remark']='Pembayaran Truck Periode '.$val['period'];
								$isi['ref']=$val['invoice'];
		//	print_mz($isi);
								}
							?>
							<tr>
							<?php 
							echo form_hidden('idj[]',$isi['id']); ?>
								<td><?php echo form_dropdown('akun[]',$opt_coa,$isi['akun'],'class="form-control select2"  ')?></td>
								<td><?php echo form_dropdown('rc[]',$opt_curr,(isset($isi['rc']) ? $isi['rc'] : '1'))?></td>
								<td><?php echo form_input('debit[]',$isi['debit'],'class="form-control debit currency " ')?></td>
								<td><?php echo form_input('kredit[]',$isi['kredit'],'class="form-control kredit currency "')?></td>
								<td><?php echo form_input('remark[]',$isi['remark'],'class="form-control"')?></td>
								<td><?php echo form_input('refer[]',$isi['ref'],'class="form-control"')?></td>
							</tr>	
							<?php } ?>
						<?php
						//print_mz($detail);
						foreach($detail as $isi){
							if($pay){
								$isi['id']=0;
								$isi['debit']=numbers($isi['total']);
								$isi['remark']=$isi['desc'];
								$isi['ref']=$isi['invoice'];
								$isi['kurs']=1;
							}
								elseif($costruck){
									$truck=GetValue('code','master_truck',array('id'=>'where/'.$isi['truck']));
									if($truck==0){
										$truck=GetValue('name','master_vendor',array('id'=>'where/'.$val['vendor']));
										$mess='Penyewaan Truck Client '.$truck." Periode ".$val['period'];
									}
									else{
										$mess='Pembayaran Truck '.$truck." Periode ".$val['period'];
										
									}
									
								$isi['id']=0;
								$isi['kredit']=$isi['amount'];
								$isi['remark']=$mess;
								$isi['kurs']=1;
								$isi['ref']=$val['invoice'];
								}
							
							?>
							<tr>
							<?php 
							echo form_hidden('idj[]',$isi['id']); ?>
								<td><?php echo form_dropdown('akun[]',$opt_coa,$isi['akun'],'class="form-control select2" ')?></td>
								<td><?php echo form_dropdown('rc[]',$opt_curr,(isset($isi['rc']) ? $isi['rc'] : '1'))?></td>
								<td><?php echo form_input('debit[]',$isi['debit']/$isi['kurs'],'class="form-control debit currency " ')?></td>
								<td><?php echo form_input('kredit[]',$isi['kredit']/$isi['kurs'],'class="form-control kredit currency "')?></td>
								<td><?php echo form_input('remark[]',$isi['remark'],'class="form-control"')?></td>
								<td><?php echo form_input('refer[]',$isi['ref'],'class="form-control"')?></td>
							</tr>	
						<?php }?>
							<tr>
								<?php echo form_hidden('idj[]','');?>
								<td><?php echo form_dropdown('akun[]',$opt_coa,'','class=" form-control select2" ')?></td>
								<td><?php echo form_dropdown('rc[]',$opt_curr,(isset($isi['rc']) ? $isi['rc'] : '1'))?></td>
								<td><?php echo form_input('debit[]','','class="form-control debit currency"')?></td>
								<td><?php echo form_input('kredit[]','','class="form-control kredit currency"')?></td>
								<td><?php echo form_input('remark[]','','class="form-control" onClick="addTableRow()"')?></td>
								<td><?php echo form_input('refer[]','','class="form-control" onClick="addTableRow()"')?></td>
							</tr>	
						</tbody>
					</table>
					
				</div>
			 </form>
			 </fieldset>
    	</div>
    </div>
    </div>
</div>