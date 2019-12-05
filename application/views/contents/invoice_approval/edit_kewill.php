<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>
<script>
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
			
			 <fieldset>
				<legend>Edit Kewill</legend>
				<form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/kewill_submit" class="form-horizontal formular" role="form">
				<div class="form-group">
					<table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
						<thead>
							<tr>
								<th class="col-md-2">Kewill</th>
								<th class="col-md-2">Job Order</th>
								<th class="col-md-2">Desc</th>
								<th class="col-md-4">Vehicle No</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($isinya as $isi){
							$jo=$this->db->query("SELECT * FROM sv_trucking_order WHERE number='".$isi['jo']."'")->row_array();
							//lastq();
							 echo form_hidden('id[]',$isi['id']);
							?>
							<tr>
					<?php $nm_f="kewill";?>
								<td>
							<?php echo form_input($nm_f.'[]',$a= (isset($isi[$nm_f]) ? $isi[$nm_f] : ''),"id='$nm_f' class='form-control'");?></td>
								<td><?php echo $isi['jo']?></td>
								<td><?php echo $isi['desc']?></td>
								<td><?php echo GetValue('code','master_truck',array('id'=>'where/'.$jo['vehicle_no']))?></td>
							</tr>	
						<?php }?>
						</tbody>
					</table>
					
				</div>
    		<div class="form-group">
            <button type="submit" class="btn pull-right">Submit</button>
            
             </div>
			 </form>
			 </fieldset>
    	</div>
    </div>
    </div>
</div>