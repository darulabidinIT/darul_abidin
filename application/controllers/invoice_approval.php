<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class invoice_approval extends CI_Controller {
	
		var $utama ='invoice';
		var $title ='Invoice Approval';
	function __construct()
	{
		parent::__construct();permissionBiasa();
		$this->load->library('flexigrid');
        $this->load->helper('flexigrid');
	error_reporting(0);
	}
	
	function index()
	{
		$this->main();
	}
	
	function main($id)
	{
		
		$group = $this->session->userdata('webmaster_grup');
			if(!$id){
				if($group=='4' || $group=='5' || $group=='6' || $group=='8' || $group=='9' || $group=='10' ) redirect('forbidden');
					}
		//Migrasi 1 Feb 14
		permissionBiasa();
		//Set Global
		//permission();
		//$data = GetHeaderFooter();
		//$data['job_order']=GetValue('number','sv_import_sea_job',array('id'=>'where/'.$id));
		//$q=$this->db->query("SELECT SUM(b_subtotal) as sales,SUM(c_subtotal) as cost FROM sv_import_ai WHERE job_order='".$data['job_order']."'")->row_array();
		
		//$data['sales']=$q['sales'];
		//$data['cost']=$q['cost'];
		//$data['profit']=$q['sales']-$q['cost'];	
		$data['content'] = 'contents/'.$this->utama.'_approval/view';
		
		$data['js_grid']=$this->get_column($id);
		//$data['list']=GetAll($this->utama);
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function get_column($id){
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
			$colModel['jo'] = array('Job Order / PO',110,TRUE,'left',2);/* 
			$colModel['shipper'] = array('Shipper / Messers',200,TRUE,'left',2);
			$colModel['consignee'] = array('Consignee',200,TRUE,'left',2); */
			$colModel['number'] = array('Invoice',200,TRUE,'left',2);
			$colModel['total'] = array('Total',110,TRUE,'left',2);
			$colModel['status'] = array('Status',110,TRUE,'left',2);
			$colModel['generate'] = array('Approval Status',110,TRUE,'left',2);
			$colModel['last_pay'] = array('Allow To Generate?',110,TRUE,'left',2);
			//if(!$id || $id=='trucking')$colModel['action'] = array('Aksi',110,TRUE,'left',2);
        
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE
		);
        
           $buttons[] = array('select','check','btn');
            $buttons[] = array('deselect','uncheck','btn');
            $buttons[] = array('separator');/* 
           // $buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
            // $buttons[] = array('edit','edit','btn');
            $buttons[] = array('delete','delete','btn');
		$buttons[] = array('separator');
		$buttons[] = array('detail','detail','btn');
		if(webmastergrup() ==7 || webmastergrup() == '2706')$buttons[] = array('pay','pay','btn');
		if($id== 'trucking')$buttons[] = array('edit kewill','pay','btn'); */
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."_approval/get_record/".$id),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid($id)
        {

            //Build contents query
            $this->db->select("*")->from($this->utama);
			//$this->db->where(array('type'=>'AR'));
			$this->db->where(array('latest'=>'1','type'=>'AR','div <> '=>'trucking'));
			
			//if($id) $this->db->where(array('div'=>$id));
			$this->db->order_by('create_date','DESC');
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();
			//lastq();
            //Build count query
            $this->db->select("count(id) as record_count")->from($this->utama);
			//$this->db->where(array('type'=>'AR'));
			$this->db->where(array('latest'=>'1','type'=>'AR','div <> '=>'trucking'));
			//if($id) $this->db->where(array('div'=>$id));
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record($id){
		
		$valid_fields = array('id','number','create_date');
            $this->flexigrid->validate_post('create_date','DESC',$valid_fields);
            $records = $this->get_flexigrid($id);

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {
			/*	$shipper=$consignee='';
				
		$div=$row->div;
		$jo=$row->jo;
		$num=$row->number;
				
				if($div!='trucking'){
			$joborder=$this->db->query(" SELECT * FROM sv_export_air_job WHERE number='$jo'");
			if($joborder->num_rows()==0){
				
				$joborder=$this->db->query(" SELECT * FROM sv_export_sea_job WHERE number='$jo'");
				if($joborder->num_rows()==0){
					
					$joborder=$this->db->query(" SELECT * FROM sv_import_air_job WHERE number='$jo'");
					if($joborder->num_rows()==0){
				
						$joborder=$this->db->query(" SELECT * FROM sv_import_sea_job WHERE number='$jo'");
						
					}
				}
			}
			$detail=$joborder->row_array();
						$shipper=GetValue('name','master_client',array('id'=>'where/'.$detail['shipper']));
						//lastq();
						$consignee=GetValue('name','master_client',array('id'=>'where/'.$detail['consignee']));
			
		}
		else{
						$joborder=$this->db->query(" SELECT * FROM sv_trucking_order WHERE number='$jo'");
						$inv_detail=$this->db->query(" SELECT * FROM sv_invoice_detail WHERE invoice='$num'")->row_array();
						$jo=$inv_detail['jo'];
						$potong=explode('/',$num);
						$shipper=GetValue('name','master_client',array('code'=>'where/'.$potong[2]));
						$consignee='-';
		}
				
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}*/
			if($row->div=='trucking'){
				$po=$row->po;
			}else{
				$po=$row->jo;
			}
			$statuschek=($row->generate=='Accept' ? 'checked' : '');
			$check="<input type='checkbox' name='approval' id='approval' $statuschek onClick='gantiallow($row->id)' >";
			$color=($row->generate=='Accept' ? 'green' : 'red');
				
                $record_items[] = array(
                $row->id,
                $row->id,
                $row->id,
                $po,/* 
                $shipper,
                $consignee, */
                $row->number,
                uang($row->total),
                $row->status,
                '<span style="color:'.$color.'">'.$row->generate.'<span>',
                $check
                        );
            }

            return $this->output->set_output($this->flexigrid->json_build($records['record_count'],$record_items));;
	}  

	function deletec()
	{		
		//return true;
		$countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
			/*if (is_numeric($country_id) && $country_id > 0) {
				$this->delete($country_id);}*/
				$inv=GetValue('number','invoice',array('id'=>'where/'.$country_id));
			$this->db->delete($this->utama,array('id'=>$country_id));	

			$this->db->delete('invoice_detail',array('invoice'=>$inv));				
		}
		//$error = "Selected countries (id's: ".$this->input->post('items').") deleted with success. Disabled for demo";
		//echo "Sukses!";
	}
	
	function form($id=null,$job){
		
		permissionBiasa();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
		//echo $job;
		$data['job_order']=$job;
		$data['opt']=GetOptAll('menu','-Parents-');
		$data['content'] = 'contents/'.$this->utama.'/edit';
		$data['opt_client']=GetOptAll('master_client','-Client-',array('status'=>'where/1'),'name');
		$data['opt_port']=GetOptAll('master_airport','-Airport-',array(),'name');
		$data['opt_airline']=GetOptAll('master_airline','-Airline-',array(),'name');
		$data['opt_metric']=GetOptAll('master_metric','-metric-',array(),'code');
		$data['opt_marketing']=GetOptAll('marketing_form_prospect','-prospect-',array(),'number');
		$data['opt_acc']=GetOptAll('setup_account_mapping','-Account-',array(),'code');
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	function detail($id=null,$job=NULL){
		
		permissionBiasa();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
		//echo $job;
		$data['job_order']=$job;
		$data['opt']=GetOptAll('menu','-Parents-');
		$data['content'] = 'contents/'.$this->utama.'/detail';
		$data['opt_client']=GetOptAll('master_client','-Client-',array('status'=>'where/1'),'name');
		$data['opt_port']=GetOptAll('master_airport','-Airport-',array(),'name');
		$data['opt_airline']=GetOptAll('master_airline','-Airline-',array(),'name');
		$data['opt_metric']=GetOptAll('master_metric','-metric-',array(),'code');
		$data['opt_marketing']=GetOptAll('marketing_form_prospect','-prospect-',array(),'number');
		$data['opt_acc']=GetOptAll('setup_account_mapping','-Account-',array(),'code');
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function submit(){
		$webmaster_id=$this->session->userdata('webmaster_id');
		$id = $this->input->post('id');
		$GetColumns = GetColumns('sv_'.$this->utama);
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
			
			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		
		/* if(!$this->input->post('global')){$data['global']='N';}
		else{$data['global']='Y';}  */
		
		if($id != NULL && $id != '')
		{
				
			/* if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));} */
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
				//$data['job_order']=generatenumbering('import-'.$data['form'],'import','air',$data['form']);
			//if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			//addnumbering('import-'.$data['form']);
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		$id=GetValue('id','sv_import_sea_job',array('number'=>'where/'.$this->input->post('job_order')));
		redirect($this->utama.'/main/'.$id);
		
	}
	function changeapp(){
		$id=$_REQUEST['v'];
		$kini=GetValue('generate','sv_invoice',array('id'=>'where/'.$id));
		$ganti=($kini=='Accept' ? 'Reject' : 'Accept');
		$this->db->where('id',$id);
		$this->db->update('sv_invoice',array('generate'=>$ganti));
		
	}
}
?>