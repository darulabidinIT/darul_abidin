<?php error_reporting(E_ALL ^ E_NOTICE);
if(isset($list)){	
	$val=$list->row_array();
}
?>

 <div>
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
</div>
<div class="row">
    <div class="box col-md-12">
    <div class="box-inner">
    <div class="box-header well" data-original-title="">
        <h2><i class="fa-child"></i> Prospek Ref</h2>

        
    </div>
    	<div class="box-content">
       <form method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/prospek_submit">
    		<div class="row">
		<div class="col-md-12">
			<div class="invoice">
				<div class="row invoice-logo">
					<div class="col-sm-6">
						<img alt="" src="">
					</div>
					<div class="col-sm-6">
					</div>
				</div>
				<div class="row">
				<div class="form-group">
					<div class="col-md-12" style="margin-top:20px;border-top:1px solid #8CE5FF;">	
						<div class="col-md-6">
							<div class="col-md-3">
							<label>
							User
							</label>
							</div><div class="col-md-6">
                                                            
							<?php echo GetValue('nama_lengkap','master_sales',array('id'=>'where/'.$id_user)); echo form_dropdown('user_group',GetOptAll('master_sales','-Solution Force-',array(),'nama_lengkap'),$id_user,'style="display:none"');?>
							</div>
						</div>
					</div>
				</div>
				</div>
				<hr>
				<div class="row">
						
						<?php 
						//print_r($modul->result_array());
						
						$getv=GetValue('ref_to','ref_prospek',array('sales'=>'where/'.$id_user));
                                                $in=explode(',',$getv);
						foreach($modul->result_array() as $mod){ 
						
							
						?>
							
							<div class="col-md-12" style="margin-top:20px;border-top:1px solid #8CE5FF;">                                                               <div class="col-md-1">
										<label>
											<b>&nbsp;</b>
										</label>
								</div>
								<div class="col-md-6">
                                                                    <?php echo form_checkbox('ref_to[]',$mod['id'],(in_array($mod['id'],$in) ? 'checked':'')) ?> &nbsp;
								<label>
									<b>
									<?php //echo form_hidden('menu[]',$mod['id']) ?>
									
									<?php echo $mod['nama_lengkap'] ?></b>
                                                                    
                                                                    
								</label>
								</div>
								<!--div class="col-md-2" style="border-left:1px solid #8CE5FF;">
								<?php echo form_checkbox('m_c['.$mod['id'].']','1','1',($getc==0 ? '':'checked')) ?>
								Create
								</div>
								<div class="col-md-2" style="border-left:1px solid #8CE5FF;">
									<?php echo form_checkbox('m_u['.$mod['id'].']','1',($getu==0 ? '':'checked')) ?>
								Update
								</div>
								<div class="col-md-2" style="border-left:1px solid #8CE5FF;">
									<?php echo form_checkbox('m_d['.$mod['id'].']','1',($getd==0 ? '':'checked')) ?>
								Delete
								</div-->
								
							</div>
							
						<?php } ?>


                    <!--div class="col-md-5">
						<div class="form-group">
							<label class="col-sm-3 control-label" for="inputEmail3">
								Tgl. Transaksi
							</label>
							<?php $nm_f="tgl";
							?>
							<div class="col-sm-9">
								<!--Bagian Kanan->
								<?php echo form_input($nm_f,(isset($val[$nm_f]) ? $val[$nm_f] : ''),'class="form-control date" id="'.$nm_f.'" required')?>
								
								<!--//Bagian Kanan->
							</div>
						</div>
						<div class="form-group">
							
						</div>

						
						
                    </div-->
				</div>
				
				<div class="row">
					<button type="submit" id="btnSubmit" class="btn btn-lg btn-primary hidden-print pull-right" style="margin-right:15px;">
						Submit<i class="fa fa-check"></i>
					</button>
				</div>
				
				</div>
			</div>
		</div></form>
    	</div>
    	
    </div>
    </div>
</div>