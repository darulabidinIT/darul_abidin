<!DOCTYPE html>
<html lang="en">
	
<?php $this->load->view('layout/header')?>
	<script>
		jQuery(document).ready(function(){
			idmenu=parseInt(<?php echo GetValue('id_parents','sv_menu',array('filez'=>'where/'.$this->uri->segment(1)));?>);
			childmenu=parseInt(<?php echo GetValue('id','sv_menu',array('filez'=>'where/'.$this->uri->segment(1)));?>);
			renderside(idmenu);
			rendermessage();
			setInterval("rendermessage()",100000 );
			setTimeout(function() {
				
				$("#menuside"+childmenu).addClass("active");
			}, 500);
			
			function beforeCall(form, options){
				//alert('oke');
				if (window.console) 
				console.log("Right before the AJAX form validation call");
				return true;
			}
            
			// Called once the server replies to the ajax form validation request
			function ajaxValidationCallback(status, form, json, options){
				if (window.console) 
				console.log(status);
                
				if (status === true) {
					alert('the form is valid!');
					// uncomment these lines to submit the form to form.action
					form.validationEngine('detach');
					form.submit();
					// or you may use AJAX again to submit the data
				}
			}
			jQuery(document).ready(function(){
				
				//$('#kodeBar').focus();
				// binds form submission and fields to the validation engine
				jQuery("#form").validationEngine({
					
					/*ajaxFormValidation: true,
						ajaxFormValidationMethod: 'post',
					onAjaxFormComplete: ajaxValidationCallback*/
					
				});
			});
			
		});
		function renderside(id){
			$("li[id^='menuutama']").removeClass("active");
				id=parseInt(id);
			$("#listside").empty();
			$("#listside").load("<?php echo base_url()?>load/renderdropdown/"+id);
			$("#menuutama"+id).addClass("active");
		}
		function rendermessage(){
				$('#message').load("<?php echo base_url()?>load/rendermessage/");
		}
		function cobapindah(val){
			if(val!='#'){
				window.location.href ='<?php echo base_url()?>'+val;
			}
		}
	</script>
	<body class="no-skin">
		<?php $this->load->view('layout/menu')?>
		

			
		<?php $this->load->view($content);?>
				<!-- /section:settings.box --
				<div class="page-header">
					<h1>Two Menu Style </h1>
				</div><!-- /.page-header -->
				<!-- PAGE CONTENT BEGINS --
				<div class="row">
					<div class="col-xs-12">
						
						<div class="hidden-sm hidden-xs">
							
						</div>
						
						<!-- PAGE CONTENT ENDS --
					</div><!-- /.col --
				</div><!-- /.row -->
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->
								
			<div class="footer">
				<div class="footer-inner">
					<!-- #section:basics/footer -->
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">MBI</span>
							Application &copy; <?php echo date("Y")?>
						</span>

						&nbsp; &nbsp;
						<!--span class="action-buttons">
							<a href="#">
								<i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
							</a>

							<a href="#">
								<i class="ace-icon fa fa-rss-square orange bigger-150"></i>
							</a>
						</span-->
					</div>

					<!-- /section:basics/footer -->
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='<?php echo base_url('assets')?>/ace../js/jquery1x.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url('assets')?>/ace/js/jquery.mobile.custom.js'>"+"<"+"/script>");
		</script>

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->
<script src="<?php echo base_url('assets')?>/ace/js/chosen.jquery.js"></script>
<script src="<?php echo base_url('assets')?>/ace/js/typeahead.jquery.js"></script>
<script src="<?php echo base_url('assets')?>/ace/js/jquery.maskMoney.js"></script>
<script src="<?php echo base_url('assets')?>/ace/js/bootstrap.js"></script>
<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.js"></script>
<script src="<?php echo base_url('assets')?>/ace/js/ace/elements.typeahead.js"></script>
<script src="<?php echo base_url('assets')?>/ace/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.ajax-content.js"></script>
<script src="<?php echo base_url('assets')?>/highcharts/js/highcharts.js"></script>
<script src="<?php echo base_url('assets')?>/highcharts/js/modules/data.js"></script>
<script src="<?php echo base_url('assets')?>/highcharts/js/modules/drilldown.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/elements.scroller.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/elements.colorpicker.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/elements.fileinput.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/elements.wysiwyg.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/elements.spinner.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/elements.treeview.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/elements.wizard.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/elements.aside.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.touch-drag.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.sidebar.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.sidebar-scroll-1.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.submenu-hover.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.widget-box.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.settings.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.settings-rtl.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.settings-skin.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.widget-on-reload.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.searchbox-autocomplete.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/date-time/bootstrap-datepicker.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/date-time/bootstrap-timepicker.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/select2.js"></script>
		
		<!-- inline scripts related to this page -->
		<script type="text/javascript">
                    
                                
			jQuery(function($) {
				
				$('.datatable').DataTable();
				
				$('.chosen-select').chosen({allow_single_deselect:true}); 
				
				$('#sidebar2').insertBefore('.page-content').ace_sidebar('collapse', false);
				///toggleMenu(toggle_btn, save);
			   $('#navbar').addClass('h-navbar');
			   $('.footer').insertAfter('.page-content');
			   
			   $('.page-content').addClass('main-content');
			   
			   $('.menu-toggler[data-target="#sidebar2"]').insertBefore('.navbar-brand');
			   
			   
			   $(document).on('settings.ace.two_menu', function(e, event_name, event_val) {
				 if(event_name == 'sidebar_fixed') {
					 if( $('#sidebar').hasClass('sidebar-fixed') ) $('#sidebar2').addClass('sidebar-fixed')
					 else $('#sidebar2').removeClass('sidebar-fixed')
				 }
			   }).triggerHandler('settings.ace.two_menu', ['sidebar_fixed' ,$('#sidebar').hasClass('sidebar-fixed')]);
			   
			   $('#sidebar2[data-sidebar-hover=true]').ace_sidebar_hover('reset');
			   $('#sidebar2[data-sidebar-scroll=true]').ace_sidebar_scroll('reset', true);
			})
		
			$('.date-picker').datepicker({
				autoclose: true,
				todayHighlight: true
			}).next().on(ace.click_event, function(){
				$(this).prev().focus();
			});
			
			$('.date-picker').datepicker({
				autoclose: true,
				todayHighlight: true,
				<?php if($this->session->userdata('webmaster_grup')!='2706'){
					?>
				startDate: '<?php echo date("Y-m").'-01'?>', 
				<?php } ?>
				endDate: '<?php echo tanggalpenuh(date("Y-m"))?>', 
			}).next().on(ace.click_event, function(){
				$(this).prev().focus();
			});
			
			
				$('.timepicker').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
			
			
			
		</script>
