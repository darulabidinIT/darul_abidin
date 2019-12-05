<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title><?php echo GetValue('app_name','setup_app',array('id'=>'where/1')); ?></title>

	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/bootstrap.css" />
	<!--link rel="stylesheet" href="<?php echo base_url('assets')?>/fontawesome/css/all.min.css" /-->
	<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/font-awesome.css" />

	<link rel="stylesheet" href="<?php echo base_url('assets')?>/validation/css/validationEngine.jquery.css" type="text/css"/>

	<!-- page specific plugin styles -->

	<!-- text fonts -->
	<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/ace-fonts.css" />

	<!-- ace styles -->
	<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />

	<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/datepicker.css" />
	<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/bootstrap-timepicker.css" />
	<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/chosen.css" />
	<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/jquery.dataTables.css" />
	<link rel="stylesheet" href="<?php echo base_url('assets')?>/select2/css/select2.css" />
		<!--[if lte IE 9]>
			<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/ace-part2.css" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/ace-ie.css" />
		<![endif]-->

		<!-- inline styles related to this page -->

		<!-- ace settings handler -->
		<script src="<?php echo base_url('assets')?>/ace/js/ace-extra.js"></script>

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="<?php echo base_url('assets')?>/ace/js/html5shiv.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/respond.js"></script>
	<![endif]-->
	<!--[if !IE]> -->
	<script type="text/javascript">
		window.jQuery || document.write("<script src='<?php echo base_url('assets')?>/ace/js/jquery.js' >"+"<"+"/script>");
	</script>
	<script src="<?php echo base_url().'assets/ace/js/accounting.js'?>"></script>
	<script src="<?php echo base_url('assets')?>/validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
	</script>
	<script src="<?php echo base_url('assets')?>/jqueryui/jquery-ui.min.js" type="text/javascript" charset="utf-8">
	</script>
	<link type="text/css" href="<?php echo base_url();?>assets/jqueryui/jquery-ui.min.css" rel="stylesheet" />
	<?php $this->load->view('layout/validator');?>
<!--script src="<?php echo base_url('assets')?>/validation/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
</script-->
<link type="text/css" href="<?php echo base_url();?>assets/flexigrid/css/flexigrid.css" rel="stylesheet" />
<script src="<?php echo base_url('assets')?>/ace/js/jquery.maskedinput.js"></script>
<script src='<?php echo base_url()?>assets/ace/js/bootstrap-wysiwyg.js'></script> 
<script src='<?php echo base_url()?>assets/ckeditor/ckeditor.js'></script> 
</head>
<style>
/*.bDiv{
	max-height:350px!important;
}*/
</style>