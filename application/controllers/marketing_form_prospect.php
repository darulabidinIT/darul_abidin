<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class Marketing_form_prospect extends CI_Controller {
	
		var $utama ='marketing_form_prospect';
		var $title ='Marketing Form Prospect';
	function __construct()
	{
		parent::__construct();
		//permissionBiasa();
		$this->load->library('flexigrid');
        $this->load->helper('flexigrid');
error_reporting(0);
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{
		//Migrasi 1 Feb 14
		//permissionBiasa();
		//Set Global
		//permission();
		//$data = GetHeaderFooter();
		$data['content'] = 'contents/'.$this->utama.'/view';
		
		$data['js_grid']=$this->get_column();
		//$data['list']=GetAll($this->utama);
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function get_column(){
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',7,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',7,TRUE);
            $colModel['number'] = array('Number',110,TRUE,'left',2);
            $colModel['name'] = array('Client',110,TRUE,'left',2);
            $colModel['service'] = array('Service',110,TRUE,'left',7);
            $colModel['type'] = array('Type',110,TRUE,'left',7);
            $colModel['status'] = array('Status',110,TRUE,'left',7);
            $colModel['create_date'] = array('Create date',110,TRUE,'left',7);
            $colModel['quotation'] = array('Quotation',110,TRUE,'left',7);
        
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
            $buttons[] = array('separator');
            $buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
             $buttons[] = array('edit','edit','btn');
            $buttons[] = array('delete','delete','btn');
			if($this->session->userdata('webmaster_grup')=='2706' || $this->session->userdata('webmaster_grup')=='6' || $this->session->userdata('webmaster_grup')=='8' || $this->session->userdata('webmaster_grup')=='10'  ){
				$buttons[] = array('separator');
				$buttons[] = array('Input Progress','truck','btn');
				$buttons[] = array('View Progress','truck','btn');
			}
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record"),$colModel,"",'',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {
			//echo webmastergrup();
			if(webmastergrup()==4 ||webmastergrup()==5 ||webmastergrup()==6 ||webmastergrup()==8 ||webmastergrup()==10){
				if(webmastergrup()==4){$div='1';}
				elseif(webmastergrup()==5){$div='2';}
				elseif(webmastergrup()==6 ||webmastergrup()==8 ||webmastergrup()==10 ){$div='3';}
			}
            //Build contents query
            $this->db->select("$this->utama.id as id, $this->utama.number as number, $this->utama.service as service, $this->utama.type as type,  $this->utama.status as status,  $this->utama.quotation as quotation,  $this->utama.create_date as create_date, sv_master_client.name as client ")->from($this->utama);
			if(webmastergrup()!='2706'){
				$this->db->where($this->utama.'.create_user_id',$this->session->userdata('webmaster_id'));
				$this->db->where($this->utama.'.service',$div);
			}
			
			$this->db->join('sv_master_client', 'sv_master_client.id = sv_marketing_form_prospect.client', 'left');
			$this->db->order_by("$this->utama.create_date",'DESC');
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
            $this->flexigrid->build_query();
			
            //Get contents
            $return['records'] = $this->db->get();
			
			//lastq();
            //echo $this->db->last_query();
			//Build count query
            $this->db->select("count(sv_$this->utama.id) as record_count, $this->utama.id as id, $this->utama.number as number, $this->utama.service as service, $this->utama.type as type,  $this->utama.status as status, $this->utama.quotation as quotation,  $this->utama.create_date as create_date, sv_master_client.name as client ")->from($this->utama);
			if(webmastergrup()!='2706'){
				$this->db->where($this->utama.'.create_user_id',$this->session->userdata('webmaster_id'));
				$this->db->where($this->utama.'.service',$div);
			}
			$this->db->join('sv_master_client', 'sv_master_client.id = sv_marketing_form_prospect.client', 'left');
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record(){
		
		$valid_fields = array('id','number','name','service','type','status');

            $this->flexigrid->validate_post("$this->utama.create_date",'DESC',$valid_fields);
            $records = $this->get_flexigrid();

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {/*
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}*/
			if($row->quotation==NULL){$quo='<span style="color:red">N/A</span>';}
			else{$quo='<a style="color:green" href="'.base_url('assets').'/ace/xls/'.$row->quotation.'">Download</span>';}
				
                $record_items[] = array(
                $row->id,
                $row->id,
				$row->id,
                $row->number,
				$row->client,
                GetValue('title','ref_service',array('id'=>'where/'.$row->service)),
                GetValue('title','ref_service',array('id'=>'where/'.$row->type)),
                str_replace('ONGOING','IN PROGRESS',$row->status),
				$row->create_date,
				$quo
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
			$this->db->delete($this->utama,array('id'=>$country_id));				
		}
		//$error = "Selected countries (id's: ".$this->input->post('items').") deleted with success. Disabled for demo";
		//echo "Sukses!";
	}
	
	function form($id=null){
			//echo $this->session->flashdata('clientbaru');
		error_reporting(E_ALL);
		//permissionBiasa();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
		//$data['opt']=GetOptAll('menu','-Parents-');
		$data['opt_service']=GetOptAll('ref_service','-Service-',array('parent'=>'where/0'),'');
		$data['opt_client']=GetOptAll('master_client','-Client-',array('status'=>'where/1'),'name');
		$data['opt_marketing']=GetOptAll('master_sales','-Marketing-',array(),'name');
		$data['opt_exim_service']=GetOptAll('ref_service','-Type-',array('parent'=>"where/".'1,2'),'');
		$data['opt_trucking']=GetOptAll('master_trucking','-Service-',array(),'name');
		$data['opt_truck']=GetOptAll('master_truck','-Truck-',array(),'code');
		//lastq();
		$data['seaport']=GetAll('master_seaport')->result();
		$data['airport']=GetAll('master_airport')->result();
		
		$data['loc']=array();
		$location=GetAll('sv_quotation_trucking_default')->result();
		foreach($location as $lokasi){
				if(!in_array($lokasi->location,$data['loc'])){
						$data['loc'][]=$lokasi->location;
				}
		}
		
		$location=GetAll('sv_quotation_trucking_custom')->result();
		foreach($location as $lokasi){
			if(!in_array($lokasi->location,$data['loc'])){
				$data['loc'][]=$lokasi->location;
			}
		}

		$data['content'] = 'contents/'.$this->utama.'/edit';
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function submit(){
			//print_mz($this->input->post());
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
		
		//print_mz($data);
		/* if(!$this->input->post('global')){$data['global']='N';}
		else{$data['global']='Y';} */  
		
		##image nih
		if (!empty($_FILES['quotation']['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/ace/xls/';
			$config['allowed_types'] = 'xls|xlsx';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			if($id != NULL && $id != ''){
			unlink('./assets/ace/xls/'.GetValue('quotation','marketing_form_prospect',array('id'=>'where/'.$id)));}
			
			if (!$this->upload->do_upload('quotation')) {
				$upload_error = $this->upload->display_errors();
				//echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				$type=(substr($file,-4)=='xlsx' ? '.xlsx' : '.xls');
				
				
				$data['quotation']=$config['file_name'].$type;
				//echo json_encode($file_info);
       		}
		}
		##image nih
		
		if($data['service']==3){
			$numbs='trucking';
		}else{
			$numbs='marketing';
		}
		
		
		if($id != NULL && $id != '')
		{
			// if(!$this->input->post('password')){unset($data['password']);} else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));} 
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
			//if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['number']=generatenumbering($numbs);
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			
			addnumbering($numbs);
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		if($data['status']=='WIN'){
				$numbering=GetValue('number','marketing_form_prospect',array('id'=>'where/'.$id));
				$reftype=GetValue('title','ref_service',array('id'=>'where/'.$data['type']));
			$notif['from']=$webmaster_id;
			$notif['to']=GetValue('title','ref_service',array('id'=>'where/'.$data['service']));
			$notif['type']=GetValue('title','ref_service',array('id'=>'where/'.$data['type']));
			$bag=strtolower($notif['to']);
			if($bag=='trucking'){$layanan='trucking_order';
			$link=$layanan.'/form/?prospek='.$numbering;
			}
			else{
				$type=strtolower(substr($reftype,0,3));
				$layanan=$bag.'_'.$type.'_job';
					if($type=='sea'){
					$servicess=substr($reftype,-3);
					}
					else{
						$servicess='LCL';
					}
				
			$link=$layanan.'/form/?prospek='.$numbering.'&type=CC&service='.$servicess;
			}
			
			$notif['message']="Marketing telah menginput prospek berstatus WIN dengan no ".$numbering.". mohon segera diproses ";
			$notif['prospek']=$numbering;
			$notif['link']=$link;
			$notif['create_user_id'] = $webmaster_id;
			$notif['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_notif',$notif);		}
		//////////////////////////////// INPUT QUOTATION
		//print_mz($this->input->post());
		//$this->input->post('id')=0;
		
		
		if($this->input->post('tables')=="sv_quotation_exim_custom"){
	
		$this->db->query("DELETE FROM sv_quotation_exim_custom WHERE prospek='$id'");		
			$post=$this->input->post('inpust');
			foreach($post as $dats){
				$GetColumns = GetColumns('sv_quotation_exim_custom');
				foreach($GetColumns as $r)
				{
					$quo[$r['Field']] = str_replace(',','',$dats[$r['Field']]);
					$quo[$r['Field']."_temp"] = $dats[$r['Field']."_temp"];
					
					if(!$quo[$r['Field']] && !$quo[$r['Field']."_temp"]) unset($quo[$r['Field']]);
					unset($quo[$r['Field']."_temp"]);
				}
				unset($quo['id']);
				$quo['create_user_id'] = $webmaster_id;
				$quo['create_date'] = date("Y-m-d H:i:s");
				$quo['prospek']=$id;
				$this->db->insert('sv_quotation_exim_custom',$quo);
			}
		}/* 
		else{
			
				$this->db->query("DELETE FROM sv_quotation_trucking_custom WHERE prospek='$id'");
			$GetColumns = GetColumns('sv_quotation_trucking_custom');
			foreach($GetColumns as $r)
			{
				$quo[$r['Field']] = str_replace(',','',$this->input->post($r['Field']));
				$quo[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
				
				if(!$quo[$r['Field']] && !$quo[$r['Field']."_temp"]) unset($quo[$r['Field']]);
				unset($quo[$r['Field']."_temp"]);
			}	
			unset($quo['id']);
			$quo['create_user_id'] = $webmaster_id;
			$quo['create_date'] = date("Y-m-d H:i:s");
			$quo['prospek']=$id;
			$this->db->insert('sv_quotation_trucking_custom',$quo);
		} */
		////////////////////////////////////////////////////// END INPUT QUOTATION
		redirect($this->utama);
		
	}
	
}
?>