<script>
				//////////////////
				//select2
				$('.select2').css('width','200px').select2({allowClear:true})
				$('#select2-multiple-style .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which == 2) $('.select2').addClass('tag-input-style');
					 else $('.select2').removeClass('tag-input-style');
				});
                                
                                
				
				//////////////////
	///////////////////
	
	//typeahead.js
	//example taken from plugin's page at: https://twitter.github.io/typeahead.js/examples/
	var substringMatcher = function(strs) {
		return function findMatches(q, cb) {
			var matches, substringRegex;
			
			// an array that will be populated with substring matches
			matches = [];
			
			// regex used to determine if a string contains the substring `q`
			substrRegex = new RegExp(q, 'i');
			
			// iterate through the pool of strings and for any string that
			// contains the substring `q`, add it to the `matches` array
			$.each(strs, function(i, str) {
				if (substrRegex.test(str)) {
					// the typeahead jQuery plugin expects suggestions to a
					// JavaScript object, refer to typeahead docs for more info
					matches.push({ value: str });
				}
			});
			
			cb(matches);
		}
	}
	
	
	
	///////////////
	
	$('input.typeaheadtruck').typeahead({
		hint: true,
		highlight: true,
		minLength: 1
		}, {
		name: 'states',
		displayKey: 'value',
		source: substringMatcher(ace.vars['TRUCK'])
	});
	$('input.typeaheadsea').typeahead({
		hint: true,
		highlight: true,
		minLength: 1
		}, {
		name: 'states',
		displayKey: 'value',
		source: substringMatcher(ace.vars['SEA'])
		});
	$('input.typeaheadair').typeahead({
		hint: true,
		highlight: true,
		minLength: 1
		}, {
		name: 'states',
		displayKey: 'value',
		source: substringMatcher(ace.vars['AIR'])
	}); 
</script>
<script>
  $(function() {
    $('.currency').maskMoney({thousands:",",decimal:".",precision:2});
  });
</script>
		<!-- the following scripts are used in demo only for onpage help and you don't need them -->
		<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/css/ace.onpage-help.css" />
		<link rel="stylesheet" href="<?php echo base_url('assets')?>/ace/docs/js/themes/sunburst.css" />

		<script type="text/javascript"> ace.vars['base'] = '..'; </script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/elements.onpage-help.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/js/ace/ace.onpage-help.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/docs/js/rainbow.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/docs/js/language/generic.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/docs/js/language/html.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/docs/js/language/css.js"></script>
		<script src="<?php echo base_url('assets')?>/ace/docs/js/language/javascript.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/flexigrid/js/flexigrid.pack.js"></script>
	</body>
</html>
