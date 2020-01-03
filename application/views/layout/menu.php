<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar">
	<script type="text/javascript">
		try{ace.settings.check('navbar' , 'fixed')}catch(e){}
	</script>

	<div class="navbar-container" id="navbar-container">
		<div class="navbar-header pull-left">
			<!-- #section:basics/navbar.layout.brand -->
			<a href="<?php echo base_url('dashboard')?>" class="navbar-brand">
				<img src="<?php echo base_url('assets')?>/img/seahorse2.png" height="50px" />
				<?php //echo $this->session->userdata('webmaster_nama');?>
			</a>

			<!-- /section:basics/navbar.layout.brand -->

			<!-- #section:basics/navbar.toggle -->
			<button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
				<span class="sr-only">Toggle user menu</span>

				<img src="<?php echo base_url('assets')?>/ace/avatars/default.png" alt="Default Photo" />
			</button>

			<button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
				<span class="sr-only">Toggle sidebar</span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>

				<span class="icon-bar"></span>
			</button>

			<!-- /section:basics/navbar.toggle -->
		</div>

		<!-- #section:basics/navbar.dropdown -->
		<div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">

			<small>
				<ul class="nav ace-nav">
					<li class="transparent" id="message">

					</li>

					<!-- #section:basics/navbar.user_menu -->
					<li class="user-min">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<!-- <img class="nav-user-photo" src="<?php echo base_url('assets')?>/ace/avatars/<?php echo GetValue('avatar','admin_profile',array('useradmin'=>'where/'.$this->session->userdata('webmaster_id')))?>" alt="Default Photo" /> -->
							<img class="nav-user-photo" src="<?php echo base_url('assets')?>/ace/avatars/default.png" alt="Default Photo" />
							<span class="user-info">
								<small>Welcome,</small>
								<?php echo ucfirst(GetValue('name','admin_profile',array('useradmin'=>'where/'.$this->session->userdata('webmaster_id'))));?>
							</span>

							<i class="ace-icon fa fa-caret-down"></i>
						</a>
						<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
							<li>
								<a href="<?php echo base_url('admin').'/form/'.$this->session->userdata('webmaster_id')?>">
									<i class="ace-icon fa fa-cog"></i>
									Settings
								</a>
							</li>

							<li>
								<a href="<?php echo base_url('admin').'/profile/'.$this->session->userdata('webmaster_id')?>">
									<i class="ace-icon fa fa-user"></i>
									Profile
								</a>
							</li>

							<li class="divider"></li>

							<li>
								<a href="<?php echo base_url('login')?>/logout">
									<i class="ace-icon fa fa-power-off"></i>
									Logout
								</a>
							</li>
						</ul>
					</li>

					<!-- /section:basics/navbar.user_menu -->
				</ul>
			</small>
		</div>


	</div><!-- /.navbar-container -->
</div>

