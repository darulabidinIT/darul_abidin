<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>
<script>
	
	function client(a){
		var vals=a;
		$.post( "<?php echo base_url()?>load/marketingtrucking/", { v:vals },
		function( data ) {
				oy=data.split('/');
			$('#messers').val(oy[0]);
			$('#loading').val(oy[1]);
			$('#unloading').val(oy[2]);
			location.reload();
		});
		
	}	
	function lihatvendor(a){
		var vals=a;
		$.post( "<?php echo base_url()?>load/vendortruck/", { v:vals },
		function( data ) {
			$('#vendor').val(data);
		});
		
	}
	
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
			<form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit" class="form-horizontal formular" role="form">
				<?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
				<?php echo form_hidden('jo',isset($val['jo']) ? $val['jo'] : '')?>
		   
			
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="location";?>
						<label for="<?php echo $nm_f?>">Location</label>
					</div>
					<div class ="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class=" form-control" id="'.$nm_f.'" ');?>
					</div>
				</div>
				
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="supir";?>
						<label for="<?php echo $nm_f?>">Supir</label>
					</div>
					<div class ="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : $supir),'class=" form-control" id="'.$nm_f.'" ');?>
					</div>
				</div>
				
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="tlp_supir";?>
						<label for="<?php echo $nm_f?>">Tlp Supir</label>
					</div>
					<div class ="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : $tlp_supir),'class=" form-control" id="'.$nm_f.'" ');?>
					</div>
				</div>
				
				<div class="form-group">
				
					<?php $nm_f="ttm";?>
					<div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tiba Tempat Muat</label>
						</div><div class="col-sm-3">
						<div class="input-group bootstrap-timepicker">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control timepicker' ");?>
							<span class="input-group-addon">
								<i class="fa fa-clock-o bigger-110"></i>
							</span>
						</div>
					</div>
					<?php $nm_f="ktm";?>
					<div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Keluar Tempat Muat</label>
						</div><div class="col-sm-3">
						<div class="input-group bootstrap-timepicker">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control timepicker' ");?>
							<span class="input-group-addon">
								<i class="fa fa-clock-o bigger-110"></i>
							</span>
						</div>
					</div>
			</div>	<div class="form-group">
				
					<?php $nm_f="ss";?>
					<div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Start Stuffing</label>
						</div><div class="col-sm-3">
						<div class="input-group bootstrap-timepicker">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control timepicker' ");?>
							<span class="input-group-addon">
								<i class="fa fa-clock-o bigger-110"></i>
							</span>
						</div>
					</div>
					<?php $nm_f="fs";?>
					<div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Finish Stuffing</label>
						</div><div class="col-sm-3">
						<div class="input-group bootstrap-timepicker">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control timepicker' ");?>
							<span class="input-group-addon">
								<i class="fa fa-clock-o bigger-110"></i>
							</span>
						</div>
					</div>
			</div>
				
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="bongkar";?>
						<label for="<?php echo $nm_f?>">Bongkar</label>
					</div>
					<div class ="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class=" form-control" id="'.$nm_f.'" ');?>
					</div>
				</div>
				
				<div class="form-group">
				
					<?php $nm_f="ttb";?>
					<div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Tiba Tempat Bongkar</label>
						</div><div class="col-sm-3">
						<div class="input-group bootstrap-timepicker">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control timepicker' ");?>
							<span class="input-group-addon">
								<i class="fa fa-clock-o bigger-110"></i>
							</span>
						</div>
					</div>
					<?php $nm_f="ktb";?>
					<div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Keluar Tempat Bongkar</label>
						</div><div class="col-sm-3">
						<div class="input-group bootstrap-timepicker">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control timepicker' ");?>
							<span class="input-group-addon">
								<i class="fa fa-clock-o bigger-110"></i>
							</span>
						</div>
					</div>
			</div>
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="keterangan";?>
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
					</div>
					<div class ="col-sm-3">
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class=" form-control" id="'.$nm_f.'" ');?>
					</div>
				</div>
				
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="label1";?>
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class=" form-control" id="'.$nm_f.'" placeholder="Label 1" ');?>
					</div>
					<div class ="col-sm-3">
						<?php $nm_f="val1";?>
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class=" form-control" id="'.$nm_f.'" placeholder="Value 1" ');?>
					</div>
				</div>
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="label2";?>
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class=" form-control" id="'.$nm_f.'" placeholder="Label 2" ');?>
					</div>
					<div class ="col-sm-3">
						<?php $nm_f="val2";?>
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class=" form-control" id="'.$nm_f.'" placeholder="Value 2" ');?>
					</div>
				</div>
				<div class="form-group">
					
					<div class="col-sm-3">
						<?php $nm_f="label3";?>
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class=" form-control" id="'.$nm_f.'" placeholder="Label 3" ');?>
					</div>
					<div class ="col-sm-3">
						<?php $nm_f="val3";?>
						<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class=" form-control" id="'.$nm_f.'" placeholder="Value 3" ');?>
					</div>
				</div>
				<?php for ($a=1;$a<=5;$a++){ ?>
    		<div class="form-group">
					<div class="col-sm-3">
                        <label for="<?php echo $nm_f?>"><?php echo 'Foto '.$a?><?php if($type=="Edit"){echo " (Kosongkan Jika Foto tidak diganti)";}?></label>
						</div>
						
					<div class="col-sm-3">
            <?php $nm_f="picture$a";?>
                        <input type="file" name="<?php echo $nm_f?>" id="<?php echo $nm_f?>" accept="image/*" >
						</div>
				</div><?php } ?>
    		<div class="form-group">
            <button type="submit" class="btn pull-right">Submit</button>
            
             </div>
			 </form>
    	</div>
		<?php if($type=="Edit"){?>
		<div class="box-content">
		<table class="table table-striped table-bordered bootstrap-datatable responsive">
			<tr>
				<th>Kategori</th>
				<th>Gambar</th>
				<th>Aksi</th>
			</tr>
				<?php for ($a=1;$a<=5;$a++){ ?>
			<tr>
				<td>Foto <?php echo $a?></td>
				<td><?php echo $p=($val["picture$a"]==NULL ? ' No Images Available' : "<img src='".base_url()."assets/ace/pictures/".$val["picture$a"]."'width='100' height='100'/>");?></td>
				<td><a href="<?php echo base_url()?>trucking_progress/delete_photo/<?php echo $val['id'].'/'."picture$a"?>">Hapus</a></td>
				</tr><?php } ?>
		</table>
		</div><?php } ?>
    </div>
    </div>
</div>