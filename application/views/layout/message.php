<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<i class="ace-icon fa fa-bell icon-animated-bell"></i>
								<span class="badge badge-important"><?php echo $badge;?></span>
							</a>

							<div class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close" id="messages">
								<div class="tabbable">
									<ul class="nav nav-tabs">

										<li class="active">
											<a data-toggle="tab" href="#navbar-messages">
												Messages
												<span class="badge badge-danger"><?php echo $badge;?></span>
											</a>
										</li>
									</ul><!-- .nav-tabs -->

									<div class="tab-content">
										

										<div id="navbar-messages" class="tab-pane in active">
											<ul class="dropdown-menu-right dropdown-navbar dropdown-menu">
												<li class="dropdown-content">
													<ul class="dropdown-menu dropdown-navbar">
														
					<?php foreach($isi as $pesan){
						$style='';
						$from=GetValue('name','admin_profile',array('useradmin'=>'where/'.$pesan['create_user_id']));
						if($from=='0'){$from='SUPERADMIN';}
						$badges=GetValue('avatar','admin_profile',array('id'=>'where/'.$pesan['create_user_id']));
						if($badges=='0'){$badges='default.png';}
                                                if($pesan['status']=='N'){$style="background-color:cyan;";}
														?>
														<li style="<?php echo $style?>">
															<a href="<?php echo base_url().$pesan['link']?>">
																<img src="<?php echo base_url('assets')?>/ace/avatars/<?php echo $badges;?>" class="msg-photo" alt="Susan's Avatar" />
																<span class="msg-body">
																	<span class="msg-title">
																		<span class="blue"><?php echo strtoupper($from);?>:</span>
																		<?php echo $pesan['message'];?>
																	</span>

																	<span class="msg-time">
																		<i class="ace-icon fa fa-clock-o"></i>
																		<span>
																		<?php echo $pesan['create_date'];?></span>
																	</span>
																</span>
															</a>
														</li>
													<?php }?>
												<li class="dropdown-footer">
													<a href="<?php echo base_url()?>notif">
														See all messages
														<i class="ace-icon fa fa-arrow-right"></i>
													</a>
												</li>
											</ul>
										</div><!-- /.tab-pane -->
									</div><!-- /.tab-content -->
								</div><!-- /.tabbable -->
							</div><!-- /.dropdown-menu -->