<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
	<script type="text/javascript">
		try{ace.settings.check('main-container' , 'fixed')}catch(e){}
	</script>

	<!-- #section:basics/sidebar.horizontal -->
	<div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse">
		<script type="text/javascript">
			//try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
		</script>


		<!--Main Menu Disini-->
		<ul class="nav nav-list">
			<?php
			$webmaster_grup=$this->session->userdata('webmaster_grup');
			$q=GetAll('menu',array('id_parents'=>'where/0','sort'=>'order/ASC','is_active'=>'where/Active'));
			if($q->num_rows()>0){
				foreach($q->result() as $hasil){
					if($webmaster_grup=='2706'){$allow=1;}else{

						if($this->session->userdata("webmaster_id")=='38'){								
							$allow=GetValue('view','users_permission',array('menu_id'=>'where/'.$hasil->id,'user_group'=>'where/'.$webmaster_grup));
                                                        
                                                }else{
								$allow=GetValue('view','users_permission_sf',array('menu_id'=>'where/'.$hasil->id,'user_group'=>'where/'.$webmaster_grup));
                                                }								}
								if($allow==1){
									if($hasil->icon==NULL){$hasil->icon='fa fa-cog';}
									if($hasil->img==''){$hasil->icon=$hasil->icon;}else{
										$hasil->icon='';
									}
									?>
									<li class="hover" id="menuutama<?php echo $hasil->id?>">
										<a href="<?php echo base_url().$hasil->filez;?>" class="dropdown-toggle">
											<!--onClick="renderside(<?php echo $hasil->id?>)"-->
											<i class="menu-icon <?php echo $hasil->icon;?>"  onClick="cobapindah('<?php echo $hasil->filez?>')"><?php if($hasil->img!=NULL){ ?><img src="<?php echo base_url()?>assets/icons/<?php echo $hasil->img;?>" width="24px" height="24px"><?php } ?></i>
											<span class="menu-text" onClick="cobapindah('<?php echo $hasil->filez?>')"> <?php echo $hasil->title;?> </span><b class="arrow fa fa-angle-down"></b>
										</a>
										<b class="arrow"></b>
										<ul class="submenu">
											<?php
											$webmaster_grup=$this->session->userdata('webmaster_grup');

											$qz=GetAll('menu',array('id_parents'=>'where/'.$hasil->id,'sort'=>'order/ASC','is_active'=>'where/Active'));
											if($hasil->id == '99') $qz=GetAll('menu',array('id_parents'=>'where/'.$hasil->id,'sort'=>'order/ASC','is_active'=>'where/Active','id'=>'not_like/134'));
											if($hasil->id == '113') $qz=GetAll('menu',array('id'=>'where/zxzs')); 
											if($hasil->id == '122') $qz=GetAll('menu',array('id_parents'=>'where/'.$hasil->id,'sort'=>'order/ASC','is_active'=>'where/Active','id'=>'not_like/119'));
						//lastq();
											if($qz->num_rows()>0){
												foreach($qz->result() as $hasilz){
													if($webmaster_grup=='2706'){$allow=1;}else{
														if($this->session->userdata("webmaster_id")=='38'){	
															$allow=GetValue('view','users_permission',array('menu_id'=>'where/'.$hasilz->id,'user_group'=>'where/'.$webmaster_grup));}else{
																$allow=GetValue('view','users_permission_sf',array('menu_id'=>'where/'.$hasilz->id,'user_group'=>'where/'.$webmaster_grup));} 
															}
															if($allow==1){
																if($hasilz->icon==NULL){$hasilz->icon='fa fa-cog';}
																if($hasilz->img==''){$hasilz->icon=$hasilz->icon;}else{
																	$hasilz->icon='';
																}
																?>
			<li class="hover">
                            <a href="<?php echo base_url().$hasilz->filez?>">
                                <i class="<?php echo $hasilz->icon;?>">
         <?php if($hasilz->img!=NULL){ ?><img src="<?php echo base_url()?>assets/icons/<?php echo $hasilz->img;?>" width="16px" height="16px"><?php } ?>
                                </i> 
                             <?php echo $hasilz->title?></a>
                        </li><?php } 
                        }   
                    }?>
																</ul>


															</li> 
															<?php  }?>          
															<?php	}
														}?>


														<?php if($this->session->userdata('user_type')=='superuser' || $this->session->userdata('webmaster_grup')=='1'){?>
														<li class="hover">
															<a href="<?php echo base_url()?>#" class="dropdown-toggle"><i class="menu-icon glyphicon glyphicon-wrench"></i><span class="menu-text"> Super User Menu</span><b class="arrow fa fa-angle-down"></b></a>
															<b class="arrow"></b>
															<ul class="submenu">
																<?php if($this->session->userdata('webmaster_grup')=='2706'){?>
																<li class="hover"><a href="<?php echo base_url()?>admin"><i class="glyphicon glyphicon-user"></i> User Management</a></li><?php }?>
																<li class="hover"><a href="<?php echo base_url()?>admin_grup"><i class="glyphicon glyphicon-user"></i> Admin Grup</a></li>
																<li class="hover"><a href="<?php echo base_url()?>menu"><i class="glyphicon glyphicon-list"></i> Menu</a></li>
																<!--li class="hover"><a href="<?php echo base_url()?>menu_auth"><i class="glyphicon glyphicon-warning-sign"></i> Menu Authorization</a></li-->
															</ul>

														</li>
														<?php }?>
														<li class="hover">
															<button type="button" class="sidebar-collapse btn btn-white btn-primary" data-target="#sidebar">
																<i class="ace-icon fa fa-angle-double-up" data-icon1="ace-icon fa fa-angle-double-up" data-icon2="ace-icon fa fa-angle-double-down"></i>

															</button>

														</li>
													</ul>

													<!-- /.nav-list -->

													<!-- /section:basics/sidebar.layout.minimize -->
													<script type="text/javascript">
														try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
													</script>
												</div>
												<!-- /section:basics/sidebar.horizontal -->
												<div class="main-content">
													<div class="main-content-inner">
														<div class="page-content">
															<?php //$this->load->view('layout/sidesetting')?>
															<?php //$this->load->view('layout/sidemenu')?>

