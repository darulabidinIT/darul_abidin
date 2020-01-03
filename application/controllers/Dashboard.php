<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : November 2019
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.3.1.1
*************************************/	

class Dashboard extends CI_Controller {
	var $utama ='dashboard';
	function __construct()
	{
		parent::__construct();
		 permissionz('v');
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{
            
		//Set Global
		//$data = GetHeaderFooter();
		$data['content'] = 'contents/'.$this->utama.'/view';
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
function visitors(){
$charts='<chart caption="Temperature Monitoring (in degree C) on on 7/9/2013" xaxisname="Time" yaxismaxvalue="100" linecolor="008ee4" anchorsides="3" anchorradius="5" plotgradientcolor=" " bgcolor="FFFFFF" showalternatehgridcolor="0" showplotborder="0" showvalues="0" divlinecolor="666666" showcanvasborder="0" canvasborderalpha="0" >
<set label="0" value="34" />
<set label="3" value="27" />
<set label="6" value="42" />
<set label="9" value="50" />
<set label="12" value="68" />
<set label="15" value="56" />
<set label="18" value="48" />
<set label="21" value="34" />
<set label="24" value="30" />
<trendlines>
<line startvalue="80" endvalue="100" displayvalue="Critical" color="008ee4" istrendzone="1" showontop="0" alpha="35" valueonright="1" />
<line startvalue="60" endvalue="80" displayvalue="Warning" color="33bdda" istrendzone="1" showontop="0" alpha="35" valueonright="1" />
</trendlines>
</chart>';	
echo $charts;
}	
	
}
?>