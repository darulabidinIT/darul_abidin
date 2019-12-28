<!DOCTYPE html>
<html lang="en">
    <style>
        * {-webkit-font-smoothing: antialiased;}
        #shadowbox {
    position: fixed;
    z-index: 9999999998;
    height: 100%;
    width: 100%;
    background: rgba(0,0,0,0.5);
}

/*#banner {
    position: fixed;
    z-index: 999;
    top: 5%;
    min-height: 400px;
    background: #FFF;
}*/
@media (min-width: 768px) {
    #banner {
        width: 70%;
        margin-left: 15%;
        /*min-height:50%;*/
        position:fixed;
        z-index: 9999999999;
        background: #FFF;
        top: 5%;
        overflow-y: scroll;
        max-height:400px;
    }
    #closes {
        width: 70%;
        margin-left: 15%;
        /*min-height:50%;*/
        position:fixed;
        z-index: 9999999999;
        background: #FFF;
        top: 0;
        overflow-y: scroll;
        max-height:400px;
    }
}
@media (max-width: 767px) {
    #banner {
        width: 100%;
        /*min-height:50%;*/
        position:fixed;
        z-index: 9999999999;
        background: #FFF;
        top: 5%;
        overflow-y: scroll;
        max-height:400px;
    }
    #closes {
        width: 100%;
        /*min-height:50%;*/
        position:fixed;
        z-index: 9999999999;
        background: #FFF;
        top: 0;
        overflow-y: scroll;
        max-height:400px;
    }
}

#close {
    position: absolute;
    top: 0px;
    right: 0px;
    font-family: Arial, Helvetica;
    font-size: 14px;
    color: #fff;
    cursor: pointer;
    font-weight: bold;
    background-color: #f44336;
    padding: 10px;
}
        </style>
<?php $this->load->view('layout/header')?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>assets/slick/slick-theme.css"/>
        <script type="text/javascript" src="<?php echo base_url()?>assets/slick/slick.min.js"></script>
	<script>
		jQuery(document).ready(function(){
                    <?php $carimenu=GetValue('id_parents','sv_menu',array('filez'=>'where/'.$this->uri->segment(1)));
                    $ai=$this->db->query("SELECT id_parents FROM sv_menu WHERE filez='".$this->uri->segment(1)."/".$this->uri->segment(2)."'");
                    if($ai->num_rows()==0){
                    $ai=$this->db->query("SELECT id_parents FROM sv_menu WHERE filez='".$this->uri->segment(1)."'");
                    }
                    $idnya=$ai->row_array();
                     
                    ?>
			idmenu=parseInt(<?php echo $idnya['id_parents']?>);
			childmenu=parseInt(<?php echo GetValue('id','sv_menu',array('filez'=>'where/'.$this->uri->segment(1)));?>);
			renderside(idmenu);
			rendermessage();
			//setInterval("rendermessage()",100000 );
			setTimeout(function() {
                            $("#menuside"+childmenu).addClass("active");
			}, 500);
//                        $('#shadowbox').click(function(){
//                            $('#shadowbox').fadeOut( "slow", function() {});
//                            $('#banner').fadeOut( "slow", function() {});
//                            $('#closes').fadeOut( "slow", function() {});
//                        });
			$('#close').click(function(){
                            //$(this).parent().fadeOut( "slow", function() {});
                            $('#closes').fadeOut( "slow", function() {});
                            $('#shadowbox').fadeOut( "slow", function() {});
                            $('#banner').fadeOut( "slow", function() {});
                        });
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
                            $('.your-class').slick({ 
                                dots: true,
                                infinite: true,
                                speed: 300,
                                slidesToShow: 1,
                                adaptiveHeight: true
                            });
                            <?php if($this->session->flashdata('pengumuman')=='ada'){ ?>
				 $('#shadowbox').fadeIn( "slow", function() {});
                                 $('#banner').fadeIn( "slow", function() {});
                                 $('#closes').fadeIn( "slow", function() {});
                            <?php }?>
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
			//$("#listside").load("<?php echo base_url()?>load/renderdropdown/"+id);
			$("#menuutama"+id).addClass("active");
		}
		function rendermessage(){
				//$('#message').load("<?php echo base_url()?>load/rendermessage/");
		}
		function cobapindah(val){
			if(val!='#'){
				window.location.href ='<?php echo base_url()?>'+val;
			}
		}
	</script>
	<body class="no-skin">
            
            <div id="shadowbox" style="display:none"></div>
            <div class="col-md-12" id="closes" style="height:50px; display:none">  
                    <div id="close">X</div>
                  </div>
           

		<?php $this->load->view('layout/menu')?>
		

			
		<?php $this->load->view($content);?>
				
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content --> 
								
			<div class="footer">
				<div class="footer-inner">
					<!-- #section:basics/footer -->
					<div class="footer-content">
						<span class="bigger-120">
							<span class="blue bolder">Darul Abidin</span>
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
<script src="<?php echo base_url('assets')?>/ace/js/jquery.table2excel.js"></script>
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
                
                <script src="<?php echo base_url('assets')?>/highcharts/js/modules/series-label.js"></script>
                <script src="<?php echo base_url('assets')?>/highcharts/js/modules/exporting.js"></script>
                <script src="<?php echo base_url('assets')?>/highcharts/js/modules/export-data.js"></script>
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
		<!--script src="<?php echo base_url('assets')?>/ace/js/select2.js"></script-->
		<script src="<?php echo base_url('assets')?>/select2/js/select2.js"></script>

		
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
                           $('#tbl-kalkulasi').DataTable({
        "language": {
             "search": "Search Status/Tindakan:"
        }
        });
		
			})
	
			$('.date-picker').datepicker({
				autoclose: true,
                                format:'yyyy-mm-dd',
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
                                
          function matchStart(params, data) {
            params.term = params.term || '';
            if(data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
                return data;
            }
            return false;
          }  
				$('.select2').css('width','200px').select2({matcher: function(params,data){
                                    return matchStart(params, data);
                                },});
                            
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
    $('.currency').maskMoney({thousands:".",decimal:",",precision:0});
  });
  
  // Jquery Dependency

$("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}


function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(",") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(",");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    if (blur === "blur") {
      right_side += "00";
    }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val = "Rp " + left_side + "," + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val = "Rp " + input_val;
    
    // final formatting
    if (blur === "blur" && input_val!="Rp ") {
      input_val += ",00";
    }
    else if(blur === "blur" && input_val=="Rp ") {
        input_val="";
    }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}
const formatter = new Intl.NumberFormat('id', {
  style: 'decimal',
  //currency: 'IDR',
  minimumFractionDigits: 0
})

function CurrencyFormatted(amount)
{
    var i = parseFloat(amount);
    if(isNaN(i)) { i = 0; }
    var minus = '';
    if(i < 0) { minus = '-'; }
    i = Math.abs(i);
    i = parseInt((i + .005) * 100);
    i = i / 100;
    s = new String(i);
    if(s.indexOf('.') < 0) { s += ''; }
    if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
    s = minus + s;
    return s;
}
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
		<script type="text/javascript" src="<?php echo base_url();?>assets/validate_new/validate.js"></script>
                <link rel="stylesheet" href="<?php echo base_url();?>assets/validate_new/validate.css"/>
	</body>
</html>
