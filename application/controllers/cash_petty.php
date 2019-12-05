<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class cash_petty extends CI_Controller {
	
		var $utama ='cash_petty';
		var $title ='Petty Master';
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
		$q=NULL;
			if(isset($_GET['q'])){
				$q=htmlentities(mysql_real_escape_string($_GET['q']));
			}
		//Migrasi 1 Feb 14
		//permissionBiasa();
		//Set Global
		//permission();
		//$data = GetHeaderFooter();
		$data['content'] = 'contents/'.$this->utama.'/view';
		
		$data['js_grid']=$this->get_column($q);
		//$data['list']=GetAll($this->utama);
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function get_column($q){
	
            $colModel['idnya'] = array('ID',50,TRUE,'left',2,TRUE);
            $colModel['id'] = array('ID',100,TRUE,'left',2,TRUE);
            $colModel['code'] = array('Code',110,TRUE,'left',2);
            $colModel['ref'] = array('Refferal',110,TRUE,'left',2);
            $colModel['amount'] = array('Amount',110,TRUE,'left',2);
            $colModel['person'] = array('Person',110,TRUE,'left',2);
            $colModel['remark'] = array('Remark',110,TRUE,'left',2);
            $colModel['from'] = array('From',110,TRUE,'left',2);
            $colModel['save_type'] = array('Save Type',110,TRUE,'left',2);
        
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
		
            return $grid_js = build_grid_js('flex1',site_url($this->utama."/get_record/".$q),$colModel,'id','asc',$gridParams,$buttons);
	}
	
	function get_flexigrid($q)
        {

            //Build contents query
            $this->db->select("*")->from($this->utama);
			if($q!=NULL){
				$q=htmlentities(mysql_real_escape_string($q));
				$where="save_type LIKE '%$q%' OR number LIKE '%$q%' OR amount LIKE '%$q%' OR ref LIKE '%$q%' OR coa LIKE '%$q%' OR remark LIKE '%$q%' OR person LIKE '%$q%' OR `from` LIKE '%$q%' ";
				$this->db->where($where);
			}
			//lastq();
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from($this->utama);
			if($q!=NULL){
				$q=htmlentities(mysql_real_escape_string($q));
				$where="save_type LIKE '%$q%' OR number LIKE '%$q%' OR amount LIKE '%$q%' OR ref LIKE '%$q%' OR coa LIKE '%$q%' OR remark LIKE '%$q%' OR person LIKE '%$q%' OR `from` LIKE '%$q%' ";
				$this->db->where($where);
			}
            $this->flexigrid->build_query(FALSE);
            $record_count = $this->db->get();
            $row = $record_count->row();

            //Get Record Count
            $return['record_count'] = $row->record_count;

            //Return all
            return $return;
        }
	
	function get_record($q){
		
		$valid_fields = array('id','code','name');

            $this->flexigrid->validate_post('id','DESC',$valid_fields);
            $records = $this->get_flexigrid($q);

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
				$row->ref,
				uang($row->amount),
				$row->person,
				$row->remark,
				$row->from,
				$row->save_type
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
		$data['opt_from']=GetOptAll('ref_petty','-From-',array(),'name','name');
		$data['opt_curr']=GetOptAll('master_currency','-currency-',array(),'code');
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
		//konversi mata uang
		$data['amount']=str_replace(',','',$data['amount']);
		$data['rv']=$data['amount'];
		$data['kurs']=getkurs($data['rc']);
		$data['amount']=$data['rv']*$data['kurs'];
		//--------konversi mata uang
		
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
			$data['number']=generatenumbering('petty'.$webmaster_id);
			//if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_'.$this->utama, $data);
			$id = $this->db->insert_id();
			addnumbering('petty'.$webmaster_id);
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		redirect($this->utama);
		
	}
	function cekvoucher(){
	

/* RECEIVE VALUE */
$validateValue=mysql_real_escape_string($_GET['fieldValue']);
$validateId=mysql_real_escape_string($_GET['fieldId']);

$validateError= "Data dengan no ini telah di input";
$validateSuccess= "Data dengan no ini di input";
$a=$this->db->query("SELECT id FROM sv_cash_petty WHERE $validateId='$validateValue'")->num_rows();
if($a==0){$lanjut=TRUE;}
else{$lanjut=FALSE;}



	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;

if($lanjut){		// validate??
	$arrayToJs[1] = true;			// RETURN TRUE
	echo json_encode($arrayToJs);			// RETURN ARRAY WITH success
}else{
	for($x=0;$x<1000000;$x++){
		if($x == 990000){
			$arrayToJs[1] = false;
			echo json_encode($arrayToJs);		// RETURN ARRAY WITH ERROR
		}
	}
	
}

	}
	
	
}
?>