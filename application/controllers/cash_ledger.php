<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created : May 2015
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.0
*************************************/	

class cash_ledger extends CI_Controller {
	
		var $utama ='cash_ledger';
		var $tbl="sv_jurnal";
		var $title ='Ledger Master';
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
            $colModel['code'] = array('code',110,TRUE,'left',2);
            $colModel['ref'] = array('Refferal',110,TRUE,'left',2);
            $colModel['post_tgl'] = array('Post Date',110,TRUE,'left',2);
            $colModel['doc_tgl'] = array('Doc Date',110,TRUE,'left',2);
            $colModel['voucher'] = array('Job Number',110,TRUE,'left',2);
            $colModel['rincian'] = array('Rincian',110,TRUE,'left',2);
        
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
            $this->db->select("*")->from($this->tbl);
			if($q!=NULL){
				$q=htmlentities(mysql_real_escape_string($q));
				$where="number LIKE '%$q%' OR ref LIKE '%$q%' OR post_tgl LIKE '%$q%' OR doc_tgl LIKE '%$q%' OR ket LIKE '%$q%' OR voucher LIKE '%$q%' OR rincian LIKE '%$q%'";
				$this->db->where($where);
			}
			//$this->db->join('rb_customer', "$this->tabel.id_customer=rb_customer.id", 'left');
            $this->flexigrid->build_query();

            //Get contents
            $return['records'] = $this->db->get();

