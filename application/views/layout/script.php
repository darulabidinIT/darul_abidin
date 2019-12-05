
<!-- external javascript -->
<script>
var base_url='<?php echo base_url()?>';
</script>
<script src="<?php echo base_url()?>assets/charisma/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="<?php echo base_url()?>assets/charisma/js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='<?php echo base_url()?>assets/charisma/bower_components/moment/min/moment.min.js'></script>
<script src='<?php echo base_url()?>assets/charisma/bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='<?php echo base_url()?>assets/charisma/js/jquery.dataTables.min.js'></script>

<!-- select or dropdown enhancer -->
<script src="<?php echo base_url()?>assets/charisma/bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="<?php echo base_url()?>assets/charisma/bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="<?php echo base_url()?>assets/charisma/js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="<?php echo base_url()?>assets/charisma/bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="<?php echo base_url()?>assets/charisma/bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- star rating plugin -->
<script src="<?php echo base_url()?>assets/charisma/js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="<?php echo base_url()?>assets/charisma/js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="<?php echo base_url()?>assets/charisma/js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="<?php echo base_url()?>assets/charisma/js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="<?php echo base_url()?>assets/charisma/js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="<?php echo base_url()?>assets/charisma/js/charisma.js"></script>
<script src="<?php echo base_url()?>assets/ui/js/jquery-ui-1.9.2.custom.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/flexigrid/js/flexigrid.pack.js"></script>


<link type="text/css" rel="stylesheet" media="all" href="http://sysvit.com/chat/css/chat.css" />
<link type="text/css" rel="stylesheet" media="all" href="http://sysvit.com/chat/css/screen.css" />
<!--<link href="chat/emoticon/stylesheets/jquery.cssemoticons.css" media="screen" rel="stylesheet" type="text/css" />
<script src="chat/emoticon/javascripts/jquery.cssemoticons.min.js" type="text/javascript"></script>-->
<link type="text/css" rel="stylesheet" media="all" href="http://sysvit.com/chat/css/websymbols/stylesheet.css"/>
<link type="text/css" rel="stylesheet" media="all" href="http://sysvit.com/chat/emoticons/emoticon.css" />
<script type="text/javascript" src="http://sysvit.com/chat/js/chat.js"></script>
<script>
function emoticonize() {
var emoticons = {
  smile: '<img src="http://sysvit.com/chat/emoticons/face-smile.png" />',
  sad: '<img src="http://sysvit.com/chat/emoticons/face-sad.png" />',
  wink: '<img src="http://sysvit.com/chat/emoticons/face-wink.png" />',
  angel: '<img src="http://sysvit.com/chat/emoticons/face-angel.png" />',
  suprise: '<img src="http://sysvit.com/chat/emoticons/face-surprise.png" />',
  crying: '<img src="http://sysvit.com/chat/emoticons/face-crying.png" />',
  ngeledek: '<img src="http://sysvit.com/chat/emoticons/face-ngledek.png" />',
  smilebig: '<img src="http://sysvit.comS/chat/emoticons/face-smile-big.png" />',
  lunch: '<img src="http://sysvit.com/chat/emoticons/lunch.png" />',
  ok: '<img src="http://sysvit.com/chat/emoticons/ok.png" />',
  no: '<img src="http://sysvit.com/chat/emoticons/no.png" />',
  ok2: '<img src="http://sysvit.com/chat/emoticons/ok2.png" />',
  umb: '<img src="http://sysvit.com/chat/emoticons/umb.png" />',
  piss: '<img src="http://sysvit.com/chat/emoticons/piss.png" />',
  kanan: '<img src="http://sysvit.com/chat/emoticons/kanan.png" />',
  kiri: '<img src="http://sysvit.com/chat/emoticons/kiri.png" />',
  grin: '<img src="http://sysvit.com/chat/emoticons/face-grin.png" />'

};

var patterns = {
  angel: /o\)/gm,
  smile: /:\)/gm,
  sad: /:\(/gm,
  wink: /;\)/gm,
  suprise: /:O/gm,
  crying: /T_T/gm,
  smilebig: /:D/gm,
  ngeledek: /:p/gm,
  lunch: /@\=/gm,
  ok: /=b/gm,
  no: /=\?/gm,
  ok2: /@\)/gm,
  umb: /{=/gm,
  piss: /_v_/gm,
  kanan: /=6T/gm,
  kiri: /Z7=/gm,
  grin: /:B/gm 
  
};
$(document).ready(function() {
  $('.chatboxmessagecontent').each(function() {

  var $p = $(this);
  var html = $p.html();

  $p.html(html.replace(patterns.smile, emoticons.smile).
  replace(patterns.sad, emoticons.sad).
  replace(patterns.angel, emoticons.angel).
  replace(patterns.wink, emoticons.wink).
  replace(patterns.surprise, emoticons.surprise).
  replace(patterns.crying, emoticons.crying).
  replace(patterns.smilebig, emoticons.smilebig).
  replace(patterns.ngeledek, emoticons.ngeledek).
  replace(patterns.lunch, emoticons.lunch).
  replace(patterns.ok, emoticons.ok).
  replace(patterns.no, emoticons.no).
  replace(patterns.ok2, emoticons.ok2).
  replace(patterns.umb, emoticons.umb).
  replace(patterns.piss, emoticons.piss).
  replace(patterns.kanan, emoticons.kanan).
  replace(patterns.kiri, emoticons.kiri).
  replace(patterns.grin, emoticons.grin));  
 });
});
}
</script>
<script type="text/javascript">
    //base_url = 'http://sysvit.com/chatindex.php/';
   var  baseUrl = 'http://sysvit.com/chat/';
	var inFormOrLink;

$("a,:button,:submit").click(function () { inFormOrLink = true; });



$(":text").keydown(function (e) {    

    if (e.keyCode == 13) {
        inFormOrLink = true;
    } 
	else if (e.keyCode == 116) {
        inFormOrLink = true;
    }
})/// Sometime we submit form on pressing enter
$(window).keydown(function (e) {    

    if (e.keyCode == 13) {
        inFormOrLink = true;
    } 
	else if (e.keyCode == 116) {
        inFormOrLink = true;
    }
})	
	$(window).bind("unload", function () {if (!inFormOrLink) {
        $.ajax({
            type: 'POST',
            async: false,
            url: '<?php echo base_url()?>login/logout'

        });
	}
    
})

</script>
