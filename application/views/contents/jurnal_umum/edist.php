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
			<form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit" class="form-horizontal formular" role="form">
				<?php echo form_hidden('id',isset($val['id']) ? $val['id'] : '')?>
		   
			
		   
		   <!--div class="form-group">
			   
			   <?php $nm_f="number";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-2 validate[required] text-input" readonly>
			   </div>
		   </div-->
		   <div class="form-group">
			   
			   <?php $nm_f="ref";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>">Referal Number</label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required]">
			   </div>
			   </div>
		   <div class="form-group">
			   
			 
			   </div>
				<div class="form-group">
					<?php $nm_f="document_date";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">Document Date</label>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control date-picker' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
					</div>
					<?php $nm_f="posting_date";?>
					<div class="col-sm-2">
						<label for="<?php echo $nm_f?>">Posting Date</label>
					</div>
					<div class="col-sm-3">
						<div class="input-group">
							<?php echo form_input($nm_f,$a= (isset($val[$nm_f]) ? $val[$nm_f] : ''),"id='$nm_f' class='form-control date-picker' data-date-format='yyyy-mm-dd'");?>
							<span class="input-group-addon">
								<i class="fa fa-calendar bigger-110"></i>
							</span>
						</div>
				</div>
				</div>
				<div class="form-group">
					<table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
						<thead>
							<tr>
								<th class="col-md-2">Account</th>
								<th class="col-md-2">Debit</th>
								<th class="col-md-2">Credit</th>
								<th class="col-md-4">Remark</th>
								<th class="col-md-4">No Voucher</th>
								<th class="col-md-4">Rincian Transaksi</th>
								<th class="col-md-2">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$am=0;
								foreach($detail as $lalu){
									$am+=$lalu['amount'];
								?>
								<tr>
									<td><?php echo form_dropdown('akun[]',$opt_coa,$lalu['akun'],'class="chosen-select form-control" ')?></td>
									<td><?php echo form_input('debit[]',$lalu['debit'],'class="form-control"')?></td>
									<td><?php echo form_input('kredit[]',$lalu['kredit'],'class="form-control"')?></td>
									<td><?php echo form_input('remark[]',$lalu['remark'],'class="form-control"')?></td>
								</tr>
							<?php }?>
							<tr>
								<td><?php echo form_dropdown('akun[]',$opt_coa,$lalu['akun'],'class="chosen-select form-control" ')?></td>
								<td><?php echo form_input('debit[]',$lalu['debit'],'class="form-control"')?></td>
								<td><?php echo form_input('kredit[]',$lalu['kredit'],'class="form-control"')?></td>
								<td><?php echo form_input('remark[]',$lalu['remark'],'class="form-control"')?></td>
							</tr>	
						</tbody>
					</table>
					
				</div>
    		<div class="form-group">
            <button type="submit" class="btn pull-right">Submit</button>
            
             </div>
			 </form>
    	</div>
    </div>
    </div>
</div>