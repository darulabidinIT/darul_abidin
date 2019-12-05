											<?php

						$webmaster_grup=$this->session->userdata('webmaster_grup');
											foreach($menu as $isi){
													$child=GetAll('sv_menu',array('id_parents'=>'where/'.$isi->id,'is_active'=>'where/Active'));
													if($isi->icon=='' || $isi->icon==NULL){$icon='fa fa-cog';}else{
														$icon=$isi->icon;
													}
													if($isi->img==''){$icon=$icon;}else{
														$icon='';
													}
													if($webmaster_grup=='2706'){$allow=1;}else{
									$allow=GetValue('view','users_permission',array('menu_id'=>'where/'.$isi->id,'user_group'=>'where/'.$webmaster_grup));
								}
								if($allow==1){
													?>
											<li id="menuside<?php echo $isi->id?>">
												<a href="<?php echo base_url().$isi->filez;?>" class="<?php if($child->num_rows()>0) echo "dropdown-toggle"?>">
													<i class="menu-icon <?php echo $icon;?>"><?php if($isi->img!=NULL){ ?><img src="<?php echo base_url()?>assets/icons/<?php echo $isi->img;?>" width="24px" height="24px"><?php } ?></i>
													<span class="menu-text"> <?php echo $isi->title;?> </span>
													
											<?php if($child->num_rows()>0){?><b class="arrow fa fa-angle-down"></b><?php }?>
												</a>

												<b class="arrow"></b>
												<?php if($child->num_rows()>0){?>
												<ul class="submenu">
													<?php foreach($child->result() as $anak){
														if($webmaster_grup=='2706'){$allow2=1;}else{
													$cek2=GetAll('menu_auth',array('id_menu_admin'=>'where/'.$anak->id,'id_admin_grup'=>'where/'.$webmaster_grup,'is_active'=>'where/Active'));
													if($cek2->num_rows>0)$allow2=1;
												else $allow2=0;
												}
													if($allow2==1){
														if($anak->icon=='' || $anak->icon==NULL){$icon='fa fa-cog';}else{
																$icon=$anak->icon;
														}
															?>
														<li>
															<a href="<?php echo base_url().$anak->filez;?>">
																<i class="menu-icon <?php echo $icon;?>"></i>
															 <?php echo $anak->title;?> 
														</a>
														
														<b class="arrow"></b>
													</li>
													<?php }}?>
												</ul>
												<?php }?>
											</li>
											<?php
													
												}
											}
											?>
											