            //Build count query
            $this->db->select("count(id) as record_count")->from($this->tbl);
			if($q!=NULL){
				$q=htmlentities(mysql_real_escape_string($q));
				$where="number LIKE '%$q%' OR ref LIKE '%$q%' OR post_tgl LIKE '%$q%' OR doc_tgl LIKE '%$q%' OR ket LIKE '%$q%' OR voucher LIKE '%$q%' OR rincian LIKE '%$q%'";
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
		
		$valid_fields = array('id','code','ref','voucher');

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
                $row->post_tgl,
                $row->doc_tgl,
                $row->voucher,
                $row->rincian,
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
			$this->db->delete($this->tbl,array('id'=>$country_id));				
		}
		//$error = "Selected countries (id's: ".$this->input->post('items').") deleted with success. Disabled for demo";
		//echo "Sukses!";
	}
	function delete_ledger()
	{		
		
		$this->db->delete('sv_jurnal_detail',array('id'=>$this->input->post('items')));	
		//return true;
		/* $countries_ids_post_array = explode(",",$this->input->post('items'));
		array_pop($countries_ids_post_array);
		foreach($countries_ids_post_array as $index => $country_id){
			/*if (is_numeric($country_id) && $country_id > 0) {
				$this->delete($country_id);}*
		} */
		//$error = "Selected countries (id's: ".$this->input->post('items').") deleted with success. Disabled for demo";
		//echo "Sukses!";
	}
	
	function form($id=null,$type=null,$id_detail=null){
		
		permissionBiasa();
		if($id!=NULL){
			$filter=array('id'=>'where/'.$id);
			$data['type']='Edit';
			$data['list']=GetAll('sv_jurnal',$filter);
		}
		else{
			$data['type']='New';
			
		}
		//mindate
		$skr=date('d');
			$bln=date('m');
			$yr=date('Y');
			if((int)$skr==1 && (int)$skr <= 15){
				if((int)$bln==1){
					$bln=12;
					$yr=(int)$yr-1;
					}
				else{
					$bln=(int)$bln-1;
				}
			}
			$data['mindate']=$yr.'-'.$bln.'-01';
		
		//mindate
		
		$data['idnya']=$id;
		$data['opt']=GetOptAll('menu','-Parents-');
		$data['detail']=GetAll('sv_jurnal_detail',array('id_jur'=>'where/'.$id))->result_array();
		$data['content'] = 'contents/'.$this->utama.'/edit';
		$data['opt_coa']=GetOptAll('setup_coa','-Account-',array('level >'=>'where/1'),'code','code','name');
		$data['opt_curr']=GetOptAll('master_currency','-currency-',array(),'code');
		if($type!=NULL && $type=='payment'){
			$data['pay']=1;
			$data['list']=GetAll('sv_invoice',$filter);
			$noinv=GetValue('number','sv_invoice',array('id'=>'where/'.$id));
			$data['detail']=$this->db->query("SELECT * FROM sv_invoice_detail WHERE invoice='$noinv'")->result_array();
			$data['utamas']=$this->db->query("SELECT * FROM sv_payment WHERE id='$id_detail'")->row_array();
		}
		else if($type!=NULL && $type=='costing_truck'){
			$data['costruck']=1;
			$data['list']=GetAll('sv_costing_truck',$filter);
			$noinv=GetValue('number','sv_invoice',array('id'=>'where/'.$id));
			$data['detail']=$this->db->query("SELECT * FROM sv_costing_truck_detail WHERE id_cos='$id'")->result_array();
			$co=$this->db->query("SELECT SUM(amount) as tot FROM sv_costing_truck_detail WHERE id_cos='$id'")->row_array();
			$data['utamas']=array(
			'amount'=>$co['tot']
			);
			//$data['utamas']=$this->db->query("SELECT * FROM sv_payment WHERE id='$id_detail'")->row_array();
		}
		
		//End Global
		
		//Attendance
		
		$this->load->view('layout/main',$data);
	}
	
	function submit(){
		//print_mz($this->input->post());
		
		$webmaster_id=$this->session->userdata('webmaster_id');
		$id = $this->input->post('id');
		$GetColumns = GetColumns('sv_jurnal');
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
			
			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		if($this->input->post('pay')){
			$id='';
		}
		//print_mz();
		/* if(!$this->input->post('global')){$data['global']='N';}
		else{$data['global']='Y';}  */
		
		if($id != NULL && $id != '')
		{
			/* if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));} */
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_jurnal', $data);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
			$data['number']=generatenumbering('ledger');
			//if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_jurnal', $data);
			$id = $this->db->insert_id();
			addnumbering('ledger');
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		$jur=$this->input->post('idj');
		$rc=$this->input->post('rc');
		$akun=$this->input->post('akun');
		$debit=$this->input->post('debit');
		$kredit=$this->input->post('kredit');
		$remark=$this->input->post('remark');
		$ref=$this->input->post('refer');
		$a=0;
	//	print_mz($this->input->post());
		foreach($jur as $idj){
			
			$djur['id_jur']=$id;
			$djur['akun']=$akun[$a];
			$djur['rc']=$rc[$a];
			
		//konversi mata uang
			$djur['debit']=str_replace(',','',$debit[$a]);
			$djur['kredit']=str_replace(',','',$kredit[$a]);
			$djur['rv']=$djur['debit']+$djur['kredit'];
			$djur['kurs']=getkurs($djur['rc']);
			$djur['debit']=$djur['debit']*$djur['kurs'];
			$djur['kredit']=$djur['kredit']*$djur['kurs'];
		//--------konversi mata uang
			
			$djur['remark']=$remark[$a];
			$djur['ref']=$ref[$a];
			$dates=date("Y-m-d");
			
		if($idj>0){
			$djur['modify_user_id']=$webmaster_id;
			$djur['modify_date']=$dates;
			$this->db->where('id',$idj);
			$this->db->update('sv_jurnal_detail',$djur);
		}	
		else{
			if($djur['debit']!=NULL || $djur['kredit']!=NULL){
			$djur['create_user_id']=$webmaster_id;
			$djur['create_date']=$dates;
				$this->db->insert('sv_jurnal_detail',$djur);
			}
		}	
		$a++;}
		
		
		redirect($this->utama);
		
	}	
	function add_ledger(){
			//print_mz($this->input->post());
			//unset($this->input->post('id'));
		$webmaster_id=$this->session->userdata('webmaster_id');
		//$id = $this->input->post('id');
		$GetColumns = GetColumns('sv_jurnal_detail');
		foreach($GetColumns as $r)
		{
			$data[$r['Field']] = $this->input->post($r['Field']);
			$data[$r['Field']."_temp"] = $this->input->post($r['Field']."_temp");
			
			if(!$data[$r['Field']] && !$data[$r['Field']."_temp"]) unset($data[$r['Field']]);
			unset($data[$r['Field']."_temp"]);
		}	
		unset($data['id']);
		/* if(!$this->input->post('global')){$data['global']='N';}
		else{$data['global']='Y';}  */
		
		if($id != NULL && $id != '')
		{
			/* if(!$this->input->post('password')){unset($data['password']);}
			else{$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));} */
			$data['modify_user_id'] = $webmaster_id;
			$data['modify_date']=date("Y-m-d");
			$this->db->where("id", $id);
			$this->db->update('sv_jurnal_detail', $data);
			
			$this->session->set_flashdata("message", 'Sukses diedit');
		}
		else
		{
			//$data['number']=generatenumbering('ledger');
			//if($this->input->post('password')){$data['password']=md5($this->config->item('encryption_key').$this->input->post("password"));}
			//if(!$this->input->post('avatar')){$data['avatar']='default.png';}
			$data['create_user_id'] = $webmaster_id;
			$data['create_date'] = date("Y-m-d H:i:s");
			$this->db->insert('sv_jurnal_detail', $data);
			$id = $this->db->insert_id();
			//addnumbering('ledger');
			$this->session->set_flashdata("message", 'Sukses ditambahkan');
		}
		
		redirect($this->utama.'/form/'.$data['id_jur']);
		
	}
	
}
?>