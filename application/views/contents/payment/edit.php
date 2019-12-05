<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}

$show="";
$read="";
if($val['status']=='L'){
		$show="display:none;";
		$read="disabled";
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
		<div class="col-md-7 col-sm-12">
			<form id="form" method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/submit" class="form-horizontal formular" role="form">
				<?php echo form_hidden('invoice',isset($val['id']) ? $val['id'] : '')?>
		   
			
		   
		   <div class="form-group">
			   
			   <?php $nm_f="number";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control validate[required] text-input " readonly>
			   </div>
		   </div>
		   <div class="form-group">
			   
			   <?php $nm_f="amount";?>
			   <div class="col-sm-3">
				   <label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
				   </div><div class="col-sm-9">
				   <input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="col-sm-4 validate[required] currency" <?php echo $read?>>
			   </div>
			   </div>
				<div class="form-group">
				<?php $nm_f="coa";?>
				<div class="col-sm-3">
					<label for="<?php echo $nm_f?>">COA</label>
					</div><div class="col-sm-4">
					<?php echo form_dropdown($nm_f,$opt_coa, (isset($val[$nm_f]) ? $val[$nm_f] : ''),"class='chosen-select form-control' $read")?>
				</div>
				</div>
				<div class="form-group">
					
					<?php $nm_f="ref";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>">No. Voucher</label>
						</div><div class="col-sm-9">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" <?php echo $read?>>
					</div>
				</div>
				<div class="form-group">
					
					<?php $nm_f="remark";?>
					<div class="col-sm-3">
						<label for="<?php echo $nm_f?>"><?php echo ucfirst($nm_f)?></label>
						</div><div class="col-sm-9">
						<input type="text" name="<?php echo $nm_f?>"  id="<?php echo $nm_f?>" value="<?php echo $a= (isset($val[$nm_f]) ? $val[$nm_f] : '') ?>" class="form-control" <?php echo $read?>>
					</div>
				</div>
    		<div class="form-group" style="<?php echo $show;?>">
            <button type="submit" class="btn pull-right">Submit</button>
            
             </div>
			 </form>
    	</div>
		<div class="col-md-5 col-sm-12">
		<h4>Payment History</h4>
			<table class="table table-striped table-bordered bootstrap-datatable responsive">
				<thead>
					<tr>
						<th>No. Voucher</th>
						<th>Amount</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$am=0;
					foreach($history as $lalu){
						$am+=$lalu['amount'];
					?>
					<tr>
						<td><?php echo $lalu['ref']?></td>
						<td><?php echo uang($lalu['amount'])?></td>
						<td><?php echo $lalu['create_date']?></td>
					</tr>
				<?php }?>
					<tr>
						<td colspan=3><strong>Total</strong></td>
					</tr>
					<tr>
						<td><strong><?php echo uang($val['total']);?></strong></td>
						<td><strong><?php echo uang($am);?></strong></td>
						<td><strong><?php $hasil=$val['total']-$am;
						echo uang($hasil);
						?></strong></td>
					</tr>
				</tbody>
			</table>
			<?php 
			if($hasil<=0){
					echo "<strong><h5><i>Invoice Lunas</i></h5></strong>";
			}
			?>
		</div>
		</div>
    </div>
    </div>
</div>