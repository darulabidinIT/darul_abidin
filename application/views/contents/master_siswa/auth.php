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
        <h2><i class="<?php echo GetValue('icon','sv_menu',array('filez'=>'where/'.$this->utama))?>"></i> Authorization</h2>

        
    </div>
    	<div class="box-content">
       <form method="post" enctype="multipart/form-data" action="<?php echo base_url($this->utama)?>/auth_submit">
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
							<?php echo form_dropdown('user_group',GetOptAll('master_sales','-Solution Force-',array(),'nama_lengkap'),$id_user,'style="display:none"');?>
							</div>
						</div>
					</div>
				</div>
				</div>
				<hr>
				<div class="row">
						
						<?php 
						//print_r($modul->result_array());
						
						foreach($modul->result_array() as $mod){ 
						$getv=GetValue('view','users_permission_sf',array('menu_id'=>'where/'.$mod['id'],'user_id'=>'where/'.$id_user));
						$getc=GetValue('create','users_permission_sf',array('menu_id'=>'where/'.$mod['id'],'user_id'=>'where/'.$id_user));
						$getu=GetValue('update','users_permission_sf',array('menu_id'=>'where/'.$mod['id'],'user_id'=>'where/'.$id_user));
						$getd=GetValue('delete','users_permission_sf',array('menu_id'=>'where/'.$mod['id'],'user_id'=>'where/'.$id_user));
                                                $gete=GetValue('export','users_permission_sf',array('menu_id'=>'where/'.$mod['id'],'user_id'=>'where/'.$id_user));
						
							$submodul=GetAll('menu',array('id_parents'=>'where/'.$mod['id'],'is_active'=>'where/Active'));
						?>
							
							<div class="col-md-12" style="margin-top:20px;border-top:1px solid #8CE5FF;">	
								<div class="col-md-2">
								<label>
									<b>
									<?php echo form_hidden('menu[]',$mod['id']) ?>
									
									<?php echo $mod['title'] ?></b>
                                                                    <?php echo form_checkbox('m_v['.$mod['id'].']','1',($getv==0 ? '':'checked')) ?>
                                                                    
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
							<?php foreach($submodul->result_array() as $sm){ 
								
								$getv=GetValue('view','users_permission_sf',array('menu_id'=>'where/'.$sm['id'],'user_id'=>'where/'.$id_user));
								$getc=GetValue('create','users_permission_sf',array('menu_id'=>'where/'.$sm['id'],'user_id'=>'where/'.$id_user));
								$getu=GetValue('update','users_permission_sf',array('menu_id'=>'where/'.$sm['id'],'user_id'=>'where/'.$id_user));
								$getd=GetValue('delete','users_permission_sf',array('menu_id'=>'where/'.$sm['id'],'user_id'=>'where/'.$id_user));
                                                                $gete=GetValue('export','users_permission_sf',array('menu_id'=>'where/'.$sm['id'],'user_id'=>'where/'.$id_user));
							?>
								
								<div class="col-md-12" style="border-bottom:1px solid grey;">	
									<div class="col-md-1">
										<label>
											<b>&nbsp;</b>
										</label>
									</div>
									<div class="col-md-3">
										<label>
											<b>
											<?php echo form_hidden('submenu[]',$sm['id']) ?>
											
											<?php echo $sm['title'] ?></b></label>
                                                                                     
									</div>
									<div class="col-md-1">       
                                                                                            <?php echo form_checkbox('s_v['.$sm['id'].']','1',($getv==0 ? '':'checked')) ?><label>View</label>
									</div>
									<div class="col-md-1" style="border-left:1px solid #8CE5FF;">
										<?php echo form_checkbox('s_c['.$sm['id'].']','1',($getc==0 ? '':'checked')) ?>
										<label>Create</label>
									</div>
									<div class="col-md-1" style="border-left:1px solid #8CE5FF;">
										<?php echo form_checkbox('s_u['.$sm['id'].']','1',($getu==0 ? '':'checked')) ?>
										<label>Update</label>
									</div>
									<div class="col-md-1" style="border-left:1px solid #8CE5FF;">
										<?php echo form_checkbox('s_d['.$sm['id'].']','1',($getd==0 ? '':'checked')) ?>
										<label>Delete</label>
									</div>
                                                                    <?php if($sm['id']==148){?>
									<div class="col-md-1" style="border-left:1px solid #8CE5FF;">
										<?php echo form_checkbox('s_e['.$sm['id'].']','1',($gete==0 ? '':'checked')) ?>
										<label>Export</label>
									</div>
                                                                    <?php } ?>
								</div>
							<?php }  ?>
							
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