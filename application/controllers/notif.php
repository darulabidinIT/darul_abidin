<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class notif extends CI_Controller {
	
		var $utama ='notif';
		var $title ='Notification';
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
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['create_user_id'] = array('Sender',100,TRUE,'left',2);
            $colModel['to'] = array('Type',100,TRUE,'left',2);
            $colModel['type'] = array('Layanan',100,TRUE,'left',2);
            $colModel['message'] = array('Message',600,TRUE,'left',2);
            $colModel['status'] = array('Status',110,TRUE,'left',2);
            $colModel['create_date'] = array('Create date',110,TRUE,'left',2);
        
            $gridParams = array(
                'rp' => 25,
                'rpOptions' => '[10,20,30,40]',
                'pagestat' => 'Displaying: {from} to {to} of {total} items.',
                'blockOpacity' => 0.5,
                'title' => '',
                'showTableToggleBtn' => TRUE
		);
        
           /* $buttons[] = array('select','check','btn');
            $buttons[] = array('deselect','uncheck','btn');
            $buttons[] = array('separator');
            $buttons[] = array('add','add','btn');
            $buttons[] = array('separator');
             $buttons[] = array('edit','edit','btn');
            $buttons[] = array('delete','delete','btn');
            $buttons[] = array('separator'); */
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record"),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {
				$idwebmaster=$this->session->userdata('webmaster_grup');

            //Build contents query
            $this->db->select("*")->from($this->utama);
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
			
				if($idwebmaster==4){$this->db->where('to','Export');}
				if($idwebmaster==5){$this->db->where('Import');}
				if($idwebmaster==6){$this->db->where('Trucking');}
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from($this->utama);
				if($idwebmaster==4){$this->db->where('to','Export');}
				if($idwebmaster==5){$this->db->where('Import');}
				if($idwebmaster==6){$this->db->where('Trucking');}
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record(){
		
		$valid_fields = array('id','code','name');

            $this->flexigrid->validate_post('id','DESC',$valid_fields);
            $records = $this->get_flexigrid();

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {
				$sender=
                GetValue('name','admin_profile',array('useradmin'=>'where/'.$row->create_user_id));
				if($sender=='0'){$sender='SUPEARADMIN';}
					/*
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}*/
				
                $record_items[] = array(
                $row->id,
                $row->id,
				$row->id,
				$sender,
				$row->to,
				$row->type,
                $row->message,
                $row->status,
				$row->create_date
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
		permissionBiasa();
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
		$data['opt_exim_service']=GetOptAll('ref_service','-Type-',array('parent'=>"where/".'1,2'));
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
			$data['number']=generatenumbering('marketing');
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			
			addnumbering('marketing');
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		if($data['status']=='WIN'){
				$numbering=GetValue('number','marketing_form_prospect',array('id'=>'where/'.$id));
			$notif['from']=$webmaster_id;
			$notif['to']=GetValue('title','ref_service',array('id'=>'where/'.$data['service']));
			$notif['message']="Marketing telah menginput prospek berstatus WIN dengan no ".$numbering.". mohon segera diproses ";
			$notif['link']="";
			$notif['create_user_id'] = $webmaster_id;
			$notif['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_notif',$notif);		}
		//////////////////////////////// INPUT QUOTATION
		//print_mz($this->input->post());
		//$this->input->post('id')=0;
		
		if($this->input->post('tables')=="sv_quotation_exim_custom"){
			$post=$this->input->post('inpust');
			foreach($post as $dats){
				$GetColumns = GetColumns('sv_quotation_exim_custom');
				foreach($GetColumns as $r)
				{
					$quo[$r['Field']] = $dats[$r['Field']];
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
		}
		else{
			$GetColumns = GetColumns('sv_quotation_trucking_custom');
			foreach($GetColumns as $r)
			{
				$quo[$r['Field']] = $this->input->post($r['Field']);
				$quo[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
				
				if(!$quo[$r['Field']] && !$quo[$r['Field']."_temp"]) unset($quo[$r['Field']]);
				unset($quo[$r['Field']."_temp"]);
			}	
			unset($quo['id']);
			$quo['create_user_id'] = $webmaster_id;
			$quo['create_date'] = date("Y-m-d H:i:s");
			$quo['prospek']=$id;
			$this->db->insert('sv_quotation_trucking_custom',$quo);
		}
		////////////////////////////////////////////////////// END INPUT QUOTATION
		redirect($this->utama);
		
	}
	
}
?>