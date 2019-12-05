<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class trucking_progress extends CI_Controller {
	
		var $utama ='trucking_progress';
		var $title ='Truck Progress';
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
	
	function main($id)
	{
		//Migrasi 1 Feb 14
		//permissionBiasa();
		//Set Global
		//permission();
		//$data = GetHeaderFooter();
		$data['content'] = 'contents/'.$this->utama.'/view';
		$data['jo']=GetValue('number','trucking_order',array('id'=>'where/'.$id));
		$data['js_grid']=$this->get_column($id);
		//$data['list']=GetAll($this->utama);
		
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function get_column($id){
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['create_date'] = array('Date',110,TRUE,'left',2);
            $colModel['location'] = array('Location',110,TRUE,'left',2);
            $colModel['vehicle_no'] = array('Vehicle No',110,TRUE,'left',2);
            $colModel['ttm'] = array('Tiba Tempat Muat',60,TRUE,'left',2);
            $colModel['ktm'] = array('Keluar Tempat Muat',60,TRUE,'left',2);
            $colModel['ss'] = array('Start Stuffing',60,TRUE,'left',2);
            $colModel['fs'] = array('Finish Stuffing',60,TRUE,'left',2);
            $colModel['bongkar'] = array('Bongkar',100,TRUE,'left',2);
            $colModel['ttb'] = array('Tiba Tempat Bongkar',60,TRUE,'left',2);
            $colModel['ktb'] = array('Keluar Tempat Bongkar',60,TRUE,'left',2);
            $colModel['keterangan'] = array('Keterangan',100,TRUE,'left',2);
           // $colModel['picture'] = array('Picture',100,TRUE,'left',2);
        
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
            $buttons[] = array('add','add','btn');
            $buttons[] = array('separator'); */
             $buttons[] = array('edit','edit','btn');
		$buttons[] = array('delete','delete','btn');
		$buttons[] = array('separator');
		$buttons[] = array('separator');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record/".$id),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid($id)
        {

            //Build contents query
            $this->db->select("*")->from($this->utama);
			$this->db->where('jo',$id);
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from($this->utama);
			$this->db->where('jo',$id);
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record($id){
		
		
		$jo=GetAll('trucking_order',array('id'=>'where/'.$id))->row_array();
		
		
		$valid_fields = array('id','code','name');

            $this->flexigrid->validate_post('id','DESC',$valid_fields);
            $records = $this->get_flexigrid($id);

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {
				$vno=$this->db->query("SELECT code FROM sv_master_truck WHERE id='".$jo['vehicle_no']."'")->row_array();
				$p=($row->picture==NULL ? '' : "<a href='".base_url('assets')."/ace/pictures/$row->picture' target='_blank'><img src='".base_url('assets')."/ace/pictures/$row->picture' width='100%'/></a>");
				/*
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}*/
				
                $record_items[] = array(
                $row->id,
                $row->id,
				$row->id,
                $row->create_date,
                $row->location,
				$vno['code'],
                $row->ttm,
                $row->ktm,
                $row->ss,
                $row->fs,
                $row->bongkar,
                $row->ttb,
                $row->ktb,
                $row->keterangan,
                $p
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
	
	function form($id=null,$jo=null){
		error_reporting(E_ALL);
			$data['val']['jo']=$jo;
		//permissionBiasa();
		$numbs=GetValue("number",'sv_trucking_order',array('id'=>'where/'.$jo));
		
		if( $id>0){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
			if(isset($_GET['prospek'])){
				$pros=GetAll('marketing_form_prospect',array('number'=>'where/'.$_GET['prospek']))->row_array();
				$data['val']['prospek']=$pros['id'];
				$data['val']['messers']=$pros['client'];
				$data['val']['loading']=$pros['from'];
				$data['val']['unloading']=$pros['to'];
			}
			//$numbs=GetValue("number",'sv_trucking_order',array('id'=>'where/'.$jo));lastq();
			$vs=$this->db->query("SELECT * FROM sv_marketing_form_prospect WHERE id='$jo'")->row_array();
			//lastq();
			$data['supir']=$vs['supir'];
			$data['tlp_supir']=$vs['tlp_supir'];
		}
		$data['opt']=GetOptAll('menu','-Parents-');
		$data['opt_client']=GetOptAll('master_client','-Client-',array('status'=>'where/1'),'name');
		$data['opt_trucking']=GetOptAll('master_trucking','-Service-',array(),'name');
		$data['opt_truck']=GetOptAll('master_truck','-Truck-',array(),'code');
		$data['opt_marketing']=GetOptAll('marketing_form_prospect','-prospect-',array(),'number');
		$data['content'] = 'contents/'.$this->utama.'/edit';
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
		
		##image nih
		
				for ($a=1;$a<=5;$a++){ 
		if (!empty($_FILES["picture$a"]['name'])) {
			$time=date('YmdHis');
			$config['upload_path'] = './assets/ace/pictures/';
			$config['allowed_types'] = 'gif|jpg|png|ico';
			$config['max_size']	= '10000';
			$config['max_width']  = '1900';
			$config['max_height']  = '1200';
			$config['file_name']=date("mdYiHs");
			
			$this->load->library('upload', $config);
			
			if($id != NULL && $id != ''){
			unlink('./assets/ace/pictures/'.GetValue("picture$a",'trucking_progress',array('id'=>'where/'.$id)));}
			
			if (!$this->upload->do_upload("picture$a")) {
				$upload_error = $this->upload->display_errors();
				//echo json_encode($upload_error);
			} else {
				
				$file_info = $this->upload->data();
				$file =  $file_info['full_path'];
				$data["picture$a"]=$file_info['file_name'];;
				//echo json_encode($file_info);
       		}
		}
				}
		##image nih
		
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
			//if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			generateaitrucking($data);
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		redirect($this->utama.'/main/'.$data['jo']);
		
	}
	function delete_photo($id,$field){
		
			unlink('./assets/ace/pictures/'.GetValue("$field",'trucking_progress',array('id'=>'where/'.$id)));
			$this->db->query("UPDATE sv_trucking_progress SET $field='' WHERE id='$id' ");
			redirect($this->utama.'/form/'.$id);
	}
	
}
?>