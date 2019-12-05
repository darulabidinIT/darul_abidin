<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class costing_truck extends CI_Controller {
	
		var $utama ='costing_truck';
		var $title ='Costing Truck';
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
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',7,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',7,TRUE);
            $colModel['number'] = array('Code',110,TRUE,'left',2);
            $colModel['t2.name'] = array('Vendor',110,TRUE,'left',2);
            $colModel['coa'] = array('COA',110,TRUE,'left',2);
            $colModel['invoice'] = array('Invoice',110,TRUE,'left',2);
            $colModel['period'] = array('Periode',110,TRUE,'left',2);
        
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
            $buttons[] = array('separator');
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record"),$colModel,'','',$gridParams,$buttons);
	}
	
	function get_flexigrid()
        {

            //Build contents query
            $this->db->select("t1.id id, t1.number number, t1.coa coa, t1.invoice invoice,t1.period period, t2.name vendor")->from($this->utama.' t1');
			$this->db->join('sv_master_vendor t2', "t2.id=t1.vendor", 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(t1.id) as record_count")->from($this->utama.' t1');
			$this->db->join('sv_master_vendor t2', "t2.id=t1.vendor", 'left');
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record(){
		
		$valid_fields = array('id','number','t2.name','coa','invoice','period');

            $this->flexigrid->validate_post('t1.id','DESC',$valid_fields);
            $records = $this->get_flexigrid();

            $this->output->set_header($this->config->item('json_header'));

            $record_items = array();

            foreach ($records['records']->result() as $row)
            {/*
			if($row->status=='y'){$status='Aktif';}
			elseif($row->status=='n'){$status='Tidak Aktif';}
			elseif($row->status=='s'){$status='Suspended';}*/
				
                $record_items[] = array(
                $row->id,
                $row->id,
				$row->id,
                $row->number,
               $row->vendor,
				$row->coa,
				$row->invoice,
				$row->period
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
		
		permissionBiasa();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll($this->utama,$filter);
		}
		else{
			$data['type']='New';
		}
		$data['opt']=GetOptAll('menu','-Parents-');
		$data['content'] = 'contents/'.$this->utama.'/edit';
		$data['opt_coa']=GetOptAll('setup_coa','-Account-',array('level >'=>'where/1'),'code','code','name');
		$data['opt_vendor']=GetOptAll('master_vendor','-Vendor-',array(),'name');
		$data['opt_invoice']=GetOptAll('invoice','-Invoice-',array('div'=>'where/trucking'),'number','number');
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
		$data['period']=$data['period'].'-01';
		
		//$data['amount']=str_replace(',','',$data['amount']);
		/* if(!$this->input->post('global')){$data['global']='N';}
		else{$data['global']='Y';}  */
		
		if($id != NULL && $id != '')
		{
			//if(!$this->input->post('password')){unset($data['password']);}
			//else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));} 
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_'.$this->utama, $data);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
			$data['number']=generatenumbering('costing');
			//if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			addnumbering('costing');
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		$cost=$this->input->post('amount');
		$truck=$this->input->post('truck');
		$a=0;
		foreach($cost as $abis){
			$costing['amount']=str_replace(',','',$abis);
			$costing['truck']=$truck[$a];
			$costing['id_cos']=$id;
			$costing['akun']=$data['coa'];
			
			$this->db->insert('sv_costing_truck_detail',$costing);
			$a++;
		}
		//print_mz($)
		
		redirect('cash_ledger/form/'.$id.'/costing_truck/');
		
	}
	function setvendor(){
		$id=$_REQUEST['id'];
		if($id!=1){
			$this->load->view('contents/costing_truck/pinjam');
		}else{
			$data['truck']=$this->db->query("SELECT * FROM sv_master_truck WHERE milik='sendiri'")->result_array();
			$this->load->view('contents/costing_truck/sendiri',$data);
		}
		
	}
	
}
?>